@extends('admin.template')

@section('main')



 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Testimonial
      <small>Edit Testimonial</small>
    </h1>
  @include('admin.common.breadcrumb')
  </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{ url('admin/edit-testimonials/' . $result->id) }}" id="edit_testimonials" method="post" name="edit_testimonials" accept-charset='UTF-8' enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Name<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control f-14" name="name" id="name" value="{{ $result->name }}" placeholder="Enter Reviewer Name..">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Designation<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control f-14" name="designation" id="designation" placeholder="Reviewer Designation.." value="{{ $result->designation }}">
                        @if ($errors->has('designation'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('designation') }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Description<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <textarea name="description" id="description" class="form-control f-14 error" placeholder="Description..">{{ $result->description }}</textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Image<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="file" class="form-control f-14 error" name="image" id="image" placeholder="" >
                        <img src="{{ url('/public/front/images/testimonial/' . $result->image) }}" height="80px;" width="80px;">


                        @if ($errors->has('image'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Rating<span class="text-danger">*</span></label>
                        <input type="hidden" name="rating_1" id="rating" value="{{ $result->review }}">
                        <div class="col-sm-8 pt-2">
                        @for ($i=1; $i <=5 ; $i++)
                            <i id="rating-{{ $i }}" class="fa fa-star {{ $i <= $result->review ? 'fa-star-beach':'icon-light-gray' }} icon-click"></i>
                        @endfor
                        @if ($errors->has('rating_1'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('rating_1') }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                    <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Status</label>
                    <div class="col-sm-8">
                        <select class="form-control f-14" name="status" id="status">
                        <option value="Active" {{ ($result->status == 'Active') ? 'selected' : '' }} >Active</option>
                        <option value="Inactive" {{ ($result->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-info f-14 text-white me-2" id="submitBtn">Submit</button>
                  <a class="btn btn-danger f-14" href="{{ url('admin/testimonials') }}">Cancel</a>
                </div>
                <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
    </section>
    </div>
@endsection

@section('validate_script')
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>	
@endsection
