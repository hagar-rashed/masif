@extends('dashboard.layouts.app')

@section('title', __('models.add_n_article'))

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
                                            href="{{ route('admin.articles.index') }}">{{ __('models.news') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">{{ __('models.add_n_article') }}</a>
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
                                    <h2 class="card-title">{{ __('models.add_n_article') }}</h2>
                                </div>
                                <div class="card-body">
                                    <form class="form form-vertical" id="createArticleForm"
                                        action="{{ route('admin.articles.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            {{-- <div class="col-6">
                                                <div class="form-group">
                                                    <label for="formFile"
                                                        class="form-label">{{ __('models.image') }}</label>
                                                    <input class="form-control image" accept="image/png, image/jpeg"
                                                        type="file" id="formFile" name="image">
                                                    @error('image')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group prev">
                                                    <img src="" style="width: 100px"
                                                        class="img-thumbnail preview-formFile" alt="">
                                                </div>
                                            </div> --}}

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="formFile"
                                                        class="form-label">{{ __('models.images') }}</label>
                                                    <input class="form-control images" accept="image/png, image/jpeg"
                                                        type="file" id="formFile" name="images[]" multiple>
                                                    @error('images')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group prev">
                                                    <img src="" style="width: 100px"
                                                        class="img-thumbnail preview-formFile" alt="">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="category_id">{{ __('models.category') }}</label>

                                                    <select class="form-control" name="category_id" id="category_id">
                                                        <option value="">{{ __('models.select') }}</option>

                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @error('category_id')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title_ar">{{ __('models.title_ar') }}</label>
                                                    <input type="text" id="title_ar" class="form-control"
                                                        name="title_ar" value="{{ old('title_ar') }}" />
                                                    @error('title_ar')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title_en">{{ __('models.title_en') }}</label>
                                                    <input type="text" id="title_en" class="form-control"
                                                        name="title_en" value="{{ old('title_en') }}" />
                                                    @error('title_en')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="desc_ar">{{ __('models.desc_ar') }}</label>
                                                    <textarea class="form-control summernote" name="desc_ar" id="desc_ar" rows="10">{{ old('desc_ar') }}</textarea>
                                                    @error('desc_ar')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="desc_en">{{ __('models.desc_en') }}</label>
                                                    <textarea class="form-control summernote" name="desc_en" id="desc_en" rows="10">{{ old('desc_en') }}</textarea>
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
        <script src="{{ asset('dashboard/assets/js/custom/validation/articleForm.js') }}"></script>
        <script src="{{ asset('dashboard/app-assets/js/custom/preview-image.js') }}"></script>

        <script>
            CKEDITOR.replace('desc_ar', {
                contentsLangDirection: "rtl"
            });

            CKEDITOR.replace('desc_en');

            // ================================= //

            // Function to display image previews
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.prev').html('<img src="' + e.target.result +
                            '" style="width: 100px" class="img-thumbnail preview-formFile" alt="">');
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Event listener for file input change
            $('.images').change(function() {
                readURL(this);
            });
        </script>
    @endpush
@endsection
