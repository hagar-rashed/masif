@extends('dashboard.layouts.app')

@section('title', __('models.qrcodes'))

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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.qrcodes.index') }}">{{ __('models.qrcodes') }}</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="grid"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('admin.qrcodes.create') }}">
                                    <i class="mr-1" data-feather="circle"></i>
                                    <span class="align-middle">{{ __('models.add_qrcode') }}</span>
                                </a>
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
                                            <th>{{ __('models.email') }}</th>
                                            <th>{{ __('models.village_name') }}</th>
                                            <th>{{ __('models.expiration_date') }}</th>
                                            <th>{{ __('models.duration') }}</th>
                                            <th>{{ __('models.code_type') }}</th>
                                            <th>{{ __('models.code') }}</th>
                                            <th>{{ __('models.qr_code') }}</th>
                                            <th>{{ __('models.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($qrcodes as $qrcode)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $qrcode->name }}</td>
                                                <td>{{ $qrcode->email }}</td>
                                                <td>{{ $qrcode->village_name }}</td>
                                                <td>{{ $qrcode->expiration_date }}</td>
                                                <td>{{ $qrcode->duration }}</td>
                                                <td>{{ $qrcode->code_type }}</td>
                                                <td>{{ $qrcode->code }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $qrcode->qr_code) }}" alt="QR Code" class="img-fluid" width="50">
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <a href="{{ route('admin.qrcodes.edit', $qrcode->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <form action="{{ route('admin.qrcodes.destroy', $qrcode->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
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
