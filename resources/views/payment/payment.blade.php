@extends('template')

@section('main')
<div class="container-fluid container-fluid-90 margin-top-85 min-height">
	@if (Session::has('message'))
		<div class="row mt-5">
			<div class="col-md-12 text-13 alert mb-0 {{ Session::get('alert-class') }} alert-dismissable fade in  text-center opacity-1">
				<a href="#"  class="close " data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('message') }}
			</div>
		</div>
	@endif

	<div class="row justify-content-center">
		<div class="col-md-8 mb-5 mt-3 main-panel p-5 border rounded">
			<form action="{{ url('payments/create_booking') }}" method="post" id="checkout-form">
				{{ csrf_field() }}
				<div class="row justify-content-center">
				<input name="property_id" type="hidden" value="{{ $property_id }}">
				<input name="checkin" type="hidden" value="{{ $checkin }}">
				<input name="checkout" type="hidden" value="{{ $checkout }}">
				<input name="number_of_guests" type="hidden" value="{{ $number_of_guests }}">
				<input name="nights" type="hidden" value="{{ $nights }}">
				<input name="currency" type="hidden" value="{{ $result->property_price->code }}">
				<input name="booking_id" type="hidden" value="{{ $booking_id }}">
				<input name="booking_type" type="hidden" value="{{ $booking_type }}">

				@if ($status == "" && $booking_type == "request")
					<div class="h2 pb-4 m-0 text-24">{{ __('You will pay after host approval') }}</div>
				@endif
				@if ($booking_type == "instant"|| $status == "Processing" )
					<div class="col-md-12 p-0">
						<label for="exampleInputEmail1">{{ __('Country') }}</label>
					</div>

					<div class="col-sm-12 p-0 pb-3">
						<select name="payment_country" id="country-select" data-saving="basics1" class="form-control mb20">
							@foreach ($country as $key => $value)
								<option value="{{ $key }}" {{ ($key == $default_country) ? 'selected' : '' }} > {{ $value }}</option>
							@endforeach
						</select>
					</div>

					<div class="col-sm-12 p-0">
						<label for="exampleInputEmail1">{{ __('Payment type') }}</label>
					</div>

					<div class="col-sm-12 p-0 pb-3">
						<select name="payment_method" class="form-control mb20" id="payment-method-select">
							
							@foreach ($gateways as $gateway)
								<option value="{{ $gateway->alias }}" data-payment-type="payment-method" data-cc-type="visa" data-cc-name="" data-cc-expire="">
								{{ __($gateway->name) }}
								</option>
							@endforeach

						</select>
						

					</div>

				@endif

					<div class="col-sm-12 p-0">
						<label for="message"></label>
					</div>

					<div class="col-sm-12 p-0 pb-3">
						<textarea name="message_to_host" placeholder="{{ __('Type message to Host.') }}" class="form-control mb20" rows="7" required></textarea>
					</div>

					<div class="col-sm-12 p-0 text-right mt-4">
						<button id="payment-form-submit" type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3">
							<i class="spinner fa fa-spinner fa-spin d-none"></i>
							{{ ($booking_type == 'instant') ? __('Book Now') : __('Continue') }}
						</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-4  mt-3 mb-5">
				<div class="card p-3">
					<a href="{{ url('properties/' . $result->slug ) }}">
						<img class="card-img-top p-2 rounded" src="{{ $result->cover_photo }}" alt="{{ $result->name }}" height="180px">
					</a>

					<div class="card-body p-2">
						<a href="{{ url('properties/' . $result->slug ) }}">
							<p class="text-16 font-weight-700 mb-0">{{ $result->name }}</p>
						</a>

						<p class="text-14 mt-2 text-muted mb-0">
							<i class="fas fa-map-marker-alt"></i>
							{{ $result->property_address->address_line_1 }}, {{ $result->property_address->state }}, {{ $result->property_address->country_name }}
						</p>
						<div class="border p-4 mt-4 text-center rounded-3">
							<p class="text-16 mb-0">
								<strong class="font-weight-700 secondary-text-color">{{ $result->property_type_name }}</strong>
								{{ __('for') }}
								<strong class="font-weight-700 secondary-text-color">{{ $number_of_guests }} {{ __('Guest') }}</strong>
							</p>
							<div class="text-16"><strong>{{ date(setDateForFront(), strtotime($checkin)) }}</strong> to <strong>{{ date(setDateForFront(), strtotime($checkout)) }}</strong></div>
						</div>

						<div class="border p-4 rounded-3 mt-4">

							@foreach ( $price_list->date_with_price as $date_price)
								<div class="d-flex justify-content-between text-16">
									<div>
										<p class="pl-4">{{ $date_price->date }}</p>
									</div>
									<div>
										<p class="pr-4">{!! $date_price->price !!}</p>
									</div>
								</div>
							@endforeach
							<hr>
							<div class="d-flex justify-content-between text-16">
								<div>
									<p class="pl-4">{{ __('Nights') }}</p>
								</div>
								<div>
									<p class="pr-4">{{ $nights }}</p>
								</div>
							</div>

							<div class="d-flex justify-content-between text-16">
								<div>
									<p class="pl-4">{!! __(':x x :y nights', ['x' => $price_list->per_night_price_with_symbol, 'y' => $nights]) !!}</p>
								</div>
								<div>
									<p class="pr-4">{!! $price_list->total_night_price_with_symbol !!}</p>
								</div>
							</div>

							@if ($price_list->service_fee)
								<div class="d-flex justify-content-between text-16">
									<div>
										<p class="pl-4">{{ __('Service fee') }}</p>
									</div>

									<div>
										<p class="pr-4">{!! $price_list->service_fee_with_symbol !!}</p>
									</div>
								</div>
							@endif

							@if ($price_list->additional_guest)
								<div class="d-flex justify-content-between text-16">
									<div>
										<p class="pl-4">{{ __('Additional Guest fee') }}</p>
									</div>

									<div>
										<p class="pr-4">{!! $price_list->additional_guest_fee_with_symbol !!}</p>
									</div>
								</div>
							@endif

							@if ($price_list->security_fee)
								<div class="d-flex justify-content-between text-16">
									<div>
										<p class="pl-4">{{ __('Security deposit') }}</p>
									</div>

									<div>
										<p class="pr-4">{!! $price_list->security_fee_with_symbol !!}</p>
									</div>
								</div>
							@endif

							@if ($price_list->cleaning_fee)
								<div class="d-flex justify-content-between text-16">
									<div>
										<p class="pl-4">{{ __('Cleaning fee') }}</p>
									</div>

									<div>
										<p class="pr-4">{!! $price_list->cleaning_fee_with_symbol !!}</p>
									</div>
								</div>
							@endif

							@if ($price_list->iva_tax)
								<div class="d-flex justify-content-between text-16">
									<div>
										<p class="pl-4">{{ __('I.V.A Tax') }}</p>
									</div>

									<div>
										<p class="pr-4">{!! $price_list->iva_tax_with_symbol !!}</p>
									</div>
								</div>
							@endif

							@if ($price_list->accomodation_tax)
								<div class="d-flex justify-content-between text-16">
									<div>
										<p class="pl-4">{{ __('Accommodation Tax') }}</p>
									</div>

									<div>
										<p class="pr-4">{!! $price_list->accomodation_tax_with_symbol !!}</p>
									</div>
								</div>
							@endif
							<hr>

							<div class="d-flex justify-content-between font-weight-700">
								<div>
									<p class="pl-4">{{ __('Total') }}</p>
								</div>

								<div>
									<p class="pr-4">{!! $price_list->total_with_symbol !!}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<p class="exfont text-16">
							{{ __('You are paying in') }}
							<strong><span id="payment-currency">{!! moneyFormat($currencyDefault->org_symbol,$currencyDefault->code) !!}</span></strong>.
							{{ __('Your total charge is') }}
							<strong><span id="payment-total-charge">{!! moneyFormat($currencyDefault->org_symbol, $price_eur) !!}</span></strong>.
							{!! __("The exchange rate for booking this listing is :x :y to :z :w ( your host's listing currency ).", ['x' => moneyFormat($currentCurrency->symbol, 1), 'y' => $currentCurrency->code, 'z' => moneyFormat($result->property_price->currency->org_symbol, $price_rate ), 'w' => $result->property_price->currency_code ]) !!}
						</p>
					</div>
				</div>


		</div>
	</div>
</div>
@push('scripts')
	<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/payment.min.js') }}"></script>
@endpush
@stop
