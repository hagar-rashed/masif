@extends('site.layouts.app')

@title('New Cairo')

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.partners'))

@section('content')
    <section class="partners">
        <div class="main-container">
            <h2 class="title-start1">{{ __('models.our_partners') }} </h2>

            @foreach ($partners as $partner)
                <div class="sub-partners mr-section">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="text-partners">
                                <div class="logo-partners">
                                    <img src="{{ asset('storage/' . $partner->image) }}" alt="">
                                </div>
                                <h2>{{ $partner->name }}</h2>
                                <p>
                                    {{ $partner->desc }}
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="video-partners">

                                @if ($partner->ext === 'mp4')
                                    <video controls width="100%">
                                        <source src="{{ asset('storage/' . $partner->media) }}" type="video/webm">

                                        <source src="{{ asset('storage/' . $partner->media) }}" type="video/mp4">

                                        Download the
                                        <a href="{{ asset('storage/' . $partner->media) }}">WEBM</a>
                                        or
                                        <a href="{{ asset('storage/' . $partner->media) }}">MP4</a>
                                        video.
                                    </video>
                                @else
                                    <div class="img-aboutus">
                                        <object data="{{ asset('storage/' . $partner->media) }}" type="">
                                            <img src="{{ asset('storage/' . $partner->media) }}" alt="">
                                        </object>
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>

    @include('site.includes.clients')


@endsection
