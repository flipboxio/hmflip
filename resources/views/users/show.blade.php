@extends('template')
@section('main')
<div class="container-fluid container-fluid-90 margin-top-85 mb-5 p-0">
	<div class="row m-0">
		<div class="col-md-3 mt-4">
			<div class="row border rounded p-3">
				<div class="col-md-12 text-center">
					<img src="{{ $result->profile_src }}" title="{{ $result->first_name }}" class="img-fluid mt-2 p-5" alt="{{ $result->first_name }}" >
				</div>

				<div class="col-md-12 text-center p-0">
					@if ($result->id == Auth::user()->id )
						@if ((Auth::user()->users_verification->email == 'no') || (Auth::user()->users_verification->facebook == 'no') || (Auth::user()->users_verification->google == 'no'))
							<a href="{{ url('users/edit-verification') }}">
								<button  class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 mb-4">{{ __('Complete Profile') }}</button>
							</a>
						@else
							<i class="fa fa-check-circle fa-3x text-success" aria-hidden="true"></i>
						@endif
					@endif

					<h2 class="text-center">{{ __('Identity Verified (:x)', ['x' => $reviews_count]) }}</h2>
					@if ((optional($result->users_verification)->email == 'yes') || (optional($result->users_verification)->facebook == 'yes') || (optional($result->users_verification)->google == 'yes'))
						<h3 class="text-center"> <i class="fas fa-check-double"></i> {{ __('Identity Verified') }}</h3>
					@else
						<h2 class="text-center"> <i class="fa fa-times"></i> {{ __('Identity Unverified') }}</h2>
					@endif
					<hr>
				</div>

				<div class="col-md-12 mt-4 p-0">
					<h2 class="font-weight-700">{{ ucfirst($result->first_name) }} {{ __('Confirmed') }}</h2>
					<ul>
						<li class="p-2" ><i class="{{ (optional($result->users_verification)->email == 'yes') ? "fa fa-check" : "fa fa-times" }} "></i> {{ __('Email') }}</li>
						<li class="p-2"><i class="{{ (optional($result->users_verification)->facebook == 'yes') ? "fa fa-check" : "fa fa-times" }} "></i></i> {{ __('Facebook') }} </li>
						<li class="p-2"><i class="{{ (optional($result->users_verification)->google == 'yes') ? "fa fa-check" : "fa fa-times" }} "></i></i> {{ __('Google') }}</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-md-9 p-0 mt-4">
			<div class="row">
				<div class="col-md-12 p-4">
					<h1 class="font-weight-700 text-30">{{ __("Hey, I’m :x!", ['x' => ucfirst($result->first_name)]) }}</h1>
					<h5 class="gray-text mt-3"><strong>{{ __('Member since') }} {{ $result->account_since }}</strong></h5>
					<hr/>
					@if (isset($details['live']))
						<p class="text-lg-left text-16 mt-3">  <i class="fas fa-home mr-2 text-20"></i>{{ __('Lives in ') }}{{ $details['live'] }}</p>
					@endif

					@if (isset($details['about']))
						<p class="font-weight-700 mt-2 text-18">{{ __('About') }}</p>
						<p class="text-16 m-0">{{ $details['about'] }}</p>
						<br>
					@endif
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="row  ">
						<div class="col-md-12 mt-2 p-0">
							<div class="row justify-content-center">
								<div class="col-md-12 list-bacground mt-0 rounded-3 pl-3 pt-3 pb-3 pr-3 border">
									<h2></i>  <span><strong>{{ __('Reviews (:x)', ['x' => $reviews_count]) }}</strong></span></h2>
								</div>

								@if ($reviews_from_guests->count() > 0 && $reviews_from_hosts->count() > 0 )
									<div class="col-md-12 p-0 mt-4">
										<ul class="nav nav-tabs" role="tablist">
											<li class="nav-item">
												<a class="nav-link active secondary-text-color text-color-hover" data-toggle="tab" href="#tabs-1" role="tab">{{ __('Reviews From Guests') }}</a>
											</li>
											<li class="nav-item">
												<a class="nav-link secondary-text-color text-color-hover" data-toggle="tab" href="#tabs-2" role="tab">{{ __('Reviews From Hosts') }}</a>
											</li>
										</ul><!-- Tab panes -->

										<div class="tab-content">
											<div class="tab-pane active" id="tabs-1" role="tabpanel">
												@foreach ($reviews_from_guests as $row_host)
													@include('users.review_list')
												@endforeach
											</div>

											<div class="tab-pane" id="tabs-2" role="tabpanel">
												@foreach ($reviews_from_hosts as $row_host)
													@include('users.review_list')
												@endforeach
											</div>
										</div>
									</div>

								@elseif ($reviews_from_guests->count() > 0)
									@foreach ($reviews_from_guests as $row_host)
										@include('users.review_list')
									@endforeach
								@elseif ($reviews_from_hosts->count() > 0)
									@foreach ($reviews_from_hosts as $row_host)
										@include('users.review_list')
									@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('validation_script')
	<script>
		'use strict'
		let page = 'profileShow';
	</script>
	<script type="text/javascript" src="{{ asset('public/js/user_profile.min.js') }}"></script>
@endsection