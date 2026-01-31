<script src="{{ asset('backend/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script type="text/javascript" src="{{ asset('backend/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/app-assets/vendors/js/charts/jquery.sparkline.min.js') }}">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/chart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/data/jvector/visitor-data.js') }}" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="{{ asset('backend/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/core/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/customizer.js') }}" type="text/javascript"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script type="text/javascript" src="{{ asset('backend/app-assets/js/scripts/ui/breadcrumbs-with-stats.js') }}">
</script>
<script src="{{ asset('backend/app-assets/js/scripts/pages/dashboard-sales.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('backend/app-assets/vendors/js/forms/select/selectivity-full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/forms/select/form-selectivity.js') }}" type="text/javascript"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<script src="{{ asset('backend/app-assets/vendors/js/tables/datatable/datatables.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"
    type="text/javascript"></script>
@if (app()->getLocale() == 'en')
    <script src="{{ asset('backend/app-assets/js/scripts/tables/datatables/datatable-advanced.js') }}"
        type="text/javascript"></script>
@else
    <script src="{{ asset('backend/app-assets/js/scripts/tables/datatables/datatable-advancedar.js') }}"
        type="text/javascript"></script>
@endif
<script src="{{ asset('backend/app-assets/vendors/js/extensions/sweetalert.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/extensions/toastr.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/custom-js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/extensions/jquery.steps.min.js') }}" type="text/javascript">
</script>

<!-- END PAGE VENDOR JS-->
<script src="{{ asset('backend/app-assets/js/scripts/forms/wizard-steps.js') }}" type="text/javascript"></script>
</script>
<script src="{{ asset('backend/app-assets/vendors/js/forms/tags/tagging.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/forms/tags/tagging.js') }}" type="text/javascript"></script>
<!-- jQuery (Required for Toastr) -->
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('vendor/editor/tinymce.min.js') }}"></script>

<script>
tinymce.init({
    selector: '.js-editor',
    license_key: 'gpl',
    language: 'ar',
    directionality: 'rtl',
    height: 300,
    plugins: 'image link lists code autoresize',
    toolbar:
        'undo redo | bold italic underline | bullist numlist | image media-library | alignleft aligncenter alignright | code',
    branding: false,
    setup: function (editor) {
        editor.ui.registry.addButton('media-library', {
            text: '📁 مكتبة الوسائط',
            onAction: function () {
                window.activeTinyEditor = editor;
                window.open(
                    '{{ route('dashboard.media.index') }}?select_mode=editor',
                    'MediaLibrary',
                    'width=1200,height=800'
                );
            }
        });
    }
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("editor")) {
            CKEDITOR.replace("editor", {
                height: 200,
            });

            document.querySelector("form").addEventListener("submit", function(e) {
                let editor = CKEDITOR.instances.editor;
                if (editor) {
                    let editorData = editor.getData().trim();
                    let errorMsg = document.getElementById("editor-error");

                    if (!editorData) {
                        e.preventDefault();
                        errorMsg.style.display = "block";
                    } else {
                        errorMsg.style.display = "none";
                    }
                }
            });
        }
    });
</script>




<script>
    $(document).ready(function() {
        @if (session('toastr_success'))
            toastr.success("{{ session('toastr_success') }}");
        @endif

        @if (session('toastr_error'))
            toastr.error("{{ session('toastr_error') }}");
        @endif
    });
</script>

