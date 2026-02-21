@extends('layouts.master')
@section('title', 'مستشار')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">
                    {{ $consultant->exists ? 'تعديل مستشار' : 'إضافة مستشار جديد' }}
                </h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.consultants.index') }}">المستشارون</a></li>
                            <li class="breadcrumb-item active">
                                {{ $consultant->exists ? 'تعديل' : 'إضافة' }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @include('dashboard.inc.alerts')

        <form method="POST"
            action="{{ $consultant->exists
                ? route('dashboard.consultants.update', $consultant)
                : route('dashboard.consultants.store') }}"
            enctype="multipart/form-data">

            @csrf
            @if ($consultant->exists)
                @method('PUT')
            @endif

            <div class="row">
                <!-- المعلومات الأساسية -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">المعلومات الأساسية</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الاسم <span class="text-danger">*</span></label>
                                        <input class="form-control @error('name') is-invalid @enderror" 
                                               name="name" 
                                               value="{{ old('name', $consultant->name) }}"
                                               placeholder="أدخل الاسم الكامل">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               name="email"
                                               value="{{ old('email', $consultant->user->email ?? '') }}"
                                               placeholder="example@domain.com">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @if ($consultant->exists)
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                                            <input type="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   name="password"
                                                   placeholder="********">
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">التخصص</label>
                                        <input class="form-control @error('title') is-invalid @enderror" 
                                               name="title" 
                                               value="{{ old('title', $consultant->title) }}"
                                               placeholder="مثال: استشارات إدارية">
                                        @error('title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الوصف -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">الوصف التفصيلي</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">الوصف</label>
                                    <textarea class="form-control js-editor @error('description') is-invalid @enderror" 
                                              name="description" 
                                              rows="5">{{ old('description', $consultant->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- الشريط الجانبي -->
                <div class="col-md-4">
                    <!-- الصورة -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">الصورة الشخصية</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <img id="imagePreview" 
                                         src="{{ $consultant->image ? asset('storage/' . $consultant->image) : asset('assets/images/placeholder.jpg') }}"
                                         class="img-thumbnail rounded-circle" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                </div>

                                <input type="hidden" name="image" id="imageInput" value="{{ old('image', $consultant->image) }}">

                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="openMediaLibrary()">
                                        <i class="la la-image"></i> {{ __('اختيار صورة') }}
                                    </button>
                                </div>

                                <small class="text-muted">الصورة الموصى بها: 300x300 بكسل</small>
                            </div>
                        </div>
                    </div>

                    <!-- المعلومات المهنية -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">المعلومات المهنية</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">التقييم</label>
                                    <select class="form-control @error('rating') is-invalid @enderror" name="rating">
                                        <option value="">اختر التقييم</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('rating', $consultant->rating) == $i ? 'selected' : '' }}>
                                                {{ $i }} نجوم
                                            </option>
                                        @endfor
                                    </select>
                                    @error('rating')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">سنوات الخبرة</label>
                                    <input type="number" 
                                           class="form-control @error('years_experience') is-invalid @enderror" 
                                           name="years_experience"
                                           value="{{ old('years_experience', $consultant->years_experience) }}"
                                           min="0"
                                           placeholder="0">
                                    @error('years_experience')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">السعر (ريال) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control @error('price') is-invalid @enderror" 
                                               name="price"
                                               value="{{ old('price', $consultant->price) }}"
                                               min="0"
                                               step="0.01"
                                               placeholder="0.00">
                                        <div class="input-group-append">
                                            <span class="input-group-text">ريال</span>
                                        </div>
                                    </div>
                                    @error('price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- أزرار الإجراءات -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">
                                <i class="la la-save"></i> حفظ
                            </button>
                            <a href="{{ route('dashboard.consultants.index') }}" class="btn btn-danger">
                                <i class="la la-times"></i> إلغاء
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
