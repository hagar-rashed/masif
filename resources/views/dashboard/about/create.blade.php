@extends('dashboard.layouts.app')

@section('title', __('models.add_about_data'))

@section('content')
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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">{{ __('models.about') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">{{ __('models.add_about_data') }}</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">{{ __('models.add_about_data') }}</h2>
                                </div>
                                <div class="card-body">
                                    <form class="form form-vertical" id="createAboutForm"
                                        action="{{ route('admin.about.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <select name="type" id="type" class="form-control" required>
                                                        <option value="">{{ __('models.type') }}</option>
                                                        <option value="life">{{ __('models.practical_life') }}</option>
                                                        <option value="activity">{{ __('models.activity') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-6" id="desc_ar">
                                                <div class="form-group">
                                                    <label for="desc_ar">{{ __('models.desc_ar') }}</label>
                                                    <textarea class="form-control" name="desc_ar" rows="5">{{ old('desc_ar') }}</textarea>
                                                    @error('desc_ar')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-6" id="desc_ar">
                                                <div class="form-group">
                                                    <label for="desc_en">{{ __('models.desc_en') }}</label>
                                                    <textarea class="form-control" name="desc_en" rows="5">{{ old('desc_en') }}</textarea>
                                                    @error('desc_en')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1">{{ __('models.save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    @push('js')
        <script src="{{ asset('dashboard/assets/js/custom/validation/aboutForm.js') }}"></script>
    @endpush
@endsection
