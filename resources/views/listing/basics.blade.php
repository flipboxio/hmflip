@extends('template')
@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		<!-- sidebar start-->
		@include('users.sidebar')
		<!--sidebar end-->
		<div class="col-md-10">
			<div class="main-panel min-height mt-4">
				<div class="row">
					<div class="col-md-3 pl-4 pr-4">
						@include('listing.sidebar')
					</div>

					<div class="col-md-9  mt-4 mt-sm-0 pl-4 pr-4">
						<form method="post" action="{{ url('listing/' . $result->id . '/' . $step) }}"  accept-charset='UTF-8' id="listing_bes">
							{{ csrf_field() }}
							<div class="form-row mt-4 border rounded pb-4">
								<div class="form-group col-md-12 main-panelbg pb-3 pt-3">
									<h4 class="text-18 font-weight-700 pl-3">{{ __('Rooms and Beds') }}</h4>
								</div>

								<div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Bedrooms') }}</label>
									<select name="bedrooms" id="basics-select-bedrooms"  class="form-control text-16 mt-2">
										@for ($i=1;$i<=10;$i++)
											<option value="{{ $i }}" {{ ($i == $result->bedrooms) ? 'selected' : '' }}>
												{{ $i }}
											</option>
										@endfor
									</select>
								</div>

								<div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Beds') }}</label>
									<select name="beds" id="basics-select-beds"  class="form-control text-16 mt-2">
										@for ($i=1;$i<=16;$i++)
											<option value="{{ $i }}" {{ ($i == $result->beds) ? 'selected' : '' }}>
												{{ ($i == '16') ? $i . '+' : $i }}
											</option>
										@endfor
									</select>
								</div>

								<div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Bathrooms') }}</label>
									<select name="bathrooms" id="basics-select-bathrooms"  class="form-control text-16 mt-2">
										@for ($i=1;$i<=8;$i+=1)
											<option class="bathrooms" value="{{ $i }}" {{ ($i == $result->bathrooms) ? 'selected' : '' }}>
												{{ ($i == '8') ? $i . '+' : $i }}
											</option>
										@endfor
									</select>
								</div>

								<div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Bed Type') }}</label>
									<select  name="bed_type"  class="form-control text-16 mt-2">
										@foreach ($bed_type as $key => $value)
											<option value="{{ $key }}" {{ ($key == $result->bed_type) ? 'selected' : '' }}>{{ $value }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-row mt-4 border rounded pb-4">
								<div class="form-group col-md-12 main-panelbg pb-3 pt-3">
									<h4 class="text-18 font-weight-700 pl-3">{{ __('Listings') }}</h4>
								</div>

								<div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Property Type') }}</label>
									<select name="property_type"  class="form-control text-16 mt-2">
										@foreach ($property_type as $key => $value)
											<option value="{{ $key }}" {{ ($key == $result->property_type) ? 'selected' : '' }}>{{ $value }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Room Type') }}</label>
									<select name="space_type" class="form-control text-16 mt-2">
										@foreach ($space_type as $key => $value)
											<option value="{{ $key }}" {{ ($key == $result->space_type) ? 'selected' : '' }}>{{ $value }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Accommodates') }}</label>
									<select name="accommodates" id="basics-select-accommodates" class="form-control text-16 mt-2">
										@for ($i=1;$i<=16;$i++)
											<option class="accommodates" value="{{ $i }}" {{ ($i == $result->accommodates) ? 'selected' : '' }}>
												{{ ($i == '16') ? $i . '+' : $i }}
											</option>
										@endfor
									</select>
								</div>
							</div>

							<div class="form-row float-right mt-5 mb-5">
								<div class="col-md-12 pr-0">
									<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-4 pr-4 pt-3 pb-3" id="btn_next"><i class="spinner fa fa-spinner fa-spin d-none" ></i>
										<span id="btn_next-text">{{ __('Next') }}</span>
									</button>
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
<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

	'use strict'
	let nextText = "{{ __('Next') }}.."; 
	let page = 'basics';

</script>
<script type="text/javascript" src="{{ asset('public/js/listings.min.js') }}"></script>

@endsection

