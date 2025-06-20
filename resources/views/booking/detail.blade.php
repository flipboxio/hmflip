@extends('template')
@section('main')
<div class="container-fluid container-fluid-90 margin-top-85 min-height">
	<div class="row mb-4">
		<div class="col-md-8 card p-5">
			<h2 class="font-weight-700">{{ __('Requested Booking') }}</h2>
			<div class="d-flex justify-content-between">
				<div>
					@if ($result->status == 'Pending')
						<div class="pull-right mt-4">
							<span class="label label-info">
								<i class="far fa-clock"></i>
								{{ __('Expires in') }}
								<span class="countdown_timer hasCountdown"><span class="countdown_row countdown_amount" id="countdown_1"></span></span>
							</span>
						</div>
					@endif
				</div>

				<div>

				</div>
			</div>

			<div class="row flex-column-reverse flex-md-row mt-4 m-0">
				<div class="col-md-9 p-0">
					<p class="text-justify">{{ __(':x has requested to book your property.', ['x' => getColumnValue($result->users)]) }} {{ __('Please accept or decline this request.') }}</p>
					@if ($result->host_id == Auth::id())
				@if ($result->status == 'Pending')
				<div>
					<p><i class="fas fa-exclamation-triangle  text-warning"></i> {{ __('You will be penalized if you do not accept or decline this request before it expires.') }}</p>
				</div>

				<div class="mt-5 text-center text-sm-left">
					<button class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5 mt-4" id="accept-modal-trigger">
					{{ __('Accept') }}
					</button>
					<button class="btn btn-outline-danger text-16 font-weight-700  pl-5 pr-5 pt-3 pb-3 pl-5 pr-5 mt-4 ml-0 ml-sm-4" id="decline-modal-trigger">
					{{ __('Decline') }}
					</button>
				</div>

				@else
					<h3 class="mt-4 font-weight-700">Booking status</h3>
					<p class="text-16 font-weight-700 secondary-text-color">{{ $result->status }}</p>
				@endif
			@endif
				</div>

				<div class="col-md-3">
					<div class="media-photo-badge text-center">
						<a href="{{ url('users/show/' . $result->users->id) }}" ><img alt="{{ $result->users->first_name }}" class="" src="{{ $result->users->profile_src }}" title="{{ $result->users->first_name }}"></a>
					</div>
					<p class="font-weight-700 mb-0 text-center"><a href="{{ url('users/show/' . $result->users->id) }} }}" class="verification_user_name">{{ $result->users->first_name }}</a></p>
					<p class="text-14 text-muted text-center">{{ __('Member since') }} {{ $result->users->account_since }}</p>
				</div>
			</div>
		</div>

        <div class="col-md-4">
            <div class="card mt-3 mb-5 p-3">
                <a href="{{ url('properties/' . $result->properties->slug) }}">
                    <img class="card-img-top p-2 rounded" src="{{ $result->properties->cover_photo }}" alt="{{ $result->properties->name }}" height="180px">
                </a>

                <div class="card-body p-4">
                    <a href="{{ url('properties/' . $result->properties->slug) }}">
                        <p class="text-16 font-weight-700 mb-0">{{ $result->properties->name }}</p>
                    </a>

                    <p class="text-14 mt-2 text-muted mb-0">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $result->properties->property_address->address_line_1 }}, {{ $result->properties->property_address->state }}, {{ $result->properties->property_address->country_name }}
                    </p>
                    <div class="border p-4 mt-3 text-center rounded-3">
                        <p class="text-16 mb-0">
                            <strong class="font-weight-700 secondary-text-color">{{ $result->properties->property_type_name }}</strong>
                            {{ __('for') }}
                            <strong class="font-weight-700 secondary-text-color">{{ $result->guest }} {{ __('Guest') }}</strong>
                        </p>
                        <div class="text-16"><strong>{{ date(setDateForFront(), strtotime($result->startdate_dmy)) }}</strong> to <strong>{{ date(setDateForFront(), strtotime($result->enddate_dmy)) }}</strong></div>
                    </div>

                    <div class="border p-2 mt-3 rounded-3">
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ __('Nights') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{{ $result->total_night }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ __('Guests') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{{ $result->guest}}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ __('Rate (per night)') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->per_night_price_with_symbol !!}</p>
                            </div>
                        </div>

                        @if ($price_list->date_with_price)
                            @foreach ($price_list->date_with_price as $datePrice )
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{ $datePrice->date }}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $datePrice->price!!}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if ($result->cleaning_charge != 0)
                            <div class="d-flex justify-content-between text-16">
                                <div>
                                    <p class="pl-4">{{ __('Cleaning Fee') }}</p>
                                </div>

                                <div>
                                    <p class="pr-4">{!! $price_list->cleaning_fee_with_symbol !!}</p>
                                </div>
                            </div>
                        @endif

                        @if ($result->guest_charge != 0)
                            <div class="d-flex justify-content-between text-16">
                                <div>
                                    <p class="pl-4">{{ __('Additional Guest Fee') }}</p>
                                </div>

                                <div>
                                    <p class="pr-4">{!! $price_list->additional_guest_fee_with_symbol !!}</p>
                                </div>
                            </div>
                        @endif

                        @if ($result->security_money != 0)
                            <div class="d-flex justify-content-between text-16">
                                <div>
                                    <p class="pl-4">{{ __('Security Fee') }}</p>
                                </div>

                                <div>
                                    <p class="pr-4">{!! $price_list->security_fee_with_symbol !!}</p>
                                </div>
                            </div>
                        @endif

                        @if ($result->service_charge != 0)
                            <div class="d-flex justify-content-between text-16">
                                <div>
                                    <p class="pl-4">{{ __('Service fee') }}</p>
                                </div>

                                <div>
                                    <p class="pr-4">{!! $price_list->service_fee_with_symbol !!}</p>
                                </div>
                            </div>
                        @endif


                        @if ($result->iva_tax != 0)
                            <div class="d-flex justify-content-between text-16">
                                <div>
                                    <p class="pl-4">{{ __('I.V.A Tax') }}</p>
                                </div>

                                <div>
                                    <p class="pr-4">{!! $price_list->iva_tax_with_symbol !!}</p>
                                </div>
                            </div>
                        @endif

                        @if ($result->accomodation_tax != 0)
                            <div class="d-flex justify-content-between text-16">
                                <div>
                                    <p class="pl-4">{{ __('Accommodation Tax') }}</p>
                                </div>

                                <div>
                                    <p class="pr-4">{!! $price_list->accomodation_tax_with_symbol !!}</p>
                                </div>
                            </div>
                        @endif


                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ __('Subtotal') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->total_with_symbol !!}</p>
                            </div>
                        </div>

                        @if ($result->host_fee)
                            <div class="d-flex justify-content-between text-16">
                                <div>
                                    <p class="pl-4">{{ __('Host Fee') }}</p>
                                    <i class="icon icon-question icon-question-sign" data-behavior="tooltip" rel="tooltip" aria-label="Vrent charges a fee to cover the cost (banking fees) of processing payment from the traveler."></i>

                                </div>

                                <div>
                                    <p class="pr-4">{!! $result->currency->symbol !!}{{ $result->host_fee }}</p>
                                </div>
                            </div>
                        @endif

                        <hr>
                        <div class="d-flex justify-content-between text-16 font-weight-700"  id="total">
                            <div>
                                <p class="pl-4">{{ __('Total Payout') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->total_with_symbol !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

<div class="modal fade mt-5 modal-z-index" id="accept-modal" tabindex="-1" role="dialog" aria-labelledby="accept-modal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="w-100 pt-3">
						<h4 class="modal-title text-20 text-center font-weight-700">{{ __('Accept this request') }}</h4>
					</div>

					<div>
						<button type="button" class="close text-28 mr-2 filter-cancel font-weight-500" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>

				<div class="modal-body p-4">
					<form accept-charset="UTF-8" action="{{ url('booking/accept/' . $booking_id) }}" id="accept_reservation_form" method="post" name="accept_reservation_form">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-12">
								<label for="cancel_message" class="row-space-top-2">
									{{ __('Write optional message to guest') }}
								</label>
								<textarea class="form-control" id="accept_message" name="message" rows="4"></textarea>
							</div>

							<div class="col-md-12">
								<div class="row mt-4">
									<div class="col-sm-1 p-0">
										<input id="tos_confirm" name="tos_confirm" type="checkbox" value="1">
									</div>

									<div class="col-sm-11 p-0 text-16 text-justify">
										<label class="label-inline" for="tos_confirm">{{ __('By checking this box, I agree to the') }} <br><a href="{{ url('host_guarantee') }}" target="_blank" class="font-weight-700">{{ __('Host Guarantee Terms and Conditions') }}</a> <br><a href="{{ url('guest_refund') }}" target="_blank" class="font-weight-700">{{ __('Guest Refund Policy Terms') }}</a>, {{ __('and') }} <a href="{{ url('terms_of_service') }}" target="_blank" class="font-weight-700">{{ __('Terms of Service') }}</a>.</label>
									</div>
								</div>
							</div>

							<div class="col-md-12 text-right mt-4">
								<input type="hidden" name="decision" value="accept">

								<button type="button" class="btn btn-outline-danger text-16 font-weight-700 pl-5 pr-5 pt-2 pb-2 pl-5 pr-5 mt-4 ml-2" data-dismiss="modal">{{ __('Close')  }}</button>

								<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-2 pb-2 pl-5 pr-5 mt-4 mr-2" id="accept_submit" name="commit"> <i class="spinner fa fa-spinner fa-spin d-none" id="accept_spinner" ></i>
								<span id="accept_btn-text">{{ __('Accept') }}</span>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
	</div>
</div>

<div class="modal fade mt-5 modal-z-index" id="decline-modal" tabindex="-1" role="dialog" aria-labelledby="decline-modal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content ">
			<div class="modal-header">
				<div class="w-100 pt-3">
					<h4 class="modal-title text-20 text-center font-weight-700">{{ __('Cancel this Booking') }}</h4>
				</div>

				<div>
					<button type="button" class="close text-28 mr-2 filter-cancel font-weight-500" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>

			<form accept-charset="UTF-8" action="{{ url('booking/decline/' . $booking_id) }}" id="decline_reservation_form" method="post" name="decline_reservation_form">
				{{ csrf_field() }}
				<div class="modal-body p-4">
					<div class="row">
						<div class="col-md-12">
							<div id="decline_reason_container">
								<p class="tesxt-14">
									{{ __('Help us improve your experience.') }}{{ __('Please write down the main reason for Cancelling this Booking') }}
								</p>
								<p>
								<strong>
									{{ __('Your response will not be shared with the host') }}
								</strong>
								</p>
								<div class="select">
									<select class="form-control" id="decline_reason" name="decline_reason">
										<option value=" ">{{ __('Why are you declining?') }}</option>
										<option value="dates_not_available">{{ __('Dates are not available') }}</option>
										<option value="not_comfortable">{{ __('I do not feel comfortable with this guest') }}</option>
										<option value="not_a_good_fit">{{ __('My listing is not a good fit for the guest’s needs (children, pets, etc.)') }}</option>
										<option value="waiting_for_better_reservation">{{ __('I am waiting for a more attractive booking') }}</option>
										<option value="different_dates_than_selected">{{ __('The guest is asking for different dates than the ones selected in this request') }}</option>
										<option value="spam">{{ __('This message is spam') }}</option>
										<option value="other">{{ __('other') }}</option>
									</select>
									<span class="errorMessage text-danger"></span>
								</div>

								<div id="cancel_reason_other_div d-none" class="mt-4">
								<label for="cancel_reason_other" class="mb-3">
									{{ __('Why are you declining?') }}
								</label>
								<textarea class="form-control" id="decline_reason_other" name="decline_reason_other" rows="4"></textarea>
								<span class="decline_reason_other text-danger"></span>
								</div>
							</div>
						</div>

						<div class="col-md-12 mt-4">
							<input type="checkbox" checked="checked" name="block_calendar" value="yes">
							{{ __('Block my calendar from') }}  <b>{{ $result->startdate_md }}</b> {{ __('through') }} <b>{{ $result->enddate_md }}</b>
						</div>

						<div class="col-md-12">
							<label for="cancel_message" class="mt-3 mb-3">
								{{ __('Write optional message to guest') }}
							</label>
							<textarea class="form-control" id="decline_message" name="message" rows="4"></textarea>
						</div>

						<div class="col-md-12 mt-5 text-right">
							<input type="hidden" name="decision" value="decline">

							<button type="button" class="btn btn-outline-danger text-16 font-weight-700 pl-5 pr-5 pt-2 pb-2 pl-5 pr-5 ml-2" data-dismiss="modal">{{ __('Close') }}</button>

							<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-2 pb-2 pl-5 pr-5 mr-2" id="decline_submit" name="commit"> <i class="spinner fa fa-spinner fa-spin d-none" id="decline_spinner" ></i>
							<span id="decline_btn-text">{{ __('Decline') }}</span>
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<input type="hidden" id="expired_at" value="{{ $result->expiration_time }}">
<input type="hidden" id="booking_id" value="{{ $booking_id }}">
@stop

@section('validation_script')
<script type="text/javascript">
	'use strict'
	let fieldRequired = "{{ __('This field is required.') }}";
	let acceptTermText = "{{ __('Please accept the term and conditions!') }}";
	let accept = "{{ __('Accept') }}..";
	let decline = "{{ __('Decline') }} ..";
	var expireTime = "{{ $result->expiration_time }}";
</script>
<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/user-booking-detail.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/front.min.js') }}"></script>

@endsection


