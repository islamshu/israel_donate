<!-- نظام الحجز -->
<section id="booking" class="py-24 bg-soft-blue relative overflow-hidden">
    <!-- خلفية زخرفية خفيفة -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-accent/10 rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center bg-white/80 backdrop-blur-md rounded-3xl shadow-2xl p-10 card-hover reveal-on-scroll">

            <!-- أيقونة -->
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-primary to-accent flex items-center justify-center shadow-lg">
                <i class="fas fa-calendar-check text-white text-3xl"></i>
            </div>

            <!-- العنوان -->
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-4">
                احجز جلستك الاستشارية الآن
            </h2>

            <!-- الوصف -->
            <p class="text-gray-600 text-lg mb-10 leading-relaxed">
                اختر المستشار المناسب وحدد الموعد الذي يناسبك بكل سهولة وأمان،
                وابدأ رحلتك نحو التوازن النفسي والدعم المهني.
            </p>

            <!-- زر الحجز -->
            <a
                href="{{ route('booking.index') }}"
                class="btn-gradient inline-flex items-center justify-center text-white font-bold px-12 py-4 rounded-full text-lg hover:shadow-2xl transition-all duration-300"
            >
                احجز الآن
                <i class="fas fa-arrow-left ml-4"></i>
            </a>

            <!-- نص ثانوي -->
            <p class="mt-6 text-sm text-gray-500">
                ✔ سرية تامة &nbsp; | &nbsp; ✔ مستشارون معتمدون &nbsp; | &nbsp; ✔ حجز سريع
            </p>
        </div>
    </div>
</section>
