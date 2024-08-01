<title> NEW CAIRO | @yield('title')</title>

@seo

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content=" website" />
<meta name="keywords" content="" />
<meta name="author" content="" />
<!-- Chrome, Firefox OS and Opera -->
<meta name="theme-color" content="">
<!-- Windows Phone -->
<meta name="msapplication-navbutton-color" content="">
<!-- iOS Safari -->
<meta name="apple-mobile-web-app-status-bar-style" content="">
<meta name="apple-mobile-web-app-capable" content="yes">

<link rel="shortcut icon" href="{{ asset('storage/' . getSetting('logo')) }}">
<meta name="msapplication-TileColor" content="">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
    integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css"> --}}
<link rel="stylesheet" href="{{ url('site') }}/css/icons-bootstrap.css">
<link rel="stylesheet" href="{{ url('site') }}/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<link rel="stylesheet" href="https://use.fontawesome.com/6fb9af6ea9.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="{{ url('site') }}/css/owl.carousel.min.css">
<link rel="stylesheet" href="{{ url('site') }}/css/owl.theme.default.min.css">
<link rel="stylesheet" href="{{ url('site') }}/css/lightgallery-bundle.min.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="{{ url('site') }}/css/animate.css">

<link rel="stylesheet" href="{{ url('site') }}/css/general.css">

<link rel="stylesheet" href="{{ url('site') }}/css/header.css">
<link rel="stylesheet" href="{{ url('site') }}/css/footer.css">
<link rel="stylesheet" href="{{ url('site') }}/css/loader.css">
<link rel="stylesheet" href="{{ url('site') }}/css/main.css">
<link rel="stylesheet" href="{{ url('site') }}/css/responsive.css">

@if (app()->getLocale() === 'ar')
    <link rel="stylesheet" href="{{ url('site') }}/css/ar.css">
@else
    <link rel="stylesheet" href="{{ url('site') }}/css/en.css">
@endif
