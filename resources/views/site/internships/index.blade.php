@extends('site.layouts.app')

@title(__('models.internships'))

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.internships'))

@section('content')
    <section class="jops">
        <div class="main-container">
            <div class="row">

                <div class="col-12 text-center">
                    <img src="{{ url('site') }}/images/coming-soon.png" alt="">
                </div>
            </div>
        </div>
    </section>
@endsection
