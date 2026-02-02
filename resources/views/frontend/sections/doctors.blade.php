<!-- المستشارين -->
<section id="consultants" class="py-20 bg-soft-purple">
    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center section-title reveal-on-scroll">
            فريق المستشارين المتخصصين
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @foreach($doctors as $index => $doctor)
                <div
                    class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover reveal-on-scroll"
                    style="transition-delay: {{ $index * 0.1 }}s;"
                >

                    {{-- الصورة --}}
                    <div class="h-64 overflow-hidden relative">
                        <img
                            src="{{ asset('storage/'.$doctor->image) }}"
                            alt="{{ $doctor->name }}"
                            class="w-full h-full object-cover"
                        >

                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <h3 class="text-white text-xl font-bold">
                                {{ $doctor->name }}
                            </h3>
                            <p class="text-white/80 text-sm">
                                {{ $doctor->title }}
                            </p>
                        </div>
                    </div>

                    {{-- المحتوى --}}
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">

                            {{-- سنوات الخبرة --}}
                            <span class="bg-soft-green text-accent-dark px-3 py-1 rounded-full text-xs font-medium">
                                {{ $doctor->years_experience }} سنة خبرة
                            </span>

                            {{-- التقييم --}}
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= floor($doctor->rating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                        </div>

                        <p class="text-gray-700 mb-4 text-sm">
                            {!! $doctor->description !!}
                        </p>

                        <div class="flex items-center justify-between">
                            @if($doctor->price)
                            <span class="text-primary font-bold">
                                {{ $doctor->price }} ر.ع
                            </span>
                            @endif

                            <button
                                class="select-consultant-btn bg-primary text-white px-4 py-2 rounded-full text-sm hover:bg-primary-dark transition"
                                data-consultant="{{ $doctor->name }}"
                                data-price="{{ $doctor->price }}"
                                data-id="{{ $doctor->id }}"
                            >
                                اختر المستشار
                            </button>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</section>
