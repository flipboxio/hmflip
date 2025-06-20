@extends('admin.template')
@section('main')
  <div class="content-wrapper">
         <!-- Main content -->
    <section class="content-header">
        <h1>
            Pricing
            <small>Pricing</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row gap-2">
            <div class="col-lg-3 col-12 settings_bar_gap">
                  @include('admin.common.property_bar')
            </div>

            <div class="col-md-9">
                <form id="listing_pricing" method="post" action="{{ url('admin/listing/' . $result->id. '/' . $step) }}" class='signup-form login-form' accept-charset='UTF-8'>
                    {{ csrf_field() }}
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="f-18">Base price</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <label for="listing_price_native" class="label-large fw-bold">Nightly Price <span class="text-danger">*</span></label>
                                    <div class="input-addon">
                                        <span class="input-prefix pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
                                        <input type="text" data-suggested="" id="price-night" value="{{ ($result->property_price->original_price == 0) ? '' : $result->property_price->original_price }}" name="price" class="money-input form-control f-14">
                                    </div>
                                    <span class="text-danger">{{ $errors->first('price') }}</span>
                                </div>

                                <div class="col-md-8">
                                    <label class="label-large fw-bold">Currency</label>
                                    <select id='price-select-currency_code' name="currency_code" class='form-control f-14'>
                                        @foreach ($currency as $key => $value)
                                            <option value="{{ $key }}" {{ $result->property_price->currency_code == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    @if ($result->property_price->weekly_discount == 0 && $result->property_price->monthly_discount == 0)
                                        <p id="js-set-long-term-prices" class="row-space-top-6 text-center text-muted set-long-term-prices f-14 mt-1">
                                            You can offer discounts for longer stays by setting  <a data-prevent-default="" href="#" id="show_long_term">weekly and monthly</a> prices.
                                        </p>
                                        <hr class="row-space-top-6 row-space-5 set-long-term-prices">
                                    @endif
                                </div>
                            </div>

                            <div class="row {{ ($result->property_price->weekly_discount == 0 && $result->property_price->monthly_discount == 0) ? 'display-off' : '' }}" id="long-term-div">
                                <div class="col-md-12">
                                    <p class="mb-0 f-18 mt-2">Long-term prices</p>
                                </div>
                              <div class="col-md-8">
                                <label for="listing_price_native" class="label-large fw-bold mb-1">Weekly Discount Percent (%)</label>
                                <div class="input-addon">
                                  <span class="input-prefix pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
                                  <input type="text" data-suggested="" id="price-week" value="{{ $result->property_price->weekly_discount }}" name="weekly_discount" data-saving="long_price" class="money-input form-control f-14">
                                </div>
                              </div>
                              <div class="col-md-8">
                                <label for="listing_price_native" class="label-large fw-bold mb-1">Monthly Discount Percent (%)</label>
                                <div class="input-addon">
                                  <span class="input-prefix pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
                                  <input type="text" data-suggested="₹16905" id="price-month" class="money-input  form-control f-14" value="{{ $result->property_price->monthly_discount }}" name="monthly_discount" data-saving="long_price">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                              <p class="mb-0 f-18">Additional Pricing Options</p>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <label for="listing_cleaning_fee_native_checkbox" class="label-large label-inline fw-bold">
                                  <input type="checkbox" data-extras="true" class="pricing_checkbox" data-rel="cleaning" {{ ($result->property_price->original_cleaning_fee == 0) ? '' : 'checked = "checked"' }}>&nbsp
                                  Cleaning fee
                                </label>
                              </div>
                              <div id="cleaning" class="{{ ($result->property_price->original_cleaning_fee == 0) ? 'display-off' : '' }}">
                                <div class="col-md-12">
                                  <div class="col-md-4 l-pad-none">
                                    <div class="input-addon">
                                      <span class="input-prefix pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
                                      <input type="text" data-extras="true" id="price-cleaning" value="{{ $result->property_price->original_cleaning_fee }}" name="cleaning_fee" class="money-input" data-saving="additional-saving">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <label for="listing_cleaning_fee_native_checkbox" class="label-large label-inline fw-bold">
                                  <input type="checkbox" class="pricing_checkbox" data-rel="additional-guests" {{ ($result->property_price->original_guest_fee == 0) ? '' : 'checked = "checked"' }}>&nbsp
                                  Additional guests
                                </label>
                              </div>
                              <div id="additional-guests" class="{{ ($result->property_price->original_guest_fee == 0) ? 'display-off' : '' }}">
                                <div class="col-md-12">
                                  <div class="col-md-4 float-start">
                                    <div class="input-addon">
                                      <span class="input-prefix pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
                                      <input type="text" data-extras="true" value="{{ $result->property_price->original_guest_fee }}" id="price-extra_person" name="guest_fee" class="money-input" data-saving="additional-saving">
                                    </div>
                                  </div>
                                  <div class="col-md-4 txt-right float-start">
                                    <label class="label-large fw-bold pe-3 mt-2">For each guest after</label>
                                  </div>
                                  <div class="col-md-4 float-start">
                                    <select id="price-select-guests_included" name="guest_after" data-saving="additional-saving" class="form-control f-14">
                                      @for ($i=1;$i<=16;$i++)
                                          <option value="{{ $i }}" {{ ($result->property_price->guest_after == $i) ? 'selected' : '' }}>
                                          {{ ($i == '16') ? $i . '+' : $i }}
                                          </option>
                                      @endfor
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <label for="listing_cleaning_fee_native_checkbox" class="label-large label-inline fw-bold">
                                  <input type="checkbox" class="pricing_checkbox" data-rel="security" {{ ($result?->property_price?->original_security_fee == 0) ? '' : 'checked = "checked"' }}>
                                  &nbsp
                                  Security deposit
                                </label>
                              </div>
                              <div id="security" class="{{ ($result->property_price->original_security_fee == 0) ? 'display-off' : '' }}">
                                <div class="col-md-12">
                                  <div class="col-md-4 l-pad-none">
                                    <div class="input-addon">
                                      <span class="input-prefix pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
                                      <input type="text" class="money-input" data-extras="true" value="{{ $result->property_price->original_security_fee }}" id="price-security" name="security_fee" class="autosubmit-text input-stem input-large" data-saving="additional-saving">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <label for="listing_cleaning_fee_native_checkbox" class="label-large label-inline fw-bold">
                                  <input type="checkbox" class="pricing_checkbox" data-rel="weekend" {{ ($result->property_price->original_weekend_price == 0) ? '' : 'checked = "checked"' }}> &nbsp
                                  Weekend pricing
                                </label>
                              </div>
                              <div id="weekend" class="{{ ($result->property_price->original_weekend_price == 0) ? 'display-off' : '' }}">
                                <div class="col-md-12">
                                  <div class="col-md-4 l-pad-none">
                                    <div class="input-addon">
                                      <span class="input-prefix pay-currency">{!! $result->property_price->currency->org_symbol !!}</span>
                                      <input type="text" data-extras="true" value="{{ $result->property_price->original_weekend_price }}" id="price-weekend" name="weekend_price" class="money-input" data-saving="additional-saving">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-6 text-left">
                                <a data-prevent-default="" href="{{ url('admin/listing/' . $result->id . '/photos') }}" class="btn btn-large btn-primary f-14">Back</a>
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
  </div>


@endsection

@section('validate_script')
<script src="{{ asset('public/backend/js/backend.min.js') }}"></script>

  <script type="text/javascript">

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
  <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
@endsection
