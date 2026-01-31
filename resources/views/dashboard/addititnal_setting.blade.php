@extends('layouts.master')
@section('title', __('الأكواد المخصصة'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">

            {{-- HEADER --}}
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('الأكواد المخصصة') }}</h3>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">{{ __('الرئيسية') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('settings.index') }}">{{ __('الإعدادات') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('الأكواد المخصصة') }}</li>
                        </ol>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right">
                        <a href="{{ route('settings.index') }}" class="btn btn-outline-info">
                            <i class="ft-settings"></i> {{ __('الإعدادات العامة') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="content-body">
                <section id="custom-codes">

                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('الأكواد المخصصة') }}</h4>
                                   
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body">

                                        <form action="{{ route('add_general') }}" method="POST"
                                            id="customCodesForm">
                                            @csrf

                                            {{-- ================================================= --}}
                                            {{-- CSS مخصص --}}
                                            {{-- ================================================= --}}
                                            <div class="form-section mb-5">
                                                <div class="section-header mb-3">
                                                    <h5 class="section-title">
                                                        <i class="ft-layout text-primary"></i>
                                                        {{ __('CSS مخصص') }}
                                                    </h5>
                                                   
                                                </div>
                                                
                                                <div class="alert alert-info">
                                                    <i class="ft-info"></i>
                                                    {{ __('يتم تطبيق هذا الكود في جميع صفحات الموقع داخل وسم <style>') }}
                                                </div>
                                                
                                                <div class="row" id="cssSection">
                                                    <div class="col-md-12">
                                                        <div class="code-editor-container">
                                                            <label class="mb-1">
                                                                {{ __('أضف أكواد CSS مخصصة') }}
                                                                <small class="text-muted">(يتم تطبيقها على جميع الصفحات)</small>
                                                            </label>
                                                            
                                                         
                                                            <textarea class="form-control code-textarea" id="cssTextarea" rows="10"
                                                                name="general[custom_css]"
                                                                placeholder="/* أكواد CSS مخصصة */
.custom-button {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 25px;
    padding: 10px 30px;
    border: none;
    color: white;
    transition: transform 0.3s;
}

.custom-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.header-transparent {
    background: transparent !important;
    backdrop-filter: blur(10px);
}

/* استخدم !important بحذر */
.text-highlight {
    color: var(--secondary-color) !important;
}">{{ get_general_value('custom_css') }}</textarea>
                                                            
                                                            <small class="text-muted d-block mt-1">
                                                                <i class="ft-alert-triangle text-warning"></i>
                                                                {{ __('نصيحة: استخدم Selectors محددة لتجنب التعارض مع الأنماط الافتراضية') }}
                                                            </small>
                                                            <div class="css-preview mt-3 d-none">
                                                                <h6><i class="ft-eye"></i> معاينة CSS:</h6>
                                                                <div class="preview-box p-3 border rounded bg-light">
                                                                    <button class="btn custom-button">زر تجريبي</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- ================================================= --}}
                                            {{-- HTML مخصص --}}
                                            {{-- ================================================= --}}
                                            <div class="form-section mb-5">
                                                <div class="section-header mb-3">
                                                    <h5 class="section-title">
                                                        <i class="ft-code text-success"></i>
                                                        {{ __('HTML مخصص') }}
                                                    </h5>
                                                    
                                                </div>
                                                
                                                <div class="row" id="htmlSection">
                                                    <div class="col-md-6">
                                                        <div class="code-editor-container">
                                                            <label class="mb-1">
                                                                {{ __('HTML في Header') }}
                                                                <span class="badge badge-info">Head</span>
                                                            </label>
                                                            <div class="alert alert-warning">
                                                                <i class="ft-alert-triangle"></i>
                                                                {{ __('يتم إضافة هذا الكود قبل إغلاق وسم </head>') }}
                                                            </div>
                                                            
                                                           
                                                            <textarea class="form-control code-textarea" id="htmlHeadTextarea" rows="8"
                                                                name="general[custom_html_head]"
                                                                placeholder="<!-- أكواد مخصصة في ال head -->
<meta property='og:image' content='{{ asset('storage/' . get_general_value('website_logo')) }}'>
<link rel='preconnect' href='https://fonts.googleapis.com'>
<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
<link href='https://fonts.googleapis.com/css2?family=...' rel='stylesheet'>
<!-- إحصائيات أو أدوات تتبع -->
<script async src='https://www.googletagmanager.com/gtag/js?id=UA-XXXXX'></script>">{{ get_general_value('custom_html_head') }}</textarea>
                                                            
                                                            <small class="text-muted d-block mt-1">
                                                                <i class="ft-zap"></i>
                                                                {{ __('مثال: روابط خطوط، meta tags، أدوات تتبع، إلخ') }}
                                                            </small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="code-editor-container">
                                                            <label class="mb-1">
                                                                {{ __('HTML في Body') }}
                                                                <span class="badge badge-info">Body</span>
                                                            </label>
                                                            <div class="alert alert-warning">
                                                                <i class="ft-alert-triangle"></i>
                                                                {{ __('يتم إضافة هذا الكود قبل إغلاق وسم </body>') }}
                                                            </div>
                                                           
                                                            
                                                            <textarea class="form-control code-textarea" id="htmlBodyTextarea" rows="8"
                                                                name="general[custom_html_body]"
                                                                placeholder="<!-- أكواد مخصصة في نهاية ال body -->
