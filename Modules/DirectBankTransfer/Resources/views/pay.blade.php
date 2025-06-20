@extends('template')
@section('main')
    <div class="container-fluid container-fluid-90 margin-top-85 min-height">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12 mb-5 main-panel p-5 border rounded">
                <div class="pb-3 m-0 text-24 font-weight-700">{{ __('Bank Payment') }}</div>
                <form action="{{ route('gateway.complete', ['gateway' => config('directbanktransfer.alias')]) }}" method="post" id="payment-form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row justify-content-center">
                        <input name="property_id" type="hidden" value="{{ $data->property_id }}">
                        <input name="checkin" type="hidden" value="{{ $data->checkin }}">
                        <input name="checkout" type="hidden" value="{{ $data->checkout }}">
                        <input name="number_of_guests" type="hidden" value="{{ $data->number_of_guests }}">
                        <input name="nights" type="hidden" value="{{ $data->nights }}">
                        <input name="currency" type="hidden" value="{{ $data?->result?->property_price->code }}">
                        <input name="booking_id" type="hidden" value="{{ $data->id }}">
                        <input name="booking_type" type="hidden" value="{{ $data->booking_type }}">


                        <div class="col-sm-12 p-3 my-2 border-ddd border-r-10">
                                <div class="banks" id="">
                                    <table class="table table-sm table-borderless">
                                        @if ($bank->account_name)
                                            <tr>
                                                <td>{{ __('Account Holder Namer') }}:</td>
                                                <td id="name" class="text-muted">{{ $bank->account_name }}</td>
                                            </tr>
                                        @endif
                                        @if ($bank->iban)
                                            <tr>
                                                <td>{{ __('Account Number') }}:</td>
                                                <td id="name" class="text-muted">{{ $bank->iban }}</td>
                                            </tr>
                                        @endif

                                        @if ($bank->iban)
                                            <tr>
                                                <td>{{ __('Account Number/IBAN') }}:</td>
                                                <td id="iban" class="text-muted">{{ $bank->iban }}</td>
                                            </tr>
                                        @endif

                                        @if ($bank->swift_code)
                                            <tr>
                                                <td>{{ __('Swift Code') }}:</td>
                                                <td id="swift" class="text-muted">{{ $bank->swift_code }}</td>
                                            </tr>
                                        @endif


                                        @if ($bank->bank_name)
                                            <tr>
                                                <td>{{ __('Bank Name') }}:</td>
                                                <td id="bank_name" class="text-muted">{{ $bank->bank_name }}</td>
                                            </tr>
                                        @endif

                                        @if ($bank->routing_no)
                                            <tr>
                                                <td>{{ __('Routing No') }}:</td>
                                                <td id="route" class="text-muted">{{ $bank->routing_no }}</td>
                                            </tr>
                                        @endif
                                        <tr>

                                        </tr>
                                        @if ($bank->branch_name)
                                            <tr>
                                                <td>{{ __('Branch Name') }}</td>
                                                <td id="br_name" class="text-muted">{{ $bank->branch_name }}</td>
                                            </tr>
                                        @endif
                                        <tr>

                                        </tr>
                                        @if ($bank->branch_city)
                                            <tr>
                                                <td>{{__('Branch City') }}</td>
                                                <td id="br_city" class="text-muted">{{ $bank->branch_city }}</td>
                                            </tr>
                                        @endif

                                        @if ($bank->country)
                                            <tr>
                                                <td>{{ __('Country') }}:</td>
                                                <td id="country" class="text-muted">{{ $bank->country }}</td>
                                            </tr>
                                        @endif

                                        @if ($bank->logo)
                                            <tr>
                                                <td>{{ __('Logo') }}:</td>
                                                <td>
                                                    <img id="logo" src="{{ asset('/Modules/DirectBankTransfer/Resources/assets/') . '/' . $bank->logo }}" class="bank-logo" alt="">
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>{{ __('Total') }}:</td>
                                            <td id="total"
                                                class="text-muted">{!! $data?->price_list?->total_with_symbol !!}</td>
                                        </tr>
                                    </table>
                                    @if ($bank->instruction)
                                        <hr>
                                        <div class="p-2">
                                            {!! $bank->instruction !!}
                                        </div>
                                        <hr>
                                    @endif
                                </div>


                            <table class="table table-borderless">
                                <tr>
                                    <td>{{ __('Attach payment document/image') }}<span class="danger-text">*</span>:</td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td><input class="form-control" required name="attachment[]" type="file" accept="image/*" multiple="multiple">
                                        <span class="text-danger">{{ $errors->first('attachment') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Type message to Host.') }}<span class="danger-text">*</span>:</td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td><textarea class="form-control" required name="note"
                                                  type="text">{{ old('note') }}</textarea>
                                        <span class="text-danger">{{ $errors->first('note') }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12 p-0 text-right mt-4">
                        <button id="payment-form-submit" type="submit"
                                class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3">
                            <i class="spinner fa fa-spinner fa-spin d-none"></i>
                            {{ __('Confirm') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 mb-5">
                <div class="card p-3">
                    <a href="{{ url('properties/' . $data->result->slug) }}">
                        <img class="card-img-top p-2 rounded" src="{{ $data->result->cover_photo }}" alt="{{ $data->result->name }}"
                             height="180px">
                    </a>
                    <div class="card-body p-2">
                        <a href="{{ url('properties/' . $data->result->slug) }}"><p
                                class="text-16 font-weight-700 mb-0">{{ $data->result->name }}</p></a>

                        <p class="text-14 mt-2 text-muted mb-0">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $data->result?->property_address?->address_line_1 }}, {{ $data->result?->property_address?->state }}
                            , {{ $data->result?->property_address?->country_name }}
                        </p>
                        <div class="border p-4 mt-4 text-center">
                            <p class="text-16 mb-0">
                                <strong
                                    class="font-weight-700 secondary-text-color">{{ $data->result->property_type_name }}</strong>
                                {{ __('for') }}
                                <strong
                                    class="font-weight-700 secondary-text-color">{{ $data->number_of_guests }} {{ __('Guest') }}</strong>
                            </p>
                            <div class="text-14"><strong>{{ date(setDateForFront(), strtotime($data->checkin)) }}</strong> to
                                <strong>{{ date(setDateForFront(), strtotime($data->checkout)) }}</strong></div>
                        </div>

                        <div class="border p-4 mt-3">

                            @foreach ( $data->price_list->date_with_price as $date_price)
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
                                    <p class="pr-4">{{ $data->nights }}</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between text-16">
                                <div>
                                    <p class="pl-4">{!! $data->price_list->per_night_price_with_symbol !!}
                                        x {{ $data->nights }} {{ __('nights') }}</p>
                                </div>
                                <div>
                                    <p class="pr-4">{!! $data->price_list->total_night_price_with_symbol !!}</p>
                                </div>
                            </div>

                            @if ($data->price_list->service_fee)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{ __('Service fee') }}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $data->price_list->service_fee_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($data->price_list->additional_guest)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{ __('Additional Guest fee') }}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $data->price_list->additional_guest_fee_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($data->price_list->security_fee)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{ __('Security deposit') }}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $data->price_list->security_fee_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($data->price_list->cleaning_fee)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{ __('Cleaning fee') }}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $data->price_list->cleaning_fee_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($data->price_list->iva_tax)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{ __('I.V.A Tax') }}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!!  $data->price_list->iva_tax_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($data->price_list->accomodation_tax)
                                <div class="d-flex justify-content-between text-16">
                                    <div>
                                        <p class="pl-4">{{ __('Accommodation Tax') }}</p>
                                    </div>

                                    <div>
                                        <p class="pr-4">{!! $data->price_list->accomodation_tax_with_symbol !!}</p>
                                    </div>
                                </div>
                            @endif
                            <hr>

                            <div class="d-flex justify-content-between font-weight-700 text-16">
                                <div>
                                    <p class="pl-4">{{ __('Total') }}</p>
                                </div>

                                <div>
                                    <p class="pr-4">{!! $data->price_list->total_with_symbol !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-16">
                        <p class="exfont">
                            {{ __('You are paying in') }}
                            <strong><span id="payment-currency">{!!moneyFormat($data->currencyDefault->symbol,$data->currencyDefault->code)!!}</span></strong>.
                            {{ __('Your total charge is') }}
                            <strong><span id="payment-total-charge">{!! moneyFormat($data->currencyDefault->org_symbol, $data->price_eur) !!}</span></strong>.
                            {!! __("The exchange rate for booking this listing is :x 1 to :y :z ( your host's listing currency )." , ['x' => $data->symbol, 'y' => moneyFormat($data->price_list->property_default->symbol, $data->price_list->property_default->local_to_propertyRate ), 'z' => $data->price_list->property_default->currency_code]) !!}
                        </p>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>

    @push('css')
       <link rel="stylesheet" href="{{ asset('Modules/DirectBankTransfer/Resources/assets/css/style.min.css') }}">
    @endpush
    @push('scripts')
        <script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('Modules/DirectBankTransfer/Resources/assets/js/initial.min.js') }}"></script>
    @endpush
@stop

