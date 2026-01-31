@extends('layouts.master')
@section('title','طلبات التواصل')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">

        <div class="content-header row mb-3">
            <div class="col-md-6">
                <h3 class="content-header-title">طلبات التواصل</h3>
            </div>
        </div>

        <div class="content-body">
            <div class="card">
                <div class="card-body">

                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>البريد</th>
                                <th>الموضوع</th>
                                <th>IP</th>
                                <th>الحالة</th>
                                <th width="180">التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                                <tr @if($message->show == 1) class="table-warning" @endif>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->subject }}</td>
                                    <td>{{ $message->ip }}</td>
                                    <td>
                                        @if(!$message->is_read)
                                            <span class="badge badge-danger">جديد</span>
                                        @else
                                            <span class="badge badge-success">مقروء</span>
                                            <div class="text-muted small">
                                                {{ $message->read_at?->format('Y-m-d H:i') }}
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('dashboard.contact.show',$message->id) }}"
                                           class="btn btn-sm btn-info">
                                            عرض
                                        </a>

                                        <form action="{{ route('dashboard.contact.destroy',$message->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('هل أنت متأكد؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا توجد رسائل</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
