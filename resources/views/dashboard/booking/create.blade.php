@extends('dashboard.layouts.app')

@section('title', __('models.add_booking'))

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
                                            href="{{ route('admin.booking.index') }}">{{ __('models.bookings') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">{{ __('models.add_booking') }}</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    <strong>{{ session('message') }}</strong>
                </div>
            @endif
            <div class="content-body">
                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">{{ __('models.add_booking') }}</h2>
                                </div>
                                <div class="card-body">
                                    <form class="form form-vertical" id="createsectorForm"
                                        action="{{ route('admin.booking.store') }}" method="POST">
                                        @csrf
                                        <div class="row">


                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="user_id">{{ __('models.user_name') }}</label>
                                                    <select type="number" id="user_id" class="form-control"
                                                        name="user_id">
                                                        <option disabled selected>Choose A User</option>
                                                        @foreach ($users as $user)
                                                            <option value={{ $user->id }}>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="unit_id">{{ __('models.unit_name') }}</label>
                                                    <select type="number" id="unit_id" class="form-control"
                                                        name="unit_id">
                                                        <option disabled selected>Choose A Unit</option>
                                                        @foreach ($units as $unit)
                                                            @if (App::getLocale() == 'ar')
                                                                <option value="{{ $unit->id }}">{{ $unit->name_ar }}
                                                                @else
                                                                <option value="{{ $unit->id }}">{{ $unit->name_en }}
                                                            @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('trip_id')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="unit_id">{{ __('models.trip_name') }}</label>
                                                    <select type="number" id="trip_id" class="form-control"
                                                        name="trip_id">
                                                        <option disabled selected>Choose A trip</option>
                                                        @foreach ($trips as $trip)
                                                            @if (App::getLocale() == 'ar')
                                                                <option value="{{ $trip->id }}">{{ $trip->name_ar }}
                                                                @else
                                                                <option value="{{ $trip->id }}">{{ $trip->name_en }}
                                                            @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('trip_id')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- <div class="col-6">
                                                <div class="form-group">
                                                    <label for="price">{{ __('models.price') }}</label>
                                                    <input type="number" id="price" class="form-control" name="price"
                                                        value="{{ old('price') }}" />
                                                    @error('price')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> --}}

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="check_in">{{ __('models.check_in') }}</label>
                                                    <input type="date" id="check_in" class="form-control"
                                                        name="check_in" value="{{ old('check_in') }}" />
                                                    @error('check_in')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="check_out">{{ __('models.check_out') }}</label>
                                                    <input type="date" id="check_out" class="form-control"
                                                        name="check_out" value="{{ old('check_out') }}" />
                                                    @error('check_out')
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
        <script src="{{ asset('dashboard/assets/js/custom/validation/sectorForm.js') }}"></script>
        <script src="{{ asset('dashboard/app-assets/js/custom/preview-image.js') }}"></script>
    @endpush
@endsection
