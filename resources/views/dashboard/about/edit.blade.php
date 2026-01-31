@extends('layouts.master')

@section('title','عن المركز')
@section('page_title','قسم عن المركز')

@section('content')
<div class="app-content content">
<div class="content-wrapper">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('dashboard.about.update') }}">
@csrf

{{-- ================= ABOUT CONTENT ================= --}}
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <strong>رؤيتنا ورسالتنا</strong>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label>عنوان القسم</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ $about->title ?? '' }}">
                </div>

                <div class="form-group">
                    <label>الوصف</label>
                    <textarea name="description"
                              rows="6"
                              class="form-control js-editor">{{ $about->description ?? '' }}</textarea>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= FEATURES ================= --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>المميزات</strong>
                <button type="button"
                        class="btn btn-sm btn-primary"
                        onclick="addFeature()">
                    إضافة
                </button>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th width="40">☰</th>
                        <th width="130">الأيقونة</th>
                        <th width="180">العنوان</th>
                        <th>الوصف</th>
                        <th width="60">حذف</th>
                    </tr>
                    </thead>

                    <tbody id="featuresTable">
                    @foreach($features as $i => $feature)
                    <tr class="feature-row">
                        <td style="cursor:move">☰</td>

                        {{-- ICON --}}
                        <td>
                            <div class="input-group">
                                <input type="text"
                                       class="form-control icon-input"
                                       readonly
                                       data-field="icon"
                                       name="features[{{ $i }}][icon]"
                                       value="{{ $feature->icon }}">
                                <div class="input-group-append">
                                    <button type="button"
                                            class="btn btn-outline-primary"
                                            onclick="openIconPicker(this)">
                                        <i class="{{ $feature->icon ?? 'fas fa-icons' }}"></i>
                                    </button>
                                </div>
                            </div>
                        </td>

                        {{-- TITLE --}}
                        <td>
                            <input type="text"
                                   class="form-control"
                                   data-field="title"
                                   name="features[{{ $i }}][title]"
                                   value="{{ $feature->title }}">
                        </td>

                        {{-- DESCRIPTION --}}
                        <td>
                            <input type="text"
                                   class="form-control"
                                   data-field="description"
                                   name="features[{{ $i }}][description]"
                                   value="{{ $feature->description }}">
                        </td>

                        <td class="text-center">
                            <button type="button"
                                    class="btn btn-sm btn-danger"
                                    onclick="removeRow(this)">×</button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ================= POINTS ================= --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>نقاط المميزات</strong>
        <button type="button"
                class="btn btn-sm btn-primary"
                onclick="addPoint()">
            إضافة نقطة
        </button>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="thead-light">
            <tr>
                <th width="40">☰</th>
                <th width="130">الأيقونة</th>
                <th width="200">العنوان</th>
                <th>الوصف</th>
                <th width="60">حذف</th>
            </tr>
            </thead>

            <tbody id="pointsTable">
            @foreach($points as $i => $point)
            <tr class="point-row">
                <td style="cursor:move">☰</td>

                {{-- ICON --}}
                <td>
                    <div class="input-group">
                        <input type="text"
                               class="form-control icon-input"
                               readonly
                               data-field="icon"
                               name="points[{{ $i }}][icon]"
                               value="{{ $point->icon }}">
                        <div class="input-group-append">
                            <button type="button"
                                    class="btn btn-outline-primary"
                                    onclick="openIconPicker(this)">
                                <i class="{{ $point->icon ?? 'fas fa-check' }}"></i>
                            </button>
                        </div>
                    </div>
                </td>

                {{-- TITLE --}}
                <td>
                    <input type="text"
                           class="form-control"
                           data-field="title"
                           name="points[{{ $i }}][title]"
                           value="{{ $point->title }}">
                </td>

                {{-- DESCRIPTION --}}
                <td>
                    <input type="text"
                           class="form-control"
                           data-field="description"
                           name="points[{{ $i }}][description]"
                           value="{{ $point->description }}">
                </td>

                <td class="text-center">
                    <button type="button"
                            class="btn btn-sm btn-danger"
                            onclick="removeRow(this)">×</button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<button class="btn btn-success">
    حفظ القسم بالكامل
</button>

</form>

</div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
let currentIconInput = null;

/* ================= ICON PICKER ================= */
function openIconPicker(btn){
    currentIconInput = btn.closest('.input-group').querySelector('.icon-input');
    window.open(
        "{{ route('icons.index') }}",
        'iconPicker',
        'width=900,height=650'
    );
}

window.addEventListener('message', function (event) {
    if (event.data.type !== 'icon-selected') return;

    if (currentIconInput) {
        currentIconInput.value = event.data.icon;
        const iconEl = currentIconInput
            .closest('.input-group')
            .querySelector('button i');
        iconEl.className = event.data.icon;
    }
});

/* ================= REINDEX ================= */
function reindex(section, name){
    document.querySelectorAll(`.${section}-row`).forEach((row,i)=>{
        row.querySelectorAll('[data-field]').forEach(el=>{
            el.name = `${name}[${i}][${el.dataset.field}]`;
        });
    });
}

/* ================= SORTABLE ================= */
Sortable.create(featuresTable,{
    animation:150,
    onEnd(){ reindex('feature','features'); }
});

Sortable.create(pointsTable,{
    animation:150,
    onEnd(){ reindex('point','points'); }
});

/* ================= ADD ROWS ================= */
function addFeature(){
    const tr = document.createElement('tr');
    tr.className = 'feature-row';
    tr.innerHTML = `
        <td style="cursor:move">☰</td>
        <td>
            <div class="input-group">
                <input type="text" class="form-control icon-input" readonly data-field="icon">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-primary"
                            onclick="openIconPicker(this)">
                        <i class="fas fa-icons"></i>
                    </button>
                </div>
            </div>
        </td>
        <td><input class="form-control" data-field="title"></td>
        <td><input class="form-control" data-field="description"></td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger"
                    onclick="removeRow(this)">×</button>
        </td>
    `;
    featuresTable.appendChild(tr);
    reindex('feature','features');
}

function addPoint(){
    const tr = document.createElement('tr');
    tr.className = 'point-row';
    tr.innerHTML = `
        <td style="cursor:move">☰</td>
        <td>
            <div class="input-group">
                <input type="text" class="form-control icon-input" readonly data-field="icon">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-primary"
                            onclick="openIconPicker(this)">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </div>
        </td>
        <td><input class="form-control" data-field="title"></td>
        <td><input class="form-control" data-field="description"></td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger"
                    onclick="removeRow(this)">×</button>
        </td>
    `;
    pointsTable.appendChild(tr);
    reindex('point','points');
}

/* ================= REMOVE ================= */
function removeRow(btn){
    if(!confirm('حذف العنصر؟')) return;
    btn.closest('tr').remove();
}
</script>
@endsection
