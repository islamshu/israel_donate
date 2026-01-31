@extends('layouts.master')

@section('title', 'تفاصيل الحجز')

@section('style')
<style>
/* ================= Base ================= */
.booking-show {
    background: #f4f6f9;
    min-height: 100vh;
}

/* ================= Header ================= */
.booking-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ffffff;
    padding: 22px 24px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
}

.booking-header h4 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
}

/* ================= Status ================= */
.status-badge {
    padding: 6px 16px;
    font-size: 13px;
    border-radius: 20px;
    font-weight: 600;
    text-transform: capitalize;
}

.badge-success { background: #e6f4ea; color: #166534; }
.badge-warning { background: #fff7ed; color: #9a3412; }
.badge-danger  { background: #fee2e2; color: #991b1b; }
.badge-secondary { background: #f3f4f6; color: #374151; }

/* ================= Boxes ================= */
.box {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    border: 1px solid #e5e7eb;
}

.box-title {
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 14px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .5px;
}

/* ================= Info Rows ================= */
.info-row {
    display: flex;
    justify-content: space-between;
    gap: 24px;
}

.info-row > div {
    flex: 1;
}

/* ================= Payment ================= */
.payment-amount {
    font-size: 32px;
    font-weight: 700;
    color: #111827;
}

.payment-amount span {
    font-size: 16px;
    color: #6b7280;
    margin-right: 4px;
}

/* ================= Actions ================= */
.actions .btn {
    font-weight: 600;
}

/* ================= Print ================= */
@media print {
    body {
        background: white !important;
    }

    .btn,
    a {
        display: none !important;
    }

    .box,
    .booking-header {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid py-4 booking-show">

    {{-- Back --}}
    <div class="mb-3">
        <a href="{{ route('dashboard.bookings.index') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-right"></i> رجوع
        </a>
    </div>

    {{-- Header --}}
    <div class="booking-header mb-4">
        <div>
            <h4 class="mb-1">تفاصيل الحجز #{{ $booking->id }}</h4>
            <small class="text-muted">
                تم الإنشاء {{ $booking->created_at->format('Y-m-d H:i') }}
            </small>
        </div>

        <span class="status-badge badge-{{ status_color($booking->status) }}">
            {{ $booking->status }}
        </span>
    </div>

    <div class="row">

        {{-- Left --}}
        <div class="col-lg-8">

            {{-- Consultant --}}
            <div class="box mb-4">
                <h6 class="box-title">المستشار</h6>
                <p class="mb-1 fw-bold">{{ $booking->consultant->name }}</p>
                @if($booking->consultant->specialty)
                    <small class="text-muted">{{ $booking->consultant->specialty }}</small>
                @endif
            </div>

            {{-- Client --}}
            <div class="box mb-4">
                <h6 class="box-title">العميل</h6>
                <p class="mb-1 fw-bold">{{ $booking->client_name }}</p>
                <div class="text-muted">
                    {{ $booking->client_phone }}
                    @if($booking->client_email)
                        <br>{{ $booking->client_email }}
                    @endif
                </div>
            </div>

            {{-- Date & Time --}}
            <div class="box mb-4">
                <h6 class="box-title">الموعد</h6>
                <div class="info-row">
                    <div>
                        <small class="text-muted d-block">التاريخ</small>
                        <strong>{{ $booking->date->format('Y-m-d') }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block">الوقت</small>
                        <strong>{{ $booking->start_time }} – {{ $booking->end_time }}</strong>
                    </div>
                </div>
            </div>

            {{-- Payment --}}
            <div class="box mb-4">
                <h6 class="box-title">الدفع</h6>
                <div class="payment-amount mb-1">
                    {{ number_format($booking->amount_baisa / 1000, 3) }}
                    <span>ر.ع</span>
                </div>
                @if($booking->status == 'paid')
                <small class="text-muted">
                    تم الدفع عبر النظام الإلكتروني
                </small>
                @endif
            </div>

            {{-- Notes --}}
            @if($booking->notes)
                <div class="box">
                    <h6 class="box-title">ملاحظات</h6>
                    <p class="mb-0 text-muted">{{ $booking->notes }}</p>
                </div>
            @endif

        </div>

        {{-- Right --}}
        <div class="col-lg-4">
            <div class="box actions">
                <h6 class="box-title">إجراءات</h6>

                @if($booking->status === 'pending')
                    <button class="btn btn-success btn-block mb-2">
                        تأكيد الدفع
                    </button>

                    <button class="btn btn-danger btn-block mb-2">
                        إلغاء الحجز
                    </button>
                @endif

                <button onclick="printInvoice()" class="btn btn-outline-secondary btn-block">
                    <i class="fas fa-print"></i> طباعة
                </button>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<script>
function printInvoice() {
    window.print();
}
</script>
@endsection
