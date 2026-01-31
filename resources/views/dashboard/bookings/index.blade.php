@extends('layouts.master')

@section('title', 'إدارة الحجوزات')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 font-weight-bold mb-1">إدارة الحجوزات</h1>
            <p class="text-muted mb-0">عرض وإدارة جميع حجوزات المستشارين</p>
        </div>
        <span class="badge badge-primary badge-pill px-3 py-2">
            الإجمالي: {{ $bookings->count() }}
        </span>
    </div>

    {{-- STATS --}}
    <div class="row mb-4">
        @php
            $cards = [
                ['label'=>'تم الدفع','count'=>$stats['paid'],'color'=>'success','icon'=>'check-circle'],
                ['label'=>'قيد الانتظار','count'=>$stats['pending'],'color'=>'warning','icon'=>'clock'],
                ['label'=>'ملغية','count'=>$stats['canceled'],'color'=>'danger','icon'=>'times-circle'],
                ['label'=>'فشلت','count'=>$stats['failed'],'color'=>'secondary','icon'=>'exclamation-circle'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="col-md-3 mb-3">
                <div class="card border-left-{{ $card['color'] }} shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">{{ $card['label'] }}</div>
                            <div class="h5 font-weight-bold mb-0">{{ $card['count'] }}</div>
                        </div>
                        <i class="fas fa-{{ $card['icon'] }} fa-2x text-{{ $card['color'] }} opacity-50"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- FILTER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form class="row">
                <div class="col-md-3">
                    <label class="small text-muted">الحالة</label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="">الكل</option>
                        @foreach(['pending','paid','failed','expired','canceled'] as $s)
                            <option value="{{ $s }}" @selected(request('status')==$s)>
                                {{$s }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="small text-muted">المستشار</label>
                    <select name="consultant_id" class="form-control form-control-sm">
                        <option value="">الكل</option>
                        @foreach($consultants as $c)
                            <option value="{{ $c->id }}" @selected(request('consultant_id')==$c->id)>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="small text-muted">التاريخ</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="form-control form-control-sm">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('dashboard.bookings.index') }}" class="btn btn-light btn-sm">
                        إعادة
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table id="bookingsTable" class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>المستشار</th>
                    <th>العميل</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>المبلغ</th>
                    <th>الحالة</th>
                    <th>إجراء</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->consultant->name }}</td>
                        <td>{{ $booking->client_name }}</td>
                        <td>{{ $booking->date->format('Y-m-d') }}</td>
                        <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                        <td class="text-success font-weight-bold">
                            {{ number_format($booking->amount_baisa / 1000, 3) }} ر.ع
                        </td>
                        <td>
                            <span class="badge badge-{{ status_color($booking->status) }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('dashboard.bookings.show',$booking) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
