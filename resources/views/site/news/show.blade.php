@extends('site.layouts.app')

@title($article->title)

@description(isset($article->desc) ? Str::limit($article->desc, 160) : Str::limit($article->desc, 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', $article->title)

@section('content')
    <section class="news-details">
        <div class="main-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="sub-news-details">
                        <div class="owl-carousel owl-theme maincarousel" id="slider-news-details">
                            @foreach (json_decode($article->images) as $image)
                                <div class="item">
                                    <div class="img-news-details">
                                        <img src="{{ asset('storage/' . $image) }}" alt="">
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        {{-- <img src="{{ asset('storage/' . $article->image) }}" alt=""> --}}
                        <div class="text-news-details">
                            <h2>{{ $article->title }}</h2>
                            <p>
                                {!! $article->desc !!}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="search-new">
                        <h2 class="title-news">{{ __('models.search') }}</h2>

                        <div class="form-search">
                            <input type="text" id="input_search" data-url="{{ route('site.search') }}"
                                class="form-control" name="search">
                            <button> <i class="fas fa-search"></i></button>

                            <div class="details_search" style="display: none;">
                                <ul id="search_result">

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="element-news">
                        <h2 class="title-news">{{ __('models.categories') }}</h2>
                        <ul>
                            @foreach ($categories as $category)
                                <li><a href="{{ route('site.news.filter', $category->id) }}"> {{ $category->name }} </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="last-news">
                        <h2 class="title-news">{{ __('models.latest_news') }}</h2>
                        <ul>
                            @foreach ($latestArticles as $item)
                                <li>
                                    <a href="{{ route('site.news.show', $item->id) }}">
                                        <div class="img-last-news">
                                            <img src="{{ asset('storage/' . $item->first_image) }}" alt="">
                                        </div>
                                        <div class="text-last-news">
                                            <h2>{{ $item->title }}</h2>
                                            <p>
                                                {{ strip_tags(Str::limit($article->desc, 100)) }}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script src="{{ asset('js/share.js') }}"></script>
    @endpush
@endsection