<!-- زر واتساب عائم -->
<div class='floating-whatsapp'>
    <a href='https://wa.me/{{ get_general_value('phone') }}' target='_blank' class='whatsapp-float'>
        <i class='ft-phone-call'></i>
    </a>
</div>

<!-- شات دعم -->
<div id='custom-chat-widget'>
    <!-- محتوى الشات -->
</div>

<!-- إشعارات -->
<div class='notification-center'>
    <!-- إشعارات الموقع -->
</div>">{{ get_general_value('custom_html_body') }}</textarea>
                                                            
                                                            <small class="text-muted d-block mt-1">
                                                                <i class="ft-zap"></i>
                                                                {{ __('مثال: ويدجت، شات، أزرار عائمة، إلخ') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- ================================================= --}}
                                            {{-- JavaScript مخصص --}}
                                            {{-- ================================================= --}}
                                            <div class="form-section mb-5">
                                                <div class="section-header mb-3">
                                                    <h5 class="section-title">
                                                        <i class="ft-terminal text-danger"></i>
                                                        {{ __('JavaScript مخصص') }}
                                                    </h5>
                                                    
                                                </div>
                                                
                                                <div class="alert alert-danger">
                                                    <i class="ft-alert-octagon"></i>
                                                    {{ __('تنبيه: تأكد من صحة كود JavaScript قبل الحفظ لتجنب أخطاء الموقع') }}
                                                </div>
                                                
                                                <div class="row" id="jsSection">
                                                    <div class="col-md-12">
                                                        <div class="code-editor-container">
                                                            <label class="mb-1">
                                                                {{ __('أضف أكواد JavaScript') }}
                                                                <small class="text-muted">(يتم تنفيذها بعد تحميل الصفحة)</small>
                                                            </label>
                                                            
                                                          
                                                            
                                                            <textarea class="form-control code-textarea" id="jsTextarea" rows="12"
                                                                name="general[custom_js]"
                                                                placeholder="// أكواد JavaScript مخصصة
document.addEventListener('DOMContentLoaded', function() {
    // تحريك الأزرار عند المرور
    const buttons = document.querySelectorAll('.btn-primary, .custom-button');
    buttons.forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            btn.style.transform = 'scale(1.05)';
            btn.style.transition = 'transform 0.3s ease';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'scale(1)';
        });
    });

    // تتبع النقرات على الروابط
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(e) {
            console.log('تم النقر على رابط:', this.href);
            // يمكنك إضافة تتبع هنا
        });
    });

    // إضافة تأثيرات على التمرير
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.main-header');
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // إشعارات
    function showNotification(message, type = 'info') {
        // كود الإشعارات
    }
});">{{ get_general_value('custom_js') }}</textarea>
                                                            
                                                            <small class="text-muted d-block mt-1">
                                                                <i class="ft-alert-triangle"></i>
                                                                {{ __('تنبيه: استخدم console.log() للتصحيح. تجنب استخدام document.write()') }}
                                                            </small>
                                                            <div class="js-console mt-3 d-none">
                                                                <h6><i class="ft-monitor"></i> وحدة تحكم JavaScript:</h6>
                                                                <div class="console-output p-2 border rounded bg-dark text-light"
                                                                     style="height: 100px; overflow-y: auto; font-family: monospace;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- SAVE --}}
                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-success btn-lg">
                                                    <i class="la la-save"></i>
                                                    {{ __('حفظ الأكواد المخصصة') }}
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-lg ml-2"
                                                    onclick="resetCodes()">
                                                    <i class="la la-trash"></i>
                                                    {{ __('حذف جميع الأكواد') }}
                                                </button>
                                                <a href="{{ route('settings.index') }}" class="btn btn-outline-info btn-lg ml-2">
                                                    <i class="ft-arrow-left"></i>
                                                    {{ __('العودة للإعدادات العامة') }}
                                                </a>
                                            </div>

                                            {{-- CONFIRMATION MODAL --}}
                                            <div class="modal fade" id="resetModal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ __('تأكيد الحذف') }}</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('هل أنت متأكد من حذف جميع الأكواد المخصصة؟') }}</p>
                                                            <p class="text-danger">
                                                                <i class="ft-alert-triangle"></i>
                                                                {{ __('هذا الإجراء لا يمكن التراجع عنه!') }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ __('إلغاء') }}</button>
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="confirmReset()">{{ __('نعم، احذف الكل') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .form-section {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            margin-bottom: 25px;
        }
        
        .section-title {
            color: #333;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            font-size: 20px;
        }
        
        .code-textarea {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            background: #f8f9fa;
            border: 1px solid #ced4da;
        }
        
        .code-textarea:focus {
            background: #fff;
            border-color: #80bdff;
        }
        
        .editor-toolbar {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .code-editor-container {
            background: #fafafa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        
        .floating-whatsapp {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .whatsapp-float {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: #25D366;
            color: white;
            border-radius: 50%;
            font-size: 24px;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: all 0.3s;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1);
            color: white;
        }
    </style>
@endpush

