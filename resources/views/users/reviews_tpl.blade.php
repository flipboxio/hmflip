@extends('template')
@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		<!-- sidebar start-->
		@include('users.sidebar')
		<!--sidebar end-->
		<div class="col-lg-10 p-0">
			<div class="main-panel">
				<div class="container-fluid">
					<div class="col-md-12 mt-4 p-0">
						<div class="main-panel min-height">
							<div class="row">
								<div class="col-md-12 pt-0 mb-3">
									<div class="list-bacground  rounded-3 p-4 border">
										<span class="text-18 pt-4 pb-4 font-weight-700">{{ __('Review About You') }}</span>
									</div>
								</div>
							</div>

							<div class="row justify-content-center">
								<div class="col-md-12">
									@if ($reviewsAboutYou->count())
										@for ($i=0; $i<$reviewsAboutYou->count(); $i++)
											@if (!$reviewsAboutYou[$i]->hidden_review)
												<div class="row mt-4 border rounded-3">
													<div class="col-md-3 col-xl-4 pl-0 pr-0">
														<div class="img-event p-3">
															<a href="{{ url('properties/' . $reviewsAboutYou[$i]->properties->slug) }}">
																<img class="room-image-container200 rounded" src="{{ $reviewsAboutYou[$i]->properties->cover_photo }}" alt="img">
															</a>
														</div>
													</div>

													<div class="col-md-9 col-xl-8 pl-3 pr-3">
														<div class="row align-items-center pt-2 pb-2">
															<a href="{{ url('properties/' . $reviewsAboutYou[$i]->properties->slug) }}"><p class="font-weight-700 mb-0">{{ $reviewsAboutYou[$i]->properties->name }} </p></a>
														</div>

														<div class="row align-items-center pt-2 pb-2">
															<div class="col p-0">
																<p class="text-15 mt-2">{{ str_limit($reviewsAboutYou[$i]->message, 210) }}</p>

																<button class="btn vbtn-outline-success pl-4 pr-4 pt-2 pb-2 text-14 review_detials" data-name="{{ $reviewsAboutYou[$i]->properties->name }}"
																	data-toggle="modal"  data-id="{{ $reviewsAboutYou[$i]->id }}" data-target="#myModal"   >
																	{{ __('View Details') }}
																</button>

																<p class="text-14 mt-3"><i class="far fa-clock"></i> {{ $reviewsAboutYou[$i]->created_at->diffForHumans() }}</p>
															</div>

															<div class="pr-4">
																<div class="row justify-content-center">
																	<div class='img-round '>
																		<a href="{{ url('users/show/' . $reviewsAboutYou[$i]->users->id) }}">
																			<img src="{{ $reviewsAboutYou[$i]->users->profile_src }}" alt="{{ $reviewsAboutYou[$i]->users->first_name }}" class="rounded-circle img-70x70">
																		</a>
																	</div>
																</div>

																<p class="text-center font-weight-700 mb-0">
																	<a href="{{ url('users/show/' . $reviewsAboutYou[$i]->users->id) }}" class="text-color text-color-hover">
																		{{ $reviewsAboutYou[$i]->users->first_name }}
																	</a>
																</p>
															</div>
														</div>
													</div>
												</div>
											@else
												<div class="row mt-4 border">
													<div class="col-md-3 col-xl-4 pl-0 pr-0">
														<div class="img-event p-3">
															<a href="{{ url('properties/' . $reviewsAboutYou[$i]->properties->slug) }}">
																<img class="img-fluid rounded" src="{{ $reviewsAboutYou[$i]->properties->cover_photo }}" alt="img">
															</a>
														</div>
													</div>

													<div class="col-md-9 col-xl-8 p-3 pr-3">
														<div class="row align-items-center pt-2 pb-2">
															<a href="{{ url('properties/' . $reviewsAboutYou[$i]->properties->slug) }}"><p class="font-weight-700 mb-0">{{ $reviewsAboutYou[$i]->properties->name }} </p></a>
														</div>
														<div class="row align-items-center pt-2 pb-2">
															<div class="col p-0">
																<p class="text-16"> <i class="fas fa-exclamation-triangle  text-warning"></i> {{ __('Review is hidden. ') }} {{ __('Please complete your part of the review to make it visible.') }}</p>
																@if (empty($reviewsAboutYou[$i]->properties->deleted_at) || !empty($reviewsAboutYou[$i]->bookings))
                                                                  <a href="{{ url('reviews/edit/' . $reviewsAboutYou[$i]->booking_id) }}" class="mt-2">
                                                                      <button class="vrent-button button-default vbtn-success pl-4 pr-4 pt-2 pb-2">
                                                                          {{ __('Complete review') }}
                                                                      </button>
                                                                  </a>
                                                              	@else
                                                              		<p class="text-16 text-danger"> {{ __("Property or booking data is missing, you cannot proceed further.") }}</p>
                                                              	@endif
																<p class="text-14 mt-3"><i class="far fa-clock"></i> {{ $reviewsAboutYou[$i]->created_at->diffForHumans() }}</p>
															</div>

															<div class="pr-4">
																<div class="row justify-content-center">
																	<div class='img-round '>
																		<a href="{{ url('users/show/' . $reviewsAboutYou[$i]->sender_id) }}">
																			<img src="{{ $reviewsAboutYou[$i]->users->profile_src }}" alt="{{ $reviewsAboutYou[$i]->users->first_name }}" class="rounded-circle img-70x70">
																		</a>
																	</div>
																</div>

																<p class="text-center font-weight-700 mb-0">
																	<a href="{{ url('users/show/' . $reviewsAboutYou[$i]->sender_id) }}" class="text-color text-color-hover">
																		{{ $reviewsAboutYou[$i]->users->first_name }}
																	</a>
																</p>
															</div>
														</div>
													</div>
												</div>
											@endif
										@endfor
									@else
										<div class="row jutify-content-center w-100 p-4 mt-4">
											<div class="text-center w-100">
												<img src="{{ asset('public/img/unnamed.png') }}" class="img-fluid"  alt="notfound">
												<p class="text-center">{{ __('No one has reviewed you yet.') }}</p>
											</div>
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="myModal">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title font-weight-700" id="name" >Property </h2>
				<button type="button" class="close text-28" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div id="heading">
				</div>
			</div>

			<div class="modal-footer ">
				<pre> </pre>
			</div>
		</div>
	</div>
</div>
@endsection

@section('validation_script')
<script type="text/javascript">
    'use strict'
    var token = "{{ csrf_token() }}";
</script>
<script type="text/javascript" src="{{ asset('public/js/front.min.js') }}"></script>
    
@endsection
