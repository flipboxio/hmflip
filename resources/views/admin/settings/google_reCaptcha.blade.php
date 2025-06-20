@extends('admin.template')
	@push('css')
	<link href="{{ asset('public/backend/css/setting.min.css') }}" rel="stylesheet" type="text/css" />
	@endpush
	@section('main')
	<div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-lg-3 col-12 settings_bar_gap">
					@include('admin.common.settings_bar')
				</div>

				<div class="col-lg-9 col-12">
					<div class="box box-info">
                        @if (Session::has('error'))
                            <div class="error_email_settings">
                                <div class="alert alert-warning fade in alert-dismissable">
                                    <strong>Warning!</strong> Whoops there was an error. Please verify your below
                                    information. <a class="close" href="#" data-dismiss="alert" aria-label="close"
                                                    title="close">×</a>
                                </div>
                            </div>
                        @endif

						<div class="box-header with-border">
							<h3 class="box-title">Google reCaptcha Api Credentials Form</h3><span class="email_status" >(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="google_recaptcha_api_credentials" method="post" action="{{ url('admin/settings/google-recaptcha-api-information') }}" class="form-horizontal" >
							{{ csrf_field() }}
							<div class="box-body">
                                <div class="form-group row mt-3 google_recaptcha_key">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">reCaptcha Key
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="google_recaptcha_key" class="form-control f-14" id="google_recaptcha_key" placeholder="Enter Google reCaptcha Key" value="{{ !empty(settings('recaptcha_key')) ? settings('recaptcha_key') : NULL }}">
                                        <span class="text-danger">{{ $errors->first("google_recaptcha_key") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 google_recaptcha_secret">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">reCaptcha Secret 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="google_recaptcha_secret" class="form-control f-14" id="google_recaptcha_secret" placeholder="Enter Google reCaptcha Secret" value="{{ !empty(settings('recaptcha_secret')) ? settings('recaptcha_secret') : NULL }}">
                                        <span class="text-danger">{{ $errors->first("google_recaptcha_secret") }}</span>
                                    </div>
                                </div>

                               

                            </div>

							<div class="box-footer">

								<button type="submit" class="btn btn-info btn-space f-14 text-white me-2 reCaptcha_submit">Submit</button>


								<a class="btn btn-danger f-14" href="{{ url('admin/settings/social-links') }}">Cancel</a>

								
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
	@endsection


@section('validate_script')
	<script>
		var selectedRecaptchaPlace = '';
		var recaptchaPlaceholder = '';
	</script>
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/backend/js/googlereCaptcha.min.js') }}"></script>
@endsection
