	@if ($reviewDetails->reviewer == 'host')
		<div class="col-md-12 p-0">
			<div class="container-fluid min-height">
				<div class="col-md-12  p-0">
					<div class="main-panel">
						<div class="row">
							<div class="col-md-12">
								<div class="review-div">
									<div class="form-group">
										<label for="message" class="font-weight-700">{{ __('Describe Your Experience') }} <span class="text-danger"></span></label>
										<p class="text-15">{{ $reviewDetails->message }}</p>
									</div>

									<div class="form-group">
										<label for="message" class="font-weight-700">{{ __('Private Guest Feedback') }}</label>
										<p class="text-15">{{ $reviewDetails->secret_feedback }}</p>
									</div>

									<div class="form-group">
										<label for="message" class="font-weight-700">{{ __('Did the guest leave your space clean?') }}</label>
										<div class="background   text-15"  >
											@for ($i=1; $i <=5 ; $i++)
												@if ($reviewDetails->cleanliness >= $i)
													<i class="fa fa-star icon-beach"></i>
												@else
													<i class="fa fa-star"></i>
												@endif
											@endfor
										</div>
										<p class="text-15">{{ $reviewDetails->cleanliness_message }}</p>
									</div>

									<div class="form-group">
										<label for="message" class="font-weight-700">{{ __('How clearly did the guest communicate their plans, questions, and concerns?') }}</label>
										<div class="background mb20 text-15"  >
											@for ($i=1; $i <=5 ; $i++)
												@if ($reviewDetails->communication >= $i)
													<i class="fa fa-star icon-beach"></i>
												@else
													<i class="fa fa-star"></i>
												@endif
											@endfor
										</div>
										<p class="text-15">{{ $reviewDetails->communication_message }}</p>
									</div>

									<div class="form-group">
										<label for="message" class="font-weight-700">{{ __('Did the guest observe the house rules you provided?') }}</label>
										<div class="background text-15"  >
											@for ($i=1; $i <=5 ; $i++)
												@if ($reviewDetails->house_rules >= $i)
													<i class="fa fa-star icon-beach"></i>
												@else
													<i class="fa fa-star"></i>
												@endif
											@endfor
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
	<div class="col-md-12 p-0">
		<div class="container-fluid">
			<div class="col-md-12  p-0">
				<div class="main-panel">
					<div class="row">
						<div class="col-md-6">
							<div class="review-div">
								<div class="form-group">
									<label for="message" class="font-weight-700">{{ __('Describe Your Experience') }} <span class="text-danger"></span></label>
									<div class="background text-15"  >
										@for ($i=1; $i <=5 ; $i++)
											@if ($reviewDetails->rating >= $i)
												<i class="fa fa-star icon-beach"></i>
											@else
												<i class="fa fa-star"></i>
											@endif
										@endfor
									</div>
									<p class="text-15">{{ $reviewDetails->message }}</p>
								</div>

								<div class="form-group">
									<label for="message" class="font-weight-700">{{ __('Communication feedback') }}</label>
									<div class="background text-15"  >
										@for ($i=1; $i <=5 ; $i++)
											@if ($reviewDetails->communication >= $i)
												<i class="fa fa-star icon-beach"></i>
											@else
												<i class="fa fa-star"></i>
											@endif
										@endfor
									</div>
									<p class="text-15">{{ $reviewDetails->communication_message }}</p>
								</div>

								<div class="form-group">
									<label for="message" class="font-weight-700">{{ __('How accurately did the photos &amp; description represent the actual space?') }}</label>
									<div class="background text-15"  >
										@for ($i=1; $i <=5 ; $i++)
											@if ($reviewDetails->accuracy >= $i)
												<i class="fa fa-star icon-beach"></i>
											@else
												<i class="fa fa-star"></i>
											@endif
										@endfor
									</div>
									<p class="text-15">{{ $reviewDetails->accuracy_message }}</p>
								</div>

								<div class="form-group">
									<label for="message" class="font-weight-700">{{ __('How appealing is the neighborhood? Consider safety, convenience, and desirability.') }}</label>
									<div class="background text-15"  >
										@for ($i=1; $i <=5 ; $i++)
											@if ($reviewDetails->location >= $i)
												<i class="fa fa-star icon-beach"></i>
											@else
												<i class="fa fa-star"></i>
											@endif
										@endfor
									</div>
									<p class="text-15">{{ $reviewDetails->location_message }}</p>
								</div>

								<div class="form-group">
									<label for="message" class="font-weight-700">{{ __('Private Guest Feedback') }}</label>
									<p class="text-15">{{ $reviewDetails->secret_feedback }}</p>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="review-div">
								<div class="form-group">
									<label for="message" class="font-weight-700">{{ __('Check In') }}</label>
									<div class="background text-15"  >
										@for ($i=1; $i <=5 ; $i++)
											@if ($reviewDetails->checkin >= $i)
												<i class="fa fa-star icon-beach"></i>
											@else
												<i class="fa fa-star"></i>
											@endif
										@endfor
									</div>
									<p class="text-15">{{ $reviewDetails->checkin_message }}</p>
								</div>

								<div class="form-group">
									<label for="message" class="font-weight-700">{{ __('Did your host provide everything they promised in their listing description?') }}</label>
									<div class="background text-15"  >
										@for ($i=1; $i <=5 ; $i++)
											@if ($reviewDetails->amenities >= $i)
												<i class="fa fa-star icon-beach"></i>
											@else
												<i class="fa fa-star"></i>
											@endif
										@endfor
									</div>
									<p class="text-15">{{ $reviewDetails->amenities_message }}</p>
								</div>

								<div class="form-group">
									<label for="message" class="font-weight-700">{{ __('Cleanliness feedback') }}</label>
									<div class="background text-15"  >
										@for ($i=1; $i <=5 ; $i++)
											@if ($reviewDetails->cleanliness >= $i)
												<i class="fa fa-star icon-beach"></i>
											@else
												<i class="fa fa-star"></i>
											@endif
										@endfor
									</div>
									<p class="text-15">{{ $reviewDetails->value_message }}</p>
								</div>

								<div class="form-group">
									<label for="message" class="font-weight-700">{{ __('How would you rate the value of the listing?') }}</label>
									<div class="background text-15"  >
										@for ($i=1; $i <=5 ; $i++)
											@if ($reviewDetails->value >= $i)
												<i class="fa fa-star icon-beach"></i>
											@else
												<i class="fa fa-star"></i>
											@endif
										@endfor
									</div>
									<p class="text-15">{{ $reviewDetails->cleanliness_message }}</p>
								</div>

								<div class="form-group">
									<label for="message" class="font-weight-700">{{ __('How can your host improve?') }}</label>
									<p class="text-15">{{ $reviewDetails->improve_message }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif


