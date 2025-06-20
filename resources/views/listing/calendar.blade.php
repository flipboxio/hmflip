@extends('template')
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery-ui.min.css') }}" />
@section('main')
<!-- Modal -->
<!-- Button trigger modal -->
<div class="modal fade" id="hotel_date_package" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header p-4">
				<h5 class="modal-title text-16 font-weight-700" id="exampleModalLabel">{{ __('Set price for particular dates') }}</h5>
				<button type="button" class="close text-28 mt-m-15" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body pl-5 pr-5">
				<form method="post" action="hotel_date_package/" class='form-horizontal' id='dtpc_form'>
					{{ csrf_field() }}
					<p class="bg-success text-white text-center text-16 d-none" id="model-message"></p>
					<input type="hidden" value="{{ $result->id }}" name="property_id" id="dtpc_property_id">

					<div class="form-group">
						<div class="col-md-12 p-0">
							<label for="input_dob">{{ __('Start Date') }}<em class="text-danger">*</em></label>
							<input type="text" class="form-control text-14" name="start_date" id='dtpc_start' placeholder = "{{ __('Start Date') }}" autocomplete = 'off'>
							<span class="text-danger" id="error-dtpc-start_date">{{ $errors->first('start_date') }}</span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12 p-0">
							<label for="input_dob" >{{ __('End Date') }} <em class="text-danger">*</em></label>
							<input type="text" class="form-control text-14" name="end_date" id='dtpc_end' placeholder = "{{ __('End Date') }}" autocomplete = 'off'>
							<span class="text-danger" id="error-dtpc-end_date">{{ $errors->first('end_date') }}</span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12 p-0">
							<label for="input_dob">{{ __('Price') }} <em class="text-danger">*</em></label>
							<input type="text" class="form-control text-14" name="price" id='dtpc_price' placeholder = "">
							<span class="text-danger" id="error-dtpc-price">{{ $errors->first('price') }}</span>
						</div>
					</div>

					<div class="form-group">
                        <div class="col-md-12 p-0">
                          <label for="input_dob">{{ __('Minimum Stay') }}</label>
                          <input type="text" class="form-control text-14" name="minstay" id='dtpc_stay' placeholder = "Day..">
                          <span class="text-danger" id="error-dtpc-stay">{{ $errors->first('minstay') }}</span>
                        </div>
                      </div>

					<div class="form-group">
						<div class="col-md-12 p-0">
							<label for="input_dob">{{ __('Status') }}<em class="text-danger">*</em></label>
							<select class="form-control text-14" name="status" id="dtpc_status">
								<option value="" >--{{ __('Please Select') }}--</option>
								<option value="Available">{{ __('Available') }}</option>
								<option value="Not available">{{ __('Not Available') }}</option>
							</select>
							<span class="text-danger" id="error-dtpc-status">{{ $errors->first('status') }}</span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12 p-0 text-right">
							<button type="button" class="btn btn-outline-danger text-14 mt-4 pl-4 pr-4 mr-2" data-dismiss="modal">{{ __('Close') }}</button>

							<button id="price_btn" class="btn vbtn-outline-success text-14 mt-4 pl-4 pr-4 ml-2" type="submit" name="submit">
								<i id="price_spinner" class="spinner fa fa-spinner fa-spin d-none" ></i>
								<span id="price_next-text"></span>
							</button>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modal End -->
<!-- Import Calendar Modal Start -->
<!-- Modal -->
<div class="modal fade" id="import_calendar_package" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header p-4">
				<h5 class="modal-title font-weight-700 text-16">{{ __('Import a New Calendar') }}</h5>
				<button type="button" class="close mt-m-15" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-28">&times;</span>
				</button>
			</div>

			<div class="modal-body pl-5 pr-5">
				<form id='icalendar_form'>

					<p class="bg-success text-white text-center text-16 d-none" id="icalendar-model-message"></p>
					<input type="hidden" value="{{ $result->id }}" name="property_id" id="icalendar_property_id">

					<div class="form-group">
						<label for="icalendar_url" class="col-form-label">{{ __('Calendar Address (URL)') }} <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="url" id='icalendar_url' placeholder="{{ __('Paste calendar address (URL) here') }}" autocomplete = 'off'>
						<span class="text-danger" id="error-icalendar-url">{{ $errors->first('url') }}</span>
					</div>

					<div class="form-group">
						<label for="name" class="col-form-label">{{ __('Name Your Calendar') }} <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="name" id='icalendar_name' placeholder = "{{ __('Your Calendar Name') }}" autocomplete = 'off'>
						<span class="text-danger" id="error-icalendar-name">{{ $errors->first('name') }}</span>
					</div>

					<div class="form-group">
						<label for="name" class="col-form-label">{{ __('Colour of your calendar') }}<em class="text-danger">*</em></label>
						<select class="form-control" name="color" id="color">
						<option value="">--{{ __('Please Select') }}--</option>
						<option value="#7FFFD4" style="background-color: Aquamarine;">Aquamarine</option>
						<option value="#0000FF" style="background-color: Blue;">Blue</option>
						<option value="#000080" style="background-color: Navy;color: #FFFFFF;">Navy</option>
						<option value="#800080" style="background-color: Purple;color: #FFFFFF;">Purple</option>
						<option value="#FF1493" style="background-color: DeepPink;">DeepPink</option>
						<option value="#EE82EE" style="background-color: Violet;">Violet</option>
						<option value="#FFC0CB" style="background-color: Pink;">Pink</option>
						<option value="#006400" style="background-color: DarkGreen;color: #FFFFFF;">DarkGreen</option>
						<option value="#008000" style="background-color: Green;color: #FFFFFF;">Green</option>
						<option value="#9ACD32" style="background-color: YellowGreen;">YellowGreen</option>
						<option value="#FFFF00" style="background-color: Yellow;">Yellow</option>
						<option value="#FFA500" style="background-color: Orange;">Orange</option>
						<option value="#FF0000" style="background-color: Red;">Red</option>
						<option value="#A52A2A" style="background-color: Brown;">Brown</option>
						<option value="#DEB887" style="background-color: BurlyWood;">BurlyWood</option>
						<option value="custom">{{ __('Custom') }}</option>
						</select>
						<span class="text-danger" id="error-dtpc-color">{{ $errors->first('color') }}</span>
					</div>

					<div class="form-group">
						<div class="col-md-12 p-0 text-right mt-5">

							<button type="button" class="btn btn-outline-danger text-16 cls-reload pl-4 pr-4 ml-2" data-dismiss="modal">{{ __('Close') }}</button>

							<button class="btn vbtn-outline-success pull-right text-16 pl-4 pr-4 mr-2" type="submit" id="import_btn" name="Import"> <i class="spinner fa fa-spinner fa-spin d-none" id="import_spinner" ></i>
								<span id="import_btn-text">{{ __('Import Calendar') }}</span>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Import Calendar Modal End -->

