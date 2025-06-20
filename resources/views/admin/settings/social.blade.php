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
							<h3 class="box-title">Social Setting Form</h3><span class="email_status" >(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="social_setting" method="post" action="{{ url('admin/settings/social-links') }}" class="form-horizontal" >
							{{ csrf_field() }}
							<div class="box-body">
                                <div class="form-group row mt-3 facebook">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Facebook 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="facebook" class="form-control f-14" id="facebook" placeholder="Facebook" value="{{ $result['facebook'] }}">
                                        <span class="text-danger">{{ $errors->first("facebook") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 google_plus">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Google Plus 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="google_plus" class="form-control f-14" id="google_plus" placeholder="Google Plus" value="{{ $result['google_plus'] }}">
                                        <span class="text-danger">{{ $errors->first("google_plus") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 twitter">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Twitter 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="twitter" class="form-control f-14" id="twitter" placeholder="Twitter" value="{{ $result['twitter'] }}">
                                        <span class="text-danger">{{ $errors->first("twitter") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 linkedin">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Linkedin 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="linkedin" class="form-control f-14" id="linkedin" placeholder="Linkedin" value="{{ $result['linkedin'] }}">
                                        <span class="text-danger">{{ $errors->first("linkedin") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 pinterest">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Pinterest 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="pinterest" class="form-control f-14" id="pinterest" placeholder="Pinterest" value="{{ $result['pinterest'] }}">
                                        <span class="text-danger">{{ $errors->first("pinterest") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 youtube">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Youtube 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="youtube" class="form-control f-14" id="youtube" placeholder="Youtube" value="{{ $result['youtube'] }}">
                                        <span class="text-danger">{{ $errors->first("youtube") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 instagram">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Instagram 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="instagram" class="form-control f-14" id="instagram" placeholder="Instagram" value="{{ $result['instagram'] }}">
                                        <span class="text-danger">{{ $errors->first("instagram") }}</span>
                                    </div>
                                </div>
                            </div>

							<div class="box-footer">

								<button type="submit" class="btn btn-info btn-space f-14 text-white me-2">Submit</button>


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
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>   
@endsection