@extends('dashboard.layouts.app')

@section('title', __('models.bookings'))

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
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    data-feather="grid"></i></button>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                    href="{{ route('admin.booking.create') }}"><i class="mr-1"
                                        data-feather="circle"></i><span class="align-middle">{{ __('models.add_booking') }}
                                    </span></a>
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
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('models.user_name') }}</th>
                                            <th>{{ __('models.unit_name') }}</th>
                                            <th>{{ __('models.trip_name') }}</th>
                                            <th>{{ __('models.check_in') }}</th>
                                            <th>{{ __('models.check_out') }}</th>
                                            {{-- <th>{{ __('models.price') }}</th> --}}
                                            <th>{{ __('models.status') }}</th>
                                            <th>{{ __('models.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $booking)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $booking->user->name }}</td>
                                                @if (App::getLocale() == 'ar')
                                                    <td>{{ $booking->unit->name_ar ?? '' }}</td>
                                                @else
                                                    <td>{{ $booking->unit->name_en ?? '' }}</td>
                                                @endif
                                                @if (App::getLocale() == 'ar')
                                                    <td>{{ $booking->trip->name_ar ?? '' }}</td>
                                                @else
                                                    <td>{{ $booking->trip->name_en ?? '' }}</td>
                                                @endif
                                                <td>{{ $booking->check_in }}</td>
                                                <td>{{ $booking->check_out }}</td>
                                                {{-- <td>{{ $booking->price }}</td> --}}
                                                @if (App::getLocale() == 'ar')
                                                    <td>{{ $booking->status == 1 ? 'مفعل' : 'غير مفعل' }}</td>
                                                @else
                                                    <td>{{ $booking->status == 1 ? 'active' : 'inactive' }}</td>
                                                @endif
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <a href="{{ route('admin.booking.edit', $booking->id) }}"
                                                            class="btn btn-sm btn-primary"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                        <form action="{{ route('admin.booking.destroy', $booking->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                                    class="fa-solid fa-trash-can"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
    @push('js')
        <script src="{{ asset('dashboard/app-assets/js/custom/custom-delete.js') }}"></script>
    @endpush
@endsection
