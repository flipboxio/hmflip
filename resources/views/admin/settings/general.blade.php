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
							<h3 class="box-title">General Setting Form</h3><span class="email_status" >(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="general_form" method="post" action="{{ url('admin/settings') }}" class="form-horizontal" enctype=multipart/form-data >
							{{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group row mt-3 name">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Name
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="name" class="form-control f-14" id="name" placeholder="Name"
                                        value="{{ $result['name'] }}">
                                        <span class="text-danger">{{ $errors->first("name") }}</span>
                                    </div>
                                </div>
                                <div class="form-group row mt-3 email">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    
                                    <div class="col-sm-6">
                                        <input type="email" name="email" class="form-control f-14" id="email" placeholder="Email"
                                        value="{{ $result['email'] }}">
                                        <span class="text-danger">{{ $errors->first("email") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="inputEmail3"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Logo
                                       <span class="text-danger">*</span>
                                    </label>
                            
                                    <div class="col-sm-6">
                                        <input type="file" name="photos[logo]" class="form-control f-14" id="photos[logo]" placeholder="Logo">
                                        <span class="text-danger">{{ $errors->first('photos[logo]') }}</span>
                                        <br> {!! getLogo('file-img') !!}
                                        <input id="hidden_company_logo" name="hidden_company_logo" data-rel="' {{ $result['logo'] }}'" type="hidden" >
                                        <span  name="mySpan" class="remove_logo_preview" id="mySpan"></span>
                                    </div>
                            
                                    <div class="col-sm-3">
                                        <small>{{ $field['hint'] ?? '' }}</small>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="inputEmail3"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Favicon<span
                                            class="text-danger">*</span></label>
                            
                                    <div class="col-sm-6">
                                        <input type="file" name="photos[favicon]" class="form-control f-14" id="photos[favicon]" placeholder="Favicon">
                                        <span class="text-danger">{{ $errors->first('photos[favicon]') }}</span>
                                        <br>{!! getFavicon('file-img') !!}
                                        <input id="hidden_company_logo" name="hidden_company_logo" data-rel="' {{ $result['logo'] }}'" type="hidden" >
                                        <span  name="mySpan2" class="remove_favicon_preview" id="mySpan2"></span>
                                        <input id="hidden_company_favicon" name="hidden_company_favicon" data-rel="{{ $result['favicon'] }}" type="hidden" >
                                    </div>
                            
                                    <div class="col-sm-3">
                                        <small>{{ $field['hint'] ?? '' }}</small>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                        <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Head Code
                                            <span class="text-danger">*</span></label>
                                
                                    <div class="col-sm-6">
                                        <textarea name="head_code" placeholder="Head Code" rows="3"
                                            class="form-control f-14 validate_field">{{ $result['head_code'] }}</textarea>
                                        <span class="text-danger">{{ $errors->first('head_code') }}</span>
                                    </div>
                                
                                </div>
                                

                                <div class="form-group row mt-3 default_currency">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Default Currency</label>
                                    
                                    <div class="col-sm-6">
                                        <select class="form-control f-14" id="default_currency" name="default_currency" aria-invalid="false">
                                            @foreach ($currency as $key => $item)
                                                <option value="{{ $key }}" {{ $result['default_currency'] == $key ? 'selected' : '' }}>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('default_currency') }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 default_language">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Default Language</label>
                                    
                                    <div class="col-sm-6">
                                        <select class="form-control f-14" id="default_language" name="default_language" aria-invalid="false">
                                            @foreach ($language as $key => $item)
                                                <option value="{{ $key }}" {{ $result['default_language'] == $key ? 'selected' : '' }}>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('default_language') }}</span>
                                    </div>
                                </div>

                                
                            </div>
                            <div class="box-footer">

								<button type="submit" class="btn btn-info btn-space f-14 text-white me-2">Submit</button>


								<a class="btn btn-danger f-14" href="{{ url('admin/settings') }}">Cancel</a>

								
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
    
  @endsection

  @section('validate_script')
    <script type= "text/javascript">
        'use strict'
        var message = "{{ __('The file must be an image (jpg, jpeg, png or gif)') }}";
        var message_ico = "{{ __('The file must be an image (jpg, jpeg, png or ico)') }}";
    </script>
    <script type="text/javascript" src="{{ asset('public/backend/js/additional-method.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/backend/js/backend.min.js') }}"></script>
  @endsection

