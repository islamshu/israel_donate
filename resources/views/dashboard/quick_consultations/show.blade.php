@extends('layouts.master')

@section('title', 'تفاصيل الاستشارة')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">تفاصيل الاستشارة</h3>
                <span class="badge bg-dark px-3 py-2">
                    #{{ $quickConsultation->consultation_number }}
                </span>
            </div>

            <a href="{{ route('dashboard.quick_consultations.index') }}"
               class="btn btn-light border">
                <i class="fas fa-arrow-right ms-1"></i>
                العودة
            </a>
        </div>
    </div>

    {{-- Info Cards --}}
    <div class="row g-4 mb-4">

        {{-- Client Card --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-primary">
                        <i class="fas fa-user ms-2"></i>
                        معلومات العميل
                    </h5>

                    <div class="mb-2">
                        <strong>{{ $quickConsultation->client_name }}</strong>
                    </div>

                    <div class="text-muted small">
                        <div><i class="fas fa-envelope ms-2"></i>{{ $quickConsultation->client_email }}</div>
                        <div><i class="fas fa-phone ms-2"></i>{{ $quickConsultation->client_phone }}</div>
                        <div>
                            <i class="fas fa-clock ms-2"></i>
                            {{ $quickConsultation->created_at->format('Y/m/d - h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Consultant Card --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-success">
                        <i class="fas fa-user-tie ms-2"></i>
                        معلومات المستشار
                    </h5>

                    <div class="mb-3">
                        <strong>{{ $quickConsultation->consultant->name ?? 'غير محدد' }}</strong>
                    </div>

                    {{-- Status --}}
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="fw-bold">الحالة:</span>

                        <form action="{{ route('dashboard.quick_consultations.status', $quickConsultation) }}"
                              method="POST">
                            @csrf
                            <select name="status"
                                    onchange="this.form.submit()"
                                    class="form-select form-select-sm">
                                <option value="pending" {{ $quickConsultation->status == 'pending' ? 'selected' : '' }}>
                                    🟡 قيد الانتظار
                                </option>
                                <option value="answered" {{ $quickConsultation->status == 'answered' ? 'selected' : '' }}>
                                    🟢 تم الرد
                                </option>
                                <option value="closed" {{ $quickConsultation->status == 'closed' ? 'selected' : '' }}>
                                    🔴 مغلقة
                                </option>
                            </select>
                        </form>
                    </div>

                    <small class="text-muted">
                        آخر تحديث: {{ $quickConsultation->updated_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- Consultation Text --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-quote-right ms-2"></i>
                نص الاستشارة
            </h5>

            <div class="bg-light p-3 rounded">
                {{ $quickConsultation->consultation_text }}
            </div>
        </div>
    </div>

    {{-- Attachments --}}
    @if($quickConsultation->files->count())
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-paperclip ms-2"></i>
                الملفات المرفقة
            </h5>

            <div class="row g-3">
                @foreach($quickConsultation->files as $file)
                    <div class="col-md-3">
                        <a href="{{ asset('storage/' . $file->file_path) }}"
                           target="_blank"
                           class="btn btn-outline-primary w-100 text-truncate">
                            <i class="fas fa-file me-1"></i>
                            {{ basename($file->file_path) }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Replies --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-comments ms-2"></i>
                الردود
            </h5>

            @forelse($quickConsultation->replies as $reply)

                <div class="d-flex mb-4 {{ $reply->reply_type == 'client' ? 'justify-content-start' : 'justify-content-end' }}">
                    
                    <div class="p-3 rounded shadow-sm"
                         style="max-width: 75%;
                                background: {{ $reply->reply_type == 'client' ? '#f8f9fa' : '#e7f1ff' }}">

                        <div class="d-flex justify-content-between mb-2">
                            <strong>
                                @if($reply->reply_type == 'client')
                                    {{ $reply->client_name ?? 'العميل' }}
                                @elseif($reply->reply_type == 'admin')
                                    الإدارة
                                @else
                                    المستشار
                                @endif
                            </strong>

                            <small class="text-muted">
                                {{ $reply->created_at->format('Y-m-d h:i A') }}
                            </small>
                        </div>

                        <div>{{ $reply->reply_text }}</div>

                        @if($reply->file_path)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $reply->file_path) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-light">
                                    <i class="fas fa-paperclip me-1"></i>
                                    ملف مرفق
                                </a>
                            </div>
                        @endif

                    </div>
                </div>

            @empty
                <div class="text-center text-muted py-4">
                    لا توجد ردود بعد
                </div>
            @endforelse
        </div>
    </div>

    {{-- Add Reply --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-reply ms-2"></i>
                إضافة رد جديد
            </h5>

            <form action="{{ route('dashboard.quick_consultations.reply', $quickConsultation) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <textarea name="reply_text"
                              rows="4"
                              class="form-control"
                              placeholder="اكتب ردك هنا..."
                              required></textarea>
                </div>

                <div class="mb-3">
                    <input type="file" name="file" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-paper-plane ms-1"></i>
                    إرسال الرد
                </button>
            </form>
        </div>
    </div>

</div>
@endsection