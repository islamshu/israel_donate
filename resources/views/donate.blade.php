@extends('layouts.app')

@section('title', 'Donation')

@section('content')
<div class="min-h-screen bg-slate-100" dir="rtl">

    <div class="relative overflow-hidden bg-blue-950 text-white">
        <div class="absolute inset-0 bg-gradient-to-l from-blue-900 to-blue-950 opacity-95"></div>

        <div class="relative max-w-6xl mx-auto px-6 py-20 text-center">
            <h1 class="text-5xl font-bold mb-6 leading-tight">
                יחד נבנה מחדש
            </h1>

            <p class="max-w-3xl mx-auto text-xl leading-9 text-blue-100">
                אלפי משפחות איבדו בתים, ציוד בסיסי ותחושת ביטחון.
                התרומה שלכם מסייעת בשיקום בתים, רכישת ציוד חיוני,
                תמיכה רפואית וסיוע למשפחות שנפגעו.
            </p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 -mt-12 relative z-10 pb-16">
        <div class="grid lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white rounded-3xl shadow-xl p-8 border border-slate-200">
                    <h2 class="text-3xl font-bold text-slate-800 mb-6">
                        למה התרומה שלכם חשובה?
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="w-12 h-12 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-2xl font-bold">
                                ✓
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-slate-800 mb-2">שיקום בתים</h3>
                                <p class="text-slate-600 leading-7">
                                    עזרה בתיקון ובנייה מחדש של בתים ומבנים שנפגעו.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="w-12 h-12 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-2xl font-bold">
                                ✓
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-slate-800 mb-2">ציוד חיוני</h3>
                                <p class="text-slate-600 leading-7">
                                    רכישת מזון, בגדים, תרופות וציוד בסיסי למשפחות.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="w-12 h-12 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-2xl font-bold">
                                ✓
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-slate-800 mb-2">סיוע רפואי</h3>
                                <p class="text-slate-600 leading-7">
                                    תמיכה רפואית ונפשית לנפגעים ולמשפחות הזקוקות לעזרה.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="w-12 h-12 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-2xl font-bold">
                                ✓
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-slate-800 mb-2">תמיכה מיידית</h3>
                                <p class="text-slate-600 leading-7">
                                    מתן מענה מהיר לילדים ולמשפחות שנשארו ללא קורת גג.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-xl p-8 border border-slate-200">
                    <h2 class="text-2xl font-bold text-slate-800 mb-4">100% שקיפות</h2>

                    <p class="text-slate-600 leading-8 text-lg">
                        כל תרומה מועברת ישירות לקרן הסיוע והשיקום. לאחר ביצוע התרומה,
                        תקבלו אישור באימייל ופרטי התרומה ישמרו בצורה מאובטחת.
                    </p>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-3xl shadow-2xl p-8 border border-slate-200 sticky top-8">
                    <h2 class="text-3xl font-bold text-center text-slate-800 mb-8">
                        תרמו עכשיו
                    </h2>

                    <form method="POST" action="{{ route('donation.create') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">
                                שם מלא
                            </label>
                            <input
                                type="text"
                                name="name"
                                required
                                class="w-full rounded-2xl border border-slate-300 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-blue-700"
                                placeholder="הכניסו את שמכם המלא">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">
                                כתובת אימייל
                            </label>
                            <input
                                type="email"
                                name="email"
                                required
                                class="w-full rounded-2xl border border-slate-300 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-blue-700"
                                placeholder="example@email.com">
                        </div>

                        <div>
                            <label class="block mb-3 text-sm font-bold text-slate-700">
                                סכום התרומה
                            </label>

                            <div class="grid grid-cols-3 gap-3 mb-4">
                                <button type="button" data-amount="25"
                                    class="preset-amount rounded-2xl border border-slate-300 py-3 font-bold hover:bg-blue-50 hover:border-blue-700 transition">
                                    $25
                                </button>

                                <button type="button" data-amount="50"
                                    class="preset-amount rounded-2xl border border-slate-300 py-3 font-bold hover:bg-blue-50 hover:border-blue-700 transition">
                                    $50
                                </button>

                                <button type="button" data-amount="100"
                                    class="preset-amount rounded-2xl border border-slate-300 py-3 font-bold hover:bg-blue-50 hover:border-blue-700 transition">
                                    $100
                                </button>
                            </div>

                            <input
                                type="number"
                                min="10"
                                step="1"
                                id="amount"
                                name="amount"
                                required
                                class="w-full rounded-2xl border border-slate-300 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-blue-700"
                                placeholder="הכניסו סכום בדולר">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">
                                אמצעי תשלום
                            </label>

                            <select
                                name="payment_type"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-blue-700">
                                <option value="crypto" selected>USDT</option>
                                {{-- <option value="card">Visa / MasterCard → USDT</option> --}}
                            </select>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-blue-900 hover:bg-blue-800 text-white rounded-2xl py-4 text-lg font-bold transition duration-200 shadow-lg">
                            המשך לתשלום
                        </button>

                        <div class="text-center text-sm text-slate-500 leading-7 pt-2">
                            התשלום מאובטח באמצעות NOWPayments + ChangeNOW
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.querySelectorAll('.preset-amount').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('amount').value = this.dataset.amount;

            document.querySelectorAll('.preset-amount').forEach(btn => {
                btn.classList.remove('bg-blue-900', 'text-white', 'border-blue-900');
            });

            this.classList.add('bg-blue-900', 'text-white', 'border-blue-900');
        });
    });
</script>
@endsection