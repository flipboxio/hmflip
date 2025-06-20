@extends('template')

@section('main')
<div class="container mb-4 margin-top-85 min-height">
	<div class="d-flex justify-content-center">
		<div class="p-5 mt-5 mb-5 border w-450" >
			@if (Session::has('message'))
				<div class="row mt-3">
					<div class="col-md-12 p-2 text-center text-14 alert {{ Session::get('alert-class') }} alert-dismissable fade in opacity-1">
						<a href="#"  class="close text-18" data-dismiss="alert" aria-label="close">&times;</a>
						{{ Session::get('message') }}
					</div>
				</div>
			@endif
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

			<form id="login_form" method="post" action="{{ url('authenticate') }}"  accept-charset='UTF-8'>
				{{ csrf_field() }}
				<div class="form-group col-sm-12 p-0">
                    <label for="first_name">{{ __('Email') }} <span class="text-13 text-danger">*</span></label>
					@if ($errors->has('email'))
						<p class="error">{{ $errors->first('email') }}</p>
					@endif
					<input type="email" class="form-control text-14" value="{{ old('email') }}" name="email" placeholder = "{{ __('Email') }}">
				</div>

				<div class="form-group col-sm-12 p-0">
                    <label for="first_name">{{ __('Password') }} <span class="text-13 text-danger">*</span></label>
					@if ($errors->has('password'))
						<p class="error">{{ $errors->first('password') }}</p>
					@endif
					<input type="password" class="form-control text-14" value="" name="password" placeholder = "{{ __('Password') }}">
				</div>

				@if (!empty(settings('recaptcha_preference')) && !empty(settings('recaptcha_key')))
					@if (str_contains(settings('recaptcha_preference'), 'user_login'))
						<div class="g-recaptcha mt-4" data-sitekey="{{ settings('recaptcha_key') }}"></div>
						@if ($errors->has('g-recaptcha-response'))
								<p class="text-danger">{{ __($errors->first('g-recaptcha-response')) }}</p>
						@endif
						
					@endif
                @endif
				

				<div class="form-group col-sm-12 p-0 mt-3" >
					<div class="d-flex justify-content-between">
						<div class="m-3 text-14">
							<input type="checkbox" class='remember_me' id="remember_me2" name="remember_me" value="1">
							{{ __('Remember me') }}
						</div>

						<div class="m-3 text-14">
							<a href="{{ url('forgot_password') }}" class="forgot-password text-right">{{ __('Forgot password?') }}</a>
						</div>
					</div>
				</div>

				<div class="form-group col-sm-12 p-0" >
					<button type='submit' id="btn" class="btn pb-3 pt-3  button-reactangular text-15 vbtn-success w-100 rounded"> <i class="spinner fa fa-spinner fa-spin d-none" ></i>
							<span id="btn_next-text">{{ __('Login') }}</span>
					</button>
				</div>
			</form>

			<div class="mt-3 text-14">
				{{ __('Don’t have an account?') }}
				<a href="{{ url('signup') }}" class="font-weight-600">
				{{ __('Register') }}
				</a>
			</div>
		</div>
	</div>
</div>
@endsection

@section('validation_script')
<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
	'use strict'
	let fieldRequirdText = "{{ __('This field is required.') }}";
	let maxlengthText = "{{ __('Please enter no more than 255 characters.') }}";
	let validEmailText = "{{ __('Please enter a valid email address.') }}";
	let loginText = "{{ __('Login') }}..";
	let page = 'login';

		
</script>
<script type="text/javascript" src="{{ asset('public/js/login.min.js') }}"></script>

@endsection
