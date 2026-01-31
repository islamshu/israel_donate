@extends('layouts.master')
@section('title', __('إعدادات PayPal'))

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('إعدادات PayPal') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('إعدادات PayPal') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section id="paypal-settings">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('تعديل إعدادات PayPal') }}</h4>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body">
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <form class="form" action="{{ route('paypal-settings.update') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label for="paypal_client_id">{{ __('Client ID') }}</label>
                                            <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control @error('paypal_client_id') is-invalid @enderror" value="{{ old('paypal_client_id', get_general_value('paypal_client_id')) }}" required>
                                            @error('paypal_client_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="paypal_secret">{{ __('Secret') }}</label>
                                            <input type="text" name="paypal_secret" id="paypal_secret" class="form-control @error('paypal_secret') is-invalid @enderror" value="{{ old('paypal_secret', get_general_value('paypal_secret')) }}" required>
                                            @error('paypal_secret')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="paypal_mode">{{ __('الوضع') }}</label>
                                            <select name="paypal_mode" id="paypal_mode" class="form-control @error('paypal_mode') is-invalid @enderror" required>
                                                <option value="sandbox" {{ old('paypal_mode', get_general_value('paypal_mode') == 'sandbox' ? 'selected' : '' )}}>{{ __('Sandbox') }}</option>
                                                <option value="live" {{ old('paypal_mode', get_general_value('paypal_mode') == 'live' ? 'selected' : '' )}}>{{ __('Live') }}</option>
                                            </select>
                                            @error('paypal_mode')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-actions text-center mt-3">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="la la-check-square-o"></i> {{ __('حفظ التغييرات') }}
                                            </button>
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
