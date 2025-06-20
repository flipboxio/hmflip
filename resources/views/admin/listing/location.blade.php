@extends('admin.template')
@section('main')
  <div class="content-wrapper">
    <section class="content-header">
        <h1>
            Location
            <small>Location</small>
        </h1>
        <ol class="breadcrumb">
            <li>
            <a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="row gap-2">
            <div class="col-md-3 settings_bar_gap">
                @include('admin.common.property_bar')
                </div>

                <div class="col-md-9">
                    <form id="listing_location" method="post" action="{{ url('admin/listing/' . $result->id . '/' . $step) }}" class='signup-form login-form' accept-charset='UTF-8'>
                        {{ csrf_field() }}
                        <div class="box box-info">
                            <div class="box-body">
                                <input type="hidden" name='latitude' id='latitude'>
                                <input type="hidden" name='longitude' id='longitude'>
                                <div class="row">
                                    <div class="col-md-8 mb20">
                                        <label class="label-large fw-bold">Country <span class="text-danger">*</span></label>
                                        <select id="basics-select-bed_type" name="country" class="form-control f-14" id='country'>
                                            @foreach ($country as $key => $value)
                                            <option value="{{ $key }}" {{ ($key == $result->property_address->country) ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('country') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb20">
                                        <label class="label-large fw-bold">Address Line 1 <span class="text-danger">*</span></label>
                                        <input type="text" name="address_line_1" id="address_line_1" value="{{ $result->property_address->address_line_1  }}" class="form-control f-14" placeholder="House name/number + street/road">
                                        <span class="text-danger">{{ $errors->first('address_line_1') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb20">
                                        <div id="map_view" style="width:100%; height:400px;"></div>
                                    </div>
                                    <div class="col-md-8 mb20">
                                        <p>You can move the pointer to set the correct map position</p>
                                        <span class="text-danger">{{ $errors->first('latitude') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb20">
                                        <label class="label-large fw-bold">Address Line 2</label>
                                        <input type="text" name="address_line_2" id="address_line_2" value="{{ $result->property_address->address_line_2  }}" class="form-control f-14" placeholder="Apt., suite, building access code">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb20">
                                        <label class="label-large fw-bold">City / Town / District <span class="text-danger">*</span></label>
                                        <input type="text" name="city" id="city" value="{{ $result->property_address->city  }}" class="form-control f-14">
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb20">
                                        <label class="label-large fw-bold">State / Province / County / Region <span class="text-danger">*</span></label>
                                        <input type="text" name="state" id="state" value="{{ $result->property_address->state  }}" class="form-control f-14">
                                        <span class="text-danger">{{ $errors->first('state') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb20">
                                        <label class="label-large fw-bold">ZIP / Postal Code</label>
                                        <input type="text" name="postal_code" id="postal_code" value="{{ $result->property_address->postal_code }}" class="form-control f-14">
                                        <span class="text-danger">{{ $errors->first('postal_code') }}</span>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6 text-left">
                                        <a data-prevent-default="" href="{{ url('admin/listing/' . $result->id . '/description') }}" class="btn btn-large btn-primary f-14">Back</a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="submit" class="btn btn-large btn-primary next-section-button f-14">
                                            Next
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </section>
    <div class="clearfix"></div>
  </div>
@endsection

@section('validate_script')
<script type="text/javascript">
    'use strict'
    var page = 'location';
    let fieldRequiredText = "{{ __('This field is required.') }}";
	let maxlengthText = "{{ __('Please enter no more than 255 characters.') }}";
	let latitude = "{{ $result->property_address->latitude != '' ? $result->property_address->latitude:0 }}";
	let longitude = "{{ $result->property_address->longitude != '' ? $result->property_address->longitude:0 }}";
</script>
<script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/listings.min.js') }}"></script>
@endsection

