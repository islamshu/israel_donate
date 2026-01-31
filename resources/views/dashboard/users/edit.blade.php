@extends('layouts.master')

@section('title','تعديل مستخدم')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="fw-bold">تعديل المستخدم</h3>
        <p class="text-muted mb-0">تعديل بيانات المستخدم وتحديد الدور الخاص به</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            @include('dashboard.inc.alerts')

            <form action="{{ route('dashboard.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- الاسم --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $user->name) }}"
                               required>
                    </div>

                    {{-- البريد --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $user->email) }}"
                               required>
                    </div>

                    {{-- الدور --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الدور</label>
                        <select name="role" class="form-select" required>
                            @foreach($roles as $role)
                                <option value="{{ $role }}"
                                    {{ $user->hasRole($role) ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <hr class="my-4">

                {{-- كلمة المرور --}}
                <h6 class="mb-3 text-muted">تغيير كلمة المرور (اختياري)</h6>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">كلمة المرور الجديدة</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="اتركها فارغة إذا لا تريد التغيير">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">تأكيد كلمة المرور</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="تأكيد كلمة المرور">
                    </div>

                </div>

                {{-- Actions --}}
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="la la-save me-1"></i> حفظ التعديلات
                    </button>

                    <a href="{{ route('dashboard.users.index') }}"
                       class="btn btn-light px-4">
                        رجوع
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
