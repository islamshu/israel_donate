@extends('layouts.frontend')
@section('styles')
    {{-- ================= STYLE ================= --}}
    <style>
        .step {
            padding-bottom: 6px;
            border-bottom: 3px solid #e5e7eb;
            color: #9ca3af;
            transition: all 0.3s ease;
        }

        .step.active {
            color: #4f46e5;
            border-color: #4f46e5;
        }

        /* FullCalendar Custom Styles */
        .fc {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .fc-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            margin-bottom: 1rem !important;
        }

        .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
            color: #374151 !important;
        }

        .fc-button {
            background-color: #4f46e5 !important;
            border: none !important;
            padding: 0.5rem 1rem !important;
            font-weight: 600 !important;
            border-radius: 0.375rem !important;
        }

        .fc-button:hover {
            background-color: #4338ca !important;
        }

        .fc-button:active,
        .fc-button:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3) !important;
        }

        .fc-button-primary:disabled {
            background-color: #9ca3af !important;
        }

        .fc-daygrid-day {
            border: 1px solid #e5e7eb !important;
        }

        .fc-daygrid-day:hover {
            background-color: #f3f4f6 !important;
            cursor: pointer;
        }

        .fc-daygrid-day.fc-day-today {
            background-color: #eef2ff !important;
        }

        .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            color: #4f46e5 !important;
            font-weight: bold;
        }

        .fc-daygrid-day-number {
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
            padding: 0.25rem !important;
        }

        .fc-col-header-cell {
            background-color: #f9fafb !important;
            border: 1px solid #e5e7eb !important;
            padding: 0.5rem 0 !important;
        }

        .fc-col-header-cell-cushion {
            font-weight: 600 !important;
            color: #374151 !important;
            font-size: 0.9rem !important;
            padding: 0.5rem !important;
        }

        .fc-day-disabled {
            background-color: #f9fafb !important;
        }

        .fc-day-disabled .fc-daygrid-day-number {
            color: #9ca3af !important;
        }

        .fc-day-disabled:hover {
            background-color: #f9fafb !important;
            cursor: not-allowed !important;
        }

        .fc-scrollgrid {
            border: none !important;
        }

        .fc-scrollgrid-section>td {
            border: none !important;
        }

        .fc-day-selected {
            background-color: #4f46e5 !important;
        }

        .fc-day-selected .fc-daygrid-day-number {
            color: white !important;
        }

        .fc-day-selected:hover {
            background-color: #4338ca !important;
        }

        /* Time slots styling */
        #timeSlots button {
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
            background-color: white;
            color: #374151;
        }

        #timeSlots button:hover {
            background-color: #4f46e5;
            color: white;
            border-color: #4f46e5;
        }

        #timeSlots button.selected {
            background-color: #4f46e5;
            color: white;
            border-color: #4f46e5;
        }

        /* ================= TIME SLOT ================= */
        .time-slot-btn {
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-weight: 600;
            background-color: #fff;
            color: #374151;
            transition: all 0.2s ease;
        }

        .time-slot-btn:hover {
            background-color: #eef2ff;
            border-color: #4f46e5;
            color: #4f46e5;
        }

        /* عند الاختيار */
        .time-slot-btn.selected {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: #fff;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.35);
            transform: scale(1.03);
        }

        /* ================= BOOKING STEPS ================= */
        .booking-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            direction: rtl;
        }

        .booking-steps .line {
            flex: 1;
            height: 3px;
            background: #e5e7eb;
            border-radius: 10px;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            min-width: 90px;
            color: #9ca3af;
            font-size: 13px;
            font-weight: 600;
            transition: all .3s ease;
        }

        .step-item .circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #6b7280;
            transition: all .3s ease;
        }

        /* ACTIVE */
        .step-item.active {
            color: #4f46e5;
        }

        .step-item.active .circle {
            background: linear-gradient(135deg, #6366f1, #22c55e);
            color: #fff;
            box-shadow: 0 6px 18px rgba(99, 102, 241, .45);
        }

        /* COMPLETED */
        .step-item.completed {
            color: #16a34a;
        }

        .step-item.completed .circle {
            background: #22c55e;
            color: #fff;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .booking-steps span {
                font-size: 11px;
            }

            .booking-steps .line {
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <section id="booking" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">

            {{-- ================= TITLE ================= --}}
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-800 mb-2">
                    اختر التاريخ والوقت
                </h2>
                <p class="text-gray-500">
                    اختر المستشار ثم التاريخ لعرض الأوقات المتاحة
                </p>
            </div>

            {{-- ================= STEP INDICATOR ================= --}}
            <div class="booking-steps mb-16">
                <div class="step-item active" data-step="1">
                    <div class="circle">1</div>
                    <span>اختيار المستشار</span>
                </div>

                <div class="line"></div>

                <div class="step-item" data-step="2">
                    <div class="circle">2</div>
                    <span>اختيار الموعد</span>
                </div>

                <div class="line"></div>

                <div class="step-item" data-step="3">
                    <div class="circle">3</div>
                    <span>معلومات الحجز</span>
                </div>


                
            </div>


            {{-- ================= STEP 1 ================= --}}
            <div id="stepBox1">
                <h3 class="font-bold mb-4 text-gray-800">المستشارون</h3>
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    @foreach ($consultants as $c)
                        <div class="consultant-card border rounded-xl p-4 cursor-pointer
                           hover:border-indigo-500 transition hover:shadow-md bg-white"
                            data-id="{{ $c->id }}" data-name="{{ $c->name }}" data-price="{{ $c->price }}">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $c->image) }}"
                                    class="w-14 h-14 rounded-full object-cover border-2 border-gray-200">
                                <div>
                                    <div class="font-bold text-gray-800">
                                        {{ $c->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $c->title }}
                                    </div>
                                    <div class="text-indigo-600 font-semibold mt-1">
                                        {{ $c->price }} ر.ع
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button id="goStep2" disabled
                    class="px-10 py-3 bg-indigo-600 text-white rounded-full
                   disabled:opacity-40 hover:bg-indigo-700 transition font-semibold">
                    التالي
                </button>
            </div>

            {{-- ================= STEP 2 ================= --}}
            <div id="stepBox2" class="hidden">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- TIMES --}}
                    <div class="order-2 lg:order-1">
                        <h4 class="font-bold mb-3 text-gray-800">الأوقات المتاحة</h4>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 h-[380px] overflow-y-auto">
                            <div id="selectedDateInfo" class="mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded-lg">
                                <p class="text-sm text-gray-600 mb-1">التاريخ المختار</p>
                                <p id="dateText" class="font-bold text-indigo-700 text-lg">
                                    لم يتم الاختيار
                                </p>
                            </div>
                            <div id="timeSlots" class="grid grid-cols-2 gap-3">
                                <p class="col-span-2 text-gray-400 text-center py-8">
                                    اختر تاريخاً لعرض الأوقات المتاحة
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- CALENDAR --}}
                    <div class="order-1 lg:order-2 lg:col-span-2">
                        <h4 class="font-bold mb-3 text-gray-800">اختر التاريخ</h4>
                        <div id="calendar" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-10">
                    <button onclick="backToStep1()"
                        class="px-8 py-3 rounded-full bg-gray-200 hover:bg-gray-300 transition font-semibold">
                        رجوع
                    </button>
                    <button id="nextStep" disabled
                        class="px-10 py-3 rounded-full bg-indigo-600 text-white
                       disabled:opacity-40 hover:bg-indigo-700 transition font-semibold">
                        متابعة
                    </button>
                </div>
            </div>
            {{-- ================= STEP 3 ================= --}}
            <div id="stepBox3" class="hidden max-w-3xl mx-auto">

                <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">
                    بيانات الجلسة
                </h3>

                {{-- ملخص الجلسة --}}
                <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6 mb-8">
                    <p class="mb-2"><strong>المستشار:</strong> <span id="summaryConsultant"></span></p>
                    <p class="mb-2"><strong>التاريخ:</strong> <span id="summaryDate"></span></p>
                    <p class="mb-2"><strong>الوقت:</strong> <span id="summaryTime"></span></p>
                    <p class="mb-2"><strong>السعر:</strong> <span id="summaryPrice"></span> ر.ع</p>

                    <p class="text-sm text-gray-600 mt-4">
                        جلسة استشارية مدتها 60 دقيقة، يتم فيها مناقشة حالتك وتقديم الإرشادات المناسبة لك بكل خصوصية.
                    </p>
                </div>

                {{-- نموذج البيانات --}}
                <div class="bg-white border rounded-xl p-8 shadow-sm">
                    <div class="grid md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-semibold mb-1">الاسم الكامل</label>
                            <input id="clientName" type="text"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="أدخل اسمك الكامل">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">رقم الهاتف</label>
                            <input id="clientPhone" type="text"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="مثال: 9XXXXXXXX">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">العمر</label>
                            <input id="clientAge" type="number"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="العمر">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">العنوان</label>
                            <input id="clientAddress" type="text"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="المدينة / المنطقة">
                        </div>

                    </div>

                    <div class="flex justify-between mt-8">
                        <button onclick="backToStep2()"
                            class="px-8 py-3 rounded-full bg-gray-200 hover:bg-gray-300 font-semibold">
                            رجوع
                        </button>

                        <button id="goToPayment"
                            class="px-10 py-3 rounded-full bg-indigo-600 text-white hover:bg-indigo-700 font-semibold
           flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">

                            <svg id="paymentLoader" class="hidden animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                </path>
                            </svg>

                            <span id="paymentBtnText">الانتقال للدفع</span>
                        </button>


                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        /* =====================================================
                           GLOBAL STATE
                        ===================================================== */
        let booking = {
            consultant_id: null,
            consultant_name: null,
            price: null,
            date: null,
            time: null
        };

        let calendar = null;
        let isSubmitting = false;

        /* =====================================================
           STEPPER CONTROL
        ===================================================== */
        function setStep(step) {
            document.querySelectorAll('.step-item').forEach(item => {
                const s = Number(item.dataset.step);
                item.classList.remove('active', 'completed');
                if (s < step) item.classList.add('completed');
                if (s === step) item.classList.add('active');
            });
        }

        /* =====================================================
           STEP 1 – SELECT CONSULTANT
        ===================================================== */
        document.querySelectorAll('.consultant-card').forEach(card => {
            card.onclick = () => {
                document.querySelectorAll('.consultant-card').forEach(c => {
                    c.classList.remove('border-indigo-600', 'bg-indigo-50');
                    c.classList.add('border-gray-200');
                });

                card.classList.add('border-indigo-600', 'bg-indigo-50');
                card.classList.remove('border-gray-200');

                booking.consultant_id = card.dataset.id;
                booking.consultant_name = card.dataset.name;
                booking.price = card.dataset.price;
                resetSlotsAndCalendar();


                document.getElementById('goStep2').disabled = false;
            };
        });

        /* =====================================================
           STEP 1 → STEP 2
        ===================================================== */
        document.getElementById('goStep2').onclick = () => {
            document.getElementById('stepBox1').classList.add('hidden');
            document.getElementById('stepBox2').classList.remove('hidden');
            setStep(2);
            initCalendar();
        };

        function backToStep1() {
            document.getElementById('stepBox2').classList.add('hidden');
            document.getElementById('stepBox1').classList.remove('hidden');
            resetSlotsAndCalendar();
            setStep(1);
        }

        /* =====================================================
           CALENDAR
        ===================================================== */
        function initCalendar() {
            const el = document.getElementById('calendar');
            if (!el) return;
            if (calendar) calendar.destroy();

            calendar = new FullCalendar.Calendar(el, {
                initialView: 'dayGridMonth',
                locale: 'ar',
                direction: 'rtl',
                firstDay: 6,
                height: 'auto',

                // ✅ امنع اختيار أيام ماضية
                validRange: {
                    start: new Date().toISOString().split('T')[0]
                },

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },

                buttonText: {
                    today: 'اليوم'
                },

                dateClick(info) {
                    // حماية إضافية
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    const clicked = new Date(info.dateStr);
                    if (clicked < today) return;

                    document.querySelectorAll('.fc-day-selected')
                        .forEach(d => d.classList.remove('fc-day-selected'));

                    info.dayEl.classList.add('fc-day-selected');

                    booking.date = info.dateStr;
                    booking.time = null;
                    document.getElementById('nextStep').disabled = true;

                    document.getElementById('dateText').textContent =
                        clicked.toLocaleDateString('ar-OM', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });

                    loadSlots();
                }
            });


            calendar.render();
        }

        /* =====================================================
           LOAD SLOTS
        ===================================================== */
        function loadSlots() {
            const box = document.getElementById('timeSlots');
            box.innerHTML = `<p class="col-span-2 text-center text-gray-400 py-4">جاري التحميل...</p>`;

            fetch(`/consultants/${booking.consultant_id}/available-slots?date=${booking.date}`)
                .then(r => r.json())
                .then(data => {
                    renderTimeSlots(filterSlots(data.slots || []));
                })
                .catch(() => {
                    box.innerHTML = `<p class="col-span-2 text-center text-red-500 py-4">فشل تحميل الأوقات</p>`;
                });
        }

        /* =====================================================
           FILTER 09 → 17
        ===================================================== */
        function filterSlots(slots) {
            const now = new Date();
            const selectedDate = new Date(booking.date);
            return slots.filter(t => {
                const [h, m] = t.split(':').map(Number);
                const slotDate = new Date(selectedDate);
                slotDate.setHours(h, m, 0, 0);
                if (slotDate.toDateString() === now.toDateString()) {
                    return slotDate > now;
                }
                return true;
            });
        }


        /* =====================================================
           RENDER + CHECK SLOT
        ===================================================== */
        function renderTimeSlots(times) {
            const box = document.getElementById('timeSlots');
            box.innerHTML = '';

            if (!times.length) {
                box.innerHTML = `<p class="col-span-2 text-center text-red-500 py-4">لا توجد أوقات متاحة</p>`;
                return;
            }

            times.forEach(t => {
                const btn = document.createElement('button');
                btn.className = 'time-slot-btn';
                btn.textContent = formatTime(t);

                btn.onclick = async () => {
                    btn.disabled = true;
                    try {
                        const res = await fetch(
                            `/bookings/check-slot?consultant_id=${booking.consultant_id}&date=${booking.date}&time=${t}`, {
                                headers: {
                                    Accept: 'application/json'
                                }
                            }
                        );

                        const data = await res.json();

                        if (!data.available) {
                            alert('هذا الوقت تم حجزه للتو');
                            btn.classList.add('opacity-40');
                            return;
                        }

                        booking.time = t;
                        document.querySelectorAll('.time-slot-btn')
                            .forEach(b => b.classList.remove('selected'));

                        btn.classList.add('selected');
                        document.getElementById('nextStep').disabled = false;

                    } catch {
                        alert('خطأ أثناء التحقق من الوقت');
                    } finally {
                        btn.disabled = false;
                    }
                };

                box.appendChild(btn);
            });
        }

        /* =====================================================
           FORMAT TIME
        ===================================================== */
        function formatTime(time) {
            const [h, m] = time.split(':').map(Number);
            const p = h < 12 ? 'ص' : 'م';
            const hr = h > 12 ? h - 12 : h;
            return `${hr}:${String(m).padStart(2, '0')} ${p}`;
        }

        /* =====================================================
           STEP 2 → STEP 3
        ===================================================== */
        document.getElementById('nextStep').onclick = () => {
            document.getElementById('stepBox2').classList.add('hidden');
            document.getElementById('stepBox3').classList.remove('hidden');

            document.getElementById('summaryConsultant').textContent = booking.consultant_name;
            document.getElementById('summaryDate').textContent = document.getElementById('dateText').textContent;
            document.getElementById('summaryTime').textContent = formatTime(booking.time);
            document.getElementById('summaryPrice').textContent = booking.price;

            setStep(3);
        };

        function backToStep2() {
            document.getElementById('stepBox3').classList.add('hidden');
            document.getElementById('stepBox2').classList.remove('hidden');
            setStep(2);
        }

        function resetSlotsAndCalendar() {
            booking.date = null;
            booking.time = null;

            // مسح التاريخ المعروض
            const dateText = document.getElementById('dateText');
            if (dateText) dateText.textContent = 'لم يتم الاختيار';

            // مسح الأوقات
            const box = document.getElementById('timeSlots');
            if (box) {
                box.innerHTML = `
            <p class="col-span-2 text-gray-400 text-center py-8">
                اختر تاريخاً لعرض الأوقات المتاحة
            </p>
        `;
            }

            // تعطيل زر المتابعة
            const nextBtn = document.getElementById('nextStep');
            if (nextBtn) nextBtn.disabled = true;

            // إعادة إنشاء التقويم
            if (calendar) {
                calendar.destroy();
                calendar = null;
            }
        }


        /* =====================================================
           STEP 3 → PAYMENT
        ===================================================== */

        document.getElementById('goToPayment').addEventListener('click', async () => {

            // ⛔ منع الضغط المكرر
            if (isSubmitting) return;

            // تحقق بسيط
            if (!booking.consultant_id || !booking.date || !booking.time) {
                alert('الرجاء التأكد من اختيار الموعد');
                return;
            }

            const btn = document.getElementById('goToPayment');
            const loader = document.getElementById('paymentLoader');
            const text = document.getElementById('paymentBtnText');

            // 🔒 قفل الزر
            isSubmitting = true;
            btn.disabled = true;
            loader.classList.remove('hidden');
            text.textContent = 'جاري تحويلك للدفع...';

            try {
                const response = await fetch("{{ route('checkout.thawani') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        consultant_id: booking.consultant_id,
                        date: booking.date,
                        time: booking.time,
                        client_name: clientName.value.trim(),
                        client_phone: clientPhone.value.trim(),
                        client_age: clientAge.value,
                        client_address: clientAddress.value
                    })
                });

                // ⚠️ لو السيرفر رجّع خطأ
                if (!response.ok) {
                    const textError = await response.text();
                    throw new Error(textError || 'فشل إنشاء الحجز');
                }

                const data = await response.json();

                // ✅ تحويل للدفع
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                    return; // مهم جدًا
                }

                throw new Error('رد غير متوقع من السيرفر');

            } catch (error) {
                console.error(error);

                alert(
                    error.message.includes('محجوز') ?
                    'هذا الوقت تم حجزه للتو، الرجاء اختيار وقت آخر' :
                    'حدث خطأ أثناء تحويلك للدفع'
                );

                // 🔓 إعادة تفعيل الزر
                isSubmitting = false;
                btn.disabled = false;
                loader.classList.add('hidden');
                text.textContent = 'الانتقال للدفع';

                // رجّع المستخدم لاختيار الوقت
                backToStep2();
                loadSlots();
            }
        });
    </script>
@endsection
