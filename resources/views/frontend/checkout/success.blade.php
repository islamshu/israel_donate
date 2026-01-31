@extends('layouts.frontend')

@section('styles')
<style>
/* ================= PRINT STYLES ================= */
@media print {
    /* إخفاء جميع العناصر ما عدا print-container */
    body > *:not(.print-container) {
        display: none !important;
    }
    
    /* إظهار print-container فقط */
    .print-container {
        display: block !important;
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
        background: white !important;
    }
    
    /* تحسين إعدادات الصفحة */
    @page {
        size: A4;
        margin: 15mm;
    }
    
    body {
        background: white !important;
        font-size: 12pt !important;
    }
    
    .no-print-break {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }
    
    .print-hide {
        display: none !important;
    }
    
    .print-grid {
        display: block !important;
    }
    
    .print-grid > div {
        margin-bottom: 12px !important;
        break-inside: avoid;
    }
    
    .print-tight {
        padding: 16px !important;
    }
}
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-20 px-4 print-container">

    {{-- Success Header --}}
    <div class="text-center mb-10 no-print-break">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 text-green-600 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-3xl font-extrabold text-gray-800">
            تم الدفع بنجاح
        </h1>
        <p class="text-gray-500 mt-2">
            تم تأكيد الحجز وإتمام عملية الدفع بنجاح
        </p>
    </div>

    {{-- Main Card --}}
    <div class="bg-white border rounded-2xl shadow-sm overflow-hidden no-print-break">

        {{-- Booking Info --}}
        <div class="p-8 border-b print-tight">
            <h2 class="text-xl font-bold text-gray-800 mb-6">
                معلومات الحجز
            </h2>

            <div class="grid md:grid-cols-2 gap-6 text-sm print-grid">
                <div>
                    <p class="text-gray-500">رقم الحجز</p>
                    <p class="font-semibold">#{{ $booking->order_id }}</p>
                </div>

                <div>
                    <p class="text-gray-500">حالة الحجز</p>
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                        {{ $booking->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>

                <div>
                    <p class="text-gray-500">تاريخ الجلسة</p>
                    <p class="font-semibold">
                        {{ $booking->date->format('Y-m-d') }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">وقت الجلسة</p>
                    <p class="font-semibold">
                        {{ $booking->start_time }} - {{ $booking->end_time }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Consultant --}}
        <div class="p-8 border-b bg-gray-50 print-tight">
            <h2 class="text-xl font-bold text-gray-800 mb-6">
                بيانات المستشار
            </h2>

            <div class="flex items-center gap-6">
                <img
                    src="{{asset('storage/'. $booking->consultant->image ) }}"
                    class="w-20 h-20 rounded-full object-cover border"
                    alt="Consultant">

                <div>
                    <p class="font-bold text-gray-800">
                        {{ $booking->consultant->name }}
                    </p>
                    <p class="text-gray-500">
                        {{ $booking->consultant->title }}
                    </p>
                    <p class="text-sm text-gray-400 mt-1">
                        خبرة {{ $booking->consultant->years_experience }} سنوات
                    </p>
                </div>
            </div>
        </div>

        {{-- Client --}}
        <div class="p-8 border-b print-tight">
            <h2 class="text-xl font-bold text-gray-800 mb-6">
                بيانات العميل
            </h2>

            <div class="grid md:grid-cols-2 gap-6 text-sm print-grid">
                <div>
                    <p class="text-gray-500">الاسم</p>
                    <p class="font-semibold">{{ $booking->client_name }}</p>
                </div>

                <div>
                    <p class="text-gray-500">رقم الهاتف</p>
                    <p class="font-semibold">{{ $booking->client_phone }}</p>
                </div>

                <div>
                    <p class="text-gray-500">العنوان</p>
                    <p class="font-semibold">{{ $booking->client_address }}</p>
                </div>

                <div>
                    <p class="text-gray-500">العمر</p>
                    <p class="font-semibold">{{ $booking->client_age }}</p>
                </div>
            </div>
        </div>

        {{-- Payment --}}
        <div class="p-8 print-tight">
            <h2 class="text-xl font-bold text-gray-800 mb-6">
                تفاصيل الدفع
            </h2>

            <div class="grid md:grid-cols-2 gap-6 text-sm print-grid">
                <div>
                    <p class="text-gray-500">المبلغ المدفوع</p>
                    <p class="font-bold text-green-600 text-lg">
                        {{ number_format($booking->amount_baisa / 100, 2) }}
                        {{ $booking->currency }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">تاريخ الدفع</p>
                    <p class="font-semibold">
                        {{ optional($booking->paid_at)->format('Y-m-d H:i') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="px-8 py-6 bg-gray-50 flex flex-col sm:flex-row gap-4 justify-between print-hide">
            <a href="/"
               class="inline-flex justify-center px-8 py-3 rounded-full bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                العودة للرئيسية
            </a>

            <button onclick="window.print()"
                    class="inline-flex justify-center px-8 py-3 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                طباعة الصفحة
            </button>
        </div>

    </div>
</div>
@endsection