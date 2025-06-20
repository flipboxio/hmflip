@extends('admin.template')
@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-3 col-12 settings_bar_gap">
                    @include('admin.common.settings_bar')
                </div>
                <!-- right column -->
                <div class="col-lg-9 col-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#" data-toggle="tab">Twilio</a></li>
                        </ul>
                    </div>

                    <div class="box box-muted">

                        <form id="smsform" method="post" action="{{ url('admin/settings/sms') }}" class="form-horizontal"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <input class="form-control f-14" type="hidden" name="default_country" id="default_country" value="{{ isset($phoneSms['default_country)']) ? $phoneSms['default_country'] : '' }}">
                                <input class="form-control f-14" type="hidden" name="carrier_code" id="carrier_code" value="{{ isset($phoneSms['carrier_code']) ? $phoneSms['carrier_code'] : '' }}">
                                <input class="form-control f-14" type="hidden" name="formatted_phone" id="formatted_phone" value="{{ isset($phoneSms['formatted_phone']) ? $phoneSms['formatted_phone'] : '' }}">

                                <div class="form-group row mt-2">
                                    <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Twilio Phone Number<span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="tel" class="form-control f-14" id="phone" name="phone" value="{{ isset($phoneSms['formatted_phone']) ? $phoneSms['formatted_phone'] : '' }} ">
                                        <span id="phone-error" class="text-danger text-13"></span>
                                        <span id="tel-error" class="text-danger text-13"></span>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0" for="inputEmail3">Twilio SID<span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input class="form-control f-14" type="text" name="twilio_sid" id="sid" placeholder="Twilio SID" value="{{ isset($phoneSms['twilio_sid']) ? $phoneSms['twilio_sid'] : '' }}">
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0"
                                        for="inputEmail3">Twilio Token<span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input class="form-control f-14" type="text" name="twilio_token" id="token"
                                            placeholder="Twilio Token"
                                            value="{{ isset($phoneSms['twilio_token']) ? $phoneSms['twilio_token'] : '' }}">
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0"
                                        for="inputEmail3">Defaults</label>
                                    <div class="col-sm-6">
                                        <select name="defaults" class="form-control f-14">
                                            <option value="no"
                                                {{ isset($phoneSms['defaults']) && $phoneSms['defaults'] == 'no' ? 'selected' : '' }}>
                                                No</option>
                                            <option value="yes"
                                                {{ isset($phoneSms['defaults']) && $phoneSms['defaults'] == 'yes' ? 'selected' : '' }}>
                                                Yes</option>


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0"
                                        for="inputEmail3">Status</label>
                                    <div class="col-sm-6">
                                        <select name="status" class="form-control f-14">
                                            <option value="0"
                                                {{ isset($phoneSms['status']) && $phoneSms['status'] == '0' ? 'selected' : '' }}>
                                                Inactive</option>
                                            <option value="1"
                                                {{ isset($phoneSms['status']) && $phoneSms['status'] == '1' ? 'selected' : '' }}>
                                                Active</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                @if (Request::segment(3) == 'email' || Request::segment(3) == '' || Request::segment(3) == 'api_informations' || Request::segment(3) == 'payment_methods' || Request::segment(3) == 'social_links')
                                    <a class="btn btn-default f-14" href="{{ url('admin/settings') }}">Cancel</a>
                                @else
                                    <button type="submit" class="btn btn-info f-14 text-white me-2" id="submitBtn">Submit</button>
                                    <a class="btn btn-danger f-14" href="{{ url('admin/settings/sms') }}">Cancel</a>
                                @endif
                            </div>
                            <!-- /.box-footer -->
                        </form>

                    </div>
                    <!-- /.box -->
                </div>
            </div>
          <!-- /.box -->
        </section>
    <!-- /.content -->
    </div>
  @endsection

  @section('validate_script')
  <script type="text/javascript" src="{{ asset('public/js/intl-tel-input-13.0.0/build/js/intlTelInput.js') }}" type="text/javascript"></script>

  <script src="{{ asset('public/backend/js/isValidPhoneNumber.js') }}" type="text/javascript"></script>
  
    <script type="text/javascript">
        'use strict'
        let utilsScript = '{{ asset("public/js/intl-tel-input-13.0.0/build/js/utils.js") }}';
        var countryData = $("#phone").intlTelInput("getSelectedCountryData");
        let validNumberText = "{{ __('Please enter a valid International Phone Number.') }}";

    
    </script>
      <script src="{{ asset('public/backend/js/sms.min.js') }}" type="text/javascript"></script>
  @endsection

