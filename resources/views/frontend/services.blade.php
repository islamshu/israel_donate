@extends('layouts.frontend')

@section('title', 'خدماتنا | ' . get_general_value('website_name'))

@section('content')

<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">

        {{-- العنوان --}}
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-4 section-title">
                خدماتنا المتكاملة
            </h1>

            <p class="text-gray-600 max-w-2xl mx-auto">
                نقدم مجموعة متكاملة من الخدمات النفسية والأسرية المصممة خصيصًا لتلبية احتياجاتك
            </p>
        </div>

        {{-- الخدمات --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            @forelse($services as $service)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">

                    {{-- الصورة --}}
                    @if($service->image)
                        <div class="h-56 overflow-hidden">
                            <img
                                src="{{ asset('storage/' . $service->image) }}"
                                alt="{{ $service->title }}"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                            >
                        </div>
                    @endif

                    {{-- المحتوى --}}
                    <div class="p-8">

                        <h3 class="text-xl font-bold text-gray-800 mb-3">
                            {{ $service->title }}
                        </h3>

                        <p class="text-gray-600 text-sm leading-relaxed mb-6">
                            {{ Str::limit(strip_tags($service->description), 130) }}
                        </p>

                        <div class="flex items-center justify-between">

                            @if($service->price > 0)
                                <span class="text-primary font-bold">
                                    {{ number_format($service->price) }} ر.ع
                                </span>
                            
                            @endif

                            <a
                                href="{{ route('booking.index', ['service' => $service->id]) }}"
                                class="text-primary font-semibold hover:underline"
                            >
                                احجز الآن
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">
                    لا توجد خدمات متاحة حالياً
                </div>
            @endforelse

        </div>

    </div>
</section>

@endsection
