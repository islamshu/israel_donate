<nav class="bg-white shadow-lg sticky top-0 z-50 animate-fade-in border-b border-gray-100">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">

            <!-- الشعار + اسم الموقع -->
              <a href="/">
            <div class="flex items-center gap-4">
                <!-- اللوجو -->
                <div
                    class="flex items-center justify-center
                            w-16 h-16 md:w-18 md:h-18
                            rounded-xl
                            bg-white
                            shadow-md
                            overflow-hidden">

                    <img src="{{ asset('storage/' . get_general_value('website_logo')) }}"
                        alt="{{ get_general_value('website_name') }}" class="w-full h-full ">
                </div>

                <!-- اسم الموقع -->
              

                <div class="leading-tight">
                    <h1 class="text-lg md:text-xl font-extrabold gradient-text">
                        {{ get_general_value('website_name') }}
                    </h1>
                </div>
             

            </div>
   </a>

            <!-- روابط التنقل -->
            <div class="hidden md:flex space-x-reverse space-x-4 tracking-wide items-center">
                <a href="{{ url('/') }}#home"
                    class="nav-link text-gray-700 font-medium hover:text-primary transition">الرئيسية</a>
                <a href="{{ url('/') }}#about"
                    class="nav-link text-gray-700 font-medium hover:text-primary transition">عن المركز</a>
                <a href="{{ url('/') }}#services"
                    class="nav-link text-gray-700 font-medium hover:text-primary transition">خدماتنا</a>
                <a href="{{ url('/') }}#consultants"
                    class="nav-link text-gray-700 font-medium hover:text-primary transition">المستشارين</a>

                {{-- رابط الاستشارة السريعة الجديد --}}
                <a href="{{ route('quick.booking.form') }}"
                    class="nav-link text-green-600 font-bold hover:text-green-700 transition relative group">
                    <i class="fas fa-bolt ml-1 text-yellow-500"></i>
                    استشارة سريعة
                    <span
                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full animate-pulse">جديد</span>
                </a>

                <a href="{{ url('/') }}#booking"
                    class="nav-link text-gray-700 font-medium hover:text-primary transition">حجز موعد</a>
                <a href="{{ url('/') }}#contact"
                    class="nav-link text-gray-700 font-medium hover:text-primary transition">اتصل بنا</a>

                {{-- رابط الاستعلام عن الاستشارة --}}
                <a href="{{ route('consultation.query.form') }}"
                    class="nav-link text-gray-700 font-medium hover:text-primary transition">
                    <i class="fas fa-search ml-1"></i>
                    استعلام
                </a>
            </div>

            <!-- زر الحجز + الموبايل -->
            <div class="flex items-center gap-4">
                <a href="/booking"
                    class="btn-gradient text-white font-bold px-6 py-2.5 rounded-full text-sm hover:shadow-lg transition">
                    <i class="fas fa-calendar-check ml-2"></i>
                    حجز موعد
                </a>

                <!-- زر الموبايل -->
                <button id="mobileMenuButton" class="md:hidden text-primary text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>


        <!-- قائمة الجوال -->
        <div id="mobileMenu" class="md:hidden hidden bg-white border-t mt-3 animate-slide-in">
            <div class="flex flex-col py-3 space-y-2">

                <a href="{{ url('/') }}#home" class="text-primary font-semibold py-2 px-4 flex items-center">
                    <i class="fas fa-home ml-3"></i> الرئيسية
                </a>

                <a href="{{ url('/') }}#about" class="text-gray-700 py-2 px-4 flex items-center">
                    <i class="fas fa-info-circle ml-3"></i> عن المركز
                </a>

                <a href="{{ url('/') }}#services" class="text-gray-700 py-2 px-4 flex items-center">
                    <i class="fas fa-hands-helping ml-3"></i> خدماتنا
                </a>

                <a href="{{ url('/') }}#consultants" class="text-gray-700 py-2 px-4 flex items-center">
                    <i class="fas fa-user-friends ml-3"></i> المستشارين
                </a>

                {{-- استشارة سريعة --}}
                <a href="{{ route('quick.booking.form') }}"
                    class="text-green-600 font-bold py-2 px-4 flex items-center relative">
                    <i class="fas fa-bolt ml-3 text-yellow-500"></i>
                    استشارة سريعة
                    <span class="mr-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">
                        جديد
                    </span>
                </a>

                <a href="{{ url('/') }}#booking" class="text-gray-700 py-2 px-4 flex items-center">
                    <i class="fas fa-calendar-alt ml-3"></i> حجز موعد
                </a>

                <a href="{{ url('/') }}#contact" class="text-gray-700 py-2 px-4 flex items-center">
                    <i class="fas fa-phone ml-3"></i> اتصل بنا
                </a>

                {{-- استعلام --}}
                <a href="{{ route('consultation.query.form') }}" class="text-gray-700 py-2 px-4 flex items-center">
                    <i class="fas fa-search ml-3"></i>
                    استعلام عن الاستشارة
                </a>

                {{-- زر الحجز الكبير --}}
                <div class="px-4 pt-3">
                    <a href="/booking"
                        class="block text-center bg-gradient-to-r from-primary to-green-500 text-white font-bold py-2.5 rounded-full shadow-md">
                        <i class="fas fa-calendar-check ml-2"></i>
                        حجز موعد
                    </a>
                </div>

            </div>
        </div>
    </div>
</nav>