<script>
    $(document).ready(function() {
        $('#image').on('change', function() {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('.image-preview').attr('src', e.target.result);
            };

            if (this.files && this.files[0]) {
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>

<script>
    $(".imagee").change(function() {

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-previeww').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }

    });
    $('.delete-confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `هل متأكد من حذف العنصر ؟`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>

<script></script>


<script>
    let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        let switchery = new Switchery(html, {
            size: 'small'
        });
    });
</script>

@yield('script')


<script>
    $(document).ready(function() {
        @php
            $excludedRoutes = ['products.index', 'categories.index', 'coupons.index', 'orders.index', 'products.show', 'clients.show', 'orders.show'];
        @endphp

        $('table').DataTable({
            language: {
                "sProcessing": "جاري التحميل...",
                "sLengthMenu": "أظهر _MENU_ مدخلات",
                "sZeroRecords": "لم يعثر على أية سجلات",
                "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix": "",
                "search": "<span class='search-label'><i class='la la-search'></i> ابحث</span>:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "التالي",
                    "sLast": "الأخير"
                }
            },
            direction: 'rtl'
        });
    });

    function showToast(message, type = 'info') {
        if (typeof Swal !== 'undefined') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-start',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        } else {
            alert(message);
        }
    }

    @if (session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif

    @if (session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif

    @if (session('info'))
        showToast('{{ session('info') }}', 'info');
    @endif
</script>

<script>
    window.addEventListener('message', function(event) {
        if (!event.data || !event.data.path) return;

        const imagePath = event.data.path;

        document.getElementById('imageInput').value = imagePath;

        const preview = document.getElementById('imagePreview');
        preview.src = '{{ asset('storage') }}/' + imagePath;
        preview.style.display = 'block';
    });
</script>
<script>
    function openMediaLibrary() {
        window.open(
            '{{ route('dashboard.media.index') }}?select_mode=section',
            'MediaLibrary',
            'width=1200,height=800,scrollbars=yes,resizable=yes'
        );
    }



    /* ============================================================
       RECEIVE IMAGE FROM MEDIA LIBRARY
    ============================================================ */
    window.addEventListener('message', function(event) {

        if (!event.data || event.data.type !== 'media-selected') return;

        const media = event.data.media;
        if (!media || !media.url) return;

        // hidden input
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        // خزّن المسار بدون storage/
        const cleanPath = media.url.replace('{{ asset('storage') }}/', '');

        imageInput.value = cleanPath;

        imagePreview.src = media.url;
        imagePreview.style.display = 'block';

        // فعّل وضع الصورة تلقائيًا
        const imageRadio = document.getElementById('type_image');
        if (imageRadio) {
            imageRadio.checked = true;
            imageRadio.dispatchEvent(new Event('change'));
        }
    });
</script>
<script>
    window.addEventListener('message', function(event) {
        if (!event.data || !event.data.type) return;

        /* SECTION IMAGE */
        if (event.data.type === 'media-selected' && window.activeSectionId) {
            const media = event.data.media;
            const id = window.activeSectionId;

            document.getElementById(`section_image_${id}`).value = media.id;
            document.getElementById(`section_preview_${id}`).src = media.url;
            document.getElementById(`section_preview_${id}`).style.display = 'block';
            document.getElementById(`section_remove_${id}`).style.display = 'inline-block';

            window.activeSectionId = null;
            return;
        }

        /* EDITOR IMAGE */
        if (event.data.type === 'insert-image-editor' && window.activeTinyEditor) {
            window.activeTinyEditor.insertContent(
                `<img src="${event.data.media.url}" style="max-width:100%;height:auto;" />`
            );
            window.activeTinyEditor = null;
        }
    });
</script>
<script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.js-open-media');
        if (!btn) return;

        e.preventDefault();
        window.activeSectionId = btn.dataset.sectionId;

        window.open(
            '/dashboard/media?select_mode=section',
            'MediaPicker',
            'width=1200,height=800'
        );
    });

    function removeSectionImage(sectionId) {
        document.getElementById(`section_image_${sectionId}`).value = '';
        document.getElementById(`section_preview_${sectionId}`).style.display = 'none';
        document.getElementById(`section_remove_${sectionId}`).style.display = 'none';
    }
</script>
<script>
    let activeIconInput = null;

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.js-open-icon-picker');
        if (!btn) return;

        activeIconInput = btn.closest('.repeater-item').querySelector('.icon-input');

        window.open(
            '/dashboard/icons',
            'IconPicker',
            'width=1000,height=650'
        );
    });

    window.addEventListener('message', function(event) {
        if (event.data?.type !== 'icon-selected') return;
        if (!activeIconInput) return;

        activeIconInput.value = event.data.icon;
        activeIconInput.closest('.repeater-item')
            .querySelector('.icon-preview')
            .innerHTML = `<i class="${event.data.icon} fa-2x text-primary"></i>`;
    });
</script>
<!-- END PAGE LEVEL JS-->
</body>

</html>
