@extends('layouts.frontend')

@section('title', 'استعلام عن الاستشارة')

@section('content')
<div class="min-h-screen bg-gray-100 p-6 flex justify-center">
    <div class="w-full max-w-5xl">

        {{-- نموذج البحث --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">استعلام عن الاستشارة</h2>
            
            <form action="{{ route('consultation.query.result') }}" method="POST" class="flex flex-col md:flex-row gap-3">
                @csrf
                <input type="text" name="consultation_number" 
                       value="{{ request()->route('consultation_number') ?? old('consultation_number') }}"
                       placeholder="أدخل رقم الاستشارة" required
                       class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition">
                    بحث
                </button>
            </form>
            
            @error('consultation_number')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
            
            @if(session('success'))
                <p class="text-green-500 text-sm mt-2">{{ session('success') }}</p>
            @endif
        </div>

        @if(isset($consultation) && $consultation)
        {{-- بيانات الاستشارة --}}
        <div class="bg-white shadow-md rounded-lg p-6 space-y-6">

            {{-- رأس الصفحة مع رقم الاستشارة --}}
            <div class="border-b pb-4">
                <h1 class="text-xl font-bold text-gray-800">
                    رقم الاستشارة: <span class="text-blue-600">{{ $consultation->consultation_number }}</span>
                </h1>
            </div>

            {{-- العميل والمستشار --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 rounded-md shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-1">العميل</h3>
                    <h2 class="font-semibold text-lg">{{ $consultation->client_name }}</h2>
                    <p class="text-gray-600 text-sm"><i class="fas fa-envelope ml-1"></i>{{ $consultation->client_email }}</p>
                    <p class="text-gray-600 text-sm"><i class="fas fa-phone ml-1"></i>{{ $consultation->client_phone }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-md shadow-sm">
                    <h3 class="text-gray-500 text-sm mb-1">المستشار</h3>
                    <h2 class="font-semibold text-lg">{{ $consultation->consultant->name ?? 'غير محدد' }}</h2>
                    <p class="text-gray-600 text-sm">تاريخ الاستشارة: {{ $consultation->created_at->format('Y-m-d') }}</p>
                    <p class="text-gray-600 text-sm">الحالة:
                        <span class="px-2 py-1 rounded-full text-xs 
                            @if($consultation->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($consultation->status == 'answered') bg-green-100 text-green-800
                            @else bg-gray-200 text-gray-600 @endif">
                            @switch($consultation->status)
                                @case('pending') قيد الانتظار @break
                                @case('answered') تم الرد @break
                                @case('closed') مغلقة @break
                                @default {{ $consultation->status }}
                            @endswitch
                        </span>
                    </p>
                </div>
            </div>

            {{-- نص الاستشارة --}}
            <div>
                <h3 class="text-gray-500 text-sm mb-1">نص الاستشارة</h3>
                <div class="bg-gray-50 p-4 rounded-md text-gray-700">
                    {{ $consultation->consultation_text }}
                </div>
            </div>

            {{-- الملفات المرفقة في الاستشارة الأصلية --}}
            @if($consultation->files && $consultation->files->count() > 0)
            <div>
                <h3 class="text-gray-500 text-sm mb-3">الملفات المرفقة</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($consultation->files as $file)
                        @php
                            $fileName = basename($file->file_path);
                            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                            $fileSize = file_exists(storage_path('app/public/' . $file->file_path)) 
                                ? round(filesize(storage_path('app/public/' . $file->file_path)) / 1024, 1) . ' KB'
                                : 'حجم غير معروف';
                            
                            // تحديد الأيقونة حسب نوع الملف
                            $icon = 'fa-file';
                            $color = 'text-gray-600';
                            
                            if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                $icon = 'fa-file-image';
                                $color = 'text-green-600';
                            } elseif(in_array($extension, ['pdf'])) {
                                $icon = 'fa-file-pdf';
                                $color = 'text-red-600';
                            } elseif(in_array($extension, ['doc', 'docx'])) {
                                $icon = 'fa-file-word';
                                $color = 'text-blue-600';
                            } elseif(in_array($extension, ['xls', 'xlsx'])) {
                                $icon = 'fa-file-excel';
                                $color = 'text-emerald-600';
                            } elseif(in_array($extension, ['zip', 'rar', '7z'])) {
                                $icon = 'fa-file-archive';
                                $color = 'text-yellow-600';
                            } elseif(in_array($extension, ['txt'])) {
                                $icon = 'fa-file-lines';
                                $color = 'text-gray-600';
                            }
                        @endphp
                        
                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" 
                           class="flex items-center p-3 bg-white border border-gray-200 rounded-lg hover:shadow-md transition-all hover:border-blue-300 group">
                            <div class="flex-shrink-0 ml-3">
                                <i class="fas {{ $icon }} {{ $color }} text-2xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate group-hover:text-blue-600">
                                    {{ $fileName }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $fileSize }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 mr-2 text-gray-400 group-hover:text-blue-600">
                                <i class="fas fa-download"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- الردود --}}
            <div>
                <h3 class="text-gray-500 text-sm mb-2">الردود</h3>
                <div class="max-h-96 overflow-y-auto space-y-3 p-2">
                    @forelse($consultation->replies as $reply)
                        <div class="p-3 rounded-lg {{ $reply->reply_type == 'client' ? 'bg-green-50 mr-4' : 'bg-blue-50 ml-4' }}">
                            <div class="flex justify-between items-center">
                                <strong>
                                    @if($reply->reply_type == 'client')
                                        <i class="fas fa-user ml-1 text-green-600"></i>
                                        {{ $reply->client_name ?? 'العميل' }}
                                    @elseif($reply->reply_type == 'admin')
                                        <i class="fas fa-user-tie ml-1 text-blue-600"></i>
                                        {{ $reply->admin_name ?? 'الإدارة' }}
                                    @elseif($reply->reply_type == 'consultant')
                                        <i class="fas fa-user-graduate ml-1 text-purple-600"></i>
                                        {{ $reply->admin_name ?? 'المستشار' }}
                                    @else
                                        <i class="fas fa-robot ml-1 text-gray-600"></i>
                                        {{ $reply->responder_name ?? 'النظام' }}
                                    @endif
                                </strong>
                                <small class="text-gray-500">
                                    <i class="far fa-clock ml-1"></i>
                                    {{ $reply->created_at->format('Y-m-d H:i') }}
                                </small>
                            </div>
                            <p class="mt-2 text-gray-700">{{ $reply->reply_text }}</p>
                            
                            @if($reply->file_path)
                                @php
                                    $replyFileName = basename($reply->file_path);
                                    $replyExtension = strtolower(pathinfo($replyFileName, PATHINFO_EXTENSION));
                                    
                                    $replyIcon = 'fa-file';
                                    $replyColor = 'text-gray-600';
                                    
                                    if(in_array($replyExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        $replyIcon = 'fa-file-image';
                                        $replyColor = 'text-green-600';
                                    } elseif($replyExtension == 'pdf') {
                                        $replyIcon = 'fa-file-pdf';
                                        $replyColor = 'text-red-600';
                                    } elseif(in_array($replyExtension, ['doc', 'docx'])) {
                                        $replyIcon = 'fa-file-word';
                                        $replyColor = 'text-blue-600';
                                    }
                                @endphp
                                
                                <a href="{{ asset('storage/' . $reply->file_path) }}" target="_blank" 
                                   class="inline-flex items-center mt-2 px-3 py-1 bg-white rounded-md border border-gray-200 hover:border-blue-300 transition-colors text-sm">
                                    <i class="fas {{ $replyIcon }} {{ $replyColor }} ml-2"></i>
                                    <span class="text-gray-700">{{ $replyFileName }}</span>
                                    <i class="fas fa-external-link-alt mr-2 text-xs text-gray-400"></i>
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-8">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <p>لا توجد ردود بعد</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- نموذج إضافة رد جديد --}}
            <div class="pt-4 border-t border-gray-200 mt-4">
                <h3 class="text-gray-500 text-sm mb-2">إضافة رد جديد</h3>
                <form action="{{ route('quick.consult.client_reply', $consultation) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <textarea name="reply_text" required placeholder="اكتب ردك هنا..." rows="3"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    
                    <div class="flex items-center gap-2">
                        <label class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md cursor-pointer transition">
                            <i class="fas fa-upload ml-1"></i>
                            اختر ملفاً
                            <input type="file" name="file" class="hidden file-input">
                        </label>
                        <span class="text-sm text-gray-500 file-name">لم يتم اختيار ملف</span>
                    </div>
                    
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                        إرسال الرد
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- CSS إضافي --}}
<style>
    /* تحسين شكل المرفقات */
    .file-attachment {
        transition: all 0.2s ease;
    }
    
    .file-attachment:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    /* تحسين شكل الردود */
    .reply-bubble {
        position: relative;
    }
    
    .reply-bubble.client::before {
        left: -10px;
        border-width: 10px 10px 10px 0;
        border-color: transparent #f0fdf4 transparent transparent;
    }
    
    .reply-bubble.admin::before {
        right: -10px;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent #eff6ff;
    }
    
    /* تحسين شريط التمرير */
    .max-h-96::-webkit-scrollbar {
        width: 6px;
    }
    
    .max-h-96::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .max-h-96::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .max-h-96::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection

@section('scripts')
<script>
    // كود رفع الملفات - بسيط ومضمون
    document.addEventListener('DOMContentLoaded', function() {
        // انتظر شوية للتأكد من تحميل الصفحة
        setTimeout(function() {
            // اختر كل حقول رفع الملفات
            const fileInputs = document.querySelectorAll('.file-input');
            
            fileInputs.forEach(function(input) {
                input.addEventListener('change', function(e) {
                    // ابحث عن الـ span اللي جنب هذا الـ input
                    const parentDiv = this.closest('.flex.items-center.gap-2');
                    if (parentDiv) {
                        const fileNameSpan = parentDiv.querySelector('.file-name');
                        if (fileNameSpan) {
                            const fileName = e.target.files[0]?.name || 'لم يتم اختيار ملف';
                            fileNameSpan.textContent = fileName;
                            console.log('تم اختيار ملف: ' + fileName); // للتصحيح
                        }
                    }
                });
            });
            
            console.log('تم تفعيل رفع الملفات'); // للتصحيح
        }, 300);
    });
</script>
@endsection