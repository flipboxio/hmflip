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
							<h3 class="box-title">Add Country Form</h3><span class="email_status" >(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="add_country" method="post" action="{{ url('admin/settings/add-country') }}" class="form-horizontal" >
							{{ csrf_field() }}
							<div class="box-body">
                                <div class="form-group row mt-3 short_name">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Short Name 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="short_name" class="form-control f-14" id="short_name" placeholder="Short Name" value="{{ old('short_name') }}">
                                        <span class="text-danger">{{ $errors->first("short_name") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 name">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Long Name 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="name" class="form-control f-14" id="iso3" placeholder="Long Name" value="{{ old('iso3') }}">
                                        <span class="text-danger">{{ $errors->first("name") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 iso3">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">ISO3 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="iso3" class="form-control f-14" id="iso3" placeholder="ISO3" value="{{ old('iso3') }}">
                                        <span class="text-danger">{{ $errors->first("iso3") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 number_code">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Num Code 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="number_code" class="form-control f-14" id="number_code" placeholder="Num Code" value="{{ old('number_code') }}">
                                        <span class="text-danger">{{ $errors->first("number_code") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 phone_code">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Phone Code 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="phone_code" class="form-control f-14" id="phone_code" placeholder="Phone Code" value="{{ old('phone_code') }}">
                                        <span class="text-danger">{{ $errors->first("phone_code") }}</span>
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