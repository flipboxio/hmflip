@extends('template')

@section('main')
    <div class="container-fluid container-fluid-90 min-height margin-top-85 mb-5">
      <div class="error_width " >
        <div class="notfound position-center">
            <div class="notfound-404">
              <h3>{{ __('Oops!') }} {{ __('Unauthorized action') }}</h3>
              <h1><span>4</span><span>0</span><span>4</span></h1>
            </div>
            <h2 class="text-center">{{ __('We Can’t find the ') }}  {{ __('page you are looking for.') }}</h2>
          </div>
      </div>
    </div>
@stop
