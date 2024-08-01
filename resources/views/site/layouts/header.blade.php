<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

<head>

    @include('site.layouts.style')

</head>

<body>

    <!-- welcome  :) -->


    <!-- start loading -->
    <div class="loading">
        <div class="loader-wrap">
            <div class="loader">
                <div class="cube1"></div>
                <div class="cube2"></div>
                <div class="cube3"></div>
                <div class="cube4"></div>
                <div class="cube5"></div>
            </div>
        </div>
    </div>

    <!-- end lodding -->


    <!-- welcome -->

    <div class="body_page  d-flex flex-column justify-content-between">

        @include('site.layouts.navbar')
