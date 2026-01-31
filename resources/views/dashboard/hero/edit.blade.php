@extends('layouts.master')

@section('title','تعديل القسم الرئيسي')

@section('content')
<div class="app-content content">
<div class="content-wrapper">

    {{-- ================= HEADER ================= --}}
    <div class="content-header mb-4">
        <h3 class="fw-bold mb-1">Hero Section</h3>
        <p class="text-muted mb-0">التحكم بمحتوى القسم الرئيسي في الصفحة الرئيسية</p>
    </div>

    {{-- ================= ALERTS ================= --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="la la-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('hero.update') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="row">

            {{-- ================= FORM ================= --}}
            <div class="col-lg-9">

                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">محتوى القسم</h5>
                    </div>

                    <div class="card-body">

                        {{-- Title --}}
                      

                        {{-- Subtitle --}}
                        <div class="form-group">
                            <label>العنوان الصغير بالاعلى</label>
                            <input type="text"
                                   name="subtitle"
                                   class="form-control"
                                   value="{{ old('subtitle', $hero?->subtitle) }}"
                                   placeholder="استشارات نفسية وأسرية متكاملة">
                        </div>
                        <div class="form-group">
                            <label>العنوان الرئيسي</label>
                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   value="{{ old('title', $hero?->title) }}"
                                   placeholder="مركز متكامل للإرشاد النفسي">
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label>الوصف</label>
                            <textarea name="description"
                                      rows="4"
                                      class="form-control js-editor"
                                      placeholder="وصف يظهر في الصفحة الرئيسية">{{ old('description', $hero?->description) }}</textarea>
                        </div>

                        {{-- Button --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نص الزر</label>
                                    <input type="text"
                                           name="button_text"
                                           class="form-control"
                                           value="{{ old('button_text', $hero?->button_text) }}"
                                           placeholder="احجز موعد الآن">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رابط الزر</label>
                                    <input type="text"
                                           name="button_link"
                                           class="form-control"
                                           value="{{ old('button_link', $hero?->button_link) }}"
                                           placeholder="#booking">
                                </div>
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="form-group">
                            <label>صورة الخلفية</label>
                            <input type="hidden" name="background_image"
                            id="imageInput"
                            value="{{ old('background_image', $hero?->background_image )}}">

                        <div class="input-group">
                            <button type="button"
                                class="btn btn-outline-primary"
                                onclick="openMediaLibrary()">
                                📁 {{ __('اختيار صورة') }}
                            </button>
                            <input type="text" class="form-control"
                                id="imagePathDisplay"
                                value="{{ old('background_image', $hero?->background_image )}}"
                                readonly>
                        </div>

                        <div class="mt-3 text-center">
                            <img id="imagePreview"
                                src="{{ asset('storage/' . $hero?->background_image ) }}"
                                class="img-thumbnail"
                                style="max-height:120px; max-width:200px;"
                                >
                        </div>

                    

                    </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="la la-save"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </div>

            </div>

           

        </div>
    </form>

</div>
</div>
@endsection
