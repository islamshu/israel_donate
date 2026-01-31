  <!-- تواصل عائم -->
  <div class="floating-contact">
    <a href="https://wa.me/{{ get_general_value('phone') }}" target="_blank" class="bg-gradient-to-br from-green-500 to-green-600 text-white p-4 rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 flex items-center justify-center hover:scale-110">
        <i class="fab fa-whatsapp text-2xl"></i>
    </a>
</div>
<footer class="bg-gradient-to-r from-primary-dark to-primary text-white py-12">
    <div class="container mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">

            {{-- العمود الأول: اللوجو + الاسم --}}
            <div>
                <div class="flex items-center mb-4 gap-3">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center overflow-hidden shadow">
                        <img
                            src="{{ asset('storage/' . get_general_value('website_logo')) }}"
                            alt="{{ get_general_value('website_name') }}"
                            class="w-full h-full object-contain"
                        >
                    </div>

                    <h2 class="text-xl font-bold">
                        {{ get_general_value('website_name') }}
                    </h2>
                </div>

                <p class="text-white/80 text-sm leading-relaxed">
                    {{ get_general_value('website_description') ?? 'مركز متكامل للاستشارات النفسية والأسرية، نقدم خدمات استشارية متخصصة بمعايير عالمية.' }}
                </p>
            </div>

            {{-- روابط سريعة --}}
            <div>
                <h3 class="text-lg font-bold mb-4">روابط سريعة</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ url('/') }}#home" class="text-white/80 hover:text-white transition">
                            الرئيسية
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#about" class="text-white/80 hover:text-white transition">
                            عن المركز
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="text-white/80 hover:text-white transition">
                            خدماتنا
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('booking.index') }}" class="text-white/80 hover:text-white transition">
                            حجز موعد
                        </a>
                    </li>
                </ul>
            </div>

            {{-- الخدمات --}}
            <div>
                <h3 class="text-lg font-bold mb-4">الخدمات</h3>
                <ul class="space-y-2">
                    <li><a href="{{ url('/') }}#services" class="text-white/80 hover:text-white transition">الاستشارات النفسية</a></li>
                    <li><a href="{{ url('/') }}#services" class="text-white/80 hover:text-white transition">الاستشارات الأسرية</a></li>
                    <li><a href="{{ url('/') }}#services" class="text-white/80 hover:text-white transition">التطوير الشخصي</a></li>
                    <li><a href="{{ url('/') }}#services" class="text-white/80 hover:text-white transition">ورش العمل</a></li>
                </ul>
            </div>

            {{-- السوشيال --}}
            <div>
                <h3 class="text-lg font-bold mb-4">تابعنا</h3>

                <div class="flex gap-3">
                    @if(get_general_value('twitter'))
                        <a href="{{ get_general_value('twitter') }}" target="_blank"
                           class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif

                    @if(get_general_value('instagram'))
                        <a href="{{ get_general_value('instagram') }}" target="_blank"
                           class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif

                    @if(get_general_value('linkedin'))
                        <a href="{{ get_general_value('linkedin') }}" target="_blank"
                           class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif

                    @if(get_general_value('youtube'))
                        <a href="{{ get_general_value('youtube') }}" target="_blank"
                           class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- حقوق النشر --}}
        <div class="pt-8 border-t border-white/20 text-center">
            <p class="text-white/80 text-sm">
                © {{ now()->year }}
                {{ get_general_value('website_name') }}.
                جميع الحقوق محفوظة.
            </p>
        </div>

    </div>
