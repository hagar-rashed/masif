@extends('dashboard.layouts.app')

@section('title', __('models.units'))

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
                                            href="{{ route('admin.units.index') }}">{{ __('models.units') }}</a>
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
                                    href="{{ route('admin.units.create') }}"><i class="mr-1"
                                        data-feather="circle"></i><span class="align-middle">{{ __('models.add_n_unit') }}
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
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="datatables-basic table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('models.name') }}</th>
                                                    <th>{{ __('models.desc') }}</th>
                                                    <th>{{ __('models.location') }}</th>
                                                    <th>{{ __('models.lat') }}</th>
                                                    <th>{{ __('models.lng') }}</th>
                                                    <th>{{ __('models.owner_name') }}</th>
                                                    <th>{{ __('models.price') }}</th>
                                                    <th>{{ __('models.booked') }}</th>
                                                    <th>{{ __('models.available_from') }}</th>
                                                    <th>{{ __('models.available_to') }}</th>
                                                    <th>{{ __('models.images') }}</th>
                                                    <th>{{ __('models.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($units as $unit)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ app()->isLocale('ar') ? $unit->name_ar : $unit->name_en }}</td>
                                                        <td>{{ app()->isLocale('ar') ? $unit->desc_ar : $unit->desc_en }}</td>
                                                        <td>{{ app()->isLocale('ar') ? $unit->location_ar : $unit->location_en }}</td>
                                                        <td>{{ $unit->lat }}</td>
                                                        <td>{{ $unit->lng }}</td>
                                                        <td>{{ app()->isLocale('ar') ? $unit->owner_name_ar : $unit->owner_name_en }}</td>
                                                        <td>{{ $unit->price }}</td>
                                                        <td>{{ $unit->booked ? __('Yes') : __('No') }}</td>
                                                        <td>{{ $unit->avilable_from }}</td>
                                                        <td>{{ $unit->avilable_to }}</td>
                                                        <td>
                                                        <button class="btn btn-sm btn-info preview-images" data-images="{{ json_encode($unit->images) }}" data-toggle="modal" data-target="#imagePreviewModal"><i class="fa-solid fa-eye"></i></button>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group" aria-label="Second group">
                                                                <a href="{{ route('admin.units.edit', $unit->id) }}"
                                                                    class="btn btn-sm btn-primary"><i
                                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                                        <button class="btn btn-sm btn-danger item-delete" data-id="{{ $unit->id }}" data-url="{{ route('admin.units.destroy', $unit->id) }}"><i class="fa-solid fa-trash-can"></i></button>
                                                                        {{-- <button class="btn btn-sm btn-info preview-images" data-images="{{ json_encode($unit->images) }}" data-toggle="modal" data-target="#imagePreviewModal"><i class="fa-solid fa-eye"></i></button> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagePreviewModalLabel">{{ __('models.unit_images') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="imageContainer"></div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <script src="{{ asset('dashboard/app-assets/js/custom/custom-delete.js') }}"></script>
        <script>
            $(document).on('click', '.preview-images', function () {
                var images = $(this).data('images');
                var imageContainer = $('#imageContainer');
                imageContainer.empty();

                images.forEach(function(image) {
                    var imageUrl = '{{ asset('storage') }}/' + image.path;
                    var imgElement = '<div class="col-md-4 mb-3"><img src="' + imageUrl + '" class="img-fluid"></div>';
                    imageContainer.append(imgElement);
                });
            });
        </script>
    @endpush
@endsection
