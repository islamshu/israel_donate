@extends('layouts.master')

@section('title', $service->exists ? 'تعديل خدمة' : 'إضافة خدمة')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">

            <h3 class="fw-bold mb-3">
                {{ $service->exists ? 'تعديل خدمة' : 'إضافة خدمة جديدة' }}
            </h3>
            @include('dashboard.inc.alerts')

            <form method="POST"
                action="{{ $service->exists
                    ? route('dashboard.home-services.update', $service)
                    : route('dashboard.home-services.store') }}"
                enctype="multipart/form-data">

                @csrf
                @if ($service->exists)
                    @method('PUT')
                @endif

                <div class="card">
                    <div class="card-body row">

                        <div class="col-md-6 mb-3">
                            <label>العنوان</label>
                            <input type="text" class="form-control" name="title"
                                value="{{ old('title', $service->title) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>السعر</label>
                            <input type="number" class="form-control" name="price"
                                value="{{ old('price', $service->price) }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>الوصف</label>
                            <textarea class="form-control js-editor" name="description" rows="4">{{ old('description', $service->description) }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>الأيقونة</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="icon" id="iconInput"
                                    value="{{ old('icon', $service->icon) }}">
                                <button type="button" class="btn btn-outline-primary" onclick="openIconPicker()">
                                    اختيار
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">صورة الخدمة</label>
                        
                            {{-- hidden value --}}
                            <input type="hidden"
                                   name="image"
                                   id="imageInput"
                                   value="{{ old('image', $service->image) }}">
                        
                            <div class="input-group">
                                <button type="button"
                                        class="btn btn-outline-primary"
                                        onclick="openMediaLibrary()">
                                    📁 اختيار صورة
                                </button>
                        
                                <input type="text"
                                       class="form-control"
                                       id="imagePathDisplay"
                                       value="{{ old('image', $service->image) }}"
                                       readonly>
                            </div>
                        
                            <div class="mt-3 text-center">
                                <img id="imagePreview"
                                     src="{{ $service->image ? asset('storage/'.$service->image) : asset('images/placeholder.png') }}"
                                     class="img-thumbnail"
                                     style="max-height:120px; max-width:200px;"
                                    >
                            </div>
                        </div>
                        


                    </div>

                    <div class="card-footer text-end">
                        <button class="btn btn-success">
                            حفظ
                        </button>
                        <a href="{{ route('dashboard.home-services.index') }}" class="btn btn-secondary">
                            رجوع
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection

@section('script')
    <script>
        function openIconPicker() {
            window.open('{{ route('icons.index') }}',
                'iconPicker',
                'width=900,height=600');
        }

        window.addEventListener('message', function(e) {
            if (e.data.type === 'icon-selected') {
                document.getElementById('iconInput').value = e.data.icon;
            }
        });
    </script>
@endsection
