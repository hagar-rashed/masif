@extends('site.layouts.app')

@title('New Cairo')

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.sectors'))

@section('content')
    <section class="sectors">
        <div class="main-container">
            <div class="title-center">
                <span></span>
                <h2>{{ __('models.sectors') }}</h2>
                <span></span>
            </div>


            <div class="row">
                @foreach ($sectors as $sector)
                    <div class="col-lg-6">
                        <div class="sub-sectors">
                            <div class="img-sectors">
                                <img src="{{ asset('storage/' . $sector->image) }}" alt="">
                            </div>
                            <div class="text-sectors">
                                <h2>{{ $sector->name }} </h2>
                                <p>
                                    {{ $sector->desc }}
                                </p>
                                <div class="btn-sectors">
                                    <a href="{{ $sector->link }}" target="_blank"> {{ __('models.learn_more') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

@endsection
