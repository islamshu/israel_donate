@extends('layouts.master')
@section('title', 'خدمات الصفحة الرئيسية')

@section('style')
    <style>
        /* ================= Toggle Switch ================= */
        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        table img:hover {
            transform: scale(1.8);
            z-index: 10;
            position: relative;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #dc3545;
            transition: .3s;
            border-radius: 30px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }
    </style>
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">

            {{-- ================= PAGE HEADER ================= --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-0">خدمات الصفحة الرئيسية</h3>
                    <small class="text-muted">إدارة وعرض خدمات الموقع</small>
                </div>

                <a href="{{ route('dashboard.home-services.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i>
                    إضافة خدمة
                </a>
            </div>

            {{-- ================= ALERT ================= --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


            {{-- ================= CARD ================= --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">قائمة الخدمات</h5>
                        <small class="text-muted">تفعيل – تعديل – حذف</small>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th width="60" class="text-center">#</th>
                                <th width="90" class="text-center">الصورة</th>
                                <th width="90" class="text-center">الأيقونة</th>
                                <th>العنوان</th>
                                <th width="140">السعر</th>
                                <th width="110" class="text-center">الحالة</th>
                                <th width="180" class="text-center">التحكم</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($services as $service)
                                <tr>
                                    {{-- Order --}}
                                    <td class="text-center fw-bold text-muted">
                                        {{ $service->order }}
                                    </td>

                                    {{-- Image --}}
                                    <td class="text-center">
                                        @if ($service->image)
                                            <img src="{{ asset('storage/' . $service->image) }}" class="rounded border"
                                                style="width:60px;height:45px;object-fit:cover">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- Icon --}}
                                    <td class="text-center">
                                        @if ($service->icon)
                                            <span
                                                class="d-inline-flex align-items-center justify-content-center
                                         rounded-circle bg-light text-primary"
                                                style="width:38px;height:38px;">
                                                <i class="{{ $service->icon }}"></i>
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- Title --}}
                                    <td class="fw-semibold">
                                        {{ $service->title }}
                                    </td>

                                    {{-- Price --}}
                                    <td>
                                        @if ($service->price)
                                            {{ $service->price }} ر.ع
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="text-center">
                                        <label class="switch">
                                            <input type="checkbox" {{ $service->is_active ? 'checked' : '' }}
                                                onchange="toggleStatus({{ $service->id }}, this)">
                                            <span class="slider"></span>
                                        </label>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dashboard.home-services.edit', $service) }}"
                                                class="btn btn-outline-primary">تعديل</a>

                                            <form action="{{ route('dashboard.home-services.destroy', $service) }}"
                                                method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الخدمة؟')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-outline-danger">حذف</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        لا توجد خدمات مضافة حتى الآن
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        function toggleStatus(id, el) {

            fetch("{{ url('dashboard/home-services/toggle') }}/" + id, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        el.checked = !el.checked;
                        alert('حدث خطأ أثناء التحديث');
                    }
                })
                .catch(() => {
                    el.checked = !el.checked;
                    alert('فشل الاتصال بالخادم');
                });
        }
    </script>
@endsection
