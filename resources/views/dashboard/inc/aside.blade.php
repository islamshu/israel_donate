<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
    role="navigation" data-menu="menu-wrapper">

    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">

            {{-- ===================== Dashboard ===================== --}}
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="la la-home"></i>
                    <span>الرئيسية</span>
                </a>
            </li>

            {{-- ===================== Settings ===================== --}}
            <li class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('settings.index') }}">
                    <i class="la la-cog"></i>
                    <span>الإعدادات</span>
                </a>
            </li>

            {{-- ===================== Home Sections ===================== --}}
            <li
                class="dropdown nav-item
                {{ request()->routeIs(['hero.*', 'home-stats.*', 'dashboard.about.*', 'dashboard.home-services.*'])
                    ? 'active'
                    : '' }}">

                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <i class="la la-layer-group"></i>
                    <span>محتوى الصفحة الرئيسية</span>
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('hero.edit') }}">
                            <i class="la la-star"></i> Hero Section
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('home-stats.edit') }}">
                            <i class="la la-chart-bar"></i> الإحصائيات
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('dashboard.about.edit') }}">
                            <i class="la la-info-circle"></i> من نحن
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('dashboard.home-services.index') }}">
                            <i class="la la-cogs"></i> خدمات الموقع
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ===================== Consultants ===================== --}}
            <li class="nav-item {{ request()->routeIs('dashboard.consultants.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.consultants.index') }}">
                    <i class="la la-user-md"></i>
                    <span>الاستشاريين</span>
                </a>
            </li>

            {{-- ===================== Bookings ===================== --}}
            <li class="nav-item {{ request()->routeIs('dashboard.bookings.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.bookings.index') }}">
                    <i class="la la-calendar-check"></i>
                    <span>الحجوزات</span>
                </a>
            </li>
            {{-- ===================== Contact Messages ===================== --}}
            <li class="nav-item {{ request()->routeIs('dashboard.contact*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('dashboard.contact.index') }}">
                    <i class="la la-envelope"></i>
                    <span class="ml-1">طلبات التواصل</span>
                    @php
                       $unreadContactCount=  App\Models\ContactMessage::where('is_read', false)->count()
                    @endphp
                    @if ($unreadContactCount > 0)
                        <span class="badge badge-danger ml-1">
                            {{ $unreadContactCount }}
                        </span>
                    @endif
                </a>
            </li>

            {{-- ===================== Media ===================== --}}
            <li class="nav-item {{ request()->routeIs('dashboard.media.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.media.index') }}">
                    <i class="las la-photo-video"></i>
                    <span>الوسائط</span>
                </a>
            </li>

        </ul>
    </div>
</div>
