@extends('admin.template')
@section('main')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <h1>Lease Types<small>Lease Types</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
        </section>

        <section class="content">
            <div class="row gap-2">
                <div class="col-md-3 settings_bar_gap">
                    @include('admin.common.property_bar')
                </div>

                <div class="col-md-9">
                    <form method="post" action="{{ url('admin/listing/' . $result->id . '/' . $step) }}" class='signup-form login-form' accept-charset='UTF-8'>
                        {{ csrf_field() }}
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="f-18">
                                            Lease Types
                                            <span class="text-danger">*</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <ul class="list-unstyled fw-bold">
                                            @foreach ($lease_types as $leaseType)
                                                <li>
                                                    <span>&nbsp;&nbsp;</span>
                                                    <label class="label-large label-inline amenity-label">
                                                        <input type="checkbox" value="{{ $leaseType->id }}" name="lease_types[]" data-saving="{{ $leaseType->id }}" {{ in_array($leaseType->id, $property_leases) ? 'checked' : '' }}> &nbsp;&nbsp;
                                                        <span>{{ $leaseType->name }}</span>
                                                    </label>
                                                    <span>&nbsp;</span>

                                                    @if ($leaseType->description != '')
                                                        <span data-bs-toggle="tooltip" class="icon" title="{{ $leaseType->description }}"></span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <p id='error'></p>
                                <br>
                                <div class="row">
                                    <div class="col-6 text-left">
                                        <a data-prevent-default="" href="{{ url('admin/listing/' . $result->id . '/calendar') }}" class="btn btn-large btn-primary f-14">Back</a>
                                    </div>

                                    <div class="col-6 text-right">
                                        <button type="submit" class="btn btn-large btn-primary next-section-button f-14">
                                            Save & Continue
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </section>

        <div class="clearfix"></div>
    </div>
@endsection