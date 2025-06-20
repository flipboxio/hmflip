@extends('admin.template')
@section('main')
  <div class="content-wrapper">
         <!-- Main content -->
        <section class="content-header">
            <h1>
                Description
                <small>Description</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                <a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a>
                </li>
            </ol>
        </section>

        <section class="content">
            <div class="row gap-2">
                <div class="col-md-3 settings_bar_gap">
                    @include('admin.common.property_bar')
                </div>

                <div class="col-md-9">
                    <form id="list_des" method="post" action="{{ url('admin/listing/' . $result->id . '/' . $step) }}" class='signup-form login-form' accept-charset='UTF-8'>
                        {{ csrf_field() }}

                        <div class="box box-info">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8 col-sm-12 col-xs-12 mb20">
                                        <label class="label-large fw-bold">Listing Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control f-14" value=" {{ old('name', $description->properties->name)  }}" placeholder="" maxlength="100">
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8  col-sm-12 col-xs-12 mb20">
                                    <label class="label-large fw-bold">Summary <span class="text-danger">*</span></label>
                                    <textarea class="form-control f-14" name="summary" rows="6" placeholder="" ng-model="summary">{{ old('summary', $description->summary)  }}</textarea>
                                    <span class="text-danger">{{ $errors->first('summary') }}</span>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-8  col-sm-12 col-xs-12 mb20">
                                        <p class="f-14">
                                            You can add more <a href="{{ url('admin/listing/' . $result->id . '/details') }}" class="secondary-text-color" id="js-write-more">details</a> Tell travelers about your space and hosting style.
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6 text-left">
                                        <a data-prevent-default="" href="{{ url('admin/listing/' . $result->id . '/basics') }}" class="btn btn-large btn-primary f-14">Back</a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="submit" class="btn btn-large btn-primary next-section-button f-14">
                                            Next
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- /.content -->
        <div class="clearfix"></div>
  </div>
@endsection

@section('validate_script')
    <script src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
@endsection
