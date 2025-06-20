@extends('admin.template')
@section('main')
  <div class="content-wrapper">
        <!-- Main content -->
    <section class="content-header">
        <h1>
            Booking
            <small>Booking</small>
        </h1>
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
                <div class="box box-info">
                    <div class="box-body">
                        <form method="post" action="{{ url('admin/listing/' . $result->id . '/' . $step) }}" class='signup-form login-form' accept-charset='UTF-8'>
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Choose how your guests book</h4>
                                    <p class="text-muted f-14">Get ready for guests by choosing your booking style.</p>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8 col-12 min-height-div">
                                            <label class="label-large fw-bold">Booking Type  <span class="text-danger">*</span></label>
                                            <select name="booking_type" id="select-booking_type" class="form-control f-14 mt-1">
                                                <option value="request" {{ ($result->booking_type == 'request') ? 'selected' : '' }}>Review each request</option>
                                                <option value="instant" {{ ($result->booking_type == 'instant') ? 'selected' : '' }}>Guests book instantly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear-both"></div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6 text-left">
                                            <a data-prevent-default="" href="{{ url('admin/listing/' . $result->id . '/pricing') }}" class="btn btn-large btn-primary f-14">Back</a>
                                        </div>
                                        <div class="col-6 text-right">
                                            <button type="submit" class="btn btn-large btn-primary next-section-button f-14">Complete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
      </div>
    </section>
  </div>
@endsection
