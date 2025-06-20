@extends('template')
@push('css')
	<link rel="stylesheet" href="{{ asset('public\css\style.css') }}">

@endpush

@section('main')
<main role="main" id="site-content" class="margin-top-85">
    <div class="container-fluid container-fluid-90 min-height static">
        {!! $content !!}
    </div>   
    <br>
</main>
@endsection


