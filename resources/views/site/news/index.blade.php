@extends('site.layouts.app')

@title(__('models.news'))

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.news'))

@section('content')
    <section class="news">
        <div class="main-container">
            <div class="title-center">
                <span></span>
                <h2> {{ __('models.news') }}</h2>
                <span></span>
            </div>
            <div class="row">

                @foreach ($articles as $article)
                    @php
                        $images = json_decode($article->images, true);
                        $firstImage = reset($images);
                    @endphp

                    <div class="col-lg-4 col-md-6">
                        <div class="sub-news" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="700">
                            <div class="img-news">
                                <img src="{{ asset('storage/' . $firstImage) }}" alt="">
                                <div class="data-new"> <span> {{ $article->day }} </span>
                                    {{ $article->month }}</div>
                            </div>
                            <div class="text-news">
                                <h2>{{ $article->title }}</h2>
                                <p>
                                    {{ strip_tags(Str::limit($article->desc, 100)) }}
                                </p>
                                <a href="{{ route('site.news.show', $article->id) }}" class="ctm-btn">
                                    {{ __('models.read_more') }} <i class="fas fa-long-arrow-alt-left"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
@endsection
