@extends('admin.template')
	@push('css')
	<link href="{{ asset('public/backend/css/setting.min.css') }}" rel="stylesheet" type="text/css" />
	@endpush
	@section('main')
	<div class="content-wrapper">
        <section class="content-header">
			<h1>Amenitie Edit Form<small>Edit Amenities</small></h1>
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
							<h3 class="box-title">Amenitie Edit Form</h3><span class="email_status" >(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="edit_amen" method="post" action="{{ url('admin/edit-amenities/' . $result->id) }}" class="form-horizontal" >
							{{ csrf_field() }}
							<div class="box-body">
                                <div class="form-group row mt-3 title">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Name 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="title" class="form-control f-14" id="url"placeholder="Name"
                                        value="{{ $result->title }}">
                                        <span class="text-danger">{{ $errors->first("title") }}</span>
                                    </div>
                                </div>
                                
                                <div class="form-group row mt-3 description">
                                        <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Description
                                            <span class="text-danger">*</span></label>
                                
                                    <div class="col-sm-6">
                                        <textarea name="description" placeholder="Description" rows="3"
                                            class="form-control f-14">{{ $result->description }}</textarea>
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    </div>
                                
                                   
                                </div>
                                <div class="form-group row mt-3 symbol">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Symbol 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="symbol" class="form-control f-14" id="url"placeholder="Symbol"
                                        value="{{ $result->symbol }}">
                                        <span class="text-danger">{{ $errors->first("symbol") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 type_id">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Type</label>
                                    
                                    <div class="col-sm-6">
                                        <select class="form-control f-14 validate_field" id="status" name="type_id" aria-invalid="false">
                                            @foreach ($am as $value => $type_id)

                                                <option value="{{ $value }}" {{ $result->status == $value ? 'selected' : '' }}>{{ $type_id }}</option>
                                                
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3 status">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Status</label>
                                    
                                    <div class="col-sm-6">
                                        <select class="form-control f-14" id="status" name="status" aria-invalid="false">
                                            <option value="Active" {{ $result->status == "Active" ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ $result->status == "Inactive" ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>

                                

								
							</div>

							<div class="box-footer">

								<button type="submit" class="btn btn-info btn-space f-14 text-white me-2">Submit</button>


								<a class="btn btn-danger f-14" href="{{ url('admin/settings/metas') }}">Cancel</a>

								
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
