<section id="home" class="relative overflow-hidden">
    <div class="absolute inset-0 hero-gradient">
        <div class="absolute inset-0" style="background-image: url('{{ asset('storage/'.$hero->background_image) }}'); background-size: cover; background-position: center; opacity: 0.2;"></div>
    </div>
    
    <div class="relative container mx-auto px-4 py-20 md:py-32 text-white animate-fade-in">
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-block mb-6 px-4 py-2 bg-white/20 rounded-full backdrop-blur-sm animate-fade-in-up">
                <span class="text-sm font-medium">{{ $hero->subtitle }}</span>
            </div>
            
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                {{ $hero->title }}
            </h2>
            <p class="text-xl mb-8 leading-relaxed animate-fade-in-up" style="animation-delay: 0.4s;">
                {!! $hero->description !!}
            </p>
            @if ($hero->button_text)
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up" style="animation-delay: 0.6s;">
                <a href="{{ $hero->button_link }}" class="btn-gradient text-white font-bold px-8 py-4 rounded-full text-lg inline-block text-center">
                    <i class="fas fa-calendar-check ml-2"></i>
                    {{ $hero->button_text }}
                </a>
            </div>
            @endif

        </div>
    </div>
</section>