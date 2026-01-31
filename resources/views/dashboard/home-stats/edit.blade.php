@extends('layouts.master')

@section('title','إحصائيات الصفحة الرئيسية')
@section('page_title','إحصائيات الصفحة الرئيسية')

@section('style')
<style>
.switch {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 24px;
}
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background-color: #dc3545;
    transition: .3s;
    border-radius: 30px;
}
.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .3s;
    border-radius: 50%;
}
input:checked + .slider {
    background-color: #28a745;
}
input:checked + .slider:before {
    transform: translateX(22px);
}
</style>
@endsection

@section('content')
<div class="app-content content">
<div class="content-wrapper">

{{-- ================= HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="mb-0">إحصائيات الصفحة الرئيسية</h3>
        <small class="text-muted">
            إضافة – حذف – ترتيب – حفظ
        </small>
    </div>
    <button type="button" class="btn btn-primary" onclick="addRow()">
        + إضافة عنصر
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('home-stats.update') }}" id="statsForm">
@csrf

<div class="card">
<div class="card-body p-0">

<table class="table table-bordered table-hover mb-0">
<thead class="thead-light">
<tr>
    <th width="60">ترتيب</th>
    <th width="160">القيمة</th>
    <th>النص</th>
    <th width="70" class="text-center">حذف</th>
</tr>
</thead>

<tbody id="sortable">
@foreach($stats as $index => $stat)
<tr class="stat-row">

    <td style="cursor:move;font-size:18px">☰</td>

    <td>
        <input type="text"
               class="form-control"
               data-field="value"
               name="stats[{{ $index }}][value]"
               value="{{ $stat->value }}">
    </td>

    <td>
        <input type="text"
               class="form-control"
               data-field="label"
               name="stats[{{ $index }}][label]"
               value="{{ $stat->label }}">
    </td>

    <td class="text-center">
        <button type="button"
                class="btn btn-sm btn-danger"
                onclick="confirmDelete(this)">
            ×
        </button>
    </td>

</tr>
@endforeach
</tbody>
</table>

</div>
</div>

<button type="submit" class="btn btn-success mt-3">
    حفظ التغييرات
</button>

</form>

</div>
</div>
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
/* Toast */

/* إعادة ترقيم الحقول */
function reindexRows(){
    document.querySelectorAll('.stat-row').forEach((row, i) => {
        row.querySelectorAll('[data-field]').forEach(el => {
            const field = el.dataset.field;
            el.name = `stats[${i}][${field}]`;
        });
    });
}

/* Drag & Drop */
Sortable.create(document.getElementById('sortable'), {
    animation: 150,
    onEnd(){
        reindexRows();
        toast('تم تغيير الترتيب، لا تنسى حفظ التغييرات');
    }
});

/* إضافة صف */
function addRow(){
    const tbody = document.getElementById('sortable');
    const row = document.createElement('tr');
    row.className = 'stat-row';

    row.innerHTML = `
        <td style="cursor:move;font-size:18px">☰</td>

        <td>
            <input type="text"
                   class="form-control"
                   data-field="value">
        </td>

        <td>
            <input type="text"
                   class="form-control"
                   data-field="label">
        </td>

        <td class="text-center">
            <button type="button"
                    class="btn btn-sm btn-danger"
                    onclick="confirmDelete(this)">
                ×
            </button>
        </td>
    `;

    tbody.appendChild(row);
    reindexRows();
    toast('تمت إضافة عنصر جديد');
}

/* حذف صف */
function confirmDelete(btn){
    if(!confirm('هل أنت متأكد من حذف هذا العنصر؟')) return;
    btn.closest('tr').remove();
    reindexRows();
    toast('تم حذف العنصر');
}

/* قبل الإرسال */
document.getElementById('statsForm')
    .addEventListener('submit', reindexRows);
</script>

@endsection
