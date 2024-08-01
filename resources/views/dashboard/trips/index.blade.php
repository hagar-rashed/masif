@extends('dashboard.layouts.app')

@section('title', __('models.services'))

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
                                            href="{{ route('tripIndex') }}">{{ __('models.services') }}</a>
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
                                    href="{{ route('createTrip') }}"><i class="mr-1"
                                        data-feather="circle"></i><span
                                        class="align-middle">{{ __('models.add_n_trip') }}
                                    </span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                            <th>{{ __('models.name') }}</th>
                                            <th>{{ __('models.desc') }}</th>
                                            <th>{{ __('models.price') }}</th>
                                            <th>{{ __('models.start_date') }}</th>
                                            <th>{{ __('models.end_date') }}</th>
                                            <th>{{ __('models.duration') }}</th>
                                            <th>{{ __('models.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trips as $trip)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $trip->name }}</td>
                                                <td>{{ Str::words($trip->desc, 15) }}</td>
                                                <td>{{ $trip->price }}</td>
                                                <td>{{ $trip->start_date }}</td>
                                                <td>{{ $trip->end_date }}</td>
                                                <td>{{ $trip->duration }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <a href="{{ route('editTrip', ['id' => $trip->id]) }}"
                                                            class="btn btn-sm btn-primary"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                        <button class="btn btn-sm btn-danger item-delete" data-id="{{ $trip->id }}"
                                                            data-url="{{ route('destroyTrip', $trip->id) }}"><i class="fa-solid fa-trash-can"></i></button>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="{{ asset('dashboard/app-assets/js/custom/custom-delete.js') }}"></script>
    @endpush
@endsection
