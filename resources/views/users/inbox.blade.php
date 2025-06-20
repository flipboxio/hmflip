@extends('template')
@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		{{-- sidebar start--}}
		@include('users.sidebar')
		{{--sidebar end--}}

		<div class="col-lg-10 p-0 mb-5 min-height">
			<div class="main-panel">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12 p-0 mb-3">
							<div class="list-bacground mt-4 rounded-3 p-4 border">
								<span class="text-18 pt-4 pb-4 font-weight-700">{{ __('Inbox') }}</span>
							</div>
						</div>
					</div>
					@if (isset($booking))
						<div class="row">
							<div class="col-md-9 p-0">
								<div class="container-inbox">
									<sidebar>
										<div class="list-wrap overflow-hidden-x">
											@forelse ($messages as $message)
												@php
													Auth::id() != optional($message->sender)->id ? $user = optional($message->sender) :$user = optional($message->receiver);
												@endphp
												<div class="list p-2 conversassion" data-id="{{ optional($message->bookings)->id }}">
													<img src="{{ $user->profile_src }}" alt="user" />
													<div class="info">
														<h3 class="font-weight-700 "  >{{ $user->first_name }} <span class="text-muted text-12 text-right"> {{ $message->created_at->diffForHumans() }}</span></h3>
														<div class="d-flex justify-content-between">
															<div>
																<p class="text-muted text-14 mb-1 text pr-4">{{ substr(optional($message->properties)->name, 0,35)  }}</p>
																@if ($message->receiver_id == Auth::id())
																	<p class="text-14 m-0 {{ $message->read == 0  ? 'text-success font-weight-bold' : '' }}" id="msg-{{ optional($message->bookings)->id }}" ><i class="far fa-comment-alt"></i> {{ str_limit($message->message, 20) }} </p>
																@else
																	<p class="text-14 m-0" ><i class="far fa-comment-alt"></i> {{ str_limit($message->message, 20) }} </p>
																@endif


															</div>
														</div>
													</div>
												</div>
											@empty
												no conversassion
											@endforelse
										</div>
									</sidebar>

									<div class="content-inbox container-fluid p-0" id="messages">
										<header>
											@php
												$booking->host_id == Auth::id() ? $users ='users':$users ='host';
											@endphp
												<a href="{{ url('users/show/' . optional($booking->$users)->id) }}">
													<img src="{{ optional($booking->$users)->profile_src }}" alt="img" class="img-40x40" >
												</a>

												<div class="info">
													<div class="d-flex justify-content-between">
														<div>
															<span class="user">{{ optional($booking->$users)->full_name }}</span>
														</div>
													</div>
												</div>

												<div class="open">
													<i class="fas fa-inbox"></i>
													<a href="javascript:;">UP</a>
												</div>
										</header>

										<div class="message-wrap">
											@foreach ( $conversation as $con)
												<div class="{{ $con->receiver_id == Auth::id() ? 'message-list' : 'message-list me' }} message-list">
													<div class="msg pl-2 pr-2 pb-2 pt-2 mb-2">
														<p class="m-0">{{ $con->message }}</p>
													</div>
													<div class="time">{{ $con->created_at->diffForHumans() }}</div>
												</div>
											@endforeach
											<div class="message-list me">
												<div class="msg_txt mb-0"></div>
												<div class="time msg_time mt-0"></div>
											</div>
										</div>

										<div class="message-footer">
											<input type="text" class="cht_msg" data-placeholder="Send a message to {0}" />
											<a href="javascript:void(0)" class="btn btn-success chat text-18 send-btn" data-booking="{{ $booking->id }}" data-receiver="{{ $booking->$users->id }}" data-property="{{ $booking->property_id }}"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-3 card p-0 " id="booking">
								<div class="w-100 overflow-auto right-inbox p-3">
									<a href="{{ url('properties/' . optional($booking->properties)->slug) }}"><h4 class="text-left text-16 font-weight-700">{{ optional($booking->properties)->name }}</h4></a>
									<span class="street-address text-muted text-14">
										<i class="fas fa-map-marker-alt mr-2"></i>{{ optional($booking->properties)->property_address->address_line_1 }}
									</span>

									<div class="row">
										<div class="col-md-12 border p-2 rounded mt-2">
											<div class="d-flex  justify-content-between">
												<div>
													<div class="text-16"><strong>{{ __('Check In') }}</strong></div>
													<div class="text-14">{{ onlyFormat($booking->start_date) }}</div>
												</div>

												<div>
													<div class="text-16"><strong>{{ __('Check Out') }}</strong></div>
													<div class="text-14">{{ onlyFormat($booking->end_date) }}</div>
												</div>

											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12 col-sm-6 col-xs-6 border border-success pl-3 pr-3 text-center pt-3 pb-3 mt-3 rounded-3">
											<p class="text-16 font-weight-700 text-success pt-0 m-0">
												<i class="fas fa-bed text-20 d-none d-sm-inline-block pr-2 text-success"></i><strong>{{ $booking->guest }}</strong> {{ __('Guests') }} 
											</p>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-12 p-2">
											<h5 class="text-16 mt-3"><strong>{{ __('Payment') }}</strong></h5>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12 p-0">
											<div class="full-table mt-2 border text-dark rounded-3 pt-3 pb-3 mb-4 p-4">
												<p class="row margin-top10 text-justify text-16 mb-0">
													<span class="text-left col-sm-6 text-14">{!! moneyFormat($symbol, $booking->original_per_night) !!} x {{ $booking->total_night }} {{ __('night') }} </span>
													<span class="text-right col-sm-6 text-14">{!! moneyFormat($symbol, $booking->original_per_night * $booking->total_night) !!}</span>
												</p>

												<p class="row margin-top10 text-justify text-16 mb-0">
													<span class="text-left col-sm-6 text-14">{{ __('Service fee') }}</span>
													<span class="text-right col-sm-6 text-14">{!! moneyFormat($symbol, $booking->original_service_charge)!!}</span>
												</p>

												@if ($booking->accomodation_tax)
													<p class="row margin-top10 text-justify text-16 mb-0">
														<span class="text-left col-sm-6 text-14">{{ __('Accommodation Tax') }}</span>
														<span class="text-right col-sm-6 text-14">{!! moneyFormat($symbol, $booking->original_accomodation_tax)!!}</span>
													</p>
												@endif

												@if ($booking->iva_tax)
													<p class="row margin-top10 text-justify text-16 mb-0">
														<span class="text-left col-sm-6 text-14">{{ __('I.V.A Tax') }}</span>
														<span class="text-right col-sm-6 text-14">{!! moneyFormat($symbol, $booking->original_iva_tax)!!}</span>
													</p>
												@endif

                                                @if ($booking->cleaning_charge)
                                                    <p class="row margin-top10 text-justify text-16">
                                                        <span class="text-left col-sm-6 text-14">{{ __('Cleaning Fee') }}</span>
                                                        <span class="text-right col-sm-6 text-14">{!! moneyFormat($symbol, $booking->original_cleaning_charge)!!}</span>
                                                    </p>
                                                @endif

                                                @if ($booking->security_money)
                                                    <p class="row margin-top10 text-justify text-16">
                                                        <span class="text-left col-sm-6 text-14">{{ __('Security Fee') }}</span>
                                                        <span class="text-right col-sm-6 text-14">{!! moneyFormat($symbol, $booking->original_security_money)!!}</span>
                                                    </p>
                                                @endif

												<p class="row margin-top10 text-justify text-16 mb-0">
													<span class="text-left col-sm-6 text-14">{{ __('Total') }}</span>
													<span class="text-right col-sm-6 text-14">{!! moneyFormat($symbol, $booking->original_total)!!}</span>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					@else
						<div class="row jutify-content-center w-100 p-4 mt-4">
							<div class="text-center w-100">
								<img src="{{ asset('public/img/unnamed.png') }}" alt="notfound" class="img-fluid">
								<p class="text-center">{{ __('You don’t have any messages when you do, you’ll find them here.') }} </p>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
	<script type="text/javascript">
		'use strict'
		var token = "{{ csrf_token() }}";
	</script>
	<script src="{{ asset('public/js/inbox.min.js') }}"></script>
@endpush
