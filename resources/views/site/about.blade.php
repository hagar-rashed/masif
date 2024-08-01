@extends('site.layouts.app')

@title('New Cairo')

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.about_us'))

@section('content')
    <section class="aboutus">

        <div class="main-container">
            <div class="sub-aboutus">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="text-aboutus">
                            <h2 class="title-start1">{{ __('models.about_us') }} </h2>
                            <p>
                                {{ getSetting('about', app()->getLocale()) }}
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="img-aboutus">
                            <object data="{{ url('site') }}/svg/v-1.svg" type="">
                                <img src="{{ url('site') }}/svg/v-1.svg" alt="">
                            </object>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sub-aboutus">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="text-aboutus">
                            <h2 class="title-start1">{{ __('models.what_we_do') }}</h2>
                            <p>
                                {{ getSetting('what_we_do', app()->getLocale()) }}
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="img-aboutus">
                            <object data="{{ url('site') }}/svg/v-4.svg" type="">
                                <img src="{{ url('site') }}/svg/v-4.svg" alt="">
                            </object>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sub-aboutus">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="text-aboutus">
                            <h2 class="title-start1">{{ __('models.how_we_do') }}</h2>
                            <p>
                                {{ getSetting('how_we_do', app()->getLocale()) }}
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="img-aboutus">
                            <object data="{{ url('site') }}/svg/v-3.svg" type="">
                                <img src="{{ url('site') }}/svg/v-3.svg" alt="">
                            </object>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sub-aboutus">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="text-aboutus">
                            <h2 class="title-start1">{{ __('models.why_we_do') }}</h2>
                            <p>
                                {{ getSetting('why_we_do', app()->getLocale()) }}
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="img-aboutus">
                            <object data="{{ url('site') }}/svg/v-2.svg" type="">
                                <img src="{{ url('site') }}/svg/v-2.svg" alt="">
                            </object>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="aboutus-values mr-section">
            <div class="main-container">
                <div class="title-start">
                    <h2> {{ __('models.our_core_values') }} </h2>
                </div>
                <div class="owl-carousel owl-theme maincarousel" id="slider-values">

                    @foreach ($values as $value)
                        <div class="item">
                            <div class="sub-services-index">
                                <div class="img-services-index">
                                    <img src="{{ asset('storage/' . $value->image) }}" alt="">
                                </div>
                                <h2>{{ $value->name }}</h2>
                                <p>
                                    {{ $value->desc }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    @include('site.includes.clients')

@endsection
