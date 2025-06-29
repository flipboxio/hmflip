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
	<div class="row">
		<div class="col-md-8 col-sm-8 col-xs-12 mb-5 main-panel p-5 border rounded">
			<div class="pb-3 m-0 text-24 font-weight-700">{{ __('Stripe') }} {{ __('Payment') }} </div>
			<form action="{{ route('gateway.complete', ['gateway' => config('stripe.alias')]) }}" method="post" id="payment-form">
				{{ csrf_field() }}
				<div class="form-row p-0 m-0">
					<label for="card-element">
						{{ __('Credit or debit card') }}
					</label>
				<div id="card-element">
				<!-- a Stripe Element will be inserted here. -->
				</div>

				<!-- Used to display form errors -->
				<div id="card-errors" role="alert"></div>
			</div>
			<div class="form-group mt-5">
				<div class="col-sm-8 p-0">
					<button class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3" id="stripe_btn"><i class="spinner fa fa-spinner fa-spin d-none"></i> {{ __('Submit Payment') }}</button>
				</div>
			</div>
		</form>
		</div>

		<div class="col-md-4 mb-5">
			<div class="card p-3">
				<a href="{{ url('properties/' . $result->slug) }}">
					<img class="card-img-top p-2 rounded" src="{{ $result->cover_photo }}" alt="{{ $result->name }}" height="180px">
				</a>
				<div class="card-body p-2">
					<a href="{{ url('properties/' . $result->slug) }}"><p class="text-16 font-weight-700 mb-0">{{ $result->name }}</p></a>

					<p class="text-14 mt-2 text-muted mb-0">
						<i class="fas fa-map-marker-alt"></i>
						{{ $result?->property_address?->address_line_1 }}, {{ $result?->property_address?->state }}, {{ $result?->property_address?->country_name }}
					</p>
					<div class="border p-4 mt-4 text-center">
						<p class="text-16 mb-0">
							<strong class="font-weight-700 secondary-text-color">{{ $result->property_type_name }}</strong>
							{{ __('for') }}
							<strong class="font-weight-700 secondary-text-color">{{ $number_of_guests }} {{ __('Guest') }}</strong>
						</p>
						<div class="text-14"><strong>{{ date(setDateForFront(), strtotime($checkin)) }}</strong> to <strong>{{ date(setDateForFront(), strtotime($checkout)) }}</strong></div>
					</div>

					<div class="border p-4 mt-3">

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
								<p class="pl-4">{!! $price_list->per_night_price_with_symbol !!} x {{ $nights }} {{ __('nights') }}</p>
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
									<p class="pr-4">{!!  $price_list->iva_tax_with_symbol !!}</p>
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

						<div class="d-flex justify-content-between font-weight-700 text-16">
							<div>
								<p class="pl-4">{{ __('Total') }}</p>
							</div>

							<div>
								<p class="pr-4">{!! $price_list->total_with_symbol !!}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body text-16">
					<p class="exfont">
						{{ __('You are paying in') }}
						<strong><span id="payment-currency">{!!moneyFormat($currencyDefault->symbol, $currencyDefault->code)!!}</span></strong>.
						{{ __('Your total charge is') }}
						<strong><span id="payment-total-charge">{!! moneyFormat($currencyDefault->org_symbol, $price_eur) !!}</span></strong>.
						{!! __("The exchange rate for booking this listing is :x 1 to :y :z ( your host's listing currency ).", ['x' => $symbol, 'y' => moneyFormat($price_list->property_default->symbol, $price_list->property_default->local_to_propertyRate ), 'z' => $price_list->property_default->currency_code]) !!}
					</p>
				</div>
			</div>


	</div>
	</div>
</div>

@push('scripts')
    <!-- Stripe JS -->
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>

    <!-- Your JS File -->
    <script>
        var stripe = Stripe('{{ $publishableKey }}');
    </script>
    <script src="{{ asset('Modules/Stripe/Resources/assets/js/index.min.js') }}"></script>

@endpush
@stop
