<?php

namespace App\Http\Controllers;

use App\Events\QuickConsultationCreated;
use App\Models\Consultant;
use Illuminate\Http\Request;
use App\Models\QuickConsultation;
use App\Models\QuickConsultationFile;
use Illuminate\Support\Str;

class QuickConsultationController extends Controller
{
    // قائمة الاستشارات مع فلترة
    public function index(Request $request)
    {
        $consultants = Consultant::all();

        $query = QuickConsultation::with(['consultant', 'files', 'replies']);

        // ✅ لو المستخدم مستشار يشوف فقط استشاراته
        if (auth()->user()->hasRole('consultant')) {
            $consultantId = auth()->user()->consultant?->id;

            if ($consultantId) {
                $query->where('consultant_id', $consultantId);
            }
        }

        // 🔎 الفلاتر (تشتغل على الجميع)
        if ($request->consultant_id) {
            $query->where('consultant_id', $request->consultant_id);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $consultations = $query->latest()->get();

        // 📊 الإحصائيات (تكون حسب نوع المستخدم)
        $statsQuery = QuickConsultation::query();

        if (auth()->user()->hasRole('consultant')) {
            $statsQuery->where('consultant_id', auth()->user()->consultant?->id);
        }

        $stats = [
            'pending'  => (clone $statsQuery)->where('status', 'pending')->count(),
            'answered' => (clone $statsQuery)->where('status', 'answered')->count(),
            'closed'   => (clone $statsQuery)->where('status', 'closed')->count(),
        ];

        return view('dashboard.quick_consultations.index', compact(
            'consultations',
            'consultants',
            'stats'
        ));
    }

    // تحديث حالة الاستشارة
    public function updateStatus(Request $request, QuickConsultation $quickConsultation)
    {
        $request->validate([
            'status' => 'required|in:pending,answered,closed',
        ]);

        $quickConsultation->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الاستشارة بنجاح.');
    }

    // إضافة رد من النظام/Admin أو المستشار
    public function reply(Request $request, QuickConsultation $quickConsultation)
    {
        $request->validate([
            'reply_text' => 'required|string',
            'file' => 'nullable|file|max:10240',
        ]);



        // تحديد نوع المرسل باستخدام Spatie Roles
        if (auth()->check()) {
            if (auth()->user()->hasRole('admin')) {
                $replyType = 'admin';
                $adminName = auth()->user()->name;
                $clientName = null;
            } elseif (auth()->user()->hasRole('consultant')) {
                $replyType = 'consultant';
                $adminName = auth()->user()->name;
                $clientName = null;
            }
        } else {
            $replyType = 'client';
            $clientName = 'العميل';
            $adminName = null;
        }


        $quickConsultation->replies()->create([
            'reply_text' => $request->reply_text,
            'reply_type' => $replyType,
            'admin_name' => $adminName ?? null,
            'client_name' => $clientName ?? null,
        ]);
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('quick_consultation_replies', 'public');
            $quickConsultation->files()->create([
                'file_path' => $filePath,
            ]);
        }


        return back()->with('success', 'تم إرسال الرد بنجاح.');
    }

    // إضافة رد من العميل (Front-end)
    public function client_reply(Request $request, QuickConsultation $consultation)
    {
        $request->validate([
            'reply_text' => 'required|string',
            'file' => 'nullable|file|max:2048',
        ]);


        $consultation->replies()->create([
            'reply_text' => $request->reply_text,
            'reply_type' => 'client',
            'client_name' => 'المستخدم',
        ]);
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->hasFile('file') ? $request->file('file')->store('quick_consultation_replies', 'public') : null;
            $consultation->files()->create([
                'file_path' => $filePath,
            ]);
        }

        // إعادة التوجيه إلى نفس الصفحة مع رقم الاستشارة
        return redirect()->route('consultation.query.form', ['consultation_number' => $consultation->consultation_number])
            ->with('success', 'تم إرسال ردك بنجاح.');
    }

    // عرض استشارة واحدة مع الملفات والردود
    public function show(QuickConsultation $quickConsultation)
    {
        $quickConsultation->load('consultant', 'files', 'replies');

        return view('dashboard.quick_consultations.show', compact('quickConsultation'));
    }

    // عرض فورم الحجز السريع
    public function create()
    {
        $consultants = Consultant::where('is_active', 1)->orderBy('order')->get();
        return view('frontend.fast_booking', compact('consultants'));
    }

    // تخزين استشارة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'consultant_id' => 'required|exists:consultants,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'consultation_text' => 'required|string',
            'files.*' => 'nullable|file|max:10240'
        ]);

        $consultation_number = strtoupper(Str::random(8));

        $consultation = QuickConsultation::create([
            'consultant_id' => $request->consultant_id,
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'consultation_text' => $request->consultation_text,
            'consultation_number' => $consultation_number,
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('quick_consultations', 'public');
                QuickConsultationFile::create([
                    'consultation_id' => $consultation->id,
                    'file_path' => $path,
                ]);
            }
        }
\Illuminate\Support\Facades\Log::info('استدعاء Event QuickConsultationCreated');
event(new QuickConsultationCreated($consultation));
\Illuminate\Support\Facades\Log::info('استدعاء Event QuickConsultationCreated تم بنجاح');
        return response()->json([
            'success' => true,
            'consultation_number' => $consultation->consultation_number
        ]);
    }

    // استعلام عن الاستشارة - فورم
    public function queryForm($consultation_number = null)
    {
        $consultation = null;

        if ($consultation_number) {
            $consultation = QuickConsultation::with(['consultant', 'files', 'replies'])
                ->where('consultation_number', $consultation_number)
                ->first();
        }

        return view('frontend.quick_consultation.query', compact('consultation'));
    }

    // استعلام عن الاستشارة - نتيجة
    public function queryResult(Request $request)
    {
        $request->validate([
            'consultation_number' => 'required|string',
        ]);

        $consultation = QuickConsultation::with(['consultant', 'files', 'replies'])
            ->where('consultation_number', $request->consultation_number)
            ->first();

        if (!$consultation) {
            return back()->withErrors(['consultation_number' => 'رقم الاستشارة غير موجود']);
        }

        // إعادة التوجيه إلى الرابط الذي يحتوي على رقم الاستشارة
        return redirect()->route('consultation.query.form', ['consultation_number' => $consultation->consultation_number]);
    }
}
