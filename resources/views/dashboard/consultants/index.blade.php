@extends('layouts.master')
@section('title', 'المستشارون')
@section('style')
    <style>
        /* Toggle Switch */
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
            background-color: #fff;
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-0">المستشارون</h3>
                    <small class="text-muted">إدارة المستشارين</small>
                </div>

                <a href="{{ route('dashboard.consultants.create') }}" class="btn btn-primary">
                    إضافة مستشار
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif


            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>التقييم</th>
                                <th>الخبرة</th>
                                <th>السعر</th>
                                @if (!auth()->user()->hasRole('consultant'))
                                    <th>الحالة</th>
                                @endif
                                <th>التحكم</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($consultants as $c)
                                <tr>
                                    <td>{{ $c->order }}</td>

                                    <td>
                                        @if ($c->image)
                                            <img src="{{ asset('storage/' . $c->image) }}"
                                                style="width:50px;height:50px;object-fit:cover" class="rounded">
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ $c->name }}</strong><br>
                                        <small class="text-muted">{{ $c->title }}</small>
                                    </td>

                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= $c->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </td>

                                    <td>{{ $c->years_experience }} سنة</td>

                                    <td>{{ $c->price }} ر.ع</td>
                                    @if (!auth()->user()->hasRole('consultant'))
                                        <td class="text-center">
                                            <label class="switch" title="تفعيل / تعطيل المستشار">
                                                <input type="checkbox" {{ $c->is_active ? 'checked' : '' }}
                                                    onchange="toggleStatus({{ $c->id }}, this)">
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                    @endif

                                    <td>
                                        @if (!auth()->user()->hasRole('consultant'))
                                            <a href="{{ route('dashboard.consultants.edit', $c) }}"
                                                class="btn btn-sm btn-info">تعديل</a>
                                        @endif
                                        <a href="{{ route('dashboard.consultants.availability.edit', $c) }}"
                                            class="btn btn-outline-secondary">
                                            الأوقات
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
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

            fetch("{{ url('dashboard/consultants/toggle') }}/" + id, {
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
