<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Consultant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * إنشاء الحجز + الدفع (أو نجاح مباشر إن كان مجاني)
     */
    public function create(Request $request)
    {
        try {

            /* =========================================
               تنظيف الحجوزات المعلقة (أكثر من 10 دقائق)
            ========================================= */
            Booking::where('status', 'pending')
                ->where('created_at', '<', now()->subMinutes(10))
                ->update(['status' => 'expired']);

            /* =========================================
               Validation
            ========================================= */
            $data = $request->validate([
                'consultant_id'  => ['required', 'exists:consultants,id'],
                'date'           => ['required', 'date'],
                'time'           => ['required'], // HH:MM
                'client_name'    => ['required', 'string', 'max:255'],
                'client_phone'   => ['required', 'string', 'max:50'],
                'client_email'   => ['nullable', 'email', 'max:255'],
                'client_age'     => ['nullable', 'integer', 'min:1', 'max:120'],
                'client_address' => ['nullable', 'string', 'max:255'],
            ]);

            $consultant = Consultant::findOrFail($data['consultant_id']);

            /* =========================================
               تجهيز التاريخ والوقت
            ========================================= */
            $date  = Carbon::parse($data['date'])->toDateString();
            $start = Carbon::parse($date . ' ' . $data['time'] . ':00');
            $end   = $start->copy()->addMinutes(60);

            /* =========================================
               التحقق من ساعات العمل (09 → 17)
            ========================================= */
            $workStart = Carbon::parse($date . ' 09:00:00');
            $workEnd   = Carbon::parse($date . ' 17:00:00');

            if ($start->lt($workStart) || $start->gte($workEnd)) {
                return response()->json([
                    'message' => 'الوقت خارج ساعات العمل'
                ], 422);
            }

            /* =========================================
               منع التعارض (paid + pending حديث فقط)
            ========================================= */
            $conflict = Booking::where('consultant_id', $consultant->id)
                ->whereDate('date', $date)
                ->where('start_time', $start->format('H:i:s'))
                ->where(function ($q) {
                    $q->where('status', 'paid')
                      ->orWhere(function ($q) {
                          $q->where('status', 'pending')
                            ->where('created_at', '>=', now()->subMinutes(10));
                      });
                })
                ->exists();

            if ($conflict) {
                return response()->json([
                    'message' => 'هذا الوقت تم حجزه للتو، الرجاء اختيار وقت آخر'
                ], 422);
            }

            /* =========================================
               السعر بالبيسة
            ========================================= */
            $amountBaisa = (int) round(((float) $consultant->price) * 1000);

            /* =========================================
               إذا الحجز مجاني → نجاح مباشر
            ========================================= */
            if ($amountBaisa <= 0) {

                $booking = Booking::create([
                    'order_id'        => now()->format('Ymd') . '-' . random_int(1000, 9999),
                    'consultant_id'   => $consultant->id,
                    'date'            => $date,
                    'start_time'      => $start->format('H:i:s'),
                    'end_time'        => $end->format('H:i:s'),
                    'client_name'     => $data['client_name'],
                    'client_phone'    => $data['client_phone'],
                    'client_email'    => $data['client_email'] ?? null,
                    'client_age'      => $data['client_age'] ?? null,
                    'client_address'  => $data['client_address'] ?? null,
                    'amount_baisa'    => 0,
                    'currency'        => 'OMR',
                    'status'          => 'paid',
                    'paid_at'         => now(),
                ]);

                return response()->json([
                    'redirect_url' => route('checkout.thawani.success', $booking->order_id),
                    'free' => true
                ]);
            }

            /* =========================================
               إنشاء الحجز المدفوع (Pending)
            ========================================= */
            try {
                $booking = Booking::create([
                    'order_id'        => now()->format('Ymd') . '-' . random_int(1000, 9999),
                    'consultant_id'   => $consultant->id,
                    'date'            => $date,
                    'start_time'      => $start->format('H:i:s'),
                    'end_time'        => $end->format('H:i:s'),
                    'client_name'     => $data['client_name'],
                    'client_phone'    => $data['client_phone'],
                    'client_email'    => $data['client_email'] ?? null,
                    'client_age'      => $data['client_age'] ?? null,
                    'client_address'  => $data['client_address'] ?? null,
                    'amount_baisa'    => $amountBaisa,
                    'currency'        => 'OMR',
                    'status'          => 'pending',
                ]);
            } catch (QueryException $e) {
                if ($e->getCode() === '23000') {
                    return response()->json([
                        'message' => 'تم حجز هذا الوقت للتو، الرجاء اختيار وقت آخر'
                    ], 422);
                }
                throw $e;
            }

            /* =========================================
               إنشاء جلسة Thawani
            ========================================= */
            $payload = [
                'client_reference_id' => (string) $booking->id,
                'mode' => 'payment',
                'products' => [
                    [
                        'name'        => "حجز جلسة مع {$consultant->name}",
                        'quantity'    => 1,
                        'unit_amount' => $amountBaisa,
                    ]
                ],
                'success_url' => route('checkout.thawani.success', $booking->order_id),
                'cancel_url'  => route('checkout.thawani.cancel',  $booking->order_id),
            ];

            $res = Http::withHeaders([
                'Accept'          => 'application/json',
                'Content-Type'    => 'application/json',
                'thawani-api-key' => config('services.thawani.secret'),
            ])->post(config('services.thawani.base_url') . '/checkout/session', $payload);

            if (!$res->successful()) {
                $booking->update(['status' => 'failed']);
                return response()->json(['message' => 'فشل إنشاء جلسة الدفع'], 500);
            }

            $sessionId = data_get($res->json(), 'data.session_id')
                      ?? data_get($res->json(), 'session_id');

            if (!$sessionId) {
                $booking->update(['status' => 'failed']);
                return response()->json(['message' => 'لم يتم استلام session_id'], 500);
            }

            $booking->update(['thawani_session_id' => $sessionId]);

            return response()->json([
                'redirect_url' => "https://uatcheckout.thawani.om/pay/{$sessionId}?key=" .
                                  config('services.thawani.publishable')
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'message' => 'حدث خطأ غير متوقع',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /* =========================================
       Success
    ========================================= */
    public function success($id)
    {
        $booking = Booking::where('order_id', $id)->firstOrFail();

        if ($booking->status !== 'paid') {
            $booking->update([
                'status'  => 'paid',
                'paid_at'=> now()
            ]);
        }

        return view('frontend.checkout.success', compact('booking'));
    }

    /* =========================================
       Cancel
    ========================================= */
    public function cancel($id)
    {
        $booking = Booking::where('order_id', $id)->firstOrFail();

        if ($booking->status === 'pending') {
            $booking->update(['status' => 'canceled']);
        }

        return view('frontend.checkout.cancel', compact('booking'));
    }

    /* =========================================
       Check Slot (AJAX)
    ========================================= */
    public function checkSlot(Request $request)
    {
        $request->validate([
            'consultant_id' => 'required|exists:consultants,id',
            'date'          => 'required|date',
            'time'          => 'required'
        ]);

        Booking::where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(10))
            ->update(['status' => 'expired']);

        $date = Carbon::parse($request->date)->toDateString();
        $time = $request->time . ':00';

        $exists = Booking::where('consultant_id', $request->consultant_id)
            ->whereDate('date', $date)
            ->where('start_time', $time)
            ->whereIn('status', ['paid', 'pending'])
            ->exists();

        return response()->json([
            'available' => !$exists
        ]);
    }
}
