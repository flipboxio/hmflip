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
							<h3 class="box-title">Fees Setting Form</h3><span class="email_status" >(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="fees_setting" method="post" action="{{ url('admin/settings/fees') }}" class="form-horizontal" >
							{{ csrf_field() }}
							<div class="box-body">
                                
                                <div class="form-group row mt-3 guest_service_charge">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Guest service charge (%) 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="guest_service_charge" class="form-control f-14" id="guest_service_charge" placeholder="Guest service charge (%)" value="{{ $result['guest_service_charge'] }}">
                                        <span class="text-danger">{{ $errors->first("guest_service_charge") }}</span>
                                    </div>

                                    <div class="col-sm-3">
                                        <small>service charge of guest for booking</small>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 iva_tax">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">I.V.A Tax (%) 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="iva_tax" class="form-control f-14" id="iva_tax" placeholder="I.V.A Tax (%)" value="{{ $result['iva_tax'] }}">
                                        <span class="text-danger">{{ $errors->first("iva_tax") }}</span>
                                    </div>

                                    <div class="col-sm-3">
                                        <small>I.V.A Tax of guest for booking</small>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 accomodation_tax">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Accomadation Tax (%) 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="accomodation_tax" class="form-control f-14" id="accomodation_tax" placeholder="Accomadation Tax (%)" value="{{ $result['accomodation_tax'] }}">
                                        <span class="text-danger">{{ $errors->first("accomodation_tax") }}</span>
                                    </div>

                                    <div class="col-sm-3">
                                        <small>accomadation Tax of guest for booking</small>
                                    </div>
                                </div>

							</div>

							<div class="box-footer">

								<button type="submit" class="btn btn-info btn-space f-14 text-white me-2">Submit</button>


								<a class="btn btn-danger f-14" href="{{ url('admin/settings/country') }}">Cancel</a>

								
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