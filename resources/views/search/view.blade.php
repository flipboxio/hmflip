@extends('maptemplate')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/daterangepicker.min.css') }}" />
    <link href="{{ asset('public/css/bootstrap-slider.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/user-front.min.css') }}" />

@endpush
@section('main')
    <div class="container-fluid bg-white main-panel border-0 p-0 mt-70">
        <div class="row">
            <!-- Filter section start-->
            <div class="col-md-7  hidden-pod filter-h" id="listCol">
                <div class="row mt-4">
                    <h2 class="p-2">{{ __('Results for') }} <strong class="text-24">{{ $location }}</strong></h2>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <ul class="list-inline  pl-4">
                            <li class="list-inline-item mt-4">
                                <div class="dropdown">
                                    <button class="btn text-16 border border-r-25 pl-4 pr-4 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Location') }}
                                    </button>

                                    <div class="w-100">
                                        <div class="dropdown-menu dropdown-menu-location" aria-labelledby="dropdownMenuButton">
                                            <div class="row p-3">
                                                <form id="front-search-form" method="post" action="{{ url('search') }}">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="font-weight-700 text-14">{{ __('Where are you going?') }} </h3>
                                                            <div class="input-group mt-4">
                                                                <input class="form-control p-3 text-14" id="front-search-field" value="{{ $location }}" autocomplete="off" name="location" type="text" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 p-0">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <div class="d-flex" id="daterange-btn">
                                                                        <div class="pr-2">
                                                                            <h3 class="font-weight-700 mt-4 text-14">{{ __('Check In') }}</h3>
                                                                            <div class="input-group mr-2" >
                                                                                <input class="form-control p-3 border-right-0 border text-14 checkinout" name="checkin" id="startDate" type="text" placeholder="{{ __('Check In') }}" value="{{ $checkin }}" autocomplete="off" readonly="readonly" required>
                                                                                <span class="input-group-append">
                                                                                    <div class="input-group-text">
                                                                                        <i class="fa fa-calendar success-text text-14"></i>
                                                                                    </div>
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div>
                                                                            <h3 class="font-weight-700 mt-4 text-14">{{ __('Check Out') }}</h3>
                                                                            <div class="input-group ml-2">
                                                                                <input class="form-control p-3 border-right-0 border text-14 checkinout" name="checkout" id="endDate" type="text" placeholder="{{ __('Check Out') }}"  value="{{ $checkout }}" readonly="readonly" required>
                                                                                <span class="input-group-append">
                                                                                    <div class="input-group-text">
                                                                                    <i class="fa fa-calendar success-text text-14"></i>
                                                                                    </div>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <h3 class="font-weight-700 mt-4 text-14">{{ __('Guest') }}</h3>
                                                                    <select class="form-control text-16"  id="front-search-guests" name="guests">
                                                                        @for ($i=1;$i<=16;$i++)
                                                                        <option value="{{ $i }}" {{ ($i == $guest) ? 'selected' : '' }}>{{ ($i == '16') ? $i . '+ ' :$i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mt-5 text-center">
                                                            <button class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3" type="submit">
                                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                            {{ __('Find a place') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="list-inline-item  mt-4">
                                <button class="btn text-16 border border-r-25 pl-4 pr-4 dropdown-toggle" type="button" id="dropdownRoomType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Room Type') }}
                                </button>

                                <div class="dropdown-menu dropdown-menu-room-type" aria-labelledby="dropdownRoomType">
                                    <div class="row p-3">
                                        @foreach ($space_type as $rws=>$value)
                                            <div class="col-md-12">
                                                    <div class="d-flex justify-content-between pr-4">
                                                        <div>
                                                            <p class="text-16"><i class="icon icon-entire-place"></i> {{ $value }}</p>
                                                        </div>
                                                        <div>
                                                            <input type="checkbox" id="space_type_{{ $rws }}" name="space_type[]" value="{{ $rws }}" class="form-check-input" {{ in_array($rws, $space_type_selected) ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                            </div>
                                        @endforeach
                                        <div class="col-md-12 text-right mt-4">
                                            <button class="btn vbtn-success text-16 font-weight-700  rounded" id="btnRoom">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="list-inline-item  mt-4">
                                <button class="btn text-16 border border-r-25 pl-4 pr-4 dropdown-toggle" type="button" id="dropdownBookingType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Booking Type') }}
                                </button>

                                <div class="dropdown-menu caed-raise dropdown-menu-room-type" aria-labelledby="dropdownRoomType">
                                    <div class="row p-3">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between pr-4">
                                                <div>
                                                    <p class="text-16"><i class="fa fa-clock text-beach"></i> {{ __('Request to Book') }}</p>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="book_type[]" class="form-check-input" value="request">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between pr-4">
                                                <div>
                                                    <p class="text-16"><i class="fa  fa-bolt text-beach"></i>  {{ __('Instant Book') }}</p>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="book_type[]" class="form-check-input"  value="instant">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 text-right mt-4">
                                            <button class="btn vbtn-success text-16 font-weight-700  rounded" id="btnBook">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="list-inline-item  mt-4">
                                <button class="btn text-16 border border-r-25 pl-4 pr-4 dropdown-toggle" type="button" id="dropdownPrice" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Price Range') }}
                                </button>

                                <div class="dropdown-menu dropdown-menu-price p-4" aria-labelledby="dropdownPrice">
                                    <div class="row p-3 mt-4">
                                        <div class="btn text-16 border price-btn  pl-4 pr-4">
                                            <span>{!! $currency_symbol!!}</span>
                                            <span  id="minPrice">{{ $min_price }}</span>
                                        </div>

                                        <div class="pl-4 pr-4 pt-2 min-w-250">
                                            <input id="price-range" data-provide="slider" data-slider-min="{{ $min_price }}" data-slider-max="{{ $max_price }}" data-slider-value="[{{ $min_price }},{{ $max_price }}]"/>
                                        </div>

                                        <div class="btn text-16 border price-btn  pl-4 pr-4 ">
                                            <span>{!! $currency_symbol!!}</span>
                                            <span  id="maxPrice">{{ $max_price }}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 text-right mt-4">
                                            <button class="btn vbtn-success text-16 font-weight-700  rounded" id="btnPrice">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="list-inline-item  mt-4">
                                <button type="button"  id="more_filters"   class="font-weight-500 btn text-16 border border-r-25 pl-4 pr-4" data-toggle="modal" data-target="#exampleModalCenter">
                                    {{ __('More Filters') }}
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="pr-5">
                        <div class="show-map d-none" id="showMap">
                            <a href="#" class="btn text-16 border"><i class="fas fa-map-marked-alt"></i> {{ __('Show Map') }}</a>
                        </div>
                    </div>
                </div>
                <!-- No result found section start -->
                <div class="row mt-4">
                    <div id="loader" class="display-off loader-img position-center">
                        <img src="{{ asset('public/front/img/green-loader.gif') }}" alt="loader">
                    </div>
                </div>

                <div class="row mt-3">
                    <div id="properties_show" class="row w-100">
                        <div class="text-center justify-content-center w-100 position-center">
                            <!-- not found image -->
                        </div>
                    </div>
                </div>
                <!-- No result found section end -->

                <!-- Pagination start -->
                <div class="row mt-4 mb-5">
                    <div id="pagination">
                        <ul class="pager ml-4 pagination" id="pager">
                        <!--Pagination -->
                        </ul>
                        <div class="pl-3 text-16 mt-4"><span id="page-from">0</span> – <span id="page-to">0</span> {{ __('of') }} <span id="page-total">0</span> {{ __('Rentals') }}</div>
                    </div>
                </div>
                <!-- Pagination end -->
            </div>
            <!-- Filter section end -->

            <!--Map section start -->
            <div class="col-md-5 p-0" id="mapCol">
                <div class="map-close" id="closeMap"><i class="fas fa-times text-24 p-3 pl-4 text-center"></i></div>
                <div id="map_view" class="map-view"></div>
            </div>
            <!--Map section end -->
        </div>

            <!-- Modal -->
            <div class="modal fade mt-5 z-index-high" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="w-100 pt-3">
                                <h5 class="modal-title text-20 text-center font-weight-700" id="exampleModalLongTitle">{{ __('More Filters') }}</h5>
                            </div>

                            <div>
                                <button type="button" class="close text-28 mr-2" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>

                        <div class="modal-body modal-body-filter">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="font-weight-700 text-24 mt-2 p-4" for="user_birthdate">{{ __('Size') }}</h5>
                                </div>

                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="select col-sm-4">
                                            <select name="min_bedrooms" class="form-control" id="map-search-min-bedrooms">
                                                <option value="">{{ __('Bedrooms') }}</option>
                                                @for ($i=1;$i<=10;$i++)
                                                    <option value="{{ $i }}" {{ ($bedrooms == $i) ?'selected' : ''}}>
                                                        {{ $i }} {{ __('Bedrooms') }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="select col-sm-4">
                                            <select name="min_bathrooms" class="form-control" id="map-search-min-bathrooms">
                                                <option value="">{{ __('Bathrooms') }}</option>
                                                @for ($i=1;$i<=8;$i+=1)
                                                    <option class="bathrooms" value="{{ $i }}" {{ $bathrooms == $i ? 'selected' : ''}}>
                                                        {{ ($i == '8') ? $i . '+' : $i }} {{ __('Bathrooms') }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="select col-sm-4">
                                            <select name="min_beds" class="form-control" id="map-search-min-beds">
                                                <option value="">{{ __('Beds') }}</option>
                                                @for ($i=1;$i<=16;$i++)
                                                    <option value="{{ $i }}" {{ $beds == $i ? 'selected' : ''}}>
                                                        {{ ($i == '16') ? $i . '+' : $i }} {{ __('Beds') }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-sm-12">
                                    <h5 class="font-weight-700 text-24 pl-4" for="user_birthdate">{{ __('Amenities') }}</h5>
                                </div>

                                <div class="col-sm-12">
                                    <div class="row">
                                        @php $row_inc = 1 @endphp

                                        @foreach ($amenities as $row_amenities)
                                            @if ($row_inc <= 4)
                                                <div class="col-md-6">
                                                    <div class="form-check mt-4">
                                                        <input type="checkbox" name="amenities[]" value="{{ $row_amenities->id }}" class="form-check-input mt-2 amenities_array" id="map-search-amenities-{{ $row_amenities->id }}">
                                                        <label class="form-check-label mt-2 ml-25" for="exampleCheck1"> {{ $row_amenities->title }}</label>
                                                    </div>
                                                </div>
                                            @endif

                                            @php $row_inc++ @endphp
                                        @endforeach

                                        <div class="collapse" id="amenities-collapse">
                                            <div class="row">
                                                @php $amen_inc = 1 @endphp
                                                @foreach ($amenities as $row_amenities)
                                                    @if ($amen_inc > 4)
                                                        <div class="col-md-6 mt-4">
                                                            <div class="form-check">
                                                                <input type="checkbox" name="amenities[]" value="{{ $row_amenities->id }}" class="form-check-input mt-2 amenities_array" id="map-search-amenities-{{ $row_amenities->id }}" ng-checked="{{ (in_array($row_amenities->id, $amenities_selected)) ? 'true' : 'false' }}">
                                                                <label class="form-check-label mt-2 ml-25" for="exampleCheck1"> {{ $row_amenities->title }}</label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @php $amen_inc++ @endphp
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="cursor-pointer" data-toggle="collapse" data-target="#amenities-collapse" >
                                        <span class="font-weight-600 ml-4"><u> Show all amenities</u></span>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-sm-12">
                                    <h5 class="font-weight-700 text-24 pl-4" for="user_birthdate">{{ __('Property Type') }}</h5>
                                </div>

                                <div class="col-sm-12">
                                    <div class="row mt-2">
                                        @php $pro_inc = 1 @endphp
                                        @foreach ($property_type as $row_property_type =>$value_property_type)
                                            @if ($pro_inc <= 4)
                                                <div class="col-md-6">
                                                    <div class="form-check mt-4">
                                                        <input type="checkbox" name="property_type[]" value="{{ $row_property_type }}" class="form-check-input mt-2" id="map-search-property_type-{{ $row_property_type }}">
                                                        <label class="form-check-label mt-2 ml-25" for="exampleCheck1"> {{ $value_property_type}}</label>
                                                    </div>
                                                </div>
                                            @endif
                                            @php $pro_inc++ @endphp
                                        @endforeach

                                        <div class="collapse" id="property-collapse">
                                            <div class="row">
                                                @php $property_inc = 1 @endphp
                                                @foreach ($property_type as $row_property_type =>$value_property_type)
                                                    @if ($property_inc > 4)
                                                        <div class="col-md-6 mt-4">
                                                            <div class="form-check">
                                                                <input type="checkbox" name="property_type[]" value="{{ $row_property_type }}" class="form-check-input mt-2" id="map-search-property_type-{{ $row_property_type }}">
                                                                <label class="form-check-label mt-2 ml-25" for="exampleCheck1"> {{ $value_property_type}}</label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @php $property_inc++ @endphp
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="cursor-pointer" data-toggle="collapse" data-target="#property-collapse" >
                                        <span class="font-weight-600 text-16 ml-4"><u> Show all property type</u></span>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer p-4">
                            <button class="btn btn-outline-danger text-16 pl-3 pr-3 mr-4"  data-dismiss="modal">{{ __('Cancel') }}</button>
                            <button class="btn vbtn-outline-success filter-apply text-16 mr-5 pl-3 pr-3 ml-2" data-dismiss="modal">{{ __('Apply Filter') }}</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('validation_script')
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ config("vrent.google_map_key") }}&libraries=places'></script>
	<script type="text/javascript" src="{{ asset('public/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('public/js/locationpicker.jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/daterangecustom.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap-slider.min.js') }}"></script>

    <script type="text/javascript">
        'use strict'
        $("#price-range").slider();

        var dateFormat = "{{ Session::get('front_date_format_type') }}";
        var loadPage = '{{ url("search/result") }}';
        var markers      = [];
        var allowRefresh = true;
        var map_loc ='';
        var symbolPosition = ' {{ currencySymbolPosition() }}';
        var token = "{{ csrf_token() }}";
        var nightText = "{{ __('night') }}";
        var guestText = "{{ __('Guests') }}";
        var bedroomsText = "{{ __('Bedrooms') }}";
        var bathroomsText = "{{ __('Bathrooms') }}";
        var notFoundImage = "{{ url('public/img/not-found.png') }}";
        var noResult = "{{ __('No Results Found') }}";
        var latitude = "{{ $lat }}";
        var longitude = "{{ $long }}";
        var user_id = "{{ Auth::id() }}";
        var success = "{{ __('Success') }}";
        var yes = "{{ __('Yes') }}";
        var no = "{{ __('No') }}";
        var add = "{{ __('Add to Favourite List ?') }}";
        var remove = "{{ __('Remove from Favourite List ?') }}";
        var added = "{{ __('Added to favourite list.') }}";
        var removed = "{{ __('Removed from favourite list.') }}";
        const BaseURL = "{{ url('/') }}";
       
    </script>
    <script type="text/javascript" src="{{ asset('public/js/map-search.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/front.min.js') }}"></script>
    
@endsection
   
