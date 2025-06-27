@extends('template')
@section('main')
    <div class="margin-top-85">
        <div class="row m-0">
            <!-- sidebar start-->
            @include('users.sidebar')
            <!--sidebar end-->
            <div class="col-md-10">
                <div class="main-panel min-height mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-3 pl-4 pr-4">
                            @include('listing.sidebar')
                        </div>

                        <div class="col-md-9 mt-4 mt-sm-0 pl-4 pr-4">
                            <form id="amenities_id" method="post" action="{{ url('listing/' . $result->id . '/' . $step) }}" accept-charset='UTF-8'>
                                {{ csrf_field() }}

                                <div class="col-md-12 p-0 mt-4 border rounded-3">
                                    <div class="row">
                                        <div class="col-md-12 pl-4 main-panelbg mb-4">
                                            <h4 class="text-18 font-weight-700 pl-0 pr-0 pt-4 pb-4">Lease Types</h4>
                                        </div>

                                        <div class="col-md-12 pl-4 pr-4 pt-0 pb-4">
                                            <div class="row">
                                                @foreach ($lease_types as $leaseType)
                                                    <div class="col-md-6">
                                                        <label class="label-large label-inline amenity-label mt-4">
                                                            <input type="checkbox" value="{{ $leaseType->id }}" name="lease_types[]" data-saving="{{ $leaseType->id }}" {{ in_array($leaseType->id, $property_leases) ? 'checked' : '' }}>
                                                            <span>{{ $leaseType->name }}</span>
                                                        </label>
                                                        <span>&nbsp;</span>

                                                        @if ($leaseType->description != '')
                                                            <span data-toggle="tooltip" class="icon" title="{{ $leaseType->description }}"></span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                <span class="ml-4"  id="at_least_one"><br></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 p-0 mt-4 mb-5">
                                    <div class="row justify-content-between mt-4">
                                        <div class="mt-4">
                                            <a data-prevent-default="" href="{{ url('listing/' . $result->id . '/calendar') }}" class="btn btn-outline-danger secondary-text-color-hover text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3" >
                                                {{ __('Back') }}
                                            </a>
                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3" id="btn_next"> <i class="spinner fa fa-spinner fa-spin d-none" ></i>
                                                <span id="btn_next-text">{{ __('Next') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('validation_script')
    <script type="text/javascript">
      'use strict'
      let nextText = "{{ __('Next') }}..";
      let mendatoryLeaseTypes = "{{ __('Choose at least one item from the Lease Type') }}";
      let next = "{{ __('Next') }}";
      let page = 'lease';
    </script>
    <script type="text/javascript" src="{{ asset('public/js/listings.min.js') }}"></script>

@endsection