<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

            @foreach($stastic as $index => $stat)
                <div
                    class="text-center reveal-on-scroll"
                    style="transition-delay: {{ $index * 0.1 }}s;"
                >
                    <div
                        class="text-3xl font-bold gradient-text mb-2 counter"
                        data-count="{{ $stat->value }}"
                    >
                        0
                    </div>

                    <p class="text-gray-600 font-medium">
                        {{ $stat->label }}
                    </p>
                </div>
            @endforeach

        </div>
    </div>
</section>
