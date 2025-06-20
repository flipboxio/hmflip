@extends('template')
@push('css')
    <link rel="stylesheet" href="{{ asset('public/css/user-front.min.css') }}">
@section('main')
    <div class="margin-top-85">
        <div class="row m-0">
            @include('users.sidebar')
            <div class="col-lg-10">
                <div class="main-panel">
                    <div class="container-fluid min-height">
                        <div class="row">
                            <div class="col-md-12 p-0 mb-3">
                                <div class="list-bacground mt-4 rounded-3 p-4 border">
                                    <span class="text-18 pt-4 pb-4 font-weight-700">
                                        {{ __('Favourite') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if (Session::has('message'))
                            <div class="alert alert-success text-center" role="alert" id="alert">
                                <span id="messages">{{ Session::get('message') }}</span>
                            </div>
                        @endif
                        @forelse($bookings as $booking)

                            <div class="row border border p-2  rounded-3 mt-4">
                                <div class="col-md-3 p-2 pr-4">
                                    <div class="img-event">
                                        <a href="{{ url('/properties/'.optional($booking->properties)->slug) }}">
                                            <img class="img-fluid rounded" src="{{ optional($booking->properties)->cover_photo }}" alt="cover_photo">
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-9 pl-2">
                                    <div class="row m-0 pr-4 w-100">
                                        <div class="col-10 col-sm-9 p-0">
                                            <a href="{{ url('/properties/'.optional($booking->properties)->slug) }}">
                                                <p class="mb-0 text-18 text-color font-weight-700 text-color-hover pr-2">{{ optional($booking->properties)->name }} </p>
                                            </a>
                                            <p class="text-14 text-muted mb-0">
                                                <i class="fas fa-map-marker-alt"></i>
                                                {{ optional($booking->properties)->property_address->address_line_1 }}
                                            </p>
                                        </div>
                                        <div class="col-2 col-sm-3">
                                            <span data-status="{{ optional($booking->properties)->book_mark }}"  data-id="{{ optional($booking->properties)->id }}" class="book_mark_change cursor-pointer" style="font-size: 22px; color: #1dbf73;">
                                                <i class="fas fa-heart pl-5" ></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="row jutify-content-center position-center w-100 p-4 mt-4 ">
                                <div class="text-center w-100">
                                    <img src="{{ url('public/img/unnamed.png') }}"   alt="notfound" class="img-fluid">
                                    <p class="text-center">{{ __("You don't have any Favourite listing yet—but when you do, you’ll find them here.") }}</p>
                                </div>
                            </div>
                        @endforelse

                        <div class="row justify-content-between overflow-auto pb-3 mt-4 mb-5">
                            {{ $bookings->appends(request()->except('page'))->links('paginate') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('validation_script')
    <script src="{{ asset('public/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        'use strict'
        let success = "{{ __('Success') }}";
        let yes = "{{ __('Yes') }}";
        let no = "{{ __('No') }}";
        let user_id = "{{ Auth::id() }}";
        var token = "{{ csrf_token() }}";
        let add = "{{ __('Add to Favourite List ?') }}";
        let remove = "{{ __('Remove from Favourite List ?') }}";
        let added = "{{ __('Added to favourite list.') }}";
        let removed = "{{ __('Removed from favourite list.') }}";
    </script>
    <script src="{{ asset('public/js/front.min.js') }}"></script>
    
@endsection
