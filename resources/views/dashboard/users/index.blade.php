@extends('layouts.master')

@section('title','إدارة المستخدمين')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">إدارة المستخدمين</h4>

        <a href="{{ route('dashboard.users.create') }}"
           class="btn btn-primary">
            <i class="la la-user-plus"></i> إضافة مستخدم
        </a>
    </div>

    <div class="card shadow-sm border-0">
    @include('dashboard.inc.alerts')

        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد</th>
                    <th>الدور</th>
                    <th width="120">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-info">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if(!$user->hasRole('الادارة') )
                        <a href="{{ route('dashboard.users.edit',$user) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="la la-edit"></i>
                        </a>
                        <form action="{{ route('dashboard.users.destroy', $user) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('هل أنت متأكد من حذف هذه المستخدم')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-sm btn-outline-danger"
                                title="حذف">
                                <i class="la la-trash"></i>
                            </button>
                        </form>
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection
