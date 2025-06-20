@extends('template')
@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('public/js/intl-tel-input-13.0.0/build/css/intlTelInput.min.css') }}">
@endpush
@section('main')
<div class="container mb-4 margin-top-85 min-height">
    <div class="d-flex justify-content-center">
		<div class="p-5 mt-5 mb-5 border w-450">
            @if ($social['facebook_login'])
                <a href="{{ isset($facebook_url) ? $facebook_url : url('facebookLogin') }}">
                    <button class="btn btn-outline-primary pt-3 pb-3 text-16 w-100">
                        <span><i class="fab fa-facebook-f mr-2 text-16"></i> {{ __('Sign up with Facebook') }}</span>
                    </button>
                </a>
            @endif

            @if ($social['google_login'])
                <a href="{{ url('googleLogin') }}">
                    <button class="btn btn-outline-danger pt-3 pb-3 text-16 w-100 mt-3">
                        <span><i class="fab fa-google-plus-g  mr-2 text-16"></i>  {{ __('Sign up with Google') }}</span>
                    </button>
                </a>
            @endif

            @if ($social['google_login'] || $social['facebook_login'])
                <p class="text-center font-weight-700 mt-1">{{ __('or') }}</p>
            @endif
				<form id="signup_form" name="signup_form" method="post" action="{{ url('create') }}" class='signup-form login-form' accept-charset='UTF-8' onsubmit="return ageValidate();">
					{{ csrf_field() }}
					<div class="row text-16">
						<input type="hidden" name='email_signup' id='form'>
						<input type="hidden" name="default_country" id="default_country" class="form-control">
						<input type="hidden" name="carrier_code" id="carrier_code" class="form-control">
						<input type="hidden" name="formatted_phone" id="formatted_phone" class="form-control">

						<div class="form-group col-sm-12 p-0">
                            <label for="first_name">{{ __('First Name') }} <span class="text-13 text-danger">*</span></label>
							@if ($errors->has('first_name')) <p class="error-tag">{{ $errors->first('first_name') }}</p> @endif
							<input type="text" class='form-control text-14 p-2' value="{{ old('first_name') }}" name='first_name' id='first_name' placeholder='{{ __('First Name') }}'>
						</div>

						<div class="form-group col-sm-12 p-0">
                            <label for="first_name">{{ __('Last Name') }} <span class="text-13 text-danger">*</span></label>
								@if ( $errors->has('last_name') ) <p class="error-tag">{{ $errors->first('last_name') }}</p> @endif
								<input type="text" class='form-control text-14 p-2' value="{{ old('last_name') }}" name='last_name' id='last_name' placeholder='{{ __('Last Name') }}'>
						</div>

						<div class="form-group col-sm-12 p-0">
                            <label for="first_name">{{ __('Email') }} <span class="text-13 text-danger">*</span></label>
								<input type="text" class='form-control text-14 p-2' value="{{ old('email') }}" name='email' id='email' placeholder='{{ __('Email') }}'>
								@if ($errors->has('email'))
									<p class="error-tag">
									{{ $errors->first('email') }}
									</p>
								@endif
								<div id="emailError"></div>
						</div>

						<div class="form-group col-sm-12 p-0">
                            <label for="first_name">{{ __('Phone') }}</label>
								<input type="tel" class="form-control text-14 p-2" id="phone" name="phone">
								<span id="tel-error" class="text-13 text-danger"></span>
								<span id="phone-error" class="text-13 text-danger"></span>
						</div>

						<div class="form-group col-sm-12 p-0">
                            <label for="first_name">{{ __('Password') }} <span class="text-13 text-danger">*</span></label>
								@if ( $errors->has('password') ) <p class="error-tag">{{ $errors->first('password') }}</p> @endif
								<input type="password" class='form-control text-14 p-2' name='password' id='password' placeholder='{{ __('Password') }}'>
						</div>

						<div class="col-sm-12 p-0">
							<label class="l-pad-none text-14">{{ __('Birthday') }} <span class="text-13 text-danger">*</span></label>
						</div>

						<div class="col-sm-12 p-0">
								@if ($errors->has('birthday_month') || $errors->has('birthday_day') || $errors->has('birthday_year'))
								<p class="error-tag">{{ $errors->first('date_of_birth') }}</p>
								@else
									<p class="error-tag">{{ $errors->first('date_of_birth') }}</p>
								@endif
						</div>


						<div class="form-group col-sm-12 p-0">
								<div class="row">
									<div class="col-sm-4 pl-0 mt-2">
											<select name='birthday_month' class='form-control text-14 p-2' id='user_birthday_month'>
												<option value=''>{{ __('Month') }}</option>
												@for ($m=1; $m<=12; ++$m)
													<option value="{{ $m }}" {{ old('birthday_month') == $m ? 'selected = "selected"' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
												@endfor
											</select>
									</div>

									<div class="col-sm-4 mt-2">
										<select name='birthday_day' class='form-control text-14' id='user_birthday_day'>
											<option value=''>{{ __('Day') }}</option>
											@for ($m=1; $m<=31; ++$m)
											<option value="{{ $m }}" {{ old('birthday_day') == $m ? 'selected = "selected"' : '' }}>{{ $m }}</option>
											@endfor
										</select>
									</div>

									<div class="col-sm-4 pr-0 mt-2">
									<select name='birthday_year' class='form-control text-14' id='user_birthday_year'>
										<option value=''>{{ __('Year') }}</option>
										@for ($m=date('Y'); $m > date('Y')-100; $m--)
											<option value="{{ $m }}"{{ old('birthday_year') == $m ? 'selected = "selected"' : '' }}>{{ $m }}</option>
										@endfor
									</select>
									</div>
								</div>

							<span class="text-danger text-13">
								<label id='dobError'></label>
							</span>
						</div>

						@if (!empty(settings('recaptcha_preference')) && !empty(settings('recaptcha_key')))
							@if (str_contains(settings('recaptcha_preference'), 'user_reg'))
								<div class="g-recaptcha mb-4" data-sitekey="{{ settings('recaptcha_key') }}"></div>
								@if ($errors->has('g-recaptcha-response'))
										<p class="text-danger">{{ __($errors->first('g-recaptcha-response')) }}</p>
								@endif
								
							@endif
						@endif

						<button type='submit' id="btn" class="btn pb-3 pt-3 text-15 button-reactangular vbtn-success w-100 ml-0 mr-0 mb-3"> <i class="spinner fa fa-spinner fa-spin d-none" ></i>
							<span id="btn_next-text">{{ __('Sign Up') }}</span>
						</button>
					</div>
				</form>

				<div class="text-14">
					{{ __('Already an :x member?', ['x' => siteName()]) }}
					<a href="{{ url('/login?') }}" class="font-weight-600">
					{{ __('Log In') }}
                    </a>
				</div>
			</div>
    </div>
</div>
@endsection

@section('validation_script')
<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript" src="{{ asset('public/js/intl-tel-input-13.0.0/build/js/intlTelInput.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/isValidPhoneNumber.js') }}" type="text/javascript"></script>

<script type="text/javascript">

	'use strict'
	let requiredFieldText = "{{ __('This field is required.') }}";
	let minLengthText = "{{ __('Please enter at least 6 characters.') }}";
	let maxLengthText = "{{ __('Please enter no more than 255 characters.') }}";
	let oldLimitationText = "{{ __('Age must be greater than 18.') }}";
	let validEmailText = "{{ __('Please enter a valid email address.') }}";
	let checkUserURL = "{{ route('checkUser.check') }}";
	var token = "{{ csrf_token() }}";
	let emailExistText = "{{ __('Email address is already Existed.') }}";
	let validInternationalNumber = '{{ __("Please enter a valid International Phone Number.") }}';
    let numberExists = "{{ __('The number has already been taken!') }}";
	let signedUpText = "{{ __('Sign Up') }}..";
	let baseURL = "{{ url('/') }}";
	let duplicateNumberCheckURL = "{{ url('duplicate-phone-number-check') }}";
	let minAge = "{{ __('You are not old enough!') }}";
</script>

<script type="text/javascript" src="{{ asset('public/js/sign-up-login.min.js') }}"></script>

@endsection

