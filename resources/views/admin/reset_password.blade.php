@extends('admin.login-layout.template')

@section('main')
    <div class="p-1 mt-2 mb-2">
        <div class="row">
            <h5 class="font-weight-300 text-10">Reset Your Password</h5>
        </div>
        <form method="post" action="{{ url('admin/reset-password') }}" id='password-form' class='signup-form login-form' accept-charset='UTF-8'>
            {{ csrf_field() }}
            <input id="id" name="id" type="hidden" value="{{ $result->id }}">
            <input id="token" name="token" type="hidden" value="{{ $token }}">
            <div class="col-sm-12 mt-4">
                <input type="password" class="form-control" id='new_password' name="password" placeholder = "New Password">
                @if ($errors->has('password')) <p class="text-danger">{{ $errors->first('password') }}</p> @endif
            </div>

            <div class="col-sm-12 mt-4">
                <input type="password" class="form-control" id='password_confirmation' name="password_confirmation" placeholder = "Confirm Password">
                @if ($errors->has('password_confirmation')) <p class="text-danger">{{ $errors->first('password_confirmation') }}</p> @endif
            </div>

            <div class="col-sm-12 mt-4">
                <button class="btn btn-primary mx-auto rounded w-100" type="submit" id="new_pass_reset"><i class="spinner fa fa-spinner fa-spin d-none" ></i> 
                    <span id="btn_next_text">Reset Password</span>
                </button>
            </div>
        </form>
    </div>
@endsection

