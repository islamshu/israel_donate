@extends('layouts.master')
@section('title', __('الإعدادات العامة'))

@section('content')
<div class="app-content content">
    <div class="content-wrapper">

        {{-- HEADER --}}
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('الإعدادات العامة') }}</h3>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">{{ __('الرئيسية') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('settings.index') }}">{{ __('الإعدادات') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('الإعدادات العامة') }}</li>
                    </ol>
                </div>
            </div>

            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right">
                    <a href="{{ route('settings.additinal') }}" class="btn btn-outline-info">
                        <i class="ft-code"></i> {{ __('الأكواد المخصصة') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="content-body">
            <section id="settings">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('الإعدادات العامة') }}</h4>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body">

                                    <form action="{{ route('add_general') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        {{-- ============================= --}}
                                        {{-- المعلومات الأساسية --}}
                                        {{-- ============================= --}}
                                        <div class="form-section mb-5">
                                            <h5 class="section-title mb-3">
                                                <i class="ft-info"></i> {{ __('المعلومات الأساسية') }}
                                            </h5>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>{{ __('اسم الموقع') }}</label>
                                                    <input type="text" class="form-control"
                                                           name="general[website_name]"
                                                           value="{{ get_general_value('website_name') }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label>{{ __('وصف الموقع') }}</label>
                                                    <input type="text" class="form-control"
                                                           name="general[description]"
                                                           value="{{ get_general_value('description') }}">
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label>{{ __('البريد الإلكتروني') }}</label>
                                                    <input type="email" class="form-control"
                                                           name="general[website_email]"
                                                           value="{{ get_general_value('website_email') }}">
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label>{{ __('هاتف الموقع') }}</label>
                                                    <input type="text" class="form-control"
                                                           name="general[phone]"
                                                           value="{{ get_general_value('phone') }}">
                                                </div>

                                                <div class="col-md-12 mt-2">
                                                    <label>{{ __('العنوان') }}</label>
                                                    <textarea class="form-control" rows="2"
                                                              name="general[address_ar]">{{ get_general_value('address_ar') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ============================= --}}
                                        {{-- شعار الموقع --}}
                                        {{-- ============================= --}}
                                        <div class="form-section mb-5">
                                            <h5 class="section-title mb-3">
                                                <i class="ft-image"></i> {{ __('شعار الموقع') }}
                                            </h5>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="hidden"
                                                           name="general[website_logo]"
                                                           id="imageInput"
                                                           value="{{ get_general_value('website_logo') }}">

                                                    <div class="input-group">
                                                        <button type="button"
                                                                class="btn btn-outline-primary"
                                                                onclick="openMediaLibrary()">
                                                            📁 {{ __('اختيار صورة') }}
                                                        </button>
                                                        <input type="text"
                                                               class="form-control"
                                                               id="imagePathDisplay"
                                                               value="{{ get_general_value('website_logo') }}"
                                                               readonly>
                                                    </div>

                                                    <div class="mt-3 text-center">
                                                        @if(get_general_value('website_logo'))
                                                            <img
                                                                id="imagePreview"
                                                                src="{{ asset('storage/' . get_general_value('website_logo')) }}"
                                                                class="img-thumbnail"
                                                                style="max-height:120px; max-width:200px;">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ============================= --}}
                                        {{-- السوشيال ميديا --}}
                                        {{-- ============================= --}}
                                        <div class="form-section mb-5">
                                            <h5 class="section-title mb-3">
                                                <i class="ft-share-2"></i> {{ __('روابط التواصل الاجتماعي') }}
                                            </h5>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <label>
                                                        <i class="fab fa-twitter text-info"></i> Twitter
                                                    </label>
                                                    <input type="text" class="form-control"
                                                           name="general[twitter]"
                                                           placeholder="https://twitter.com/username"
                                                           value="{{ get_general_value('twitter') }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label>
                                                        <i class="fab fa-instagram text-danger"></i> Instagram
                                                    </label>
                                                    <input type="text" class="form-control"
                                                           name="general[instagram]"
                                                           placeholder="https://instagram.com/username"
                                                           value="{{ get_general_value('instagram') }}">
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label>
                                                        <i class="fab fa-linkedin text-primary"></i> LinkedIn
                                                    </label>
                                                    <input type="text" class="form-control"
                                                           name="general[linkedin]"
                                                           placeholder="https://linkedin.com/in/username"
                                                           value="{{ get_general_value('linkedin') }}">
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label>
                                                        <i class="fab fa-youtube text-danger"></i> YouTube
                                                    </label>
                                                    <input type="text" class="form-control"
                                                           name="general[youtube]"
                                                           placeholder="https://youtube.com/@channel"
                                                           value="{{ get_general_value('youtube') }}">
                                                </div>

                                            </div>
                                        </div>

                                        {{-- ============================= --}}
                                        {{-- SAVE --}}
                                        {{-- ============================= --}}
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="la la-check"></i> {{ __('حفظ الإعدادات العامة') }}
                                            </button>

                                            <a href="{{ route('settings.index') }}"
                                               class="btn btn-outline-info btn-lg ml-2">
                                                <i class="ft-code"></i> {{ __('الأكواد المخصصة') }}
                                            </a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
