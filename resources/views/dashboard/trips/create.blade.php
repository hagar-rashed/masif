@extends('dashboard.layouts.app')

@section('title', __('models.add_n_service'))

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
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('createTrip') }}">{{ __('models.services') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">{{ __('models.add_n_service') }}</a>
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
                                    <h2 class="card-title">{{ __('models.add_n_service') }}</h2>
                                </div>
                                <div class="card-body">
                                    <form class="form form-vertical" id="createserviceForm"
                                        action="{{ route('storeTrip') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <!-- Arabic Name -->
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name_ar">{{ __('models.name_ar') }}</label>
                                                    <input type="text" id="name_ar" class="form-control" name="name_ar"
                                                        value="{{ old('name_ar') }}" />
                                                    @error('name_ar')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- English Name -->
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name_en">{{ __('models.name_en') }}</label>
                                                    <input type="text" id="name_en" class="form-control" name="name_en"
                                                        value="{{ old('name_en') }}" />
                                                    @error('name_en')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Arabic Location -->
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="location_ar">{{ __('models.location_ar') }}</label>
                                                    <input type="text" id="location_ar" class="form-control"
                                                        name="location_ar" value="{{ old('location_ar') }}" />
                                                    @error('location_ar')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- English Location -->
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="location_en">{{ __('models.location_en') }}</label>
                                                    <input type="text" id="location_en" class="form-control"
                                                        name="location_en" value="{{ old('location_en') }}" />
                                                    @error('location_en')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="price">سعر الرحلة</label>
                                                    <input type="text" id="price" class="form-control" name="price"
                                                        value="{{ old('price') }}" />
                                                    @error('price')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="start_date">تاريخ بداية الرحلة</label>
                                                    <input type="date" id="start_date" class="form-control"
                                                        name="start_date" value="{{ old('start_date') }}" />
                                                    @error('start_date')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="end_date">تاريخ نهاية الرحلة</label>
                                                    <input type="date" id="end_date" class="form-control"
                                                        name="end_date" value="{{ old('end_date') }}" />
                                                    @error('end_date')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="duration">مدة الرحلة</label>
                                                    <input type="text" id="duration" class="form-control"
                                                        name="duration" value="{{ old('duration') }}" />
                                                    @error('duration')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Arabic Description -->
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="desc_ar">{{ __('models.desc_ar') }}</label>
                                                    <input type="text" id="desc_ar" class="form-control"
                                                        name="desc_ar" value="{{ old('desc_ar') }}" />
                                                    @error('desc_ar')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- English Description -->
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="desc_en">{{ __('models.desc_en') }}</label>
                                                    <input type="text" id="desc_en" class="form-control"
                                                        name="desc_en" value="{{ old('desc_en') }}" />
                                                    @error('desc_en')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary mr-1">{{ __('models.save') }}</button>
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
        <script src="{{ asset('dashboard/assets/js/custom/validation/serviceForm.js') }}"></script>
        <script src="{{ asset('dashboard/app-assets/js/custom/preview-image.js') }}"></script>
    @endpush
@endsection
