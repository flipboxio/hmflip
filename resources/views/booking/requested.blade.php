@extends('template')

@section('main')
<div class="container-fluid container-fluid-90 margin-top-85 min-height">
    <div class="flash-message">
        @if (Session::has('message'))
            <div class="row mt-5">
                <div class="col-md-12  alert {{ Session::get('alert-class') }} alert-dismissable fade in top-message-text opacity-1">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ Session::get('message') }}
                </div>
            </div>
        @endif
    </div>

	<div class="row">
		<div class="col-md-8 mb-5 mt-3 main-panel p-5 border rounded">
			<div class="col-lg-12 p-0">
				@if ($booking_details->status == 'Pending')
                    @if ($booking_details->payment_method_id == 4)
                        <h2>{{ __('Get ready for') }} {{  optional($booking_details->properties)->property_address->city }}!</h2>
                        <p>{{ __('Your booking is in processing. Please wait until the admin confirm your payment and accept the booking.') }}</p>
                    @else
                        <h2 class="font-weight-700">{{ __('Your request has been sent.') }}</h2>
                        <p>{{ __('It is not a confirmed booking.') }} {{ __('You’ll hear back.') }} {{ __('You won’t be charged if') }} {{ optional($booking_details->properties)->users->first_name }} {{ __('can’t accommodate your stay') }}.</p>
                    @endif
                @endif

				@if ($booking_details->status == 'Accepted')
					<h2>{{ __('Get ready for') }} {{  optional($booking_details->properties)->property_address->city }}!</h2>
					<p>{{ __('You have a confirmed booking with') }} {{ optional($booking_details->properties)->users->first_name }}. {{ __('We’ve emailed your itinerary to') }} {{ optional($booking_details->properties)->users->email }}.</p>
				@endif

                @if ($booking_details->status == 'Processing')
					<h2 class="font-weight-700">{{ __('Your request has been sent.') }}</h2>
					<p>{{ __('Your booking is in processing. Please wait until the admin confirm your payment and accept the booking.') }}.</p>
				@endif

			</div>


		</div>

		<div class="col-md-4">
			<div class="card mt-3 mb-5 p-3">
				<a href="{{ url('properties/' . optional($booking_details->properties)->slug) }}">
					<img class="card-img-top p-2 rounded" src="{{ optional($booking_details->properties)->cover_photo }}" alt="{{ optional($booking_details->properties)->name }}" height="180px">
				</a>

				<div class="card-body p-4">
					<a href="{{ url('properties/' . optional($booking_details->properties)->slug) }}">
						<p class="text-16 font-weight-700 mb-0">{{  optional($booking_details->properties)->name }}</p>
					</a>

					<p class="text-14 mt-2 text-muted mb-0">
						<i class="fas fa-map-marker-alt"></i>
						{{ optional($booking_details->properties)->property_address->address_line_1 }}, {{  optional($booking_details->properties)->property_address->state }}, {{  optional($booking_details->properties)->property_address->country_name }}
					</p>
					<div class="border p-4 mt-3 text-center rounded-3">
						<p class="text-16 mb-0">
							<strong class="font-weight-700 secondary-text-color">{{  optional($booking_details->properties)->property_type_name }}</strong>
							{{ __('for') }}
							<strong class="font-weight-700 secondary-text-color">{{ $booking_details->guest }} {{ __('Guest') }}</strong>
						</p>
						<div class="text-16"><strong>{{ date(setDateForFront(), strtotime($booking_details->startdate_dmy)) }}</strong> to <strong>{{ date(setDateForFront(), strtotime($booking_details->enddate_dmy)) }}</strong></div>
					</div>

					<div class="border p-2 mt-3 rounded-3">
						<div class="d-flex justify-content-between text-16">
							<div>
								<p class="pl-4">{{ __('Nights') }}</p>
							</div>

							<div>
								<p class="pr-4">{{ $booking_details->total_night }}</p>
							</div>
						</div>

						<div class="d-flex justify-content-between text-16">
							<div>
								<p class="pl-4">{{ __('Guests') }}</p>
							</div>

							<div>
								<p class="pr-4">{{ $booking_details->guest}}</p>
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

						@if ($booking_details->cleaning_charge != 0)
							<div class="d-flex justify-content-between text-16">
								<div>
									<p class="pl-4">{{ __('Cleaning Fee') }}</p>
								</div>

								<div>
									<p class="pr-4">{!! $price_list->cleaning_fee_with_symbol !!}</p>
								</div>
							</div>
						@endif

						@if ($booking_details->guest_charge != 0)
							<div class="d-flex justify-content-between text-16">
								<div>
									<p class="pl-4">{{ __('Additional Guest Fee') }}</p>
								</div>

								<div>
									<p class="pr-4">{!! $price_list->additional_guest_fee_with_symbol !!}</p>
								</div>
							</div>
						@endif

						@if ($booking_details->security_money != 0)
							<div class="d-flex justify-content-between text-16">
								<div>
									<p class="pl-4">{{ __('Security Fee') }}</p>
								</div>

								<div>
									<p class="pr-4">{!! $price_list->security_fee_with_symbol !!}</p>
								</div>
							</div>
						@endif

						@if ($booking_details->service_charge != 0)
							<div class="d-flex justify-content-between text-16">
								<div>
									<p class="pl-4">{{ __('Service fee') }}</p>
								</div>

								<div>
									<p class="pr-4">{!! $price_list->service_fee_with_symbol !!}</p>
								</div>
							</div>
						@endif


						@if ($booking_details->iva_tax != 0)
							<div class="d-flex justify-content-between text-16">
								<div>
									<p class="pl-4">{{ __('I.V.A Tax') }}</p>
								</div>

								<div>
									<p class="pr-4">{!! $price_list->iva_tax_with_symbol !!}</p>
								</div>
							</div>
						@endif

						@if ($booking_details->accomodation_tax != 0)
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

						@if ($booking_details->host_fee)
							<div class="d-flex justify-content-between text-16">
								<div>
									<p class="pl-4">{{ __('Host Fee') }}</p>
									<i class="icon icon-question icon-question-sign" data-behavior="tooltip" rel="tooltip" aria-label="Vrent charges a fee to cover the cost (banking fees) of processing payment from the traveler."></i>

								</div>

								<div>
									<p class="pr-4">{!! optional($booking_details->currency)->symbol !!}{{ $booking_details->host_fee }}</p>
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
@endsection

