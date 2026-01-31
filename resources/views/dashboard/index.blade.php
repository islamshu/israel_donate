@extends('layouts.master')
@section('title','لوحة التحكم')

@section('style')
<style>
.dashboard {
    background: #f4f6f9;
    min-height: 100vh;
}

/* Header */
.dashboard-header {
    background: #fff;
    padding: 22px 24px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    margin-bottom: 24px;
}

.dashboard-header h3 {
    font-weight: 700;
    color: #111827;
}

/* Stat Cards */
.stat-card {
    background: #fff;
    border-radius: 10px;
    padding: 18px;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 16px;
}

.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.icon-blue { background: #e0f2fe; color: #0369a1; }
.icon-green { background: #dcfce7; color: #166534; }
.icon-orange { background: #ffedd5; color: #9a3412; }
.icon-red { background: #fee2e2; color: #991b1b; }
.icon-gray { background: #f3f4f6; color: #374151; }

.stat-value {
    font-size: 22px;
    font-weight: 700;
    color: #111827;
}

.stat-label {
    font-size: 13px;
    color: #6b7280;
}

/* Box */
.box {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    border: 1px solid #e5e7eb;
}

.box-title {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 16px;
    color: #374151;
}

/* Table */
.table td, .table th {
    vertical-align: middle;
    font-size: 14px;
}
</style>
@endsection

@section('content')
<div class="app-content content dashboard">
<div class="content-wrapper">

    {{-- Header --}}
    <div class="dashboard-header">
        <h3 class="mb-1">لوحة التحكم</h3>
        <p class="text-muted mb-0">نظرة عامة على النظام</p>
    </div>

    {{-- Stats --}}
    <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="la la-calendar"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">إجمالي الحجوزات</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon icon-orange">
                    <i class="la la-clock"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                    <div class="stat-label">قيد الانتظار</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class="la la-check-circle"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['paid'] }}</div>
                    <div class="stat-label">مدفوعة</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon icon-red">
                    <i class="la la-times-circle"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['canceled'] }}</div>
                    <div class="stat-label">ملغاة</div>
                </div>
            </div>
        </div>

    </div>

    {{-- Second Row --}}
    <div class="row mb-4">

        <div class="col-lg-4 mb-3">
            <div class="stat-card">
                <div class="stat-icon icon-gray">
                    <i class="la la-user-md"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['consultants'] }}</div>
                    <div class="stat-label">الاستشاريين</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class="la la-money"></i>
                </div>
                <div>
                    <div class="stat-value">
                        {{ number_format($stats['revenue'], 2) }} ر.ع
                    </div>
                    <div class="stat-label">إجمالي الإيرادات</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="stat-card">
                <div class="stat-icon icon-gray">
                    <i class="la la-ban"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['failed'] + $stats['expired'] }}</div>
                    <div class="stat-label">فشل / منتهي</div>
                </div>
            </div>
        </div>

    </div>

    {{-- Latest Bookings --}}
    <div class="box">
        <h6 class="box-title">آخر الحجوزات</h6>

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>العميل</th>
                    <th>الاستشاري</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th>من - الى</th>

                    <th>الحالة</th>

                </tr>
            </thead>
            <tbody>
                @forelse($latestBookings as $key=> $booking)
                    <tr>
                        <td>#{{ $key+1 }}</td>
                        <td>{{ $booking->client_name }}</td>
                        <td>{{ $booking->consultant->name ?? '-' }}</td>
                        <td ><span class="badge badge-{{ status_color($booking->status) }}">{{ $booking->status }}</span></td>
                        <td>{{ $booking->created_at->format('Y-m-d') }}</td>
                        <td><strong>{{ $booking->start_time }} – {{ $booking->end_time }}</strong>
                        </td>

                        <td>
                            <a href="{{ route('dashboard.bookings.show',$booking) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            لا توجد حجوزات
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</div>
@endsection
