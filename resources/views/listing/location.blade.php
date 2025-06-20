@extends('template')
@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		@include('users.sidebar')
		<div class="col-md-10">
			<div class="main-panel min-height mt-4">
				<div class="row justify-content-center">
					<div class="col-md-3 pl-4 pr-4">
						@include('listing.sidebar')
					</div>

					<div class="col-md-9 mt-4 mt-sm-0 pl-4 pr-4">
						<form id="lis_location" method="post" action="{{ url('listing/' . $result->id . '/' . $step) }}" accept-charset='UTF-8'>
							{{ csrf_field() }}
							<div class="col-md-12 border mt-4 pb-5 rounded-3 pl-4 pl-sm-0 pr-4 pr-sm-0 ">
								<div class="form-group col-md-12 main-panelbg pb-3 pt-3 mt-4 mt-sm-0 ">
									<h4 class="text-18 font-weight-700 pl-3">{{ __('Location') }}</h4>
								</div>

								<input type="hidden" name='latitude' id='latitude'>
								<input type="hidden" name='longitude' id='longitude'>
								<div class="row mt-4">
									<div class="col-md-12 pl-5 pr-5">
										<label>{{ __('Country') }} <span class="text-danger">*</span></label>
										<select id="basics-select-bed_type" name="country" class="form-control text-16 mt-2" id='country'>
											@foreach ($country as $key => $value)
												<option value="{{ $key }}" {{ ($key == $result->property_address->country) ? 'selected' : '' }}>{{ $value }}</option>
											@endforeach
										</select>
										<span class="text-danger">{{ $errors->first('country') }}</span>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-md-12 pl-5 pr-5">
										<label>{{ __('Address Line 1') }} <span class="text-danger">*</span></label>
										<input type="text" name="address_line_1" id="address_line_1" value="{{ $result->property_address->address_line_1  }}" class="form-control text-16 mt-2" placeholder="House name/number + street/road">
										<span class="text-danger">{{ $errors->first('address_line_1') }}</span>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-md-12 pl-5 pr-5">
										<div id="map_view" class="map-view-location"></div>
									</div>
									<div class="col-md-12 mt-4 pl-5 pr-5">
										<p>{{ __('You can move the pointer to set the correct map position') }}</p>
										<span class="text-danger">{{ $errors->first('latitude') }}</span>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-md-6 mt-4 pl-5 pr-5">
										<label>{{ __('Address Line 2') }}</label>
										<input type="text" name="address_line_2" id="address_line_2" value="{{ $result->property_address->address_line_2  }}" class="form-control text-16 mt-2" placeholder="Apt., suite, building access code">
									</div>
									<div class="col-md-6 mt-4 pl-5 pr-5">
										<label>{{ __('City / Town / District') }}  <span class="text-danger">*</span></label>
										<input type="text" name="city" id="city" value="{{ $result->property_address->city  }} " class="form-control text-16 mt-2">
										<span class="text-danger">{{ $errors->first('city') }}</span>
									</div>

									<div class="col-md-6 mt-4 pl-5 pr-5">
										<label>{{ __('State / Province / County / Region') }} <span class="text-danger">*</span></label>
										<input type="text" name="state" id="state" value="{{ $result->property_address->state  }}" class="form-control text-16 mt-2">
										<span class="text-danger">{{ $errors->first('state') }}</span>
									</div>

									<div class="col-md-6 mt-4 pl-5 pr-5">
										<label>{{ __('ZIP / Postal Code') }}</label>
										<input type="text" name="postal_code" id="postal_code" value="{{ $result->property_address->postal_code }}" class="form-control text-16 mt-2">
										<span class="text-danger">{{ $errors->first('postal_code') }}</span>
									</div>
								</div>
							</div>

							<div class="col-md-12 p-0 mt-4 mb-5">
								<div class="row justify-content-between">
									<div class="mt-4">
										<a href="{{ url('listing/' . $result->id . '/description') }}" class="btn btn-outline-danger secondary-text-color-hover text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3">
											{{ __('Back') }}
										</a>
									</div>

									<div class="mt-4">
										<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5" id="btn_next"><i class="spinner fa fa-spinner fa-spin d-none" ></i>
											<span id="btn_next-text">{{ __('Next') }}</span>
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('validation_script')
	<script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ config("vrent.google_map_key") }}&libraries=places'></script>
	<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/locationpicker.jquery.min.js') }}"></script>

	<script type="text/javascript">
		'use strict'
		let nextText = "{{ __('Next') }}..";
		let fieldRequiredText = "{{ __('This field is required.') }}";
		let maxlengthText = "{{ __('Please enter no more than 255 characters.') }}";
		let latitude = "{{ $result->property_address->latitude != '' ? $result->property_address->latitude:0 }}";
		let longitude = "{{ $result->property_address->longitude != '' ? $result->property_address->longitude:0 }}";
		let page = 'location';
	</script>
	<script type="text/javascript" src="{{ asset('public/js/listings.min.js') }}"></script>

@endsection

