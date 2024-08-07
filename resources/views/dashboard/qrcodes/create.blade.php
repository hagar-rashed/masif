@extends('dashboard.layouts.app')

@section('title', __('models.add_n_sector'))

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.qrcodes.index') }}">{{ __('models.qrcodes') }}</a></li>
                                <li class="breadcrumb-item"><a href="#">{{ __('models.add_n_qrcode') }}</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-vertical-layouts">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">{{ __('models.add_n_qrcode') }}</h2>
                            </div>
                            <div class="card-body">
                                <form class="form form-vertical" id="createsectorForm"
                                    action="{{ route('admin.qrcodes.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name">{{ __('models.name') }}</label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" />
                                                @error('name')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>                                          

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="email">{{ __('models.email') }}</label>
                                                <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" />
                                                @error('email')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="village_name">{{ __('models.village_name') }}</label>
                                                <input type="text" id="village_name" class="form-control" name="village_name" value="{{ old('village_name') }}" />
                                                @error('village_name')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="starting_date">{{ __('models.starting_date') }}</label>
                                                <input type="date" id="starting_date" class="form-control" name="starting_date" value="{{ old('starting_date') }}" />
                                                @error('starting_date')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="expiration_date">{{ __('models.expiration_date') }}</label>
                                                <input type="date" id="expiration_date" class="form-control" name="expiration_date" value="{{ old('expiration_date') }}" />
                                                @error('expiration_date')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- <div class="col-6">
                                            <div class="form-group">
                                                <label for="duration">{{ __('models.duration_days') }}</label>
                                                <input type="number" name="duration" id="duration" class="form-control" value="{{ old('duration') }}" />
                                                @error('duration')
                                                <span class="alert alert-danger">
                                                    <small class="errorTxt">{{ $message }}</small>
                                                </span>
                                                @enderror
                                            </div>
                                        </div> -->
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="code_type">{{ __('models.code_type') }}</label>
                                                <select id="code_type" class="form-control" name="code_type">
                                                    <option value="guest" {{ old('code_type') == 'guest' ? 'selected' : '' }}>{{ __('models.guest') }}</option>
                                                    <option value="owner" {{ old('code_type') == 'owner' ? 'selected' : '' }}>{{ __('models.owner') }}</option>
                                                    <option value="rental" {{ old('code_type') == 'rental' ? 'selected' : '' }}>{{ __('models.rental') }}</option>
                                                </select>
                                                @error('code_type')
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
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('dashboard/assets/js/custom/validation/sectorForm.js') }}"></script>
    <script src="{{ asset('dashboard/app-assets/js/custom/preview-image.js') }}"></script>
@endpush
@endsection
