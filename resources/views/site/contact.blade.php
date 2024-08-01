@extends('site.layouts.app')

@title('New Cairo')

@description(Str::limit(getSetting('about', app()->getLocale()), 160))

@image(asset('storage/' . getSetting('logo')))

@section('title', __('models.contact_us'))

@section('content')
    <section class="contactus">
        <div class="main-container">
            <div class="title-start">
                <h2 class="title-start1"> {{ __('models.contact_us') }} </h2>
            </div>


            <div class="main-contactus">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('site.contact.sendContact') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-contactus">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-form">
                                            <label for="surname">{{ __('models.surname') }} </label>
                                            <input type="text" class="form-control" value="{{ old('surname') }}"
                                                name="surname" required>

                                            @error('surname')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-form">
                                            <label for="firstname">{{ __('models.firstname') }} </label>
                                            <input type="text" class="form-control" value="{{ old('firstname') }}"
                                                name="firstname" required>
                                            @error('firstname')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-form">
                                            <label for="company">{{ __('models.company') }} </label>
                                            <input type="text" class="form-control" value="{{ old('company') }}"
                                                name="company" required>
                                            @error('company')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-form">
                                            <label for="location">{{ __('models.location') }} </label>
                                            <input type="text" class="form-control" value="{{ old('location') }}"
                                                name="location" required>
                                            @error('location')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-form">
                                            <label for="email">{{ __('models.email') }} </label>
                                            <input type="email" class="form-control" value="{{ old('email') }}"
                                                name="email" required>
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-form">
                                            <label for="phone">{{ __('models.phone') }} </label>
                                            <input type="tel" class="form-control" value="{{ old('phone') }}"
                                                name="phone" required>
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="input-form upload-form">
                                            <input type="file" class="form-control"
                                                accept="image/png, image/jpeg, application/pdf" id="upload-1"
                                                name="file" required>
                                            <label for="upload-1">
                                                {{ __('models.choose_file') }}
                                                <p class="form-control"></p>
                                            </label>
                                            @error('file')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="input-form">
                                            <label for="message">{{ __('models.message') }} </label>
                                            <textarea name="message" id="message" cols="" rows="" class="form-control">{{ old('message') }}</textarea>
                                            @error('message')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="btn-contactus">
                                            <button class="ctm-btn"> {{ __('models.send') }} </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="col-lg-6">
                        <div class="map">
                            <a href="{{ getSetting('location') }}" target="_blank">
                                <img src="{{ asset('storage/' . getSetting('map_image')) }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.4/jquery.validate.min.js"
            integrity="sha512-FOhq9HThdn7ltbK8abmGn60A/EMtEzIzv1rvuh+DqzJtSGq8BRdEN0U+j0iKEIffiw/yEtVuladk6rsG4X6Uqg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_ar.min.js"></script>

        <script src="{{ url('site') }}/js/custom/contactForm.js"></script>
    @endpush
@endsection
