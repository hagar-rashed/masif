@extends('site.layouts.app')

@title(__('models.jobs'))

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.jobs'))

@section('content')
    <section class="jops">
        <div class="main-container">
            <div class="row">

                @foreach ($jobs as $job)
                    <div class="col-lg-6">
                        <div class="sub-jops">
                            <h2> {{ $job->name }} </h2>
                            <p>
                                {{ strip_tags(Str::limit($job->desc, 100)) }}
                            </p>
                            <a href="{{ route('site.jobs.show', $job->id) }}" class="ctm-btn">{{ __('models.apply') }}</a>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
@endsection
