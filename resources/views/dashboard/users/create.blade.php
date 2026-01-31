@extends('layouts.master')

@section('title','إضافة مستخدم')

@section('content')
<div class="container-fluid">

    <h4 class="fw-bold mb-4">إضافة مستخدم جديد</h4>

    <div class="card shadow-sm border-0">
        <div class="card-body">
        @include('dashboard.inc.alerts')

            <form method="POST"
                  action="{{ route('dashboard.users.store') }}">
                @csrf

                <div class="mb-3">
                    <label>الاسم</label>
                    <input name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>البريد الإلكتروني</label>
                    <input name="email" type="email"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>كلمة المرور</label>
                    <input name="password" type="password"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>تأكيد كلمة المرور</label>
                    <input name="password_confirmation"
                           type="password" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label>الدور</label>
                    <select name="role" class="form-select" required>
                        @foreach($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-success">
                    حفظ المستخدم
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
