@extends('site.layouts.app')

@title('New Cairo')

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.home'))

@section('content')
    <!-- start videos-index  ================== -->
    <section class="videos-index">
        <div class="main-container">
            <div class="sub-videos-index">
                <video src="{{ asset('storage/' . getSetting('main_video')) }}" autoplay loop muted></video>
            </div>
        </div>
    </section>
    <!-- end videos-index  ================== -->



    <!-- start aboutus-index =========== -->
    <section class="aboutus-index mr-section">
        <div class="main-container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="text-aboutus-index" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="600">
                        <h2>{{ __('models.about_us') }}</h2>
                        <p>
                            {{ getSetting('about', app()->getLocale()) }}
                        </p>


                        <a href="{{ route('site.about') }}" class="ctm-btn"> {{ __('models.read_more') }} <i class="fas fa-long-arrow-alt-left"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="more-aboutus-index">
                        <ul>
                            <li data-aos="fade-up" data-aos-easing="linear" data-aos-duration="600" data-aos-delay="00">
                                <div class="img-more-aboutus-index">
                                    <img src="{{ url('site') }}/images/a1.png" alt="">
                                </div>
                                <div class="text-more-aboutus-index">
                                    <h2>{{ __('models.vision') }}</h2>
                                    <p>
                                        {{ getSetting('vision', app()->getLocale()) }}
                                    </p>
                                </div>
                            </li>
                            <li data-aos="fade-up" data-aos-easing="linear" data-aos-duration="600" data-aos-delay="300">
                                <div class="img-more-aboutus-index">
                                    <img src="{{ url('site') }}/images/a2.png" alt="">
                                </div>
                                <div class="text-more-aboutus-index">
                                    <h2>{{ __('models.mission') }}</h2>
                                    <p>
                                        {{ getSetting('mission', app()->getLocale()) }}
                                    </p>
                                </div>
                            </li>
                            <li data-aos="fade-up" data-aos-easing="linear" data-aos-duration="600" data-aos-delay="600">
                                <div class="img-more-aboutus-index">
                                    <img src="{{ url('site') }}/images/a3.png" alt="">
                                </div>
                                <div class="text-more-aboutus-index">
                                    <h2>{{ __('models.goals') }}</h2>
                                    <p>
                                        {{ getSetting('goal', app()->getLocale()) }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end aboutus-index =========== -->


    <!-- start services-index =========== -->
    <section class="services-index mr-section">
        <div class="main-container">
            <div class="title-center">
                <span></span>
                <h2>{{ __('models.our_services') }}</h2>
                <span></span>
            </div>

            <div class="main-services-index">
                <div class="row">

                    @foreach ($services as $service)
                        <div class="col-lg-4" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="600">

                            <div class="sub-services-index">
                                <div class="img-services-index">
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="">
                                </div>
                                <h2>{{ $service->name }}</h2>
                                <p>
                                    {{ $service->desc }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
    <!-- end services-index =========== -->



    <!-- start news-index  ======================== -->
    <section class="news-index mr-section">
        <div class="main-container">
            <div class="title-start">
                <h2>{{ __('models.our_news') }} </h2>
            </div>

            <div class="main-news-index">
                <div class="owl-carousel owl-theme maincarousel" id="slider-news">
                    @foreach ($news as $item)
                        <div class="item">
                            <div class="sub-news-index">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="">
                                <div class="text-news-index">
                                    <h2> {{ $item->name }} </h2>
                                    <p>
                                        {{ strip_tags(Str::limit($item->desc, 53)) }}
                                    </p>
                                    <a href="{{ route('site.news.show', $item->id) }}"> {{ __('models.read_more') }} <i class="fas fa-long-arrow-alt-left"></i> </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- end news-index  ======================== -->



    @include('site.includes.clients')
@endsection
