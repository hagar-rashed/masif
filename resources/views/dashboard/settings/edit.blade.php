@extends('dashboard.layouts.app')
@section('title', __('models.settings'))
@section('content')
    @push('js')
        <link rel="stylesheet" href="{{ url('intlTelInput.min.css') }}" type="text/css" />
    @endpush
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.home') }}">{{ __('models.home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ __('models.settings') }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">

                <!-- Validation -->
                <section class="bs-validation">
                    <div class="row">
                        <!-- Bootstrap Validation -->
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('models.settings') }}</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.settings.update') }}" method="POST"
                                        class="needs-validation" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @method('PATCH')

                                        <div class="row">

                                            @foreach ($settings as $setting)
                                                @php
                                                    $ext = explode('_', $setting->key);
                                                @endphp

                                                @if ($setting->type == 'file')
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="price_from">{{ __('models.' . $setting->key) }}</label>
                                                            <input type="file" id="{{ $setting->key }}"
                                                                name="{{ $setting->key }}"
                                                                accept="image/png, image/jpeg, image/jpg, {{ $setting->key == 'main_video' ? 'video/mp4' : '' }}"
                                                                class="form-control image" aria-label="Name"
                                                                aria-describedby="basic-addon-name" require />
                                                            <div class="">
                                                                @if ($errors->has($setting->key))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            style="color: red;">{{ $errors->first($setting->key) }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if ($setting->key != 'main_video')
                                                            <div class="form-group prev">
                                                                <img src="{{ url('storage/' . $setting->value) }}"
                                                                    style="width: 100px"
                                                                    class="img-thumbnail preview-{{ $setting->key }}"
                                                                    alt="">
                                                            </div>
                                                        @endif
                                                    </div>
                                                @elseif($setting->type == 'text')
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="title">{{ __('models.' . $setting->key) }} </label>
                                                            <input type="{{ $setting->type }}" id="{{ $setting->key }}"
                                                                name="{{ $setting->key }}" value="{{ $setting->value }}"
                                                                class="form-control image" aria-label="Name"
                                                                aria-describedby="basic-addon-name" require />
                                                            <div class="">
                                                                @if ($errors->has('title'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            style="color: red;">{{ $errors->first('title') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($setting->type == 'textarea')
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="title">{{ __('models.' . $setting->key) }} </label>
                                                            <textarea name="{{ $setting->key }}" class="form-control" dir="{{ end($ext) == 'ar' ? 'rtl' : 'ltr' }}"
                                                                name="{{ $setting->key }}" id="{{ $setting->key }}" cols="30" rows="10" require>{{ $setting->value }}</textarea>
                                                            <div class="">
                                                                @if ($errors->has('title'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            style="color: red;">{{ $errors->first('title') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($setting->type == 'json')
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="title">{{ __('models.' . $setting->key) }} </label>
                                                            @foreach (json_decode($setting->value) as $value)
                                                                <div class="row my-2">
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="{{ $setting->key }}[]"
                                                                            class="form-control"
                                                                            value="{{ $value }}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <a class="btn btn-danger remove-btn">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            <div class="">
                                                                @if ($errors->has('title'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            style="color: red;">{{ $errors->first('title') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <a class="btn btn-primary add-btn">
                                                                <i data-feather='plus'></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @elseif($setting->type == 'number')
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="title">{{ __('models.' . $setting->key) }} </label>
                                                            <input
                                                                type="{{ $setting->key == 'phone' ? 'text' : $setting->type }}"
                                                                id="{{ $setting->key }}" name="{{ $setting->key }}"
                                                                value="{{ $setting->value }}"
                                                                class="form-control {{ $setting->key }}"
                                                                aria-label="Name" aria-describedby="basic-addon-name"
                                                                require />
                                                            <div class="">
                                                                @if ($errors->has('title'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            style="color: red;">{{ $errors->first('title') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($setting->type == 'email')
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="title">{{ __('models.' . $setting->key) }}
                                                            </label>
                                                            <input type="{{ $setting->type }}" id="{{ $setting->key }}"
                                                                name="{{ $setting->key }}" value="{{ $setting->value }}"
                                                                class="form-control image" aria-label="Name"
                                                                aria-describedby="basic-addon-name" require />
                                                            <div class="">
                                                                @if ($errors->has('title'))
                                                                    <span class="help-block">
                                                                        <strong
                                                                            style="color: red;">{{ $errors->first('title') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">تحديث <i
                                                        data-feather="edit"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /Bootstrap Validation -->

                    </div>
                </section>
                <!-- /Validation -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
    @push('js')
        <script src="{{ url('dashboard') }}/app-assets/js/custom/preview-image.js"></script>
        {{-- <script src="{{ url('dashboard') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script> --}}
        <script src="https://cdn.ckeditor.com/4.20.1/standard-all/ckeditor.js"></script>
        {{-- <script src="{{ url('intlTelInput.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('utils.js') }}" type="text/javascript"></script> --}}

        <script>
            // CKEDITOR.config.extraPlugins = 'justify';

            // CKEDITOR.replace('about_ar', {
            //     language: 'ar'
            // });
            // CKEDITOR.replace('about_en', {
            //     language: 'en'
            // });

            $(document).on('click', '.remove-btn', function(e) {
                e.preventDefault();
                $(this).closest('.row').remove();
            });

            $('.add-btn').click(function(e) {
                e.preventDefault();
                var content = `<div class="row my-2">
                                    <div class="col-md-8">
                                        <input type="text" name="features[]"
                                            class="form-control"
                                            value="" required>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="btn btn-danger remove-btn">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </div>`;
                $(this).parent().prepend(content);
            });
        </script>
    @endpush

@endsection
