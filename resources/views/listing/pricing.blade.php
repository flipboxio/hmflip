	@extends('template')

	@section('main')
	<div class="margin-top-85">
		<div class="row m-0">
			<!-- sidebar start-->
			@include('users.sidebar')
			<!--sidebar end-->
			<div class="col-md-10">
				<div class="main-panel min-height mt-4">
					<div class="row justify-content-center">
						<div class="col-md-3 pl-4 pr-4">
							@include('listing.sidebar')
						</div>

						<div class="col-md-9 mt-4 mt-sm-0 pl-4 pr-4">
							<form id="lis_pricing" method="post" action="{{ url('listing/' . $result->id . '/' . $step) }}" accept-charset='UTF-8'>
								{{ csrf_field() }}
								<div class="form-row mt-4 border rounded pb-4 m-0">
									<div class="form-group col-md-12 main-panelbg pb-3 pt-3 pl-4">
										<h4 class="text-16 font-weight-700">{{ __('Base price') }}</h4>
									</div>

									<div class="form-group col-lg-6 pl-5 pr-5">
										<label for="listing_price_native">
											{{ __('Nightly Price') }}
											<span class="text-danger">*</span>
										</label>
										<div class="form-groupw-100">
											<div class="input-group-prepend ">
												<span class="input-group-text line-height-2-4 text-16 pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>

												<input type="text" id="price-night" value="{{ ($result->property_price->original_price == 0) ? '' : $result->property_price->original_price }}" name="price"  class="money-input w-100 text-16" >
											</div>
											<span class="text-danger" id="price-error">{{ $errors->first('price') }}</span>
										</div>
									</div>

									<div class="form-group col-lg-6 pl-5 pr-5">
										<label for="inputPassword4">{{ __('Currency') }}</label>
										<select id='price-select-currency_code' name="currency_code" class='form-control text-16 mt-2'>
											@foreach ($currency as $key => $value)
												<option value="{{ $key }}" {{ $result->property_price->currency_code == $key?'selected':'' }}>{{ $value }}</option>
											@endforeach
										</select>
										<span class="text-danger" id="price-error">
											<label id="price-night-error" class="error" for="price-night">{{ $errors->first('currency') }}</label>
										</span>
									</div>

									<div class="form-group col-md-12">
										@if ($result->property_price->weekly_discount == 0 && $result->property_price->monthly_discount == 0)
											<p id="js-set-long-term-prices" class="text-center text-muted set-long-term-prices">
												{{ __('You can offer discounts for longer stays by setting') }}
												<a  href="#" id="show_long_term" class="secondary-text-color">
													{{ __('weekly and monthly') }}
												</a> {{ __('prices') }}.
											</p>
										@endif
									</div>
								</div>

								<div class="form-row mt-4 border rounded pb-4 m-0  {{ ($result->property_price->weekly_discount == 0 && $result->property_price->monthly_discount == 0) ? 'display-off' : '' }}" id="long-term-div">
									<div class="form-group col-md-12 main-panelbg pb-3 pt-3 pl-4">
										<h4 class="text-16 font-weight-700">{{ __('Long-term prices') }}</h4>
									</div>

									<div class="col-md-12 pl-5 pr-5">
										<label for="listing_price_native" >
											{{ __('Weekly Discount Percent (%)') }}
										</label>

										<div class="input-addon">
											<input type="text" data-suggested="" id="price-week" class="text-16" value="{{ $result->property_price->weekly_discount }}" name="weekly_discount" data-saving="long_price">
											<span class="text-danger">{{ $errors->first('weekly_discount') }}</span>
										</div>
									</div>

									<div class="col-md-12 mt-3 pl-5 pr-5">
										<label for="listing_price_native">
											{{ __('Monthly Discount Percent (%)') }}
										</label>

										<div class="input-addon">
											<input type="text" data-suggested="₹16905" id="price-month" class="money-input text-16 mt-2" value="{{ $result->property_price->monthly_discount }}" name="monthly_discount" data-saving="long_price">
											<span class="text-danger">
												{{ $errors->first('monthly_discount') }}
											</span>
										</div>
									</div>
								</div>


								<div class="mt-4 border rounded pb-4 m-0">
									<div class="form-group col-md-12 main-panelbg pb-3 pt-3 pl-4">
										<h4 class="text-16 font-weight-700">{{ __('Additional Pricing Options') }}</h4>
									</div>

									<div class="col-md-12 col-xs-12 pl-3 pr-3 pl-sm-5 pr-sm-5">
										<label for="listing_cleaning_fee_native_checkbox" class="label-large label-inline">
											<input type="checkbox" data-extras="true" class="pricing_checkbox" data-rel="cleaning" {{ ($result->property_price->original_cleaning_fee == 0) ? '' : 'checked = "checked" ' }}>
											{{ __('Cleaning fee') }}
										</label>
									</div>

									<div id="cleaning" class="{{ ( $result?->property_price?->original_cleaning_fee == 0) ? 'display-off' : '' }}">
										<div class="col-md-12 pl-3 pr-3 pl-sm-5 pr-sm-5 mt-3">
											<div class="input-group">
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text text-16 pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
													</div>
													<input type="text" data-extras="true" id="price-cleaning" aria-label="Amount" value="{{ $result->property_price->original_cleaning_fee }}" name="cleaning_fee" class="money-input text-16" data-saving="additional-saving" >
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-12 col-xs-12 mt-4 pl-3 pr-3 pl-sm-5 pr-sm-5">
										<label for="listing_cleaning_fee_native_checkbox" class="label-large label-inline">
											<input type="checkbox" class="pricing_checkbox" data-rel="additional-guests" {{ ($result->property_price->original_guest_fee == 0) ? '' : 'checked="checked"' }}>
											{{ __('Additional guests') }}
										</label>
									</div>

									<div id="additional-guests" class="{{ ($result->property_price->original_guest_fee == 0) ? 'display-off' : '' }}">
										<div class="col-md-12 pl-3 pr-3 pl-sm-5 pr-sm-5 mt-3">
											<div class="input-group">
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text text-16 pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
													</div>
													<input type="text" data-extras="true" value="{{ $result->property_price->original_guest_fee }}" id="price-extra_person" name="guest_fee" class="money-input text-16" data-saving="additional-saving" >
												</div>
											</div>

											<div class="input-group mt-3">
												<label class="label-large">{{ __('For each guest after') }}</label>
											</div>

											<div class="input-group mt-3">
												<select id="price-select-guests_included" name="guest_after" data-saving="additional-saving" class="text-16">
													@for ($i=1;$i<=16;$i++)
														<option value="{{ $i }}" {{ ($result?->property_price?->guest_after == $i) ? 'selected' : '' }}>
															{{ ($i == '16') ? $i . '+' : $i }}
														</option>
													@endfor
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-12 pl-3 pr-3 pl-sm-5 pr-sm-5 mt-4">
										<label for="listing_cleaning_fee_native_checkbox" class="label-large label-inline">
											<input type="checkbox" class="pricing_checkbox" data-rel="security" {{ ( $result?->property_price?->original_security_fee == 0) ? '' : 'checked = "checked"' }}>
											{{ __('Security deposit') }}
										</label>
									</div>

									<div id="security" class="{{ ($result->property_price->original_security_fee == 0) ? 'display-off' : '' }}">
										<div class="col-md-12 pl-3 pr-3 pl-sm-5 pr-sm-5 mt-4">
											<div class="input-group">
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text text-16 pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
													</div>
													<input type="text" class="money-input text-16" data-extras="true" value="{{ $result->property_price->original_security_fee }}" id="price-security" name="security_fee" data-saving="additional-saving">
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-12 pl-3 pr-3 pl-sm-5 pr-sm-5 mt-4">
										<label for="listing_cleaning_fee_native_checkbox" class="label-large label-inline">
											<input type="checkbox" class="pricing_checkbox" data-rel="weekend" {{ ($result->property_price->original_weekend_price == 0) ? '' : 'checked = "checked"' }}>
											{{ __('Weekend pricing') }}
										</label>
									</div>

									<div id="weekend" class="{{ ($result->property_price->original_weekend_price == 0) ? 'display-off' : '' }}">
										<div class="col-md-12 pl-3 pr-3 pl-sm-5 pr-sm-5 mt-3">
											<div class="input-group">
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text text-16 pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
													</div>
													<input type="text" data-extras="true" value="{{ $result->property_price->original_weekend_price }}" id="price-weekend" name="weekend_price" class="text-16" data-saving="additional-saving">
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row justify-content-between mt-4 mb-5">
									<div class="mt-4">
										<a  data-prevent-default="" href="{{ url('listing/' . $result->id . '/photos') }}" class="btn btn-outline-danger secondary-text-color-hover text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5">
											{{ __('Back') }}
										</a>
									</div>

									<div class="mt-4">
										<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5" id="btn_next"> <i class="spinner fa fa-spinner fa-spin d-none" ></i> <span id="btn_next-text">{{ __('Next') }}</span>

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
		let currencySymbolURL = '{{ url("currency-symbol") }}';
		let nextText = "{{ __('Next') }}..";
		var token = "{{ csrf_token() }}";
		let fieldRequiredText = "{{ __('This field is required.') }}";
		let validNumberText = "{{ __('Please enter a valid number.') }}";
		let priceMinValue = "{{ __('Please enter a value greater than or equal to 5.') }}";
		let discountsMinValue =  "{{ __('Please enter a value greater than or equal to 0.') }}";
		let discountsMaxValue = "{{ __('Please enter a value less than or equal to 99.') }}";
		let page = 'pricing';
	</script>
	<script type="text/javascript" src="{{ asset('public/js/listings.min.js') }}"></script>

@endsection

