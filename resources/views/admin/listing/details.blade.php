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
            <div class="row">
                <div class="col-md-3 settings_bar_gap">
                    @include('admin.common.property_bar')
                </div>

                <div class="col-md-9">

                    <form method="post" action="{{ url('admin/listing/' . $result->id . '/' . $step) }}"
                        class='signup-form login-form' accept-charset='UTF-8'>
                        {{ csrf_field() }}
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4>The Trip</h4>
                                        <label
                                            class="label-large">About Place</label>
                                        <textarea class="form-control" name="about_place" rows="4" placeholder="">{{ $result->property_description->about_place }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label
                                            class="label-large">Place is great for</label>
                                        <textarea class="form-control" name="place_is_great_for" rows="4" placeholder="">{{ $result->property_description->place_is_great_for }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label
                                            class="label-large">Guest Access</label>
                                        <textarea class="form-control" name="guest_can_access" rows="4" placeholder="">{{ $result->property_description->guest_can_access }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label
                                            class="label-large">Interaction with Guests</label>
                                        <textarea class="form-control" name="interaction_guests" rows="4" placeholder="">{{ $result->property_description->interaction_guests }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label
                                            class="label-large">Other Things to Note</label>
                                        <textarea class="form-control" name="other" rows="4" placeholder="">{{ $result->property_description->other }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <h4>The Neighborhood</h4>
                                        <label
                                            class="label-large">Overview</label>
                                        <textarea class="form-control" name="about_neighborhood" rows="4" placeholder="">{{ $result->property_description->about_neighborhood }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label
                                            class="label-large">Getting Around</label>
                                        <textarea class="form-control" name="get_around" rows="4" placeholder="">{{ $result->property_description->get_around }}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row mt20">
                                    <div class="col-6 text-left">
                                        <a data-prevent-default=""
                                            href="{{ url('admin/listing/' . $result->id . '/description') }}"
                                            class="btn btn-large btn-primary">Back</a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="submit" class="btn btn-large btn-primary next-section-button">
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
        <div class="clearfix"></div>
    </div>
@endsection
