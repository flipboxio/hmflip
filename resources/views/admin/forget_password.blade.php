@extends('admin.login-layout.template')

@section('main')
	<div class="p-1 mt-2 mb-2">
		<div class="row">
			<h4 class="font-weight-700 text-18">{{ __('Reset Password') }}</h4>
		</div>

		<form id="forgot_password_form" method="post" action="{{ url('admin/forgot-password') }}" class='signup-form login-form mt-3' accept-charset='UTF-8'>
			{{ csrf_field() }}
			<div class="col-sm-12">
				<p>{{ __('We will send you a email to reset your password') }}</p>
			</div>

			<div class="col-sm-12">
				<input type="text" id="email" class="form-control" name="email" placeholder = "{{ __('Email') }}">
				@if ($errors->has('email'))<label class="text-danger email-error">{{ $errors->first('email') }}</label>@endif
			</div>

			<div class="col-sm-12 mt-4">
				<button id="reset_btn" class="btn btn-primary rounded w-100" type="submit" > <i class="spinner fa fa-spinner fa-spin d-none" ></i>
					<span id="btn_next_text">{{ __('Continue') }}</span>

				</button>
			</div>
		</form>

		<div class="text-center w-100 mt-3 back-arrow">
			<a href="{{ url('admin/login') }}" class="mt-2 text-decoration-none back-to-login">
				<i class="fa fa-angle-left" aria-hidden="true"></i>		{{ __('Back to sign-in') }}
			</a>
		</div>
	</div>
@endsection
