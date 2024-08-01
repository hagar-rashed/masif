@extends('site.layouts.app')

@title(__('models.jobs'))

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.jobs'))

@section('content')
    <div class="job-application">
        <div class="main-container">
            <div class="title-center">
                <span></span>
                <h2>{{ __('models.apply_job') }}</h2>
                <span></span>
            </div>


            <div class="form-job-application">
                <form action="{{ route('site.jobs.submit-job-application', $job->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="input-form">
                        <label for="name">{{ __('models.name') }} </label>
                        <input type="text" class="form-control" placeholder="" name="name" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="input-form">
                        <label for="email">{{ __('models.email') }} </label>
                        <input type="email" class="form-control" placeholder="" name="email" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="input-form">
                        <label for="phone">{{ __('models.phone') }} </label>
                        <input type="tel" class="form-control" placeholder="" name="phone" required>
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="input-form">
                        <div class="input-form upload-form">
                            <input type="file" class="form-control" accept="image/png, image/jpeg, application/pdf"
                                id="upload-1" name="file" required>
                            <label for="upload-1">
                                {{ __('models.resume') }}
                                <p class="form-control"></p>
                            </label>
                        </div>
                        @error('file')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="btn-job-application">
                        <button class="ctm-btn"> {{ __('models.send') }} </button>
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection
