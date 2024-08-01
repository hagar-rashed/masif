<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
        <span class="float-md-left d-block d-md-inline-block mt-25">
            <span class="d-none d-sm-inline-block">
                {{ __('models.all_rights') . ' ' . date('Y') . ' ' . __('models.reserved_to') . ' ' . 'New Cairo' }}
            </span>
        </span>
    </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->

@include('dashboard.layouts.script')

</body>
<!-- END: Body-->

</html>
