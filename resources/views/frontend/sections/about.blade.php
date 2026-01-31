<!-- عن المركز -->
<section id="about" class="py-20 bg-soft-purple">
    <div class="container mx-auto px-4">

        {{-- العنوان --}}
        <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center section-title reveal-on-scroll">
            {{ $about->title ?? 'عن المركز' }}
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center reveal-on-scroll">

            {{-- العمود الأيسر --}}
            <div>
                <div class="bg-white rounded-2xl shadow-lg p-8 card-hover">

                    <h3 class="text-2xl font-bold text-primary mb-6">
                        {{ $about->title }}
                    </h3>

                    <p class="text-gray-700 mb-6 leading-relaxed">
                        {!! $about->description !!}
                    </p>

                    {{-- النقاط --}}
                    <div class="space-y-4">
                        @foreach($about_points as $point)
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-soft-green flex items-center justify-center ml-3 mt-1">
                                    <i class="{{ $point->icon }} text-accent"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-1">
                                        {{ $point->title }}
                                    </h4>
                                    <p class="text-gray-600 text-sm">
                                        {!! $point->description !!}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            {{-- العمود الأيمن (الخدمات / المميزات) --}}
            <div>
                <div class="grid grid-cols-2 gap-6">

                    @foreach($about_fet as $index => $feature)
                        <div
                            class="bg-white rounded-xl shadow-md p-6 text-center card-hover reveal-on-scroll"
                            style="transition-delay: {{ $index * 0.1 }}s;"
                        >
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-accent flex items-center justify-center mx-auto mb-4">
                                <i class="{{ $feature->icon }} text-white text-2xl"></i>
                            </div>

                            <h4 class="font-bold text-gray-800 mb-2">
                                {{ $feature->title }}
                            </h4>

                            <p class="text-gray-600 text-sm">
                                {{ $feature->description }}
                            </p>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
</section>
