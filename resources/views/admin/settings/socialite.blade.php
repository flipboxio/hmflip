@extends('admin.template')
@section('main')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-3 col-12 settings_bar_gap">
                    @include('admin.common.settings_bar')
                </div>
                <!-- right column -->
                <div class="col-lg-9 col-12">
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Social Logins</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form id="socialiteform" method="post" action="{{ url('admin/settings/social-logins') }}" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Google</label>
                                    <div class="col-sm-6">
                                        <select name="google_login" class="form-control f-14" >
                                            <option value="0" {{ isset($social['google_login']) && $social['google_login'] == '0' ? 'selected' : "" }}>Inactive</option>
                                            <option value="1" {{ isset($social['google_login']) && $social['google_login'] == '1' ? 'selected' : "" }}>Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Facebook</label>
                                    <div class="col-sm-6">
                                        <select name="facebook_login" class="form-control f-14" >
                                            <option value="0" {{ isset($social['facebook_login']) && $social['facebook_login'] == '0' ? 'selected' : "" }}>Inactive</option>
                                            <option value="1" {{ isset($social['facebook_login']) && $social['facebook_login'] == '1' ? 'selected' : "" }}>Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                               
                                    <button type="submit" class="btn btn-info f-14 text-white me-2">Submit</button>
                                    <a class="btn btn-danger f-14" href="{{ url('admin/settings/social-logins') }}">Cancel</a>

                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box -->

                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

@endsection
