@extends('layouts.master')

@section('title','نقاط الرؤية')
@section('page_title','نقاط الرؤية')

@section('content')
<div class="app-content content">
<div class="content-wrapper">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('dashboard.about.points.update') }}">
@csrf

<div class="d-flex justify-content-between mb-3">
    <h4 class="mb-0">نقاط الرؤية</h4>
    <button type="button" class="btn btn-primary" onclick="addRow()">إضافة نقطة</button>
</div>

<div class="card">
<div class="card-body p-0">

<table class="table table-bordered mb-0">
<thead class="thead-light">
<tr>
    <th width="40">☰</th>
    <th width="200">العنوان</th>
    <th>الوصف</th>
    <th width="80">حذف</th>
</tr>
</thead>

<tbody id="sortable">
@foreach($points as $i => $point)
<tr class="row-item">
    <td style="cursor:move">☰</td>

    <td>
        <input type="text"
               class="form-control"
               data-field="title"
               name="points[{{ $i }}][title]"
               value="{{ $point->title }}">
    </td>

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
            el.name = `points[${i}][${el.dataset.field}]`;
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
        <td><input type="text" class="form-control" data-field="title"></td>
        <td><input type="text" class="form-control" data-field="description"></td>
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
