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
							<h3 class="box-title">Email Setting Form</h3><span class="email_status" >(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="email_setting" method="post" action="{{ url('admin/settings/email') }}" class="form-horizontal" >
							{{ csrf_field() }}
							<div class="box-body">

                                <div class="form-group row mt-3 driver">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Email Protocol</label>
                                    
                                    <div class="col-sm-6">
                                        <select class="form-control f-14 validate_field protocol_type" id="driver" name="driver" aria-invalid="false">
                                            @foreach ($drivers as $key => $driver)
                                                 <option value="{{ $key }}" {{ $result['driver'] == $key ? 'selected' : '' }}>{{ $driver }}</option>    
                                            @endforeach
                                            
                                        </select>
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>
                                
                                <div class="form-group row mt-3 host">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Host 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="host" class="form-control f-14" id="host" placeholder="Host"
                                        value="{{ $result['host'] }}">
                                        <span class="text-danger">{{ $errors->first("host") }}</span>
                                    </div>
                                </div>
                                <div class="form-group row mt-3 port">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Port
                                        <span class="text-danger">*</span>
                                    </label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="port" class="form-control f-14" id="port" placeholder="Port"
                                        value="{{ $result['port'] }}">
                                        <span class="text-danger">{{ $errors->first("port") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 from_address">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">From Address
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="from_address" class="form-control f-14" id="from_address" placeholder="From Address"
                                        value="{{ $result['from_address'] }}">
                                        <span class="text-danger">{{ $errors->first("from_address") }}</span>
                                    </div>
                                </div>
                                <div class="form-group row mt-3 from_name">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">From Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="from_name" class="form-control f-14" id="from_name" placeholder="From Name"
                                        value="{{ $result['from_name'] }}">
                                        <span class="text-danger">{{ $errors->first("from_name") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 encryption">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Encryption 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="encryption" class="form-control f-14" id="encryption "placeholder="Encryption"
                                        value="{{ $result['encryption'] }}">
                                        <span class="text-danger">{{ $errors->first("encryption") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 username">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Username 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="username" class="form-control f-14" id="username "placeholder="Username"
                                        value="{{ $result['username'] }}">
                                        <span class="text-danger">{{ $errors->first("username") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 password">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Password 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="password" class="form-control f-14" id="encryption "placeholder="Password"
                                        value="{{ $result['password'] }}">
                                        <span class="text-danger">{{ $errors->first("password") }}</span>
                                    </div>
                                </div>
                               
                                
                                <input type="hidden" class="email_status_check" name="email_status" value="{{ $result['email_status'] }}">
								
							</div>

							<div class="box-footer">

								<button type="submit" class="btn btn-info btn-space f-14 text-white me-2">Submit</button>


								<a class="btn btn-danger f-14" href="{{ url('admin/settings/email') }}">Cancel</a>

								
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
    <script type="text/javascript" src="{{ asset('public/backend/js/backend.min.js') }}"></script>

@endsection

