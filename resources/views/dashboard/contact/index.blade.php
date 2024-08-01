@extends('dashboard.layouts.app')

@section('title', __('models.contact_msgs'))

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
                                            href="{{ route('admin.contacts.index') }}">{{ __('models.contact_msgs') }}</a>
                                    </li>
                                </ol>
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
                                            <th>{{ __('models.fullname') }}</th>
                                            <th>{{ __('models.company') }}</th>
                                            <th>{{ __('models.zlocation') }}</th>
                                            <th>{{ __('models.phone') }}</th>
                                            <th>{{ __('models.email') }}</th>
                                            <th>{{ __('models.file') }}</th>
                                            <th>{{ __('models.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $contact)
                                            <tr>
                                                <td>{{ $contact->id }}</td>
                                                <td>{{ $contact->fullname }}</td>
                                                <td>{{ $contact->company }}</td>
                                                <td>{{ $contact->location }}</td>
                                                <td>
                                                    <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                                </td>
                                                <td>
                                                    <a href="mailTo:{{ $contact->email }}">{{ $contact->email }}</a>
                                                </td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $contact->file) }}" target="_blank">
                                                        <i class="fa-solid fa-link" style="color: #4d8eff;"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                                            class="btn btn-sm btn-primary"><i
                                                                class="fa-solid fa-eye"></i></a>
                                                        <a href="{{ route('admin.contacts.deleteMsg', $contact->id) }}"
                                                            data-id="{{ $contact->id }}"
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
