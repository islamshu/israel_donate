@extends('layouts.master')
@section('title','اختيار أيقونة')

{{-- ================= STYLE ================= --}}
@section('style')
<style>
    .icon-box {
        cursor: pointer;
        border: 1px solid #e5e7eb;
        padding: 12px 6px;
        border-radius: 10px;
        text-align: center;
        transition: .2s;
        height: 95px;
        background: #fff;
    }

    .icon-box:hover {
        background: #f8f9fa;
        border-color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(13,110,253,.15);
    }

    .icon-box i {
        font-size: 22px;
        color: #0d6efd;
    }

    .icon-name {
        font-size: 11px;
        margin-top: 6px;
        color: #555;
        word-break: break-all;
    }
</style>
@endsection

{{-- ================= CONTENT ================= --}}
@section('content')
<div class="app-content content">
    <div class="content-wrapper">

        <h3 class="mb-3 fw-bold">
            <i class="fas fa-icons me-2 text-primary"></i>
            اختيار أيقونة
        </h3>

        <input type="text"
               id="searchIcon"
               class="form-control mb-4"
               placeholder="ابحث عن أيقونة...">

        <div class="row" id="iconsContainer"></div>

    </div>
</div>
@endsection

{{-- ================= SCRIPT ================= --}}
@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('iconsContainer');
    const searchInput = document.getElementById('searchIcon');

    if (!container) {
        console.error('iconsContainer not found');
        return;
    }

    // تحميل الأيقونات
    fetch('/fontawesome/icons.json')
        .then(res => {
            if (!res.ok) {
                throw new Error('Failed to load icons.json');
            }
            return res.json();
        })
        .then(icons => {

            Object.keys(icons).forEach(name => {

                // فقط solid
                if (!icons[name].styles.includes('solid')) return;

                const iconClass = `fa-solid fa-${name}`;

                const col = document.createElement('div');
                col.className = 'col-6 col-md-2 mb-3 icon-item';
                col.dataset.name = name;

                col.innerHTML = `
                    <div class="icon-box" data-icon="${iconClass}">
                        <i class="${iconClass}"></i>
                        <div class="icon-name">${iconClass}</div>
                    </div>
                `;

                container.appendChild(col);
            });

        })
        .catch(err => {
            console.error(err);
            alert('فشل تحميل الأيقونات');
        });

    // اختيار أيقونة (event delegation)
    container.addEventListener('click', function (e) {
        const box = e.target.closest('.icon-box');
        if (!box) return;

        const icon = box.dataset.icon;

        window.opener?.postMessage({
            type: 'icon-selected',
            icon: icon
        }, '*');

        window.close();
    });

    // البحث
    searchInput.addEventListener('input', function () {
        const value = this.value.toLowerCase();

        document.querySelectorAll('.icon-item').forEach(item => {
            item.style.display = item.dataset.name.includes(value)
                ? 'block'
                : 'none';
        });
    });

});
</script>
@endsection
