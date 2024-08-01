@extends('dashboard.layouts.app')

@section('title', $article->title)

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
                                    <li class="breadcrumb-item"><a href="#">{{ $article->title }}</a>
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
                                    <h2 class="card-title">{{ $article->title }}</h2>
                                </div>
                                <div class="card-body">
                                    <form class="form form-vertical" id="updateArticleForm"
                                        action="{{ route('admin.articles.update', $article->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
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
                                                    <img src="{{ asset('storage/' . $article->image) }}"
                                                        style="width: 100px" class="img-thumbnail preview-formFile"
                                                        alt="">
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
                                                <div class="form-group prev" style="display: flex; flex-wrap: wrap;">
                                                    @if ($article->images)
                                                        @foreach (json_decode($article->images) as $index => $image)
                                                            <div class="image-container" data-image-id="{{ $index }}"
                                                                style="display: inline-block; margin-right: 10px; margin-bottom: 10px;">
                                                                <img src="{{ asset('storage/' . $image) }}"
                                                                    style="width: 100px; margin-right: 10px; margin-top: 5px;"
                                                                    class="img-thumbnail" alt="">

                                                                <button type="button" class="btn btn-danger delete-image"
                                                                    data-url="{{ route('admin.delete-image') }}"
                                                                    data-index="{{ $index }}"><i
                                                                        class="fas fa-trash"></i></button>

                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="category_id">{{ __('models.category') }}</label>

                                                    <select class="form-control" name="category_id" id="category_id">
                                                        <option value="">{{ __('models.select') }}</option>

                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
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
                                                        name="title_ar"
                                                        value="{{ old('title_ar', $article->title_ar) }}" />
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
                                                        name="title_en"
                                                        value="{{ old('title_en', $article->title_en) }}" />
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
                                                    <textarea class="form-control" name="desc_ar" id="desc_ar" rows="10">{{ old('desc_ar', $article->desc_ar) }}</textarea>
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
                                                    <textarea class="form-control" name="desc_en" id="desc_en" rows="10">{{ old('desc_en', $article->desc_en) }}</textarea>
                                                    @error('desc_en')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary mr-1">{{ __('models.update') }}</button>
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

            // ========================== //

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




            // ================================================================ //

            $(document).ready(function() {
                $('.delete-image').on('click', function() {
                    var imageId = $(this).data('image-id');
                    var url = $(this).data('url');
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var $imageContainer = $(this).closest(
                        '.image-container'); // Store the reference to the image container

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            article_id: "{{ $article->id }}",
                            image_id: imageId,
                            _token: csrfToken
                        },
                        dataType: 'json',
                        success: function(response) {
                            // Image deleted successfully, remove the image container
                            $imageContainer.remove();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
