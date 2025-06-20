@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add Page Form
                <small>add page form</small>
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
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Page Form</h3>
                        </div>
                        <!-- form start -->
                        <form class="form-horizontal" action="{{ url('admin/add-page') }}" id="add_page" method="post"
                            name="add_page" accept-charset='UTF-8' enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group row mt-2">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Name<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control f-14" value="" name="name"
                                            placeholder="" id="geturl">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">URL<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control f-14" name="url" id="page_url"
                                            placeholder="">
                                        @if ($errors->has('url'))
                                            <p class="error-tag">{{ $errors->first('url') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="inputEmail3"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Content<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea id="content" name="content" placeholder="" rows="10" cols="80" class=""> </textarea>
                                        <span id="content-validation-error"></span>
                                    </div>

                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Position</label>
                                    <div class="col-sm-6">
                                        <select name="position" class="form-control f-14">
                                            <option value="first"> First Column </option>
                                            <option value="second"> Second Column </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Status</label>
                                    <div class="col-sm-6">
                                        <select name="status" class="form-control f-14">
                                            <option value="Active"> Active </option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info btn-sm f-14 text-white"
                                    id="submitBtn">Submit</button>
                                <a href="{{ url('admin/pages') }}" class="btn btn-danger btn-sm f-14 ms-1">
                                    Cancel
                                </a>

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
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/admin.min.js') }}"></script>

    <script type="text/javascript">
        'use strict'
        let filebrowserUploadUrl = '{{ route("upload", ["_token" => csrf_token()]) }}';
    </script>
    <script type="text/javascript" src="{{ asset('public/backend/js/static_page_photo_upload.min.js') }}"></script>

@endsection