</footer>
<script>
    // بيانات التطبيق
    let bookingData = {
        consultant: null,
        price: null,
        date: null,
        time: null,
        name: '',
        phone: '',
        email: '',
        sessionType: 'وجهاً لوجه',
        notes: '',
        paymentMethod: null
    };

    // تهيئة عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function() {
    // إخفاء شريط التحميل
    const loadingBar = document.getElementById('loadingBar');
    if (loadingBar) {
        setTimeout(() => {
            loadingBar.style.transform = 'scaleX(0)';
            loadingBar.style.transition = 'transform 0.5s ease';
            setTimeout(() => loadingBar.style.display = 'none', 500);
        }, 800);
    }

  
    // ✅ خليه
    initScrollReveal();
});

    // تهيئة التقويم
  
    // تنسيق التاريخ
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        return date.toLocaleDateString('ar-SA', options);
    }

    // توليد الأوقات المتاحة
    function generateTimeSlots() {
        const timeSlotsContainer = document.querySelector('#bookingStep2 .grid.gap-3');
        timeSlotsContainer.innerHTML = '';

        const timeSlots = [
            '09:00', '10:00', '11:00', '12:00',
            '14:00', '15:00', '16:00', '17:00', '18:00'
        ];

        timeSlots.forEach(time => {
            const slot = document.createElement('div');
            slot.className =
                'time-slot bg-white border-2 border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:border-primary transition';
            slot.textContent = time;
            slot.dataset.time = time;

            slot.addEventListener('click', function() {
                // إزالة التحديد من جميع الأوقات
                document.querySelectorAll('.time-slot').forEach(s => {
                    s.classList.remove('selected');
                });

                // إضافة التحديد للوقت المختار
                this.classList.add('selected');

                // تحديث بيانات الحجز
                bookingData.time = this.dataset.time;
                document.getElementById('selectedTimeInfo').textContent = this.dataset.time;
                document.getElementById('confirmTime').textContent = this.dataset.time;
                document.getElementById('modalTime').textContent = this.dataset.time;

                // تفعيل زر التالي
                document.getElementById('nextStep2').disabled = false;
            });

            timeSlotsContainer.appendChild(slot);
        });
    }

    // تهيئة نظام الحجز

    // عرض خطوة محددة
    function showStep(stepNumber) {
        // إخفاء جميع الخطوات
        document.querySelectorAll('.booking-step').forEach(step => {
            step.classList.remove('active');
        });

        // إظهار الخطوة المطلوبة
        document.getElementById(`bookingStep${stepNumber}`).classList.add('active');

        // تحديث مؤشرات الخطوات
        document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
            indicator.classList.remove('active', 'completed', 'pending');
            if (index + 1 < stepNumber) {
                indicator.classList.add('completed');
            } else if (index + 1 === stepNumber) {
                indicator.classList.add('active');
            } else {
                indicator.classList.add('pending');
            }
        });

        // تمرير إلى قسم الحجز
        document.getElementById('booking').scrollIntoView({
            behavior: 'smooth'
        });
    }

    // إعادة تعيين نظام الحجز
    function resetBookingSystem() {
        bookingData = {
            consultant: null,
            price: null,
            date: null,
            time: null,
            name: '',
            phone: '',
            email: '',
            sessionType: 'وجهاً لوجه',
            notes: '',
            paymentMethod: null
        };

        // إعادة تعيين النماذج
        document.getElementById('bookingName').value = '';
        document.getElementById('bookingPhone').value = '';
        document.getElementById('bookingEmail').value = '';
        document.getElementById('bookingNotes').value = '';
        document.getElementById('sessionType').value = 'وجهاً لوجه';

        // إعادة تعيين التحديدات
        document.querySelectorAll('.consultant-card').forEach(card => {
            card.classList.remove('border-primary', 'bg-primary/5');
        });

        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.classList.remove('selected');
        });

        document.querySelectorAll('.payment-method').forEach(method => {
            method.classList.remove('selected');
            method.querySelector('.fa-check-circle').classList.add('hidden');
        });

        // إعادة تعيين المعلومات
        document.getElementById('selectedConsultantInfo').textContent = '-';
        document.getElementById('selectedPriceInfo').textContent = '-';
        document.getElementById('selectedDateInfo').textContent = '-';
        document.getElementById('selectedTimeInfo').textContent = '-';
        document.getElementById('confirmConsultant').textContent = '-';
        document.getElementById('confirmDate').textContent = '-';
        document.getElementById('confirmTime').textContent = '-';
        document.getElementById('confirmSessionType').textContent = '-';
        document.getElementById('confirmName').textContent = '-';
        document.getElementById('confirmPhone').textContent = '-';
        document.getElementById('confirmEmail').textContent = '-';
        document.getElementById('confirmTotal').textContent = '- ر.ع';

        // إعادة تعيين الأزرار
        document.getElementById('nextStep1').disabled = true;
        document.getElementById('nextStep2').disabled = true;
        document.getElementById('nextStep3').disabled = true;
    }

    // تهيئة كشف العناصر عند التمرير
    function initScrollReveal() {
        const revealElements = document.querySelectorAll('.reveal-on-scroll');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        revealElements.forEach(element => {
            observer.observe(element);
        });
    }

    // قائمة الجوال
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    mobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
    });

    // إغلاق القائمة عند النقر على رابط
    const mobileLinks = document.querySelectorAll('#mobileMenu a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.add('hidden');
        });
    });

    // التمرير السلس
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // عدادات الإحصائيات
    const counters = document.querySelectorAll('[data-count]');

    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const updateCounter = () => {
                        current += step;
                        if (current < target) {
                            counter.textContent = Math.floor(current);
                            setTimeout(updateCounter, 16);
                        } else {
                            counter.textContent = target;
                        }
                    };
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        observer.observe(counter);
    });