<!-- Export Icalendar Modal Starts -->

<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="calendar_export_package" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header p-4">
				<h5 class="modal-title font-weight-700 text-16">{{ __('Export Calendar') }}</h5>
				<button type="button" class="close mt-m-15 p-0" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-28">&times;</span>
				</button>
			</div>

			<div class="modal-body pl-5 pr-5">
				<div class="form-group">
					<p><span>{{ __('Copy and paste the link into other ICAL applications.') }}</span></p>

				</div>

				<div class="input-group mb-3">
					<input type="text" class="form-control" aria-describedby="basic-addon2" value="{{ url('icalender/export/' . $result->id . '.ics') }}" readonly="" id="myInput">
					<div class="input-group-append">
						<button class="btn vbtn-outline-success text-14 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5" onclick="myFunction()" id="copied">Copy</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Export Icalendar Modal End -->

<div class="margin-top-85">
	<div class="row m-0">
		<!-- sidebar start-->
		@include('users.sidebar')
		<!--sidebar end-->
		<div class="col-md-10">
			@if (Session::has('message'))
				<div class="alert {{ Session::get('alert-class') }}  alert-dismissible fade show text-center" role="alert">
					{{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

			@endif
			<div class="main-panel min-height mt-4">
				<div class="row justify-content-center">
					<div class="col-md-3 pl-4 pr-4">
						@include('listing.sidebar')
					</div>

					<div class="col-md-9 mt-sm-0 pl-4 pr-4">
						<div class="row border rounded p-4 mt-4">
							<div class="col-md-12 p-0">
								<div class="row">
									<form method='post' action="property-save/{{ $result->id }}/pricing">
										<input type="hidden" id="dtpc_property_id1" value="{{ $result->id }}">
										<div class="col-md-12 p-0" >
											<div id="calender-dv">
												{!! $calendar !!}
											</div>
										</div>
									</form>
								</div>

								<div class="row justify-content-start mb-4">
									<ul class="list-inline ml-4">
										<li class="list-inline-item mt-4">
											<a class="js-calendar-sync text-white text-16 btn secondary-bg " data-prevent-default="true" href="{{ url('icalendar/synchronization/' . $result->id) }}" id="cal_sync"><i class="spinner fa fa-spinner fa-spin d-none" id="cal_sync_spinner"></i> {{ __('Sync with other calendars') }}</a>
										</li>

										<li class="list-inline-item mt-4">
											<button class="text-white text-16 btn secondary-bg imporpt_calendar">{{ __('Import Calendar') }}</button>
										</li>

										<li class="list-inline-item mt-4">
											<button class="text-white text-16 btn secondary-bg" id="export_icalendar">{{ __('Export Calendar') }}</button>
										</li>
									</ul>
								</div>
							</div>
						</div>



						<div class="row justify-content-between mt-4 mb-5">
							<div class="mt-4">
								<a  data-prevent-default="" href="{{ url('listing/' . $result->id . '/booking') }}" class="btn btn-outline-danger secondary-text-color-hover text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3">
									{{ __('Back') }}
								</a>
							</div>

							<div class="mt-4">
								<a  data-prevent-default="" href="{{ url('properties/' . $result->slug) }}" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3" id="btn_next">
									<i class="spinner fa fa-spinner fa-spin d-none" id="btn_next_spinner"></i>
									<span id="btn_next-text">{{ __('Next') }}</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('validation_script')
<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/js/jquery-ui.js') }}"></script>

<script type="text/javascript">
	'use strict'
	let submit = "{{ __('Submit') }}";
	let nextText = "{{ __('Next') }}..";
	let fieldRequiredText = "{{ __('This field is required.') }}";
	let importCalendarText = "{{ __('Import Calendar') }} ..";
	let minLengthText = "{{ __('Please enter at least 6 characters.') }}";
	let page = 'calendar';
	let frontDateFormatType = "{{ Session::get('front_date_format_type') ?? settings('date_format_type') }}";
	let startDateError = "{{ __('Start date not greater than end date.') }}";
	let endDateError = "{{ __('End date not less than start date.') }}";
	let startDateBlankError = "{{ __('Start date not given.') }}";
	let endDateBlankError = "{{ __('End date not given.') }}";
	let priceBlankError = "{{ __('Price not given.') }}";
	let statusBlankError = "{{ __('Status not selected.') }}";
	let errorOccuredMessage = "{{ __('An error occurred') }}";
	let submittingText = "{{ __('Submitting...') }}";
</script>

<script src="{{ asset('public/js/front.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/listings.min.js') }}"></script>



@endsection



