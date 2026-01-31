<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- عنوان الصفحة -->
    <title>
        {{ get_general_value('website_name')  }}
        | استشارات نفسية وأسرية متكاملة
    </title>

    <!-- وصف الموقع (SEO) -->
    <meta
        name="description"
        content="مركز الإشراق الاستشاري يقدم استشارات نفسية وأسرية متخصصة، جلسات فردية، أسرية، تطوير شخصي، وحلول علاجية بمعايير مهنية عالية."
    >

    <!-- كلمات مفتاحية -->
    <meta
        name="keywords"
        content="استشارات نفسية, استشارات أسرية, علاج نفسي, جلسات نفسية, مركز استشاري, الإرشاد الأسري"
    >

    <!-- اسم الموقع -->
    <meta name="application-name" content="{{ get_general_value('website_name') }}">

    <!-- أيقونة الموقع -->
    <link
        rel="icon"
        type="image/png"
        href="{{ asset('storage/' . get_general_value('website_logo')) }}"
    >

    <!-- Apple Touch Icon -->
    <link
        rel="apple-touch-icon"
        href="{{ asset('storage/' . get_general_value('website_logo')) }}"
    >

    <!-- Open Graph (Facebook / WhatsApp) -->
    <meta property="og:title" content="{{ get_general_value('website_name') }} | استشارات نفسية وأسرية">
    <meta property="og:description" content="جلسات نفسية وأسرية متخصصة مع نخبة من المستشارين المعتمدين. احجز جلستك الآن.">
    <meta property="og:image" content="{{ asset('storage/' . get_general_value('website_logo')) }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ar_AR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ get_general_value('website_name') }}">
    <meta name="twitter:description" content="مركز متخصص في الاستشارات النفسية والأسرية والتطوير الشخصي.">
    <meta name="twitter:image" content="{{ asset('storage/' . get_general_value('website_logo')) }}">

    <!-- رابط Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- إضافة مكونات إضافية لـ Tailwind -->
  
    <!-- أيقونات Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- خطوط Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
  
    <style>
        body {
            font-family: 'Cairo', 'Tajawal', sans-serif;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.95) 0%, rgba(16, 185, 129, 0.9) 100%);
        }
        
        .section-title {
            position: relative;
            padding-bottom: 15px;
            display: inline-block;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #10B981 0%, #4F46E5 100%);
            border-radius: 2px;
        }
        
        .nav-link {
            position: relative;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            bottom: -5px;
            right: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #10B981 0%, #4F46E5 100%);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.15);
        }
        
        .btn-gradient {
            background: linear-gradient(90deg, #4F46E5 0%, #10B981 100%);
            background-size: 200% 100%;
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background-position: 100% 0;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }
     
        
        .fc .fc-toolbar-title {
            font-size: 1.4em;
            font-weight: 600;
        }
        
        .fc .fc-button-primary {
            background-color: #4F46E5;
            border-color: #4F46E5;
        }
        
        .fc .fc-button-primary:hover {
            background-color: #4338CA;
            border-color: #4338CA;
        }
        
        .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(16, 185, 129, 0.1);
        }
        
      
        .loading-bar {
            height: 4px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            background: linear-gradient(90deg, #4F46E5 0%, #10B981 100%);
            transform-origin: 0%;
        }
        
        .floating-contact {
            position: fixed;
            bottom: 30px;
            left: 30px;
            z-index: 100;
            animation: float 3s ease-in-out infinite;
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #4F46E5 0%, #10B981 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }
        
       
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal-overlay.active {
            display: flex;
        }
        
        .modal-content {
            background: white;
            border-radius: 16px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: scaleIn 0.3s ease-out;
        }
        
        
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }
        
        .reveal-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
   @yield('styles')
        
</head>
<body class="bg-gray-50" lang="ar" dir="rtl">
    <!-- شريط التحميل -->
    <div class="loading-bar" id="loadingBar"></div>
    