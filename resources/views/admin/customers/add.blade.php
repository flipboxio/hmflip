@extends('admin.template')

@section('main')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Customers<small>Add Customer</small></h1>
        @include('admin.common.breadcrumb')
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
            <div class="box">
                <form class="form-horizontal" action="{{ url('admin/add-customer') }}" id="add_customer" method="post" name="add_customer" accept-charset='UTF-8'>
                    {{ csrf_field() }}
                    <div class="box-body">
                        <input type="hidden" name="default_country" id="default_country" class="form-control">
                        <input type="hidden" name="carrier_code" id="carrier_code" class="form-control">
                        <input type="hidden" name="formatted_phone" id="formatted_phone" class="form-control">
                        <div class="form-group mt-1 row">
                            <label for="exampleInputPassword1" class="control-label col-sm-3 mt-2 fw-bold">First Name<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="">
                            </div>
                        </div>

                        <div class="form-group mt-3 row">
                            <label for="exampleInputPassword1" class="control-label col-sm-3 mt-2 fw-bold">Last Name<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="">
                            </div>
                        </div>

                        <div class="form-group mt-3 row">
                            <label for="exampleInputPassword1" class="control-label col-sm-3 mt-2 fw-bold">Email<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control error" name="email" id="email" placeholder="">
                                <div id="emailError"></div>
                            </div>
                        </div>

                        <div class="form-group mt-3 row">
                            <label for="exampleInputPassword1" class="control-label col-sm-3 mt-2 fw-bold">Phone</label>
                            <div class="col-sm-8">
                                <input type="tel" class="form-control" id="phone" name="phone">
                                <span id="phone-error" class="text-danger text-13"></span>
                                <span id="tel-error" class="text-danger text-13"></span>
                            </div>
                        </div>

                        <div class="form-group mt-3 row">
                            <label for="exampleInputPassword1" class="control-label col-sm-3 mt-2 fw-bold">Password<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password" id="password" placeholder="">
                            </div>
                        </div>

                        <div class="form-group mt-3 row">
                            <label for="exampleInputPassword1" class="control-label col-sm-3 mt-2 fw-bold">Status</label>
                            <div class="col-sm-8">
                            <select class="form-control f-14" name="status" id="status">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                    <button type="submit" class="btn btn-info f-14 text-white" id="submitBtn">Submit</button>
                    <button type="reset" class="btn btn-danger f-14">Reset</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('validate_script')
<script src="{{ asset('public/backend/js/intl-tel-input-13.0.0/build/js/intlTelInput.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/js/isValidPhoneNumber.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/backend/dist/js/validate.min.js') }}" type="text/javascript"></script>
<script>
    'use strict'
    let requiredFieldText = "This field is required.";
	let minLengthText = "Please enter at least 6 characters.";
	let maxLengthText = "Please enter no more than 255 characters.";
	let oldLimitationText = "Age must be greater than 18.";
	let validEmailText = "Please enter a valid email address.";
	let checkUserURL = "{{ route('checkUser.check') }}";
	var token = "{{ csrf_token() }}";
	let emailExistText = "Email address is already Existed.";
	let validInternationalNumber = "Please enter a valid International Phone Number.";
    let numberExists = "The number has already been taken!";
	let signedUpText = "Sign Up..";
	let baseURL = "{{ url('/') }}";
	let duplicateNumberCheckURL = "{{ url('duplicate-phone-number-check') }}";
	let minAge = "You are not old enough!";

</script>
<script type="text/javascript" src="{{ asset('public/js/sign-up-login.min.js') }}"></script>

@endsection
