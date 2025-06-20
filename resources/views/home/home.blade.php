@extends('template')
@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('public/css/daterangepicker.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('public/css/user-front.min.css') }}" />
    
@endpush

@section('main')
	<input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type') }}">
	<section class="hero-banner magic-ball">
		<div class="main-banner"  style="background-image: url('{{ getBanner() }}');">
			<div class="container">
				<div class="row align-items-center text-center text-md-left">
					<div class="col-md-6 col-lg-5 mb-5 mb-md-0">
						<div class="main_formbg item animated zoomIn mt-80">
							<h1 class="pt-4 ">{{ __('Make Your Reservation') }}</h1>
							<form id="front-search-form" method="post" action="{{ url('search') }}">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-12">
										<div class="input-group pt-4">
											<input class="form-control p-3 text-14" id="front-search-field" placeholder="{{ __('Where do you want to go?') }}" autocomplete="off" name="location" type="text" required>
										</div>
									</div>

									<div class="col-md-12 mt-5">
										<div class="d-flex" id="daterange-btn">
											<div class="input-group mr-2 pt-4" >
												<input class="form-control p-3 border-right-0 border text-14 checkinout" name="checkin" id="startDate" type="text" placeholder="{{ __('Check In') }}" autocomplete="off" readonly="readonly" required>
												<span class="input-group-append">
													<div class="input-group-text">
														<i class="fa fa-calendar success-text text-14"></i>
													</div>
												</span>
											</div>

											<div class="input-group ml-2 pt-4">
												<input class="form-control p-3 border-right-0 border text-14 checkinout" name="checkout" id="endDate" placeholder="{{ __('Check Out') }}" type="text" readonly="readonly" required>
												<span class="input-group-append">
													<div class="input-group-text">
													<i class="fa fa-calendar success-text text-14"></i>
													</div>
												</span>
											</div>
										</div>
									</div>

									<div class="col-md-6 mt-5 pt-4">
										<div class="input-group">
											<select id="front-search-guests" name="guest" class="form-control  text-14">
											<option class="p-4 text-14" value="1">1 {{ __('Guest') }}</option>
											@for ($i=2;$i<=16;$i++)
												<option  class="p-4 text-14" value="{{ $i }}"> {{ ($i == '16') ? $i . '+ '.__('Guest') : $i . ' ' . __('Guests') }} </option>
											@endfor
											</select>
										</div>
									</div>

									<div class="col-md-12 front-search mt-5 pb-3 pt-4">
										<button type="submit" class="btn vbtn-default btn-block p-3 text-16">{{ __('Search') }}</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	@if (!$starting_cities->isEmpty())
	<section class="bg-gray mt-70 pb-2">
		<div class="container-fluid container-fluid-90">
			<div class="row">
				<div class="section-intro text-center">
					<p class="item animated fadeIn text-24 font-weight-700 m-0 text-capitalize">{{ __('Top Destination') }}</p>
					<p class="mt-3">{{ __('Best places where to live in the world and enjoy your trip') }} </p>
				</div>
			</div>

			<div class="row mt-2">
				@foreach ($starting_cities as $city)
				<div class="col-md-4 mt-5">
				<a href="{{ url('search?location=' . $city->name . '&checkin=&checkout=&guest=1') }}">
						<div class="grid item animated zoomIn">
							<figure class="effect-ming">
								<img src="{{ $city->image_url }}" alt="city"/>
									<figcaption>
										<p class="text-18 font-weight-700 position-center">{{ $city->name }}</p>
									</figcaption>
							</figure>
						</div>
					</a>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif

	@if (!$properties->isEmpty())
		<section class="recommandedbg bg-gray mt-4 magic-ball magic-ball-about pb-5">
			<div class="container-fluid container-fluid-90">
				<div class="row">
					<div class="recommandedhead section-intro text-center mt-70">
						<p class="item animated fadeIn text-24 font-weight-700 m-0">{{ __('Recommended Home') }}</p>
						<p class="mt-2">{{ __('Alluring home where you can stay and enjoy a comfortable life.') }}</p>
					</div>
				</div>

				<div class="row mt-5">
					@foreach ($properties as $property)
					<div class="col-md-6 col-lg-4 col-xl-3 pl-3 pr-3 pb-3 mt-4">
						<div class="card h-100 card-shadow card-1">
							<div class="grid">
								<a href="properties/{{ $property->slug }}" aria-label="{{ $property->name }}">
									<figure class="effect-milo">
										<img src="{{ $property->cover_photo }}" class="room-image-container200" alt="{{ $property->name }}"/>
										<figcaption>
										</figcaption>
									</figure>
								</a>
							</div>

							<div class="card-body p-0 pl-1 pr-1">
								<div class="d-flex">
									<div>
										<div class="profile-img pl-2">
											<a href="{{ url('users/show/' . $property->host_id) }}"><img src="{{ $property->users->profile_src }}" alt="{{ $property->name }}" class="img-fluid"></a>
										</div>
									</div>

									<div class="p-2 text">
										<a class="text-color text-color-hover" href="properties/{{ $property->slug }}">
											<p class="text-16 font-weight-700 text"> {{ $property->name }}</p>
										</a>
										<p class="text-13 mt-2 mb-0 text"><i class="fas fa-map-marker-alt"></i> {{ $property->property_address->city }}</p>
									</div>
								</div>

								<div class="review-0 p-3">
									<div class="d-flex justify-content-between">

										<div class="d-flex">
                                            <div class="d-flex align-items-center">
											<span><i class="fa fa-star text-14 secondary-text-color"></i>
												@if ( $property->guest_review)
                                                    {{ $property->avg_rating }}
                                                @else
                                                    0
                                                @endif
                                                ({{ $property->guest_review }})</span>
                                            </div>

                                            <div class="">
                                                @auth
                                                    <a class="btn btn-sm book_mark_change"
                                                       data-status="{{ $property->book_mark }}" data-id="{{ $property->id }}"
                                                       style="color:{{ ($property->book_mark == true) ? '#1dbf73':'' }}; ">
                                                    <span style="font-size: 22px;">
                                                        <i class="fas fa-heart pl-2"></i>
                                                    </span>
                                                    </a>
												@else
													<a class="btn btn-sm book_mark_change" data-id="{{ $property->id }}"
														style="color:#1dbf73 }}; ">
														<span style="font-size: 22px;">	
															<i class="fas fa-heart pl-2"></i>
														</span>
													</a>
                                                @endauth
                                            </div>
                                        </div>


										<div>
											<span class="font-weight-700">{!! moneyFormat( $property->property_price->default_symbol, $property->property_price->price) !!}</span> / {{ __('night') }}
										</div>
									</div>
								</div>

								<div class="card-footer text-muted p-0 border-0">
									<div class="d-flex bg-white justify-content-between pl-2 pr-2 pt-2 mb-3">
										<div>
											<ul class="list-inline">
												<li class="list-inline-item  pl-4 pr-4 border rounded-3 mt-2 bg-light text-dark">
														<div class="vtooltip"> <i class="fas fa-user-friends"></i> {{ $property->accommodates }}
														<span class="vtooltiptext text-14">{{ $property->accommodates }} {{ __('Guests') }}</span>
													</div>
												</li>

												<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-2 bg-light">
													<div class="vtooltip"> <i class="fas fa-bed"></i> {{ $property->bedrooms }}
														<span class="vtooltiptext  text-14">{{ $property->bedrooms }} {{ __('Bedrooms') }}</span>
													</div>
												</li>

												<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-2 bg-light">
													<div class="vtooltip"> <i class="fas fa-bath"></i> {{ $property->bathrooms }}
														<span class="vtooltiptext  text-14 p-2">{{ $property->bathrooms }} {{ __('Bathrooms') }}</span>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</section>
	@endif
	@if (!$testimonials->isEmpty())
	<section class="testimonialbg pb-70">
		<div class="testimonials">
			<div class="container">
				<div class="row">
					<div class="recommandedhead section-intro text-center mt-70">
						<p class="animated fadeIn text-24 text-color font-weight-700 m-0">{{ __('Say about Us') }}</p>
						<p class="mt-2">{{ __('People Say The Nicest Things') }}</p>
					</div>
				</div>

				<div class="row mt-5">
					@foreach ($testimonials as $testimonial)
					<?php $i = 0; ?>
						<div class="col-md-4 mt-4">
							<div class="item h-100 card-1">
								<img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}">
								<div class="name">{{ $testimonial->name }}</div>
									<small class="desig">{{ $testimonial->designation }}</small>
									<p class="details">{{ substr($testimonial->description, 0, 200) }} </p>
									<ul>
										@for ($i = 0; $i < 5; $i++)
											@if ($testimonial->review >$i)
												<li><i class="fa fa-star secondary-text-color" aria-hidden="true"></i></li>
											@else
												<li><i class="fa fa-star rating" aria-hidden="true"></i></li>
											@endif
										@endfor
									</ul>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</section>
	@endif
@stop

@section('validation_script')
	<script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ config("vrent.google_map_key") }}&libraries=places'></script>
	<script type="text/javascript" src="{{ asset('public/js/moment.min.js') }}"></script>
	<script src="{{ asset('public/js/sweetalert.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/daterangepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/daterangecustom.js') }}"></script>
    <script type="text/javascript">
        'use strict'
        var success = "{{ __('Success') }}";
        var yes = "{{ __('Yes') }}";
        var no = "{{ __('No') }}";
        var user_id = "{{ Auth::id() }}";
        var token = "{{ csrf_token() }}";
        var add = "{{ __('Add to Favourite List ?') }}";
        var remove = "{{ __('Remove from Favourite List ?') }}";
        var added = "{{ __('Added to favourite list.') }}";
        var removed = "{{ __('Removed from favourite list.') }}";
        var dateFormat = '{{ $date_format }}';
		const BaseURL = '{{ url("/") }}';
    </script>
    <script src="{{ asset('public/js/front.min.js') }}"></script>
    
@endsection


