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
						<div class="row mt-5">
							<div class="col-md-12 p-0">
								<div class="container-fluid">
									<div class="row flex-column-reverse flex-md-row">
										<div class="col-md-8 border rounded-3 p-4 mb-5">
											<div class="panel panel-default {{ $review_id ? 'display-off' : '' }} opening-div">
												<div class="panel-body text-18 font-weight-700 pb-2">
													{{ __('Write a review for :x',['x' => $result->properties->users->first_name]) }}
												</div>

												<div class="panel-footer text-16">
													<p>
														{{ __('You and your host will only see your feedback from this trip once you have both completed a review.') }}
														{{ __('An honest review will help your host provide a better experience, and it will help travelers when they’re selecting a place to stay.') }}
													</p>
													<p>
														{{ __('You have 14 days to complete your reviews, and if only one of you has completed a review in that time, we’ll make it public after the review period ends.') }}
													</p>
													<button class="btn vbtn-outline-success text-16 font-weight-700 p-0 mt-2 pl-4 pr-4 pt-2 pb-2" id="open-review">
														{{ __('Write a Review') }}
													</button>
												</div>
											</div>

											<div class="panel panel-default {{ $review_id ? '' : 'display-off' }} review-div">
												<input type="hidden" value="{{ $review_id }}" name="review_id" id="review_id">
												<input type="hidden" value="{{ $result->id }}" name="booking_id" id="booking_id">

												<div class="panel-footer">
													<p class="font-weight-700">{{ __('Your host will not know how you respond to these') }}</p>
													<form id="guest-review-form1" method="post" class="edit_review">
														{{ csrf_field() }}
														<div id="review-guest-1">
															<input type="hidden" value="host_summary" name="section" id="section">
															<div class="input-fields">
																<h4 class="text-16 font-weight-700">{{ __('Describe Your Experience') }} <span class="text-danger">*</span></h4>
																<p class="mt-4">{{ __('Your review will be public on your host’s profile and your host’s listing page. If you have additional feedback that you don’t want to make public, you can share it with :x on the next page.',['x'=>siteName()]) }}</p>
																<textarea rows="5" placeholder="{{ __('How did your host make you feel welcome? Was the listing description accurate? What was the neighborhood like?') }}" name="message" id="message" data-behavior="countable" cols="40" maxlength="500" class="form-control mb10 mt-2">{{ isset($result->review_details($review_id)->message) ? $result->review_details($review_id)->message : '' }}</textarea>
																<span class="float-right">{{ __('500 words left') }}</span>

																<span class="error-msg text-12 d-none text-danger" id='error-comments'>{{ __('This field is required.') }}</span>
															</div>

															<div class="input-fields mt-5">
																<h4 class="text-16 font-weight-700">{{ __('Private Host Feedback') }}</h4>
																<p class="mt-4">{{ __('We won’t make it public and your feedback will only be shared with your host, :x employees and its service providers',['x'=> siteName()]) }}</p>
																<div class="row-space-2">
																	<h4>{{ __('What did you love about staying at this listing?') }}</h4>
																	<textarea rows="5" name="secret_feedback" id="secret_feedback" class="form-control mt-2">{{ isset($result->review_details($review_id)->secret_feedback) ? $result->review_details($review_id)->secret_feedback : '' }}</textarea>
																</div>
																<div class="mt-4">
																	<h4>{{ __('How can your host improve?') }}</h4>
																	<textarea rows="5" name="improve_message" id="improve_message" class="form-control mt-2">{{ isset($result->review_details($review_id)->improve_message) ? $result->review_details($review_id)->improve_message : '' }}</textarea>
																</div>
															</div>

															<div class="input-fields mt-4">
																<h4 class="text-16 font-weight-700">{{ __('Overall Experience') }}<span class="text-danger">*</span></h4>
																<input type="hidden" name="rating" id="rating" value="{{ isset($result->review_details($review_id)->rating) ? $result->review_details($review_id)->rating : '' }}">
																<div class="background text-16">
																	@for ($i=1; $i <=5 ; $i++)
																		<i id="rating-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->rating) ? 'icon-beach':'icon-light-gray' }} icon-click"></i>
																	@endfor
																</div>
																<span class="error-msg d-none" id='error-rating'>{{ __('This field is required.') }}</span>
															</div>

															<div class="mt-4 mb-4 text-right">
																<button class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3" type="submit" id="btn_next">
																 <i class="spinner fa fa-spinner fa-spin d-none" id="btn_spin"></i>
																 <span id="btnnext-text1">{{ __('Next') }}</span>
																</button>
															</div>
														</div>
													</form>

													<form id="guest-review-form2" method="post" class="edit_review">
														{{ csrf_field() }}
														<div id="review-guest-2" class="display-off">
															<div class="input-fields">
																<h4 class="text-16 font-weight-700">{{ __('Accuracy') }}</h4>
																<p class="mt-2">{!! __('How accurately did the photos &amp; description represent the actual space?') !!}</p>
																<input type="hidden" name="accuracy" id="accuracy" value="{{ isset($result->review_details($review_id)->accuracy) ? $result->review_details($review_id)->accuracy : '' }}">
																<div class="background text-16" >
																	@for ($i=1; $i <=5 ; $i++)
																		<i id="accuracy-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->accuracy) ? 'icon-beach':'icon-light-gray' }} icon-click"></i>
																	@endfor
																</div>
																<p>{{ __('Tell this host how they could make their listing page more accurate. We\'ll send them your suggestions.') }}</p>
																<textarea rows="2" placeholder="{{ __('Accuracy') }}" name="accuracy_message" id="accuracy_message" cols="40" class="form-control mb10">{{ isset($result->review_details($review_id)->accuracy_message) ? $result->review_details($review_id)->accuracy_message : '' }}</textarea>
															</div>

															<div class="input-fields mt-4">
																<h4 class="text-16 font-weight-700">{{ __('Cleanliness') }}</h4>
																<p class="mt-2">{{ __('Was the space as clean as you expect a listing to be?') }}</p>
																<input type="hidden" name="cleanliness" id="cleanliness" value="{{ isset($result->review_details($review_id)->cleanliness) ? $result->review_details($review_id)->cleanliness : '' }}">
																<div class="background text-16">
																	@for ($i=1; $i <=5 ; $i++)
																		<i id="cleanliness-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->cleanliness) ? 'icon-beach':'icon-light-gray' }} icon-click"></i>
																	@endfor
																</div>
																<p>{{ __("Tell this host how they could improve their cleanliness. We'll send them your suggestions.") }}</p>
																<textarea rows="2" placeholder="{{ __('Cleanliness') }}" name="cleanliness_message" id="cleanliness_message" cols="40" class="form-control mb10">{{ isset($result->review_details($review_id)->cleanliness_message) ? $result->review_details($review_id)->cleanliness_message : '' }}</textarea>
															</div>

															<div class="input-fields mt-4">
																<h4 class="text-16 font-weight-700">{{ __('Arrival') }}</h4>
																<p class="mt-2">{{ __('Did the host do everything within their control to provide you with a smooth arrival process?') }}</p>
																<input type="hidden" name="checkin" id="checkin" value="{{ isset($result->review_details($review_id)->checkin) ? $result->review_details($review_id)->checkin : ''  }}">
																<div class="background text-16">
																	@for ($i=1; $i <=5 ; $i++)
																		<i id="checkin-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->checkin) ? 'icon-beach':'icon-light-gray' }} icon-click"></i>
																	@endfor
																</div>
																<p>{{ __("Tell this host how they could make their guest's arrival better. We'll send them your suggestions.") }}</p>
																<textarea rows="2" placeholder="{{ __('Arrival') }}" name="checkin_message" id="checkin_message" cols="40" class="form-control mb10">{{ isset($result->review_details($review_id)->checkin_message) ? $result->review_details($review_id)->checkin_message : ''  }}</textarea>
															</div>

															<div class="input-fields mt-4">
																<h4 class="text-16 font-weight-700">{{ __('Amenities') }}</h4>
																<p class="mt-2">{{ __('Did your host provide everything they promised in their listing description?') }}</p>
																<input type="hidden" name="amenities" id="amenities" value="{{ isset($result->review_details($review_id)->amenities) ? $result->review_details($review_id)->amenities : '' }}">
																<div class="background text-16">
																	@for ($i=1; $i <=5 ; $i++)
																		<i id="amenities-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->amenities) ? 'icon-beach':'icon-light-gray' }} icon-click"></i>
																	@endfor
																</div>
																<p>{{ __('Tell this host how they could improve their amenities. We\'ll send them your suggestions.') }}</p>
																<textarea rows="2" placeholder="{{ __('Amenities') }}" name="amenities_message" id="amenities_message" cols="40" class="form-control mb10">{{ isset($result->review_details($review_id)->amenities_message) ? $result->review_details($review_id)->amenities_message : '' }}</textarea>
															</div>

															<div class="input-fields mt-4">
																<h4 class="text-16 font-weight-700">{{ __('Communication') }}</h4>
																<p class="mt-2">{{ __('How responsive and accessible was the host before and during your stay?') }}</p>
																<input type="hidden" name="communication" id="communication" value="{{ isset($result->review_details($review_id)->communication) ? $result->review_details($review_id)->communication : ''  }}">
																<div class="background text-16">
																	@for ($i=1; $i <=5 ; $i++)
																		<i id="communication-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->communication) ? 'icon-beach':'icon-light-gray' }} icon-click"></i>
																	@endfor
																</div>
																<p>{{ __("Tell this host how they could improve their communication. We\'ll send them your suggestions.") }}</p>
																<textarea rows="2" placeholder="{{ __('Communication') }}" name="communication_message" id="communication_message" cols="40" class="form-control mb10">{{ isset($result->review_details($review_id)->communication_message) ? $result->review_details($review_id)->communication_message : ''  }}</textarea>
															</div>

															<div class="input-fields mt-4">
																<h4 class="text-16 font-weight-700">{{ __('Location') }}</h4>
																<p class="mb10">{{ __('How appealing is the neighborhood? Consider safety, convenience, and desirability.') }}</p>
																<input type="hidden" name="location" id="location" value="{{ isset($result->review_details($review_id)->location) ? $result->review_details($review_id)->location : ''  }}">
																<div class="background text-16">
																	@for ($i=1; $i <=5 ; $i++)
																		<i id="location-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->location) ? 'icon-beach':'icon-light-gray' }} icon-click"></i>
																	@endfor
																</div>
																<p>{{ __("Tell this host how they could better describe their location. We\'ll send them your suggestions.") }}</p>
																<textarea rows="2" placeholder="{{ __('Location') }}" name="location_message" id="location_message" cols="40" class="form-control mb10">{{ isset($result->review_details($review_id)->location_message) ? $result->review_details($review_id)->location_message : ''  }}</textarea>
															</div>

															<div class="input-fields mt-4">
																<h4 class="text-16 font-weight-700">{{ __('Value') }}</h4>
																<p class="mb10">{{ __('How would you rate the value of the listing?') }}</p>
																<input type="hidden" name="value" id="value" value="{{ isset($result->review_details($review_id)->value) ? $result->review_details($review_id)->value : ''  }}">
																<div class="background text-16">
																	@for ($i=1; $i <=5 ; $i++)
																		<i id="value-{{ $i }}" class="fa fa-star {{ $i <= isset($result->review_details($review_id)->value) ? 'icon-beach':'icon-light-gray' }} icon-click"></i>
																	@endfor
																</div>
																<p>{{ __("Tell this host how they could improve the value they provide. We'll send them your suggestions.") }}</p>
																<textarea rows="2" placeholder="{{ __('Value') }}" name="value_message" id="value_message" cols="40" class="form-control mb10">{{ isset($result->review_details($review_id)->value_message) ? $result->review_details($review_id)->value_message : '' }}</textarea>
															</div>

															<div class="mt-4 mb-4 text-right">
																<button class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 " id="btn_submit" type="submit">
																	<i class="spinner fa fa-spinner fa-spin d-none" id="btn_spin2"></i>

																	<span id="btnnext-text2">{{ __('Submit') }}</span>


																</button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>

										<div class="col-md-4">
											<div class="border rounded-3 p-4">
												<a href="{{ url('properties/' . $result->property_id) }}" alt="{{ $result->properties->name }}" class="media-cover">
													<img class="img-fluid" src="{{ $result->properties->cover_photo }}" alt="coverphoto">
												</a>
												<div class="mt-3">
													<div class="col-xs-12 mb20 l-pad-none r-pad-none">
														<div class="font-weight-700"><a href="{{ url('properties/' . $result->property_id) }}" alt="{{ $result->properties->name }}" class="media-cover" target="_blank">{{ $result->properties->name }}</a></div>
														<div class="location-title">{{ __('Hosted by') }} <a href="{{ url('users/show/' . $result->host_id) }}" class="media-cover" target="_blank">{{ $result->properties->users->full_name }}</a></div>
														<div class="text-muted">{{ $result->dates }}</div>
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
			</div>
		</div>
	</div>
</div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('public/css/user-front.min.css') }}">
@endpush


@section('validation_script')
<script>
	let nextText = "{{ __('Next') }}..";
	let submitText = "{{ __('Submit') }}..";
</script>
<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/main.js') }}"></script>	
@endsection

