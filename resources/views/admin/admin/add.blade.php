@extends('admin.template')
	@push('css')
	<link href="{{ asset('public/backend/css/setting.min.css') }}" rel="stylesheet" type="text/css" />
	@endpush
	@section('main')
	<div class="content-wrapper">
        <section class="content-header">
            <h1>
                Add Admin User Form
              <small>Add Admin</small>
            </h1>
          @include('admin.common.breadcrumb')
        </section>
		<section class="content">
			<div class="row">
				<div class="col-lg-12 col-12">
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
							<h3 class="box-title">Admin Add Form</h3><span class="email_status" >(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="add_admin" method="post" action="{{ url('admin/add-admin') }}" class="form-horizontal" enctype=multipart/form-data >
							{{ csrf_field() }}
							<div class="box-body">
                                <div class="form-group row mt-3 username">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Username 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="username" class="form-control f-14" id="heading"placeholder="Username">
                                        <span class="text-danger">{{ $errors->first("username") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 email">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Email
                                        <span  class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="email" class="form-control f-14" id="heading" placeholder="Email">
                                        <span class="text-danger">{{ $errors->first("email") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    
                                    <label for="inputEmail3"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Password <span
                                            class="text-danger">*</span></label>
                                
                                    <div class="col-sm-6">
                                        <input type="password" name="password" class="form-control f-14" id="password" placeholder="Password">
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    </div>
                                
                                    <div class="col-sm-3">
                                        <small></small>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 role">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Role</label>
                                    
                                    <div class="col-sm-6">
                                        <select class="form-control f-14" id="role" name="role" aria-invalid="false">
                                            @foreach ($roles as $key=>$item)
                                                <option value="{{ $key }}">{{ $item }}</option>
                                                
                                            @endforeach
                                            
                                        </select>
                                        <span class="text-danger">{{ $errors->first('role') }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 status">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Status</label>
                                    
                                    <div class="col-sm-6">
                                        <select class="form-control f-14" id="status" name="status" aria-invalid="false">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>
								
							</div>

							<div class="box-footer">

								<button type="submit" class="btn btn-info btn-space f-14 text-white me-2">Submit</button>


								<a class="btn btn-danger f-14" href="{{ url('admin/admin-users') }}">Cancel</a>

								
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
