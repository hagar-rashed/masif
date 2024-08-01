@include('site.layouts.header')
<!-- BEGIN: Content-->

<main id="app" class="{{ Route::currentRouteName() != 'site.home' ? 'mr-section' : '' }}">
    @yield('content')
</main>
<!-- END: Content-->
@include('site.layouts.footer')
