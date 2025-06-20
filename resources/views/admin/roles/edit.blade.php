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
                            <h3 class="box-title">Edit Role Form</h3><span class="email_status" >(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
                        </div>

                        <form id="edit_role" method="post" action="{{ url('admin/settings/edit-role/' . $result->id) }}" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group row mt-3 name">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Name 
                                        <span class="text-danger">*</span></label>
                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="name" class="form-control f-14" id="heading"placeholder="Name"
                                        value="{{ $result->name }}">
                                        <span class="text-danger">{{ $errors->first("name") }}</span>
                                    </div>
                                </div>
                                <div class="form-group row mt-3 display_name">

                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Display Name
                                        <span class="text-danger">*</span></label>

                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="display_name" class="form-control f-14" id="heading" placeholder="Display Name"
                                        value="{{ $result->display_name }}">
                                        <span class="text-danger">{{ $errors->first("display_name") }}</span>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                  <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Description
                                      <span class="text-danger">*</span></label>
                          
                                  <div class="col-sm-6">
                                      <textarea name="description" placeholder="Meta Description" rows="3"
                                          class="form-control f-14">{{ $result->description }}</textarea>
                                      <span class="text-danger">{{ $errors->first('description') }}</span>
                                  </div>
                                </div>

                          <div class="form-group row mt-3">
                            <label class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Permissions</label>
                            <div class="col-sm-6">
                                <ul class="ul-checkbox ms-4">
                                    @foreach ($permissions as $value => $name)
                                        <li class="checkbox li-checkbox">
                                            <label>
                                                <input type="checkbox" name="permission[]" value="{{ $value }}"
                                                    {{ isset($stored_permissions) && in_array($value, $stored_permissions) ? 'checked' : '' }}>
                                                {{ $name }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                        </div>
                                
                            </div>

                            <div class="box-footer">

                                <button type="submit" class="btn btn-info btn-space f-14 text-white me-2">Submit</button>


                                <a class="btn btn-danger f-14" href="{{ url('admin/settings/roles') }}">Cancel</a>

                                
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
        var message = "{{ __('Please select at least one checkbox!') }}";
    </script>
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
    
@endsection