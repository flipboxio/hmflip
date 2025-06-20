<!--================ Header Menu Area start =================-->
<?php
    $lang = Session::get('language');
?>
<input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type') }}">
<header class="header_area  animated fadeIn">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid container-fluid-90">
                <a class="navbar-brand logo_h" aria-label="logo" href="{{ url('/') }}">{!! getLogo('img-130x32') !!}</a>
				<!-- Trigger Button -->
				<a href="#" aria-label="navbar" class="navbar-toggler" data-toggle="modal" data-target="#left_modal">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
                </a>

                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <div class="nav navbar-nav menu_nav justify-content-end">
                            @if (Request::segment(1) != 'help')
                                <div class="nav-item">
                                    <a class="nav-link p-2" href="{{ url('property/create') }}" aria-label="property-create">
                                        <button class="btn vbtn-outline-success text-14 font-weight-700 p-0 mt-2 pl-4 pr-4">
                                            <p class="p-3 mb-0">  {{ __('List your Space') }}</p>
                                        </button>

                                    </a>
                                </div>
                            @endif

                        @if (!Auth::check())
                            <div class="nav-item">
                                <a class="nav-link strip-left" href="{{ url('signup') }}" aria-label="signup">{{ __('Sign Up') }}</a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link" href="{{ url('login') }}" aria-label="login">{{ __('Log In') }}</a>
                            </div>
                        @else
                            <div class="d-flex">
                                <div>
                                    <div class="nav-item mr-0">
                                    <img src="{{ Auth::user()->profile_src }}" class="head_avatar" alt="{{ Auth::user()->first_name }}">
                                </div>
                                </div>
                                <div>
                                <div class="nav-item ml-0 pl-0">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="nav-link dropdown-toggle text-15" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-label="user-profile" aria-haspopup="true" aria-expanded="false">
                                            {{ Auth::user()->first_name }}
                                        </a>
                                        <div class="dropdown-menu drop-down-menu-left p-0 drop-width text-14" aria-labelledby="dropdownMenuButton">
                                            <a class="vbg-default-hover border-0  font-weight-700 list-group-item vbg-default-hover border-0" href="{{ url('dashboard') }}" aria-label="dashboard">{{ __('Dashboard') }}</a>
                                            <a class="font-weight-700 list-group-item vbg-default-hover border-0 " href="{{ url('users/profile') }}" aria-label="profile">{{ __('Profile') }}</a>
                                            <a class="font-weight-700 list-group-item vbg-default-hover border-0 " href="{{ url('logout') }}" aria-label="logout">{{ __('Logout') }}</a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

    </div>
</header>

<!-- Modal Window -->
<div class="modal left fade" id="left_modal" tabindex="-1" role="dialog" aria-labelledby="left_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 secondary-bg">
                @if (Auth::check())
                    <div class="row justify-content-center">
                        <div>
                            <img src="{{ Auth::user()->profile_src }}" class="head_avatar" alt="{{ Auth::user()->first_name }}">
                        </div>

                        <div>
                            <p  class="text-white mt-4"> {{ Auth::user()->first_name }}</p>
                        </div>
                    </div>
                @endif

                <button type="button" class="close text-28" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
			</div>

            <div class="modal-body">
                <ul class="mobile-side">
                    @if (Auth::check())
                        <li><a href="{{ url('dashboard') }}"><i class="fa fa-tachometer-alt mr-3"></i>{{ __('Dashboard') }}</a></li>
                        <li><a href="{{ url('inbox') }}" class="d-flex justify-content-between align-items-center"><div><i class="fas fa-inbox mr-3"></i>{{ __('Inbox') }}</div>
                        @php
							$count = getInboxUnreadCount();
						@endphp
						@if ($count)
                            <span class="badge badge-danger rounded-circle mr-2 text-12">{{ $count }}</span>
						@endif
                        </a></li>
                        <li><a href="{{ url('properties') }}"><i class="far fa-list-alt mr-3"></i>{{ __('Listings') }}</a></li>
                        <li><a href="{{ url('my-bookings') }}"><i class="fa fa-bookmark mr-3"></i>{{ __('Bookings') }}</a></li>
                        <li><a href="{{ url('trips/active') }}"><i class="fa fa-suitcase mr-3"></i> {{ __('Your Trips') }}</a></li>
                        <li><a href="{{ url('user/favourite') }}"><i class="fas fa-heart mr-3"></i> {{ __('Favourite') }}</a></li>
                        <li><a href="{{ url('users/payout-list') }}"><i class="far fa-credit-card mr-3"></i> {{ __('Payouts') }}</a></li>
                        <li><a href="{{ url('users/transaction-history') }}"><i class="fas fa-money-check-alt mr-3 text-14"></i> {{ __('Transactions') }}</a></li>
                        <li><a href="{{ url('users/profile') }}"><i class="far fa-user-circle mr-3"></i>{{ __('Profile') }}</a></li>
                        <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <li><i class="fas fa-user-edit mr-3"></i>{{ __('Reviews') }}</li>
                        </a>

                        <div class="collapse" id="collapseExample">
                            <ul class="ml-4">
                                <li><a href="{{ url('users/reviews') }}" class="text-14">{{ __('Review About You') }}</a></li>
                                <li><a href="{{ url('users/reviews_by_you') }}" class="text-14">{{ __('Review By You') }}</a></li>
                            </ul>
                        </div>
                        <li><a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt mr-3"></i>{{ __('Logout') }}</a></li>
                    @else
                        <li><a href="{{ url('signup') }}"><i class="fas fa-stream mr-3"></i>{{ __('Sign Up') }}</a></li>
                        <li><a href="{{ url('login') }}"><i class="far fa-list-alt mr-3"></i>{{ __('Log In') }}</a></li>
                    @endif

                    @if (Request::segment(1) != 'help')
                        <a href="{{ url('property/create') }}">
                            <button class="btn vbtn-outline-success text-14 font-weight-700 pl-5 pr-5 pt-3 pb-3">
                                    {{ __('List your Space') }}
                            </button>
                        </a>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!--================Header Menu Area =================-->
