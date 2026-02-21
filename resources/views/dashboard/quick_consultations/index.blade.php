@extends('layouts.master')

@section('title', 'الاستشارات السريعة')

@section('content')
<div class="container-fluid">

    {{-- إحصائيات سريعة --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">قيد الانتظار</h5>
                    <h2>{{ $stats['pending'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">تم الرد</h5>
                    <h2>{{ $stats['answered'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h5 class="card-title">مغلقة</h5>
                    <h2>{{ $stats['closed'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- فلترة --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row">
                <div class="col-md-3">
                    <select name="consultant_id" class="form-control">
                        <option value="">كل المستشارين</option>
                        @foreach($consultants as $consultant)
                            <option value="{{ $consultant->id }}" {{ request('consultant_id') == $consultant->id ? 'selected' : '' }}>
                                {{ $consultant->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">كل الحالات</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="answered" {{ request('status') == 'answered' ? 'selected' : '' }}>تم الرد</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلقة</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">بحث</button>
                    <a href="{{ route('dashboard.quick_consultations.index') }}" class="btn btn-secondary">إعادة تعيين</a>
                </div>
            </form>
        </div>
    </div>

    {{-- جدول الاستشارات --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>رقم الاستشارة</th>
                            <th>العميل</th>
                            <th>المستشار</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>الردود</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultations as $consultation)
                        <tr>
                            <td>
                                <a href="{{ route('dashboard.quick_consultations.show', $consultation) }}">
                                    {{ $consultation->consultation_number }}
                                </a>
                            </td>
                            <td>
                                {{ $consultation->client_name }}<br>
                                <small>{{ $consultation->client_phone }}</small>
                            </td>
                            <td>{{ $consultation->consultant->name ?? 'غير محدد' }}</td>
                            <td>{{ $consultation->created_at->format('Y-m-d') }}</td>
                            <td>
                                <form action="{{ route('dashboard.quick_consultations.status', $consultation) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="form-control form-control-sm">
                                        <option value="pending" {{ $consultation->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="answered" {{ $consultation->status == 'answered' ? 'selected' : '' }}>تم الرد</option>
                                        <option value="closed" {{ $consultation->status == 'closed' ? 'selected' : '' }}>مغلقة</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $consultation->replies->count() }}</span>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.quick_consultations.show', $consultation) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد استشارات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection