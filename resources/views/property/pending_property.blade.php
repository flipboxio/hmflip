@extends('template')

@section('main')
    <div class="container-fluid container-fluid-90 min-height margin-top-85 mb-5">
        <div class="error_width " >
            <div class="row jutify-content-center position-center w-100 p-4 mt-4">
            <div class="text-center w-100">
                <p class="text-center">{{ __("The Property is currently waiting for verification — Once the admin verifies it, you’ll find this property here.") }}</p>
            </div>
            </div>
        </div>
    </div>
@stop
