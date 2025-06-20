@extends('admin.login-layout.template')

@section('main')
    <p class="login-box-msg">LOGIN TO <span class="loginto"><strong>{{ siteName() }}</strong></span></p>

    <form action="{{ url('admin/authenticate') }}" method="post" id="admin_login">
    {{ csrf_field() }}

        <div class="form-group has-feedback mb-3">
            <label class="fw-bold" for="username">{{ __('Email') }}</label>

            <div class="input-group">
                <input type="email" name="email" class="form-control" placeholder="{{ __('Email') }}" required>
            </div>
            @if ($errors->has('email'))
                    <p class="text-danger">{{ $errors->first('email') }}</p>
            @endif
        </div>
        
        
        <div class="form-group has-feedback">
            <label class="fw-bold" for="password">{{ __('Password') }}</label>
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="{{ __('Password') }}" required>
            </div>
            @if ($errors->has('password'))
                    <p class="text-danger">{{ $errors->first('password') }}</p>
            @endif
            
        </div>
        @if (!empty(settings('recaptcha_preference')) && !empty(settings('recaptcha_key')))
            @if (str_contains(settings('recaptcha_preference'), 'admin_login'))
                <div class="g-recaptcha mt-4" data-sitekey="{{ settings('recaptcha_key') }}"></div>
                @if ($errors->has('g-recaptcha-response'))
                        <p class="text-danger">{{ $errors->first('g-recaptcha-response') }}</p>
                @endif
                
            @endif
        @endif
        
        <div class="row">
            <div class="col-xs-8">
                <div class="mt-3 text-14 ">
                    <a href="{{ url('admin/forgot-password') }}" class="forgot-password text-right text-decoration-none">{{ __('Forgot password?') }}</a>
                </div>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat float-end login"><i class="spinner fa fa-spinner fa-spin d-none" ></i> {{ __('Sign In') }}</button>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            
        </div>
    </form>
@endsection