</script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'primary': '#4F46E5',
                    'primary-light': '#6366F1',
                    'primary-dark': '#4338CA',
                    'secondary': '#F8FAFC',
                    'accent': '#10B981',
                    'accent-light': '#34D399',
                    'accent-dark': '#059669',
                    'soft-blue': '#E0F2FE',
                    'soft-green': '#D1FAE5',
                    'soft-purple': '#F5F3FF',
                    'soft-orange': '#FFEDD5',
                    'soft-pink': '#FCE7F3',
                    'warning': '#F59E0B',
                    'danger': '#EF4444',
                    'success': '#10B981'
                },
                animation: {
                    'fade-in': 'fadeIn 0.8s ease-in-out',
                    'fade-in-up': 'fadeInUp 0.8s ease-out',
                    'float': 'float 3s ease-in-out infinite',
                    'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    'slide-in': 'slideIn 0.5s ease-out',
                    'scale-in': 'scaleIn 0.5s ease-out',
                    'shimmer': 'shimmer 2s infinite linear'
                },
                keyframes: {
                    fadeIn: {
                        '0%': {
                            opacity: '0'
                        },
                        '100%': {
                            opacity: '1'
                        }
                    },
                    fadeInUp: {
                        '0%': {
                            opacity: '0',
                            transform: 'translateY(20px)'
                        },
                        '100%': {
                            opacity: '1',
                            transform: 'translateY(0)'
                        }
                    },
                    float: {
                        '0%, 100%': {
                            transform: 'translateY(0)'
                        },
                        '50%': {
                            transform: 'translateY(-10px)'
                        }
                    },
                    slideIn: {
                        '0%': {
                            transform: 'translateX(-100%)'
                        },
                        '100%': {
                            transform: 'translateX(0)'
                        }
                    },
                    scaleIn: {
                        '0%': {
                            opacity: '0',
                            transform: 'scale(0.9)'
                        },
                        '100%': {
                            opacity: '1',
                            transform: 'scale(1)'
                        }
                    },
                    shimmer: {
                        '0%': {
                            backgroundPosition: '-200% 0'
                        },
                        '100%': {
                            backgroundPosition: '200% 0'
                        }
                    }
                }
            }
        }
    }
</script>
@yield('scripts')
</body>

</html>
