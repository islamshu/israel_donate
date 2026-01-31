@extends('layouts.frontend')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center bg-gray-50">
    <div class="max-w-xl w-full px-4">
        
        <div class="bg-white rounded-3xl shadow-xl p-10 text-center relative overflow-hidden">

            {{-- خلفية زخرفية --}}
            <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-white opacity-70"></div>

            <div class="relative z-10">

                {{-- أيقونة --}}
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-500 text-4xl"></i>
                </div>

                {{-- العنوان --}}
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-3">
                    تم إلغاء عملية الدفع
                </h1>

                {{-- الوصف --}}
                <p class="text-gray-600 mb-6 leading-relaxed">
                    لم تكتمل عملية الدفع بنجاح، ولم يتم خصم أي مبلغ من حسابك.
                    يمكنك المحاولة مرة أخرى في أي وقت.
                </p>

                {{-- معلومات الحجز --}}
                <div class="bg-gray-50 border rounded-xl p-5 mb-8 text-sm">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500">رقم الحجز</span>
                        <span class="font-semibold text-gray-800">
                            #{{ $booking->order_id }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">حالة الطلب</span>
                        <span class="font-semibold text-red-600">
                            {{ __('ملغي') }}
                        </span>
                    </div>
                </div>

                {{-- الأزرار --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    
                    <a
                        href="{{ route('booking.index') }}"
                        class="btn-gradient text-white font-bold px-8 py-3 rounded-full hover:shadow-lg transition"
                    >
                        إعادة المحاولة
                        <i class="fas fa-redo ml-2"></i>
                    </a>

                    <a
                        href="{{ url('/') }}"
                        class="px-8 py-3 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100 transition"
                    >
                        العودة للرئيسية
                    </a>

                </div>

            </div>
        </div>

    </div>
</section>
@endsection
