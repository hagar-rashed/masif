@extends('dashboard.layouts.app')

@section('title', __('models.add_n_service'))

@section('content')
@section('content')
   <!-- BEGIN: Content-->
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
                                <li class="breadcrumb-item"><a href="{{ route('admin.units.index') }}">{{ __('models.units') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('models.add_n_unit') }}</li>
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
                                <h2 class="card-title">{{ __('models.add_n_unit') }}</h2>
                            </div>
                            <div class="card-body">
                                <form class="form form-vertical" id="createUnitForm" action="{{ route('admin.units.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="village_id">{{ __('models.village') }}</label>
                                                <select class="form-control" name="village_id">
                                                    @foreach($villages as $village)
                                                        <option value="{{ $village->id }}" {{ old('village_id') == $village->id ? 'selected' : '' }}>
                                                            {{ $village->{'name_'.app()->getLocale()} }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('village_id')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name_ar">{{ __('models.name_ar') }}</label>
                                                <input type="text" id="name_ar" class="form-control" name="name_ar" value="{{ old('name_ar') }}" />
                                                @error('name_ar')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name_en">{{ __('models.name_en') }}</label>
                                                <input type="text" id="name_en" class="form-control" name="name_en" value="{{ old('name_en') }}" />
                                                @error('name_en')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="location_ar">{{ __('models.location_ar') }}</label>
                                                <textarea class="form-control" name="location_ar" rows="3">{{ old('location_ar') }}</textarea>
                                                @error('location_ar')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="location_en">{{ __('models.location_en') }}</label>
                                                <textarea class="form-control" name="location_en" rows="3">{{ old('location_en') }}</textarea>
                                                @error('location_en')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="owner_name_ar">{{ __('models.owner_name_ar') }}</label>
                                                <textarea class="form-control" name="owner_name_ar" rows="3">{{ old('owner_name_ar') }}</textarea>
                                                @error('owner_name_ar')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="owner_name_en">{{ __('models.owner_name_en') }}</label>
                                                <textarea class="form-control" name="owner_name_en" rows="3">{{ old('owner_name_en') }}</textarea>
                                                @error('owner_name_en')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="desc_ar">{{ __('models.desc_ar') }}</label>
                                                <textarea class="form-control" name="desc_ar" rows="3">{{ old('desc_ar') }}</textarea>
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
                                                <textarea class="form-control" name="desc_en" rows="3">{{ old('desc_en') }}</textarea>
                                                @error('desc_en')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="price">{{ __('models.price') }}</label>
                                                <input type="text" id="price" class="form-control" name="price" value="{{ old('price') }}" />
                                                @error('price')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="booked">{{ __('models.booked') }}</label>
                                                <select class="form-control" name="booked">
                                                    <option value="0" {{ old('booked') == 0 ? 'selected' : '' }}>No</option>
                                                    <option value="1" {{ old('booked') == 1 ? 'selected' : '' }}>Yes</option>
                                                </select>
                                                @error('booked')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="avilable_from">{{ __('models.avilable_from') }}</label>
                                                <input type="datetime-local" id="avilable_from" class="form-control" name="avilable_from" value="{{ old('avilable_from') }}" />
                                                @error('avilable_from')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="avilable_to">{{ __('models.avilable_to') }}</label>
                                                <input type="datetime-local" id="avilable_to" class="form-control" name="avilable_to" value="{{ old('avilable_to') }}" />
                                                @error('avilable_to')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                              <!-- Image Upload Field -->
                                              <div class="col-6">
                                                <div class="form-group">
                                                    <label for="images">{{ __('models.images') }}</label>
                                                    <input type="file" id="images" class="form-control" name="images[]" multiple />
                                                    @error('images')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                    @error('images.*')
                                                        <span class="alert alert-danger">
                                                            <small class="errorTxt">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="lat">{{ __('models.lat') }}</label>
                                                <textarea id="lat" class="form-control" name="lat" rows="3">{{ old('lat') }}</textarea>
                                                @error('lat')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="lng">{{ __('models.lng') }}</label>
                                                <textarea id="lng" class="form-control" name="lng" rows="3">{{ old('lng') }}</textarea>
                                                @error('lng')
                                                    <span class="alert alert-danger">
                                                        <small class="errorTxt">{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div id="map" style="height: 500px; width: 100%;"></div>
                                  


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
            <!-- Basic Vertical form layout section end -->
        </div>
    </div>
</div>
<!-- END: Content-->


    @push('js')
        <script src="{{ asset('dashboard/assets/js/custom/validation/serviceForm.js') }}"></script>
        <script src="{{ asset('dashboard/app-assets/js/custom/preview-image.js') }}"></script>

        
<script>
    $("#pac-input").focusin(function() {
        $(this).val('');
    });
  
    $('#lat').val('');
    $('#lng').val('');
  
    function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 24.740691, lng: 46.6528521},
            zoom: 13,
            mapTypeId: 'roadmap'
        });
  
        var marker = new google.maps.Marker({
            position: {lat: 24.740691, lng: 46.6528521},
            map: map,
            title: 'Drag me!',
            draggable: true
        });
  
        google.maps.event.addListener(marker, 'dragend', function(event) {
            document.getElementById("lat").value = this.getPosition().lat();
            document.getElementById("lng").value = this.getPosition().lng();
        });
  
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
                marker.setPosition(pos);
                document.getElementById("lat").value = pos.lat;
                document.getElementById("lng").value = pos.lng;
            }, function() {
                handleLocationError(true, map.getCenter());
            });
        } else {
            handleLocationError(false, map.getCenter());
        }
    }
  
    function handleLocationError(browserHasGeolocation, pos) {
        var content = browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.';
        var options = {
            map: map,
            position: pos,
            content: content
        };
        var infowindow = new google.maps.InfoWindow(options);
        infowindow.open(map);
        map.setCenter(pos);
    }
  
  
  </script>

  
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDc4op2z5AnCNM5hgYKl5M4mDsV_rILD4Y&libraries=places&callback=initAutocomplete&language=ar&region=EG" async defer></script>
  
    @endpush
@endsection
