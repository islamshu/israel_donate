@extends('layouts.frontend')

@section('title', 'إرسال استشارة سريعة')

@section('styles')
<style>
    .file-input::-webkit-file-upload-button {
        cursor: pointer;
        background-color: #3b82f6;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: none;
        transition: background 0.2s ease;
    }
    .file-input::-webkit-file-upload-button:hover {
        background-color: #2563eb;
    }
    
    /* تحسين شكل الملفات المختارة */
    .file-list {
        margin-top: 0.5rem;
    }
    
    .file-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.5rem;
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .file-item:hover {
        background-color: #f3f4f6;
    }
    
    .remove-file {
        color: #ef4444;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .remove-file:hover {
        color: #dc2626;
    }
    
    /* تحسين شكل الملخص */
    #summaryBox {
        border-right: 4px solid #3b82f6;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-100 p-6 flex justify-center">
    <div class="w-full max-w-5xl">

        {{-- رأس الصفحة --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-2">إرسال استشارة سريعة</h2>
            <p class="text-gray-600">املأ النموذج التالي وسيتم الرد عليك في أقرب وقت ممكن</p>
        </div>

        {{-- فورم الاستشارة --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <form id="quickConsultForm" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- اختيار المستشار --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        اختر المستشار <span class="text-red-500">*</span>
                    </label>
                    <select name="consultant_id" id="consultantId" required
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- اختر مستشار --</option>
                        @foreach ($consultants as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} - {{ $c->title ?? 'مستشار' }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- بيانات العميل --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            الاسم الكامل <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="client_name" placeholder="أدخل اسمك الكامل" required
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            البريد الإلكتروني <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="client_email" placeholder="example@email.com" required
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            رقم الهاتف <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="client_phone" placeholder="مثال: 05xxxxxxxx" required
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>

                {{-- نص الاستشارة --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        نص الاستشارة <span class="text-red-500">*</span>
                    </label>
                    <textarea name="consultation_text" rows="5" placeholder="اكتب استشارتك هنا..." required
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>

                {{-- رفع ملفات --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">الملفات المرفقة (اختياري)</label>
                    
                    {{-- منطقة رفع الملفات --}}
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition" id="dropZone">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600 mb-2">اسحب وأفلت الملفات هنا أو</p>
                        <label class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer transition">
                            اختر ملفات
                            <input type="file" name="files[]" multiple class="hidden file-input" id="fileInput">
                        </label>
                        <p class="text-xs text-gray-500 mt-2">pdf, png, jpg, docx - الحد الأقصى 10MB لكل ملف</p>
                    </div>

                    {{-- قائمة الملفات المختارة --}}
                    <div id="fileList" class="file-list mt-3"></div>
                </div>

                {{-- ملخص قبل الإرسال --}}
                <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg hidden" id="summaryBox">
                    <h4 class="font-bold text-blue-700 mb-2 flex items-center">
                        <i class="fas fa-check-circle ml-2"></i>
                        ملخص الاستشارة
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                        <p><strong class="text-gray-700">المستشار:</strong> <span id="summaryConsultant" class="text-gray-600"></span></p>
                        <p><strong class="text-gray-700">الاسم:</strong> <span id="summaryName" class="text-gray-600"></span></p>
                        <p><strong class="text-gray-700">البريد:</strong> <span id="summaryEmail" class="text-gray-600"></span></p>
                        <p><strong class="text-gray-700">الهاتف:</strong> <span id="summaryPhone" class="text-gray-600"></span></p>
                        <p class="md:col-span-2"><strong class="text-gray-700">الاستشارة:</strong> <span id="summaryText" class="text-gray-600"></span></p>
                    </div>
                </div>

                {{-- زر الإرسال --}}
                <button type="submit" id="submitBtn"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-md transition flex items-center justify-center gap-2">
                    <svg id="loader" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span id="btnText">إرسال الاستشارة</span>
                </button>
            </form>
        </div>

        {{-- رسالة النجاح المنبثقة --}}
       {{-- رسالة النجاح المنبثقة --}}
<div id="successMessage" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md mx-4 text-center">
        <div class="text-green-600 text-6xl mb-4">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">تم الإرسال بنجاح!</h3>
        <p class="text-gray-600 mb-4">رقم استشارتك هو:</p>
        <div class="bg-blue-100 text-blue-800 text-2xl font-bold py-3 px-6 rounded-lg mb-4" id="consultationNumber"></div>
        <p class="text-sm text-gray-500 mb-6">احتفظ برقم الاستشارة لمتابعة حالتها</p>
        <div class="flex gap-3">
            {{-- الرابط المعدل --}}
            <a href="{{ route('consultation.query.form') }}" id="followUpLink" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg transition">
                متابعة الاستشارة
            </a>
            <button onclick="closeSuccessMessage()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded-lg transition">
                إضافة استشارة أخرى
            </button>
        </div>
    </div>
</div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // متغيرات عامة
    const fileInput = document.getElementById('fileInput');
    const dropZone = document.getElementById('dropZone');
    const fileList = document.getElementById('fileList');
    const form = document.getElementById('quickConsultForm');
    const successMessage = document.getElementById('successMessage');
    let selectedFiles = [];

    // 1. رفع الملفات عن طريق الزر
    fileInput.addEventListener('change', function(e) {
        addFiles(e.target.files);
    });

    // 2. رفع الملفات عن طريق السحب والإفلات
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-500', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        addFiles(files);
    });

    // 3. دالة إضافة الملفات للقائمة
    function addFiles(files) {
        for (let file of files) {
            // تحقق من حجم الملف (10MB كحد أقصى)
            if (file.size > 10 * 1024 * 1024) {
                alert(`الملف ${file.name} كبير جداً. الحد الأقصى 10MB`);
                continue;
            }
            
            // تحقق من نوع الملف
            const allowedTypes = ['image/jpeg', 'image/png','image/avif', 'image/jpg', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!allowedTypes.includes(file.type) && !file.name.match(/\.(jpg|jpeg|png|pdf|doc|docx)$/i)) {
                alert(`نوع الملف ${file.name} غير مسموح به`);
                continue;
            }
            
            selectedFiles.push(file);
        }
        
        updateFileList();
        updateFileInput();
    }

    // 4. تحديث قائمة الملفات
    function updateFileList() {
        fileList.innerHTML = '';
        
        if (selectedFiles.length === 0) {
            return;
        }
        
        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';
            
            // أيقونة حسب نوع الملف
            let icon = 'fa-file';
            let color = 'text-blue-500';
            
            if (file.type.includes('image')) {
                icon = 'fa-file-image';
                color = 'text-green-500';
            } else if (file.type.includes('pdf')) {
                icon = 'fa-file-pdf';
                color = 'text-red-500';
            } else if (file.type.includes('word') || file.name.match(/\.docx?$/i)) {
                icon = 'fa-file-word';
                color = 'text-blue-600';
            }
            
            // حجم الملف
            const fileSize = (file.size / 1024).toFixed(1) + ' KB';
            
            fileItem.innerHTML = `
                <div class="flex items-center flex-1">
                    <i class="fas ${icon} ${color} ml-2 text-lg"></i>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-700">${file.name}</p>
                        <p class="text-xs text-gray-500">${fileSize}</p>
                    </div>
                </div>
                <i class="fas fa-times remove-file" onclick="removeFile(${index})"></i>
            `;
            
            fileList.appendChild(fileItem);
        });
    }

    // 5. حذف ملف من القائمة
    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        updateFileList();
        updateFileInput();
    };

    // 6. تحديث حقل رفع الملفات
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    // 7. إرسال الفورم
// 7. إرسال الفورم
document.getElementById('quickConsultForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // التحقق من الحقول المطلوبة
    if (!form.consultant_id.value || !form.client_name.value || !form.client_email.value || !form.client_phone.value || !form.consultation_text.value) {
        alert('الرجاء ملء جميع الحقول المطلوبة');
        return;
    }

    // عرض الملخص
    document.getElementById('summaryConsultant').textContent = form.consultant_id.options[form.consultant_id.selectedIndex]?.text || '';
    document.getElementById('summaryName').textContent = form.client_name.value;
    document.getElementById('summaryEmail').textContent = form.client_email.value;
    document.getElementById('summaryPhone').textContent = form.client_phone.value;
    document.getElementById('summaryText').textContent = form.consultation_text.value.substring(0, 100) + (form.consultation_text.value.length > 100 ? '...' : '');
    document.getElementById('summaryBox').classList.remove('hidden');

    // تجهيز الزر للإرسال
    const btn = document.getElementById('submitBtn');
    const loader = document.getElementById('loader');
    const text = document.getElementById('btnText');

    btn.disabled = true;
    loader.classList.remove('hidden');
    text.textContent = 'جاري الإرسال...';

    try {
        const res = await fetch("{{ route('quick.booking.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (data.success) {
            // عرض رقم الاستشارة
            const consultationNumber = data.consultation_number;
            document.getElementById('consultationNumber').textContent = consultationNumber;
            
            // تعديل رابط متابعة الاستشارة عشان يحول على رقم الاستشارة الجديد
            const followUpLink = document.getElementById('followUpLink');
            if (followUpLink) {
                followUpLink.href = "{{ route('consultation.query.form', '') }}" + '/' + consultationNumber;
            }
            
            successMessage.classList.remove('hidden');
            
            // تصفير الفورم
            form.reset();
            selectedFiles = [];
            updateFileList();
            updateFileInput();
            document.getElementById('summaryBox').classList.add('hidden');
        } else {
            alert('حدث خطأ أثناء الإرسال');
        }
    } catch(err) {
        console.error(err);
        alert('حدث خطأ أثناء الإرسال');
    } finally {
        btn.disabled = false;
        loader.classList.add('hidden');
        text.textContent = 'إرسال الاستشارة';
    }
});

    // 8. إغلاق رسالة النجاح
    window.closeSuccessMessage = function() {
        successMessage.classList.add('hidden');
    };

    // 9. إغلاق رسالة النجاح بالضغط على ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !successMessage.classList.contains('hidden')) {
            closeSuccessMessage();
        }
    });

    // 10. إغلاق رسالة النجاح بالضغط خارجها
    successMessage.addEventListener('click', function(e) {
        if (e.target === this) {
            closeSuccessMessage();
        }
    });
</script>
@endsection