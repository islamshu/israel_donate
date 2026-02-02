<!-- الخدمات -->
<section id="services" class="py-20 bg-white">
    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center section-title reveal-on-scroll">
            خدماتنا المتكاملة
        </h2>

        {{-- الكروت --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($services as $index => $service)
                <div
                    class="bg-gradient-to-b from-soft-blue to-white rounded-2xl shadow-lg overflow-hidden card-hover reveal-on-scroll"
                    style="transition-delay: {{ $index * 0.1 }}s;"
                >
                    <div class="h-56 overflow-hidden relative">
                        <img
                            src="{{ asset('storage/' . $service->image) }}"
                            alt="{{ $service->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                        >
                    </div>

                    <div class="p-8">
                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-primary to-accent flex items-center justify-center mb-6">
                            <i class="{{ $service->icon }} text-white text-2xl"></i>
                        </div>

                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            {{ $service->title }}
                        </h3>

                        <p class="text-gray-700 mb-6 leading-relaxed">
                            {!! $service->description !!}
                        </p>

                        <div class="flex justify-between items-center">
                        @if($service->price > 0)
                            <span class="text-primary font-bold">
                                {{ $service->price }} ر.ع / جلسة
                            </span>
                            @endif

                            <a href="#booking" class="text-primary font-semibold hover:text-primary-dark transition">
                                احجز الآن
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- زر رؤية المزيد --}}
        <div class="mt-16 text-center reveal-on-scroll">
            <a
                href="{{ route('services') }}"
                class="btn-gradient inline-flex items-center justify-center text-white font-bold px-12 py-4 rounded-full hover:shadow-xl transition"
            >
                رؤية جميع الخدمات
                <i class="fas fa-arrow-left ml-3"></i>
            </a>
        </div>

    </div>
</section>
