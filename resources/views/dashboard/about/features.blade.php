@extends('layouts.master')

@section('title','خدمات عن المركز')
@section('page_title','الخدمات المصغّرة')

@section('content')
<div class="app-content content">
<div class="content-wrapper">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('dashboard.about.features.update') }}">
@csrf

<div class="d-flex justify-content-between mb-3">
    <h4 class="mb-0">الخدمات المصغّرة</h4>
    <button type="button" class="btn btn-primary" onclick="addRow()">إضافة خدمة</button>
</div>

<div class="card">
<div class="card-body p-0">

<table class="table table-bordered mb-0">
<thead class="thead-light">
<tr>
    <th width="40">☰</th>
    <th width="120">أيقونة</th>
    <th>العنوان</th>
    <th width="80">حذف</th>
</tr>
</thead>

<tbody id="sortable">
@foreach($features as $i => $feature)
<tr class="row-item">
    <td style="cursor:move">☰</td>

    <td>
        <input type="text"
               class="form-control"
               data-field="icon"
               name="features[{{ $i }}][icon]"
               value="{{ $feature->icon }}">
    </td>

    <td>
        <input type="text"
               class="form-control"
               data-field="title"
               name="features[{{ $i }}][title]"
               value="{{ $feature->title }}">
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

<button class="btn btn-success mt-3">حفظ</button>

</form>

</div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
function reindex(){
    document.querySelectorAll('.row-item').forEach((row,i)=>{
        row.querySelectorAll('[data-field]').forEach(el=>{
            el.name = `features[${i}][${el.dataset.field}]`;
        });
    });
}

Sortable.create(document.getElementById('sortable'), {
    animation:150,
    onEnd: reindex
});

function addRow(){
    const tbody = document.getElementById('sortable');
    const tr = document.createElement('tr');
    tr.className = 'row-item';
    tr.innerHTML = `
        <td style="cursor:move">☰</td>
        <td><input type="text" class="form-control" data-field="icon"></td>
        <td><input type="text" class="form-control" data-field="title"></td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger"
                    onclick="removeRow(this)">×</button>
        </td>`;
    tbody.appendChild(tr);
    reindex();
}

function removeRow(btn){
    if(!confirm('حذف العنصر؟')) return;
    btn.closest('tr').remove();
    reindex();
}
</script>
@endsection
