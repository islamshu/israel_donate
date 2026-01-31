@extends('layouts.master')
@section('title', 'مستشار')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            @include('dashboard.inc.alerts')
            <form method="POST"
                action="{{ $consultant->exists
                    ? route('dashboard.consultants.update', $consultant)
                    : route('dashboard.consultants.store') }}">

                @csrf
                @if ($consultant->exists)
                    @method('PUT')
                @endif

                <div class="card">
                    <div class="card-body row">

                        <div class="col-md-6 mb-3">
                            <label>الاسم</label>
                            <input class="form-control" name="name" value="{{ old('name', $consultant->name) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>التخصص</label>
                            <input class="form-control" name="title" value="{{ old('title', $consultant->title) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>التقييم</label>
                            <select class="form-control" name="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}"
                                        {{ old('rating', $consultant->rating) == $i ? 'selected' : '' }}>
                                        {{ $i }} نجوم
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>سنوات الخبرة</label>
                            <input type="number" class="form-control" name="years_experience"
                                value="{{ old('years_experience', $consultant->years_experience) }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>الوصف</label>
                            <textarea class="form-control js-editor" name="description" rows="3">{{ old('description', $consultant->description) }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>السعر</label>
                            <input type="number" class="form-control" name="price"
                                value="{{ old('price', $consultant->price) }}">
                        </div>

                       
                        <div class="col-md-6">
                            <label>{{ __('الصورة') }}</label>

                            <input type="hidden" name="image"
                                id="imageInput"
                                value="{{ old('image', $consultant->image) }}">

                            <div class="input-group">
                                <button type="button"
                                    class="btn btn-outline-primary"
                                    onclick="openMediaLibrary()">
                                    📁 {{ __('اختيار صورة') }}
                                </button>
                                <input type="text" class="form-control"
                                    id="imagePathDisplay"
                                    value="{{ old('image', $consultant->image) }}"
                                    readonly>
                            </div>

                            <div class="mt-3 text-center">
                                <img id="imagePreview"
                                    src="{{ asset('storage/' . $consultant->image) }}"
                                    class="img-thumbnail"
                                    style="max-height:120px; max-width:200px;"
                                    >
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <button class="btn btn-success">حفظ</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection
