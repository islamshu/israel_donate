 <!-- اتصل بنا -->
 <section id="contact" class="py-20 bg-soft-blue">
     <div class="container mx-auto px-4">
         <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center section-title reveal-on-scroll">اتصل بنا</h2>

         <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
             <div>
                 <div class="bg-white rounded-2xl shadow-lg p-8 card-hover">
                     <h3 class="text-2xl font-bold text-primary mb-6">معلومات التواصل</h3>

                     <div class="space-y-6">
                         <div class="flex items-center">
                             <div class="w-12 h-12 rounded-full bg-soft-purple flex items-center justify-center ml-4">
                                 <i class="fas fa-map-marker-alt text-primary"></i>
                             </div>
                             <div>
                                 <h4 class="font-bold text-gray-800">العنوان</h4>
                                 <p class="text-gray-700"> {{ get_general_value('address_ar') }}</p>
                             </div>
                         </div>

                         <div class="flex items-center">
                             <div class="w-12 h-12 rounded-full bg-soft-purple flex items-center justify-center ml-4">
                                 <i class="fas fa-phone-alt text-primary"></i>
                             </div>
                             <div>
                                 <h4 class="font-bold text-gray-800">الهاتف</h4>
                                 <p class="text-gray-700">{{ get_general_value('phone') }}</p>
                             </div>
                         </div>

                         <div class="flex items-center">
                             <div class="w-12 h-12 rounded-full bg-soft-purple flex items-center justify-center ml-4">
                                 <i class="fas fa-envelope text-primary"></i>
                             </div>
                             <div>
                                 <h4 class="font-bold text-gray-800">البريد الإلكتروني</h4>
                                 <p class="text-gray-700">{{ get_general_value('website_email') }}</p>
                             </div>
                         </div>

                     </div>
                 </div>
             </div>

             <div>
                 <div class="bg-white rounded-2xl shadow-lg p-8 card-hover">
                     <h3 class="text-2xl font-bold text-primary mb-6">إرسال رسالة</h3>
                     <p id="contactFormMsg" class="mt-4 text-center text-sm hidden"></p>

                     <form id="contactForm">
                         @csrf

                         <div class="mb-6">
                             <label class="block text-gray-700 mb-2 font-medium">الاسم الكامل</label>
                             <input name="name" type="text"
                                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                 required>
                         </div>

                         <div class="mb-6">
                             <label class="block text-gray-700 mb-2 font-medium">البريد الإلكتروني</label>
                             <input name="email" type="email"
                                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                 required>
                         </div>

                         <div class="mb-6">
                             <label class="block text-gray-700 mb-2 font-medium">الموضوع</label>
                             <input name="subject" type="text"
                                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                 required>
                         </div>

                         <div class="mb-6">
                             <label class="block text-gray-700 mb-2 font-medium">الرسالة</label>
                             <textarea name="message" rows="4"
                                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary" required></textarea>
                         </div>

                         <button type="submit" id="contactSubmitBtn"
                             class="btn-gradient text-white font-bold px-8 py-3 rounded-full w-full transition">
                             إرسال الرسالة
                             <i class="fas fa-paper-plane ml-2"></i>
                         </button>

                     </form>

                 </div>
             </div>
         </div>
     </div>
 </section>
 <script>
     document.getElementById('contactForm').addEventListener('submit', function(e) {
         e.preventDefault();

         const form = this;
         const btn = document.getElementById('contactSubmitBtn');
         const msg = document.getElementById('contactFormMsg');

         // تنظيف الرسائل السابقة
         msg.classList.add('hidden');
         msg.classList.remove('text-green-600', 'text-red-500');
         msg.textContent = '';

         btn.disabled = true;
         btn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> جاري الإرسال...';

         fetch("{{ route('contact.send') }}", {
                 method: 'POST',
                 headers: {
                     'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                     'Accept': 'application/json',
                 },
                 body: new FormData(form)
             })
             .then(async res => {
                 const data = await res.json();
                 if (!res.ok) throw data;
                 return data;
             })
             .then(data => {
                 // نجاح
                 msg.classList.remove('hidden');
                 msg.classList.add('text-green-600');
                 msg.textContent = data.message || 'تم الإرسال بنجاح';

                 // تفريغ الحقول فقط عند النجاح
                 form.reset();
             })
             .catch(error => {
                 // خطأ
                 msg.classList.remove('hidden');
                 msg.classList.add('text-red-500');

                 if (error?.errors) {
                     // أخطاء Validation
                     msg.textContent = Object.values(error.errors)[0][0];
                 } else {
                     msg.textContent = error?.message || 'حدث خطأ، حاول مرة أخرى';
                 }
             })
             .finally(() => {
                 btn.disabled = false;
                 btn.innerHTML = 'إرسال الرسالة <i class="fas fa-paper-plane ml-2"></i>';
             });
     });
 </script>
