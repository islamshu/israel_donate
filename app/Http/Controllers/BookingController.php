<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Consultant;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
{
    $query = Booking::with('consultant');

    // ✅ إذا كان Consultant → اعرض فقط حجوزاته
    if (auth()->user()->hasRole('consultant')) {
        $consultantId = auth()->user()->consultant->id;
        $query->where('consultant_id', $consultantId);
    }

    // فلترة عادية
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('consultant_id') && auth()->user()->hasRole('admin')) {
        $query->where('consultant_id', $request->consultant_id);
    }

    if ($request->filled('date')) {
        $query->whereDate('date', $request->date);
    }

    $bookings = $query
        ->orderByDesc('created_at')
        ->get();

    // ✅ قائمة الاستشاريين
    if (auth()->user()->hasRole('admin')) {
        $consultants = Consultant::orderBy('name')->get();
    } else {
        $consultants = collect([auth()->user()->consultant]);
    }

    // ✅ الإحصائيات
    if (auth()->user()->hasRole('consultant')) {

        $consultantId = auth()->user()->consultant->id;

        $stats = [
            'paid'     => Booking::where('consultant_id', $consultantId)->where('status', 'paid')->count(),
            'pending'  => Booking::where('consultant_id', $consultantId)->where('status', 'pending')->count(),
            'canceled' => Booking::where('consultant_id', $consultantId)->where('status', 'canceled')->count(),
            'failed'   => Booking::where('consultant_id', $consultantId)->where('status', 'failed')->count(),
        ];
    } else {

        $stats = [
            'paid'     => Booking::where('status', 'paid')->count(),
            'pending'  => Booking::where('status', 'pending')->count(),
            'canceled' => Booking::where('status', 'canceled')->count(),
            'failed'   => Booking::where('status', 'failed')->count(),
        ];
    }

    return view('dashboard.bookings.index', compact(
        'bookings',
        'consultants',
        'stats'
    ));
}


    public function show(Booking $booking)
    {
        $booking->load('consultant');

        return view('dashboard.bookings.show', compact('booking'));
    }
}
