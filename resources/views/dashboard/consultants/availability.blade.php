@extends('layouts.master')
@section('title','أوقات عمل المستشار')

@section('style')
<style>
/* ===== Switch Toggle ===== */
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
    background-color: white;
    transition: .3s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #28a745;
}

input:checked + .slider:before {
    transform: translateX(22px);
}
</style>
@endsection

@section('content')
<div class="app-content content">
<div class="content-wrapper">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-0">أوقات عمل المستشار</h3>
        <span class="text-4xl">{{ $consultant->name }}</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('dashboard.consultants.availability.update', $consultant) }}">
        @csrf

        <div class="card shadow-sm">
            <div class="card-body p-0">

                <table class="table table-bordered align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="160">اليوم</th>
                            <th width="100" class="text-center">تفعيل</th>
                            <th>من</th>
                            <th>إلى</th>
                            <th width="180">مدة الجلسة</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($days as $dayIndex => $dayName)
                        @php
                            $day = $availabilities[$dayIndex] ?? null;
                        @endphp
                        <tr>

                            {{-- Day --}}
                            <td class="fw-bold">
                                {{ $dayName }}
                            </td>

                            {{-- Switch --}}
                            <td class="text-center">
                                <label class="switch">
                                    <input type="checkbox"
                                           name="days[{{ $dayIndex }}][enabled]"
                                           {{ $day ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </td>

                            {{-- Start --}}
                            <td>
                                <input type="time"
                                       class="form-control"
                                       name="days[{{ $dayIndex }}][start_time]"
                                       value="{{ $day->start_time ?? '09:00' }}">
                            </td>

                            {{-- End --}}
                            <td>
                                <input type="time"
                                       class="form-control"
                                       name="days[{{ $dayIndex }}][end_time]"
                                       value="{{ $day->end_time ?? '17:00' }}">
                            </td>

                            {{-- Slot --}}
                            <td>
                                <select class="form-control"
                                        name="days[{{ $dayIndex }}][slot_duration]">
                                    @foreach([30,45,60,90] as $m)
                                        <option value="{{ $m }}"
                                            {{ ($day && $day->slot_duration == $m) ? 'selected' : '' }}>
                                            {{ $m }} دقيقة
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div class="card-footer text-end">
                <button class="btn btn-success">
                    حفظ الأوقات
                </button>
                <a href="{{ route('dashboard.consultants.index') }}"
                   class="btn btn-secondary">
                    رجوع
                </a>
            </div>
        </div>

    </form>

</div>
</div>
@endsection
