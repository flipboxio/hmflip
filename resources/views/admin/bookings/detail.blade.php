@extends('admin.template')

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('public/js/ninja/ninja-slider.min.css') }}" />	
@endpush
	@section('main')
	<div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-md-8 offset-sm-2">
					<div class="box box-info box_info">
						<div class="box-header with-border">
							<h3 class="box-title">Booking Details</h3>
						</div>

						<form action="{{ url('admin/bookings/detail/' . $result->id) }}" method="post" class='form-horizontal'>
							{{ csrf_field() }}
							<div class="box-body">
								<div class="form-group row mt-2">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Property name
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ $result->properties->name }}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Host name
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ ucfirst($result->properties->users->first_name) }}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Guest name
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ ucfirst($result->users->first_name) }}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Checkin
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ onlyFormat($result->start_date) }}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Checkout
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ onlyFormat($result->end_date) }}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Number of guests
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ $result->guest }}
									</div>
								</div>


								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
									Total nights
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
									{{ $result->total_night }}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
									Per nights fee
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
									{!! moneyFormat($result->currency->org_symbol, $result->original_per_night) !!}
									</div>
								</div>

								@if ($date_price)
	            					@foreach ($date_price as $datePrice )
										<div class="form-group row mt-3">
											<label class="col-4 col-sm-3 control-label fw-semibold">
											{{ $datePrice->date }}
											</label>
											<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
											{!! moneyFormat($result->currency->org_symbol, $datePrice->price) !!}
											</div>
										</div>
									@endforeach
          						@endif


								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Sub Total amount
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
									{!! moneyFormat($result->currency->org_symbol, $result->original_base_price) !!}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Cleaning fee
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{!! moneyFormat($result->currency->org_symbol, $result->original_cleaning_charge) !!}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										I.V.A Tax
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{!! moneyFormat($result->currency->org_symbol, $result->iva_tax) !!}

									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Accomodation Tax
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{!! moneyFormat($result->currency->org_symbol, $result->accomodation_tax) !!}

									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Additional guest fee
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
									{!! moneyFormat($result->currency->org_symbol, $result->original_guest_charge) !!}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Security fee
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
									{!! moneyFormat($result->currency->org_symbol, $result->original_security_money) !!}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
									Service fee
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
									{!! moneyFormat($result->currency->org_symbol, $result->original_service_charge) !!}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Host fee
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
									{!! moneyFormat($result->currency->org_symbol, $result->original_host_fee) !!}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Total amount
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{!! moneyFormat($result->currency->org_symbol, $result->original_total) !!}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Currency
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{!! $result->currency_code !!}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Paymode
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ $result?->payment_methods?->name }}
									</div>
								</div>

								<div class="form-group row mt-3">
									<label class="col-4 col-sm-3 control-label fw-semibold">
										Status
									</label>
									<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ $result->status }}
									</div>
								</div>

								@if ($result->status == "Cancelled")
									<div class="form-group row mt-3">
										<label class="col-4 col-sm-3 control-label fw-semibold">
										Cancelled By
										</label>
										<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ $result->cancelled_by }}
										</div>
									</div>

									<div class="form-group row mt-3">
										<label class="col-4 col-sm-3 control-label fw-semibold">
										Cancelled Date
										</label>
										<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ dateFormat($result->cancelled_at) }}
										</div>
									</div>
								@endif

								@if ($result->transaction_id != '' && $result->transaction_id != ' ')
                                    <div class="form-group row mt-3">
                                        <label class="col-4 col-sm-3 control-label fw-semibold">
                                            Transaction ID
                                        </label>
                                        <div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
                                            {{ $result->transaction_id }}
                                        </div>
                                    </div>
                                @endif


                                @if ($result->payment_method_id == 4)

                                    <div class="form-group row mt-3">
                                        <label class="col-4 col-sm-3 control-label fw-semibold">
                                            Bank Account Name
                                        </label>
                                        <div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
                                            {{ ($result->bank && $result->bank->account_name) ? $result->bank->account_name : 'Not Found' }}
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <label class="col-4 col-sm-3 control-label fw-semibold">
                                            Bank Account No.
                                        </label>
                                        <div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
                                            {{ ($result->bank && $result->bank->iban) ? $result->bank->iban : 'Not Found' }}
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <label class="col-4 col-sm-3 control-label fw-semibold">
                                            Bank Name
                                        </label>
                                        <div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
                                            {{ ($result->bank && $result->bank->bank_name) ? $result->bank->bank_name : 'Not Found' }}
                                        </div>
                                    </div>

									<div class="d-none" id="showSlider-mobile">
										<div id="ninja-slider-mobile">
											<div class="slider-inner">
												<ul>
													@foreach ($result->attachment as $item)
													<li>
														<a class="ns-img"
															href="{{ $item }}"
															aria-label="photo"></a>
													</li>
													@endforeach
												</ul>
												<div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
											</div>
										</div>
									</div>
									<div class="d-none" id="showSlider">
										<div id="ninja-slider">
											<div class="slider-inner">
												<ul>
													@foreach ($result->attachment as $item)
													<li>
														<a class="ns-img"
															href="{{ $item }}"
															aria-label="photo"></a>
													</li>
													@endforeach
												</ul>
												<div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
											</div>
										</div>
									</div>
                                    <div class="form-group row mt-3">
                                        <label class="col-4 col-sm-3 control-label fw-semibold">
                                            Attached
                                        </label>
										
												
										@php $i=0 @endphp
	
										@foreach ($result->attachment as $item)
											@if ($i <= 2) 
												@if ($i==2) <div class="col-sm-2 offset-sm-1 offet-0 f-14 pt-0 pt-md-2 position-relative">
													<div class="view-all gal-img h-110px">
														<img src="{{ $item }}"
															alt="property-photo" class="attachment_images rounded"
															onclick="lightbox({{ $i }})" />
														<span class="position-center cursor-pointer text-white"
															onclick="lightbox({{ $i }})">{{ __('View All') }}</span>
													</div>
			
												@else
												
													<div class="col-sm-2 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
														<img src="{{ $item }}"
															alt="NOt Found" class=" attachment_images rounded"
															onclick="lightbox({{ $i }})" />
													</div>
												@endif
		
		
		
		
		
											@else
												@php break; @endphp
											@endif
											@php $i++ @endphp

										@endforeach
											
                                    </div>

                                    <div class="form-group row mt-3">
                                        <label class="col-4 col-sm-3 control-label fw-semibold">
                                            Payment Note
                                        </label>
                                        <div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
                                            {{ ($result->bank && $result->note) ? $result->note : '' }}
                                        </div>
                                    </div>
									
                                    @if (($result->status == 'Pending' && $result->booking_type == 'instant') || $result->status ==  'Processing')

                                        <div class="form-group row mt-3">
                                            <label class="col-4 col-sm-3 control-label fw-semibold">
                                                Confirm Booking?
                                            </label>
                                            <div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
                                                <div class="d-flex">
                                                    <a href="{{ url('/admin/bookings/edit/confirm/' . $result->id) }}" class="btn btn-sm btn-info btn-outline-info f-14 text-white">Accept</a>
                                                    <a href="{{ url('/admin/bookings/edit/decline/' . $result->id) }}" class="btn text-danger btn-outline-danger f-14">Decline</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

								@if ($result->paymode == 'Credit Card')
									<div class="form-group row mt-3">
										<label class="col-4 col-sm-3 control-label fw-semibold">
										First name
										</label>
										<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ $result->first_name }}
										</div>
									</div>

									<div class="form-group row mt-3">
										<label class="col-4 col-sm-3 control-label fw-semibold">
										Last name
										</label>
										<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ $result->last_name }}
										</div>
									</div>

									<div class="form-group row mt-3">
										<label class="col-4 col-sm-3 control-label fw-semibold">
										Postal code
										</label>
										<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ $result->postal_code }}
										</div>
									</div>
								@endif

								@if ($result->host_account != '')
									<div class="form-group row mt-3">
										<label class="col-4 col-sm-3 control-label fw-semibold">
										Host Paypal account
										</label>
										<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ $result->host_account }}
										</div>
									</div>
								@endif

								@if ($bank?->account_number != '')
									<div class="form-group row mt-3">
										<label class="col-4 col-sm-3 control-label fw-semibold">
										Host Bank account
										</label>
										<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
										{{ $bank->account_number }}
										</div>
									</div>
								@endif

								@if ($result->guest_account != '')
									<div class="form-group row mt-3">
										<label class="col-4 col-sm-3 control-label fw-semibold">
											Guest Paypal account
										</label>
										<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
											{{ $result->guest_account }}
										</div>
									</div>
								@endif

								@if ($result->host_penalty_amount != 0)
									<div class="form-group row mt-3">
										<label class="col-4 col-sm-3 control-label fw-semibold">
											Applied Penalty Amount
										</label>
										<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
											{!! $result->currency->org_symbol !!}{{ $result->host_penalty_amount }}
										</div>
									</div>
								@endif

								@if ( $penalty_amount ?? '' != 0)
									<div class="form-group row mt-3">
										<label class="col-4 col-sm-3 control-label fw-semibold">
											Subtracted Penalty Amount
										</label>
										<div class="col-8 col-sm-6 offset-sm-1 offet-0 f-14 pt-0 pt-md-2">
											{!! $result->currency->org_symbol !!}{{ $penalty_amount ?? ' 0' }}
										</div>
									</div>
								@endif
							</div>
						</form>
						<div class="box-footer text-center">
							<a class="btn btn-default f-14" href="{{ url('admin/bookings') }}">Back</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	@endsection

	@section('validate_script')
		<script type="text/javascript" src="{{ asset('public/js/ninja/ninja-slider.js') }}"></script>
		<script src="{{ asset('public/backend/js/booking-detail.min.js') }}"></script>
	@endsection
	
