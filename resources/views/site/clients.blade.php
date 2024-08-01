@extends('site.layouts.app')

@title('New Cairo')

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.clients'))

@section('content')
    <section class="clients">
        <div class="main-container">
            <div class="title-center">
                <span></span>
                <h2>{{ __('models.clients') }} </h2>
                <span></span>
            </div>



            <div class="row">

                @foreach ($clients as $client)
                    <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                        <a href="{{ $client->link }}" target="_blank">
                            <div data-aos="flip-right" data-aos-easing="linear"data-aos-duration="700"
                                class="img-clinet-index">
                                <img src="{{ asset('storage/' . $client->image) }}" alt="">
                            </div>
                        </a>
                    </div>
                @endforeach


            </div>


            <div class="pagination">
                {{ $clients->links('vendor.pagination.default') }}

                {{-- <ul>
                    <li><a href=""> <i class="bi bi-arrow-right"> </i> </a></li>
                    <li><a href="" class="active"> 1 </a></li>
                    <li><a href=""> 2</a></li>
                    <li><a href=""> <i class="bi bi-arrow-left"> </i> </a></li>
                </ul> --}}
            </div>
        </div>
    </section>

@endsection
