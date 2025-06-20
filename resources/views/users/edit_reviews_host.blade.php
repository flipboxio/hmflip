@extends('template')
@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		<!-- sidebar start-->
		@include('users.sidebar')
		<!--sidebar end-->
		<div class="col-lg-10 p-0">
			<div class="container-fluid min-height">
				<div class="col-md-12 mt-5 p-0">
					<div class="main-panel">
						<div class="row flex-column-reverse flex-md-row">
							<div class="col-md-9">
								<div class="mt-4 mt-sm-0 {{ $review_id ? 'display-off' : '' }} opening-div">
									<h3 class="font-weight-700">{{ __('Write a review for') }} {{ $result->users->first_name }}</h3>
									<div class="mt-3">
										<p class="text-justify">
										{{ __('You and your guest will only see your feedback from this trip once you have both completed a review.') }}
										{{ __('Be honest so that you help your guest plan for future trips on :x. Your review will also help other hosts know what to expect when they receive a reservation request from them.',['x'=>siteName()]) }}
										</p>

										<p class="text-justify">
										{{ __('You have 14 days to complete your reviews, and if only one of you has completed a review in that time, we’ll make it public after the review period ends.') }}
										</p>

										<button class="vrent-button  vbtn-success pl-4 pr-4 mb-4 rounded" id="open-review">
										{{ __('Write a Review') }}
										</button>
									</div>
								</div>

								<div class="mt-4 mt-sm-0 {{ $review_id ? '' : 'display-off' }} review-div">

									<form id="guest-form" method="post" class="edit_review">
										{{ csrf_field() }}
										<input type="hidden" value="{{ $review_id }}" name="review_id" id="review_id">
										<input type="hidden" value="{{ $result->id }}" name="booking_id" id="booking_id">
										<div class="form-group">
											<label for="message" class="font-weight-700">1. {{ __('Describe Your Experience') }} <span class="text-danger">*</span></label>
											<p class="text-15">{{ __('Your review will be public on :x’s profile.',['x'=>$result->users->first_name]) }}</p>
											<textarea rows="3" placeholder="{{ __('What was it like to host this guest?') }}" name="message" id="review_message" data-behavior="countable" cols="40" maxlength="500" class="form-control mb10">{{ isset($result->review_details($review_id)->message) ? $result->review_details($review_id)->message : '' }}</textarea>
											<span class="float-right">{{ __('500 words left') }}</span>
											<p class="text-15">{{ __('Make sure your review doesn’t include personal information (last name, address, contact information, etc.).') }}</p>
										</div>

										<div class="form-group">
											<label for="message" class="font-weight-700">2. {{ __('Private Guest Feedback') }}</label>
											<p class="text-15">{{ __('This feedback is just for your guest. We won’t make it public.') }}</p>
											<textarea rows="3" placeholder="{{ __('Thank your guest for visiting or offer some tips to help them improve for their next trip.') }}" name="secret_feedback" id="secret_feedback" cols="40" class="form-control mb10">{{ isset($result->review_details($review_id)->secret_feedback) ? $result->review_details($review_id)->secret_feedback : ''  }}</textarea>
										</div>

										<div class="form-group">
											<label for="message" class="font-weight-700">3. {{ __('Overall Experience') }}</label>
											<input type="hidden" name="rating" id="rating" value="{{ isset($result->review_details($review_id)->rating) ? $result->review_details($review_id)->rating : ''  }}">
											<div class="background ml-3">
											@for ($i=1; $i <=5 ; $i++)
												<i id="rating-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->rating) ? 'icon-beach':'icon-light-gray' }} icon-click"></i>
											@endfor
											</div>
										</div>

										<div class="form-group">
											<label for="message" class="font-weight-700">4. {{ __('Did the guest leave your space clean?') }}</label>
											<input type="hidden" name="cleanliness" id="cleanliness" value="{{ isset($result->review_details($review_id)->cleanliness) ? $result->review_details($review_id)->cleanliness : ''  }}">
											<div class="background ml-3">
											@for ($i=1; $i <=5 ; $i++)
												<i id="cleanliness-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->cleanliness) ? '':'icon-light-gray' }} icon-click"></i>
											@endfor
											</div>
										</div>

										<div class="form-group">
											<label for="message" class="font-weight-700">5. {{ __('How clearly did the guest communicate their plans, questions, and concerns?') }}</label>
											<input type="hidden" name="communication" id="communication" value="{{ isset($result->review_details($review_id)->communication) ? $result->review_details($review_id)->communication : '' }}">
											<div class="background ml-3">
											@for ($i=1; $i <=5 ; $i++)
												<i id="communication-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->communication) ? '':'icon-light-gray' }} icon-click"></i>
											@endfor
											</div>
										</div>



										<div class="form-group">
											<label for="message" class="font-weight-700">6. {{ __('Did the guest observe the house rules you provided?') }}</label>
											<input type="hidden" name="house_rules" id="house_rules" value="{{ isset($result->review_details($review_id)->house_rules) ? $result->review_details($review_id)->house_rules : '' }}">
											<div class="background ml-3">
											@for ($i=1; $i <=5 ; $i++)
												<i id="house_rules-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->house_rules) ? '':'icon-light-gray' }} icon-click"></i>
											@endfor
											</div>
										</div>

										<div class="form-group w-100  mt-5">
											<button class="btn vbtn-outline-success text-16 font-weight-700 pl-4 pr-4 pt-3 pb-3" type="submit" id="save_button">
												<i class="spinner fa fa-spinner fa-spin d-none"></i>
												<span id="save_button_text">{{ __('Submit') }}</span>
											</button>
										</div>
									</form>
								</div>
							</div>

							<div class="col-md-3">
								<div class="text-center card pt-3 pb-3">
									<a href="{{ url('users/show/' . $result->users->id) }}" title="{{ __('View Profile') }}">
										<div class='img-round'>
											<img src="{{ $result->users->profile_src }}" alt="{{ $result->users->first_name }}" class="rounded-circle img-100x100">
										</div>
									</a>

								<div class="add-photo"><a href="#" class="text-color text-color-hover font-weight-700">{{ $result->users->first_name }}</a></div>
									<div class="row">
										<div class="col-md-12 ">
										<small class="text-15 text-center">{{ __('Stayed at') }}
											{{ $result->properties->name }}</small>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('css')
	<link rel="stylesheet" href="{{ asset('public/css/user-front.min.css') }}">

@endpush

@section('validation_script')
<script type="text/javascript">
    'use strict'
    let submit = "{{ __('Submit') }}..";
</script>
<script type="text/javascript" src="{{ asset('public/js/front.min.js') }}"></script>
    
@endsection

