<!-- BEGIN: Vendor JS-->

<script src="{{ asset('dashboard/app-assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('dashboard/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/js/core/app.js') }}"></script>
<!-- END: Theme JS-->



<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('dashboard/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/jszip.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
<script src="{{ asset('dashboard/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
{{-- <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script> --}}

<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('dashboard/app-assets/js/scripts/pages/page-auth-login.js') }}"></script>
<!-- END: Page JS-->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (app()->getLocale() == 'ar')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_ar.min.js"></script>
@else
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_en.min.js"></script>
@endif


<script>
    var locale = '{!! config('app.locale') !!}';


    $('.table').DataTable({
        "language": {
            "url": locale == 'ar' ? "https://cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json" :
                "https://cdn.datatables.net/plug-ins/1.11.5/i18n/en-GB.json"
        },
    });
</script>


@stack('js')

@if (session()->has('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: "{{ session()->get('success') }}"
        })
    </script>
@endif

@if (session()->has('error'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "{{ session()->get('error') }}"
        })
    </script>
@endif

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
