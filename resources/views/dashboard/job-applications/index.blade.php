@extends('dashboard.layouts.app')

@section('title', __('models.job_applications'))

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
                                            href="{{ route('admin.job-applications.index') }}">{{ __('models.job_applications') }}</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    data-feather="grid"></i></button>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                    href="{{ route('admin.job-applications.create') }}"><i class="mr-1"
                                        data-feather="circle"></i><span class="align-middle">{{ __('models.add_n_job') }}
                                    </span></a>
                            </div>
                        </div>
                    </div>
                </div> --}}
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
                                            <th>{{ __('models.job_name') }}</th>
                                            <th>{{ __('models.name') }}</th>
                                            <th>{{ __('models.email') }}</th>
                                            <th>{{ __('models.phone') }}</th>
                                            <th>{{ __('models.resume') }}</th>
                                            <th>{{ __('models.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($applications as $application)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $application->jobVacancy->name }}</td>
                                                <td>{{ $application->name }}</td>
                                                <td>
                                                    <a
                                                        href="mailTo:{{ $application->email }}">{{ $application->email }}</a>
                                                </td>
                                                <td>
                                                    <a href="tel:{{ $application->phone }}">{{ $application->phone }}</a>
                                                </td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $application->file) }}" target="_blank">
                                                        <i class="fa-solid fa-link" style="color: #4d8eff;"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <a href="{{ route('admin.job-applications.deleteMsg', $application->id) }}"
                                                            data-id="{{ $application->id }}"
                                                            class="btn btn-sm btn-danger item-delete"><i
                                                                class="fa-solid fa-trash-can"></i></a>
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
