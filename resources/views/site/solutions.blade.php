@extends('site.layouts.app')

@title('New Cairo')

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.solutions'))

@section('content')
    <section class="solutions">
        <div class="main-container">

            @foreach ($solutions as $solution)
                <div class="sub-solutions sub-aboutus">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="text-aboutus">
                                <h2 class="title-start1">{{ $solution->name }}</h2>
                                <p>
                                    {{ $solution->desc }}
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="img-aboutus">
                                <object data="{{ asset('storage/' . $solution->image) }}" type="">
                                    <img src="{{ asset('storage/' . $solution->image) }}" alt="">
                                </object>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    @include('site.includes.clients')

@endsection
