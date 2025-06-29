@extends('template')
@section('main')
<div class="margin-top-85">
    <div class="row m-0">
        @include('users.sidebar')
        <div class="col-lg-10 p-0 mb-5">
            <div class="container-fluid p-0 min-height">
                <div class="col-md-12 mt-4">
                    <div class="main-panel">
                        <div class="row justify-content-center">
                            <div class="col-md-12 pl-4 pr-4">
                                <ul class="nav  navbar-expand-lg navbar-light list-bacground border rounded-3 p-2 pt-4 pb-4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $write ?? ' ' }} text-color" data-toggle="tab" href="#tabs-1" role="tab">{{ __('Write Review') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $you ?? ' ' }} text-color" data-toggle="tab" href="#tabs-2" role="tab">{{ __('Past Review') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $expired ?? ' ' }} text-color" data-toggle="tab" href="#tabs-3" role="tab">{{ __('Expired Review') }}</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane {{ $write ?? ' ' }}" id="tabs-1" role="tabpanel">
                                        @forelse ($reviewsToWrite as $writeReview)
                                            <div class="row mt-4 border w-100 rounded-3">
                                                <div class="col-md-3 col-xl-4 pl-0 pr-0">
                                                    <div class="img-event p-3">
                                                        <a href="{{ url('properties/' . optional($writeReview->properties)->slug) }}">
                                                            <img class="room-image-container200 rounded" src="{{ optional($writeReview->properties)->cover_photo }}" alt="img">
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="col-md-9 col-xl-8 pl-2 pr-2">
                                                    <div class="row align-items-center mt-4">
                                                        <div class="col-md-12 p-0">
                                                            <a href="{{ url('properties/' . optional($writeReview->properties)->slug) }}"><p class="font-weight-700 mb-0">{{ optional($writeReview->properties)->name }}</p></a>

                                                        </div>

                                                        <div class="col-md-12 p-0">
                                                            <div class="d-flex justify-content-between">
                                                                <div>

                                                                    <p class="mt-2"><i class="fa fa-calendar"></i> {{ date(' M d, Y', strtotime($writeReview->start_date)) }}  -  {{ date(' M d, Y', strtotime($writeReview->end_date)) }}</p>
                                                                    <p class="text-15 p-0"><i class="fas fa-exclamation-triangle text-success"></i>
                                                                        {{ __('You have') }} <b>{{ str_replace('+','',$writeReview->review_days) }} {{ ($writeReview->review_days > 1) ? __('days') : __('day') }}</b> {{ __('to submit a public review for') }}  <b> {{ Auth::user()->id == $writeReview->user_id ? optional($writeReview->host)->full_name : optional($writeReview->users)->full_name }}</b> .
                                                                    </p>
                                                                    <a href="{{ url('reviews/edit/' . $writeReview->id) }}" class="text-color text-color-hover font-weight-700 text-15">{{ __('Write Review') }}</a>
                                                                </div>

                                                                <div>
                                                                    <div class="d-flex w-100 h-100  mt-3 mt-sm-0 p-2">
                                                                        <div class="align-self-center w-100">
                                                                            <div class="row">
                                                                                <div class="row justify-content-center">
                                                                                    <div class="col-md-12">
                                                                                        <div class='img-round text-center'>
                                                                                            <a href="{{ url('users/show/' . $writeReview->user_id == Auth::id()  ? $writeReview->host_id : $writeReview->user_id) }}">
                                                                                                <img src="{{ Auth::user()->id == $writeReview->user_id ? optional($writeReview->host)->profile_src : optional($writeReview->users)->profile_src }}" class="rounded-circle img-70x70">
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-12">
                                                                                        <p class="text-center font-weight-700 mb-0">
                                                                                            <a href="{{ url('users/show/' . Auth::user()->id == $writeReview->user_id ? $writeReview->host_id : $writeReview->user_id ) }}"><p class="text-center font-weight-700 mb-0">{{ Auth::user()->id == $writeReview->user_id ? optional($writeReview->host)->full_name : optional($writeReview->users)->full_name }}</p></a>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="row jutify-content-center w-100 p-4 mt-4">
                                                <div class="text-center w-100">
                                                    <img src="{{ asset('public/img/unnamed.png') }}" class="img-fluid"  alt="notfound">
                                                    <p class="text-center">{{ __('Nobody to review right now. Looks like it’s time for another trip!') }}</p>
                                                </div>
                                            </div>
                                        @endforelse
                                        <div class="row justify-content-between overflow-auto pb-3 mt-4">
                                            {{ $reviewsToWrite->appends(['write' => $reviewsToWrite->currentPage()])->links('paginate') }}
                                        </div>
                                    </div>

                                    <div class="tab-pane {{ $you ?? ' ' }}" id="tabs-2" role="tabpanel">
                                        @forelse ($reviewsByYou as $pastReview)
                                        <div class="row mt-4 border rounded">
                                            <div class="col-md-3 col-xl-4 pl-0 pr-0">
                                                <div class="img-event p-3">
                                                    <a href="{{ url('properties/' . optional($pastReview->properties)->slug) }}">
                                                        <img class="room-image-container200 rounded" src="{{ optional($pastReview->properties)->cover_photo }}" alt="img">
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-md-9 col-xl-8 pl-2 pr-2">
                                                <div class="row align-items-center mt-2">
                                                    <div class="col-md-12 p-0">
                                                        <a href="{{ url('properties/' . optional($pastReview->properties)->slug) }}"><p class="font-weight-700 text-18 mb-0">{{ optional($pastReview->properties)->name }} </p></a>

                                                    </div>

                                                    <div class="col-md-12 p-0">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <p class="font-weight-300 mb-0 text-15 mt-2"><i class="fa fa-calendar"></i> {{ optional($pastReview->bookings)->date_range }}</p>
                                                                <p class="text-15 p-0 text-justify mt-2">{{ str_limit($pastReview->message,80) }} </p>
                                                                <button class="btn vbtn-outline-success pl-3 pr-3 pt-2 pb-2 review_detials text-15" data-name="{{ optional($pastReview->properties)->name }}"
                                                                    data-toggle="modal"  data-id="{{ $pastReview->id }}" data-target="#myModal" >
                                                                    {{ __('View Details') }}
                                                                </button>
                                                                <p class="text-15 mt-2"><i class="far fa-clock"></i> {{ $pastReview->created_at->diffForHumans() }}</p>
                                                            </div>

                                                            <div>
                                                                <div class="d-flex w-100 h-100  mt-3 mt-sm-0 p-2">
                                                                    <div class="align-self-center w-100">
                                                                        <div class="row">
                                                                            <div class="row justify-content-center">
                                                                                <div class="col-md-12">
                                                                                    <div class='img-round text-center'>
                                                                                        <a href="{{ url('users/show/' . optional($pastReview->users_from)->id) }}">
                                                                                            <img src="{{ optional($pastReview->users_from)->profile_src }}" alt="{{ optional($pastReview->users_from)->first_name }}" class="rounded-circle img-70x70">
                                                                                        </a>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-12">
                                                                                    <p class="text-center font-weight-700 mb-0">
                                                                                        <a href="{{ url('users/show/' . optional($pastReview->users_from)->id) }}" class="text-color text-color-hover">
                                                                                            {{ optional($pastReview->users_from)->full_name }}
                                                                                        </a>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="row jutify-content-center  w-100 p-4 mt-4">
                                            <div class="text-center w-100">
                                                <img src="{{ asset('public/img/unnamed.png') }}" class="img-fluid"  alt="notfound">
                                                <p class="text-center">{{ __('Nobody to review right now. Looks like it’s time for another trip!') }}</p>
                                            </div>
                                        </div>
                                        @endforelse
                                        <div class="row justify-content-between overflow-auto pb-3 mt-4">
                                            {{ $reviewsByYou->appends(['you' => $reviewsByYou->currentPage()])->links('paginate') }}
                                        </div>
                                    </div>

                                    <div class="tab-pane {{ $expired ?? ' ' }}" id="tabs-3" role="tabpanel">
                                        @forelse ($expiredReviews as $expired)

                                        <div class="row mt-4 border w-100 rounded">
                                            <div class="col-md-3 col-xl-4 pl-0 pr-0">
                                                <div class="img-event p-3">
                                                    <a href="{{ url('properties/' . optional($expired->properties)->slug) }}">
                                                        <img class="room-image-container200 rounded" src="{{ optional($expired->properties)->cover_photo }}" alt="img">
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-md-9 col-xl-8 pl-2 pr-2">
                                                <div class="row align-items-center mt-4">
                                                    <div class="col-md-12 p-0">
                                                        <a href="{{ url('properties/' . optional($expired->properties)->slug) }}"><p class="font-weight-700 mb-0"> {{ optional($expired->properties)->name }}</p></a>
                                                    </div>

                                                    <div class="col-md-12 p-0">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <p class="mt-2"><i class="fa fa-calendar"></i> {{ $expired->date_range }}</p>
                                                                <p class="text-15 text-justify p-0"><i class="far fa-frown-open text-16 text-danger"></i> {{ __('Unfortunately, the deadline to submit a public review for this user has passed.') }}</p>
                                                            </div>

                                                            <div>
                                                                <div class="d-flex w-100 h-100  mt-3 mt-sm-0 p-2">
                                                                    <div class="align-self-center w-100">
                                                                            <div class="row justify-content-center">
                                                                                @if (Auth::user()->id == optional($expired->users)->id)
                                                                                    <div class="col-md-12">
                                                                                        <div class='img-round text-center'>
                                                                                            <a href="{{ url('users/show/' . optional($expired->host)->id) }}"><img src="{{ optional($expired->host)->profile_src }}" alt="{{ optional($expired->host)->first_name }}" class="rounded-circle img-70x70"></a>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-12">
                                                                                        <p class="text-center font-weight-700 mb-0">
                                                                                            <a href="{{ url('users/show/' . optional($expired->host)->id) }}" class="text-color text-color-hover">
                                                                                                {{ optional($expired->host)->first_name }}
                                                                                            </a>
                                                                                        </p>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col-md-12">
                                                                                        <div class='img-round text-center'>
                                                                                            <a href="{{ url('users/show/' . optional($expired->users)->id) }}"><img src="{{ optional($expired->users)->profile_src }}" alt="{{ optional($expired->users)->first_name }}" class="rounded-circle img-70x70"></a>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-12">
                                                                                        <p class="text-center font-weight-700 mb-0">
                                                                                            <a href="{{ url('users/show/' . optional($expired->users)->id) }}" class="text-color text-color-hover">
                                                                                                {{ optional($expired->users)->first_name }}
                                                                                            </a>
                                                                                        </p>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                            <div class="row jutify-content-center w-100 p-4 mt-4">
                                                <div class="text-center w-100">
                                                    <img src="{{ asset('public/img/unnamed.png') }}" class="img-fluid"  alt="notfound">
                                                    <p class="text-center">{{ __('Nobody to review right now. Looks like it’s time for another trip!') }}</p>
                                                </div>
                                            </div>
                                        @endforelse

                                        <div class="row justify-content-between overflow-auto pb-3 mt-4">
                                                {{ $expiredReviews->appends(['expired' => $expiredReviews->currentPage()])->links('paginate') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title font-weight-700" id="name" >Property </h2>
                <button type="button" class="close text-28" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="heading">
                </div>
            </div>

            <div class="modal-footer">
                <pre> </pre>
            </div>
        </div>
    </div>
</div>
@endsection

@section('validation_script')
<script type="text/javascript">
    'use strict'
    var token = "{{ csrf_token() }}";
</script>
<script type="text/javascript" src="{{ asset('public/js/front.min.js') }}"></script>
    
@endsection
