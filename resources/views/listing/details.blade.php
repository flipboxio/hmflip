@extends('template')

@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		<!-- sidebar start-->
		@include('users.sidebar')
		<!--sidebar end-->
		<div class="col-md-10">
			<div class="main-panel mt-4 min-height">
				<div class="row">
					<div class="col-md-3 mt-4 mt-sm-0 pl-4 pr-4">
						@include('listing.sidebar')
					</div>

					<div class="col-md-9 mt-4 mt-sm-0 pl-4 pr-4">
						<form method="post" action="{{ url('listing/' . $result->id . '/' . $step) }}" class='signup-form login-form' accept-charset='UTF-8' id="listing_det">
							{{ csrf_field() }}
							<div class="col-md-12 pb-4 p-0 border rounded-3 mt-4">
								<div class="form-group col-md-12 main-panelbg pb-3 pt-3">
									<h4 class="text-18 font-weight-700 pl-3 text-capitalize">{{ __('details') }}</h4>
								</div>
								<div class="row mt-4">
									<div class="col-md-12 pl-5 pr-5">
										<label class="label-large">{{ __('About Place') }}</label>
										<textarea class="form-control mt-2" name="about_place" rows="4" placeholder="">{{ $result->property_description->about_place }}</textarea>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-md-12 pl-5 pr-5">
										<label class="label-large">{{ __('Place is great for') }}</label>
										<textarea class="form-control mt-2" name="place_is_great_for" rows="4" placeholder="">{{ $result->property_description->place_is_great_for }}</textarea>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-md-12 pl-5 pr-5">
										<label class="label-large">{{ __('Guest Access') }}</label>
										<textarea class="form-control mt-2" name="guest_can_access" rows="4" placeholder="">{{ $result->property_description->guest_can_access }}</textarea>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-md-12 pl-5 pr-5">
										<label class="label-large">{{ __('Interaction with Guests') }}</label>
										<textarea class="form-control mt-2" name="interaction_guests" rows="4" placeholder="">{{ $result->property_description->interaction_guests }}</textarea>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-md-12 pl-5 pr-5">
										<label class="label-large">{{ __('Other Things to Note') }}</label>
										<textarea class="form-control mt-2" name="other" rows="4" placeholder="">{{ $result->property_description->other }}</textarea>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-md-12 pl-5 pr-5">
										<label class="label-large">{{ __('Overview') }}</label>
										<textarea class="form-control mt-2" name="about_neighborhood" rows="4" placeholder="">{{ $result->property_description->about_neighborhood }}</textarea>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-md-12 pl-5 pr-5">
										<label class="label-large">{{ __('Getting Around') }}</label>
										<textarea class="form-control mt-2" name="get_around" rows="4" placeholder="">{{ $result->property_description->get_around }}</textarea>
									</div>
								</div>
							</div>

							<div class="col-md-12 p-0 mt-4 mb-5">
								<div class="row m-0 justify-content-between">
									<div class="mt-4">
										<a  href="{{ url('listing/' . $result->id . '/description') }}" class="btn btn-outline-danger secondary-text-color-hover text-16 font-weight-700  pt-3 pb-3 pl-5 pr-5">
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
	<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>

	<script type="text/javascript">
		'use strict'
		let nextText = "{{ __('Next') }}..";
		let page = 'details';
	</script>

	<script type="text/javascript" src="{{ asset('public/js/listings.min.js') }}"></script>

@endsection


