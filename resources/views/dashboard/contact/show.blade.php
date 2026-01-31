@extends('layouts.master')
@section('title','تفاصيل الرسالة')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">

        <div class="content-header mb-3">
            <h3>تفاصيل رسالة التواصل</h3>
        </div>

        <div class="content-body">
            <div class="card">
                <div class="card-body">

                    <p><strong>الاسم:</strong> {{ $message->name }}</p>
                    <p><strong>البريد:</strong> {{ $message->email }}</p>
                    <p><strong>الموضوع:</strong> {{ $message->subject }}</p>
                    <p><strong>IP:</strong> {{ $message->ip }}</p>
                    <hr>
                    <p><strong>الرسالة:</strong></p>
                    <div class="border p-3 rounded bg-light">
                        {{ $message->message }}
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('dashboard.contact.index') }}"
                           class="btn btn-secondary">
                            رجوع
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
