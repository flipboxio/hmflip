@extends('template')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/glyphicon.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/js/ninja/ninja-slider.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/single-property.min.css') }}">
@endpush

@section('main')

<input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type') }}">

<div class="carousel-inner" role="listbox">
    <div class="item active">
        <div class="ex-image-container" onclick="lightbox(0)" style="background-image:url('{{ $result->cover_photo }}');">
        </div>
    </div>
</div>
<div class="container-fluid container-fluid-90">
    <div class="row" id="mainDiv">
        <div class="col-lg-8 col-xl-9">
            <div id="sideDiv">
                <div class="d-flex border rounded-4 p-4 mt-4">
                    <div class="text-center">
                        <a href="{{ url('users/show/' . $result->host_id) }}">
                            <img alt="User Profile Image" class="img-fluid rounded-circle mr-4 img-90x90"
                                src="{{ $result->users->profile_src }}" title="{{ $result->users->first_name }}">
                        </a>
                    </div>

                    <div class="ml-2">
                        <h3 class="text-20 mt-4"><strong>{{ $result->name }}</strong></h3>
                        <span class="text-14 gray-text"><i class="fas fa-map-marker-alt"></i> 
                            {{ $result->property_address->city }} @if ($result->property_address->city !=''),@endif 
                            {{ $result->property_address->state }} @if ($result->property_address->state !=''),@endif 
                            {{ $result->property_address->countries->name }}
                        </span>
                        @if ($result->avg_rating)
                            <p> <i class="fa fa-star secondary-text-color"></i> {{ sprintf("%.1f",$result->avg_rating ) }} ({{ $result->guest_review }})</p>
                        @endif
                    </div>
                    <div class="ml-auto">
                        @auth
                            <a class="btn btn-sm book_mark_change" data-status="{{ $result->book_mark }}"
                                data-id="{{ $result->id }}" style="color:{{ ($result->book_mark == true) ? '#1dbf73' : '' }}; ">
                                <span style="font-size: 22px;">
                                    <i class="fas fa-heart pl-5"></i>
                                </span>
                            </a>
                        @else
                            <a class="btn btn-sm book_mark_change" data-id="{{ $result->id }}"
                                style="color:#1dbf73 }}; ">
                                <span style="font-size: 22px;">	
                                    <i class="fas fa-heart pl-2"></i>
                                </span>
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="row justify-content-between mt-4 ">
                    <div class="col text-center border p-4 rounded mt-3 mr-2 mr-sm-5 bg-light text-dark">
                        <i class="fa fa-home fa-2x" aria-hidden="true"></i>
                        <div>{{ $result->space_type_name }}</div>
                    </div>

                    <div class="col text-center border p-4 rounded mt-3 bg-light text-dark">
                        <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                        <div> {{ $result->accommodates }} {{ __('Guests') }} </div>
                    </div>

                    <div class="col text-center border p-4 rounded mt-3 ml-2 ml-sm-5 bg-light text-dark">
                        <i class="fa fa-bed fa-2x" aria-hidden="true"></i>
                        <div>
                            {{ $result->beds }} {{ __('Beds') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center border rounded pb-5 mt-5 desktop" id="listMargin">
                <div class="col-md-12 mt-3 pl-4 pr-4">
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h2><strong>{{ __('About this listing') }}</strong> </h2>
                                <p class="mt-4 text-justify">{{ $result->property_description->summary }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <div class="d-flex h-100">
                                    <div class="align-self-center">
                                        <h2 class="font-weight-700 text-18">
                                            {{ __('The Space') }}</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 col-sm-9">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        @if ($result?->bed_types?->name != NULL)
                                            <div>
                                                <span class="font-weight-600">{{ __('Bed type') }}:</span>
                                                {{ $result?->bed_types?->name }}
                                            </div>
                                        @endif

                                        <div>
                                            <strong>{{ __('Property type') }}:</strong> {{ $result?->property_type_name }}
                                        </div>

                                        <div>
                                            <strong>{{ __('Accommodates') }}:</strong> {{ $result?->accommodates }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div>
                                            <strong>{{ __('Bedrooms') }}:</strong> {{ $result?->bedrooms }}
                                        </div>

                                        <div>
                                            <strong>{{ __('Bathrooms') }}:</strong> {{ $result?->bathrooms }}
                                        </div>

                                        <div>
                                            <strong>{{ __('Beds') }}:</strong> {{ $result?->beds }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <div class="d-flex h-100">
                                    <div class="align-self-center">
                                        <h2 class="font-weight-700 text-18">
                                            {{ __('Amenities') }}</h2>
                                    </div>
                                </div>
                            </div>
                            @if (count($amenities) != 0)

                                  <div class="col-md-9 col-sm-9">
                                    <div class="row">
                                        @php $i = 1 @endphp

                                        @php $count = round(count($amenities)/2) @endphp
                                        @foreach ($amenities as $all_amenities)
                                            @if ($i < 6)
                                                <div class="col-md-6 col-sm-6">
                                                    <div>
                                                        <i class="icon h3 icon-{{ $all_amenities->symbol }}" aria-hidden="true"></i>
                                                        @if ($all_amenities->status == null)
                                                            <del>
                                                                {{ $all_amenities->title }}
                                                            </del>
                                                        @else
                                                            {{ $all_amenities->title }}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                            @php $i++ @endphp

                                        @endforeach
                                        @if ($i > 6)
                                            <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                                <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2" data-toggle="modal" data-target="#exampleModalCenter">
                                                    + {{ __('More') }}
                                                </button>
                                            </div>
                                        @endif

                                </div>
                            @else
                                <div class="col-md-9 col-sm-9">
                                     <b style="font-weight: bold">{{ __('There is no Amenities') }}</b>
                                 </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="d-flex h-100">
                                <div class="align-self-center">
                                    <h2 class="font-weight-700 text-18">{{ __('Prices') }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 col-sm-9">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div> <i class="fa fa-users text-13 mr-2" style="color: #5d717fa2"></i> {{ __('Extra people') }}:
                                        <strong>
                                            @if ($result->property_price->guest_fee !=0)
                                            <span>
                                                {!! __(':x / night after the', ['x' => moneyFormat($symbol, $result->property_price->guest_fee)]) !!}
                                                {{ __(':x guest', ['x' => $result->property_price->guest_after] ) }}</span>
                                            @else
                                            <span>{{ __('No Charge') }}</span>
                                            @endif
                                        </strong>
                                    </div>

                                    <div>
                                        <i class="fa fa-arrow-down mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i> {{ __('Weekly discount') }} (%):
                                        @if ($result->property_price->weekly_discount != 0)
                                        <strong> <span id="weekly_price_string">{!! moneyFormat($symbol,
                                                $result->property_price->weekly_discount) !!}</span>
                                            /{{ __('week') }}</strong>
                                        @else
                                        <strong><span id="weekly_price_string">{!! moneyFormat($symbol,
                                                $result->property_price->weekly_discount) !!}</span>
                                            /{{ __('week') }}</strong>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div>
                                        <i class="fa fa-arrow-down mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                        {{ __('Monthly discount') }} (%):
                                        @if ($result->property_price->monthly_discount != 0)
                                        <strong>
                                            <span id="weekly_price_string">{!! moneyFormat($symbol,
                                                $result->property_price->monthly_discount) !!}</span>
                                            /{{ __('month') }}
                                        </strong>
                                        @else
                                        <strong><span id="weekly_price_string">{!! moneyFormat($symbol,
                                                $result->property_price->monthly_discount) !!}</span>
                                            /{{ __('month') }}</strong>
                                        @endif
                                    </div>

                                    <!-- weekend price -->
                                    @if ($result->property_price->weekend_price > 0)
                                        <div>
                                            <i class="fa fa-calendar-minus mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                            {{ ('Weekend pricing') }}:
                                            <strong>
                                                <span id="weekly_price_string">{!! $symbol !!} {{ $result->property_price->weekend_price }}</span> /
                                                {{ __('Weekend Night') }}
                                            </strong>
                                        </div>
                                    @endif
                                    <!-- end weekend price -->
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (count($safetyAmenities) !=0)
                    <hr>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="d-flex h-100">
                                <div class="align-self-center">
                                    <h2 class="font-weight-700 text-18">
                                        {{ __('Safety Features') }}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 col-sm-9">
                            <div class="row">
                                @php $i = 1 @endphp
                                @foreach ($safetyAmenities as $row_safety)
                                    @if ($i < 6)
                                    <div class="col-md-6 col-sm-6">
                                        <i class="fa h3 fa-{{ $row_safety->symbol }}" aria-hidden="true"></i>
                                        @if ($row_safety->status == null)
                                            <del>
                                                {{ $row_safety->title }}
                                            </del>
                                        @else
                                            {{ $row_safety->title }}
                                        @endif
                                    </div>
                                    @endif
                                    @php $i++ @endphp
                                @endforeach

                                @if ($i>6)
                                    <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                        <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2" data-toggle="modal" data-target="#safetyModal">
                                            + {{ __('More') }}
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @if (count($allNewAmenities) != 0)
                        @foreach ($allNewAmenities as $key => $newAmenities)
                            <hr>
                            <div class="row">
                                <div class="col-md-3 col-sm-3">
                                    <div class="d-flex h-100">
                                        <div class="align-self-center">
                                            <h2 class="font-weight-700 text-18"> {{ $key }}</h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-9 col-sm-9">
                                    <div class="row">
                                        @php $i = 1 @endphp
                                        @foreach ($newAmenities as $row_safety)
                                            @if ($i < 6)
                                                <div class="col-md-6 col-sm-6">
                                                    <i class="fa h3 fa-{{ $row_safety->symbol }}" aria-hidden="true"></i>
                                                    @if ($row_safety->status == null)
                                                        <del>
                                                            {{ $row_safety->title }}
                                                        </del>
                                                    @else
                                                        {{ $row_safety->title }}
                                                    @endif
                                                </div>
                                            @endif
                                            @php $i++ @endphp
                                        @endforeach
                                        @if ($i>6)
                                            <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                                <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2"
                                                    data-toggle="modal" data-target="#exampleModalCenter_{{ str_replace(" ","-",$key) }}">
                                                    + {{ __('More') }}
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if ($result?->property_description->about_place !='' ||
                    $result->property_description->place_is_great_for !='' ||
                    $result->property_description->guest_can_access !='' ||
                    $result->property_description->interaction_guests !='' || $result->property_description->other ||
                    $result->property_description->about_neighborhood || $result->property_description->get_around)
                    <hr>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="d-flex h-100">
                                <div class="align-self-center">
                                    <h2 class="font-weight-700 text-18">
                                        {{ __('Description') }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 col-sm-9">
                            @if ($result->property_description->about_place)
                                <strong class="font-weight-700">{{ __('About Place') }}</strong>
                                <p class="text-justify">{{ $result->property_description->about_place }}</p>
                            @endif

                            @if ($result->property_description->place_is_great_for)
                                <strong
                                    class="font-weight-700">{{ __('Place is Greate For') }}</strong>
                                <p class="text-justify">{{ $result->property_description->place_is_great_for }} </p>
                            @endif

                            <a href="javascript:void(0)" id="description_trigger_mobile" data-rel="description"
                                class="more-btn-mobile"><strong>+ {{ __('More') }}</strong></a>
                            <div class="d-none" id='description_after_mobile'>
                                @if ($result->property_description->interaction_guests)
                                    <strong
                                        class="font-weight-700">{{ __('Interaction with Guests') }}</strong>
                                    <p class="text-justify"> {{ $result->property_description->interaction_guests }}</p>
                                @endif

                                @if ($result->property_description->about_neighborhood)
                                    <strong
                                        class="font-weight-700">{{ __('About Neighborhood') }}</strong>
                                    <p class="text-justify"> {{ $result->property_description->about_neighborhood }}</p>
                                @endif

                                @if ($result->property_description->guest_can_access)
                                    <strong
                                        class="font-weight-700">{{ __('Guest can Access') }}</strong>
                                    <p class="text-justify">{{ $result->property_description->guest_can_access }}</p>
                                @endif

                                @if ($result->property_description->get_around)
                                    <strong
                                        class="font-weight-700">{{ __('Get Around') }}</strong>
                                    <p class="text-justify">{{ $result->property_description->get_around }}</p>
                                @endif

                                @if ($result->property_description->other)
                                    <strong class="font-weight-700">{{ __('Other') }}</strong>
                                    <p class="text-justify">{{ $result->property_description->other }}</p>
                                @endif
                                <a href="javascript:void(0)" id="description_less" data-rel="description"
                                    class="less-btn-mobile"><strong>{{ __('- less') }}</strong></a>

                            </div>
                        </div>
                    </div>
                    @endif
                    <hr>
                    <!--popup slider end-->
                    @if (count($result->property_photos) > 0)
                        <div class="row mt-4">
                            <div class="col-md-12 col-sm-12 pl-3 pr-3">
                                <div class="row">
                                    @php $i=0 @endphp

                                    @foreach ($result->property_photos as $row_photos)
                                    @if ($i == 0)
                                    <div class="col-md-12 col-sm-12 mb-2 mt-2 p-2">
                                        <div class="slider-image-container" onclick="lightbox({{ $i }})"
                                            style="background-image:url({{ url('public/images/property/' . $result->id . '/' . $row_photos->photo) }});">
                                        </div>
                                    </div>
                                    @elseif ($i <= 4) @if ($i==4) <div class="p-2 position-relative">
                                        <div class="view-all gal-img h-110px">
                                            <img src="{{ url('public/images/property/' . $result->id . '/' . $row_photos->photo) }}"
                                                alt="property-photo" class="img-fluid h-110px rounded"
                                                onclick="lightbox({{ $i }})" />
                                            <span class="position-center cursor-pointer"
                                                onclick="lightbox({{ $i }})">{{ __('View All') }}</span>
                                        </div>
                                </div>

                                @else
                                <div class="p-2">
                                    <div class="h-110px gal-img">
                                        <img src="{{ url('public/images/property/' . $result->id . '/' . $row_photos->photo) }}"
                                            alt="property-photo" class="img-fluid h-110px rounded"
                                            onclick="lightbox({{ $i }})" />
                                    </div>
                                </div>
                                @endif





                                @else
                                @php break; @endphp
                                @endif
                                @php $i++ @endphp
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <hr>
                
            </div>

            <!--Start Reviews-->
            @if (!$result->reviews->count())
            <div class="mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <h2><strong>{{ __('No Reviews Yet') }}</strong></h2>
                    </div>

                    @if ($result->users->reviews->count())
                    <div class="col-md-12">
                        <p>{{ __('This host has :count review for other properties.',['count'=>$result->users->guest_review]) }}</p>
                        <p class="text-center mt-5 mb-4">
                            <a href="{{ url('users/show/' . $result->users->id) }}" class="btn btn vbtn-outline-success text-14 font-weight-700 pl-5 pr-5 pt-3 pb-3">
                            {{  __('View Other Reviews') }}</a>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex">
                            <div>
                                <h2 class="text-20"><strong> {{ __('Review') }}</strong></h2>
                            </div>

                            <div class="ml-4">
                                <p> <i class="fa fa-star secondary-text-color"></i> {{ sprintf("%.1f",$result->avg_rating) }} ({{ $result->guest_review }})</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="font-weight-700 text-16">{{ __('Summary') }}</h3>
                    </div>

                    <div class="col-md-12">
                        <div class="mt-3 p-4 pt-3 pb-3 border rounded">
                            <div class="row justify-content-between">
                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ __('Accuracy') }}</h4>
                                        </div>

                                        <div>
                                            <progress max="5" value="{{ $result->accuracy_avg_rating }}">
                                                <div class="progress-bar">
                                                    <span></span>
                                                </div>
                                            </progress>
                                            <span> {{ sprintf("%.1f",$result->accuracy_avg_rating) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ __('Location') }}</h4>
                                        </div>

                                        <div>
                                            <progress max="5" value="{{ $result->location_avg_rating }}">
                                                <div class="progress-bar">
                                                    <span></span>
                                                </div>
                                            </progress>
                                            <span> {{ sprintf("%.1f",$result->location_avg_rating) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="text-truncate">{{ __('Communication') }}</h4>
                                        </div>

                                        <div>
                                            <progress max="5" value="{{ $result->communication_avg_rating }}">
                                                <div class="progress-bar">
                                                    <span></span>
                                                </div>
                                            </progress>
                                            <span> {{ sprintf("%.1f",$result->communication_avg_rating) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ __('Check In') }}</h4>
                                        </div>

                                        <div>
                                            <progress max="5" value="{{ $result->checkin_avg_rating }}">
                                                <div class="progress-bar">
                                                    <span></span>
                                                </div>
                                            </progress>
                                            <span> {{ sprintf("%.1f",$result->checkin_avg_rating) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ __('Cleanliness') }}</h4>
                                        </div>

                                        <div>
                                            <progress max="5" value="{{ $result->cleanliness_avg_rating }}">
                                                <div class="progress-bar">
                                                    <span></span>
                                                </div>
                                            </progress>
                                            <span> {{ sprintf("%.1f",$result->cleanliness_avg_rating) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ __('Value') }}</h4>
                                        </div>

                                        <div>
                                            <ul>
                                                <li>
                                                    <progress max="5" value="{{ $result->value_avg_rating }}">
                                                        <div class="progress-bar">
                                                            <span></span>
                                                        </div>
                                                    </progress>
                                                    <span> {{ sprintf("%.1f",$result->value_avg_rating) }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div class="row">
                    @foreach ($result->reviews as $row_review)
                    @if ($row_review->reviewer == 'guest')
                    <div class="col-12 mt-4 mb-2">
                        <div class="d-flex">
                            <div class="">
                                <div class="media-photo-badge text-center">
                                    <a href="{{ url('users/show/' . $row_review->users->id) }}"><img
                                            alt="{{ $row_review->users->first_name }}" class=""
                                            src="{{ $row_review->users->profile_src }}"
                                            title="{{ $row_review->users->first_name }}"></a>
                                </div>
                            </div>

                            <div class="ml-2 pt-2">
                                <a href="{{ url('users/show/' . $row_review->users->id) }}">
                                    <h2 class="text-16 font-weight-700">{{ $row_review->users->full_name }}</h2>
                                </a>
                                <p class="text-14 text-muted"><i class="far fa-clock"></i> {{ dateFormat($row_review->date_fy) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="background text-15">
                            @for($i=1; $i <=5 ; $i++) @if ($row_review->rating >= $i)
                                <i class="fa fa-star secondary-text-color"></i>
                                @else
                                <i class="fa fa-star"></i>
                                @endif
                                @endfor
                        </div>
                        <p class="mt-2 text-justify pr-4">{{ $row_review->message }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="mt-4">
                @if ($result->users->reviews->count() - $result->reviews->count())
                <div class="row">

                    <div class="col-md-12">
                        <p class="text-center mt-2">
                            <a target="blank"
                                class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5"
                                href="{{ url('users/show/' . $result->users->id) }}">
                                <span>{{ __('View Other Reviews') }}</span>
                            </a>
                        </p>
                    </div>
                </div>
                @endif
            </div>
            @endif
            <hr>
            <!--End Reviews-->
            <div class="mt-5">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <h2><strong>{{ __('About the Host') }}</strong></h2>
                    <div class="d-flex mt-4">
                        <div class="">
                            <div class="media-photo-badge text-center">
                                <a href="{{ url('users/show/' . $result->host_id) }}"><img
                                        alt="{{ $result->users->first_name }}" class=""
                                        src="{{ $result->users->profile_src }}"
                                        title="{{ $result->users->first_name }}"></a>
                            </div>
                        </div>

                        <div class="ml-2 pt-3">
                            <a href="{{ url('users/show/' . $result->host_id) }}">
                                <h2 class="text-16 font-weight-700">{{ $result->users->full_name }}</h2>
                            </a>
                            <p>{{ __('Member since') }} {{ date('F Y',
                                strtotime($result->users->created_at)) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4 col-xl-3 mb-4 mt-4">
    <div id="sticky-anchor" class="d-none d-md-block"></div>
    <div class="card p-4">
        <div id="booking-price" class="panel panel-default">
            <div class="" id="booking-banner" class="">
                <div class="secondary-bg rounded">
                    <div class="col-lg-12">
                        <div class="row justify-content-between p-3">
                            <div class="text-white">
                                {!! moneyFormat($symbol, numberFormat($result->property_price->price,2)) !!}
                            </div>

                            <div class="text-white text-14">
                                <div id="per_night" class="per-night">
                                    {{ __('Per Night') }}
                                </div>
                                <div id="per_month" class="per-month display-off">
                                    {{ __('Per Month') }}
                                    <i id="price-info-tooltip" class="fa fa-question hide" data-behavior="tooltip"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <form accept-charset="UTF-8" method="post" action="{{ url('payments/book/' . $result->id) }}"
                    id="booking_form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12  p-4 single-border border-r-10 ">
                            <div class="row p-2" id="daterange-btn">
                                <div class="col-6 p-0">
                                    <label>{{ __('Check In') }}</label>
                                    <div class="mr-2">
                                        <input class="form-control" id="startDate" name="checkin"
                                            value="{{ $checkin ? $checkin : onlyFormat(date('d-m-Y', time() + 86400)) }}"
                                            placeholder="dd-mm-yyyy" type="text" required>
                                    </div>
                                </div>
                                <input type="hidden" id="property_id" value="{{ $result->id }}">
                                <input type="hidden" id="room_blocked_dates" value="">
                                <input type="hidden" id="calendar_available_price" value="">
                                <input type="hidden" id="room_available_price" value="">
                                <input type="hidden" id="price_tooltip" value="">
                                <input type="hidden" id="url_checkin" value="{{ $checkin }}">
                                <input type="hidden" id="url_checkout" value="{{ $checkout }}">
                                <input type="hidden" id="url_guests" value="{{ $guests }}">
                                <input type="hidden" name="booking_type" id="booking_type"
                                    value="{{ $result->booking_type }}">

                                <div class="col-6 p-0">
                                    <label>{{ __('Check Out') }}</label>
                                    <div class="ml-2">
                                        <input class="form-control" id="endDate" name="checkout"
                                            value="{{ $checkout ? $checkout : onlyFormat(date('d-m-Y', time() + 86400)) }}"
                                            placeholder="dd-mm-yyyy" type="text" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 p-0">
                                    <div class=" ml-2 mr-2 ">
                                        <label>{{ __('guest') }}</label>
                                        <div class="">
                                            <select id="number_of_guests" class="form-control" name="number_of_guests">
                                                @for($i=1; $i<= $result->accommodates; $i++)
                                                    <option value="{{ $i }}" <?= $guests == $i ? 'selected' : '' ?>>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="book_it" class="mt-4">
                        <div class="js-subtotal-container booking-subtotal panel-padding-fit">
                            <div id="loader" class="display-off single-load">
                                <img src="{{ asset('public/front/img/green-loader.gif') }}" alt="loader">
                            </div>
                            <div class="table-responsive price-table-scroll">
                                <table class="table table-bordered price_table" id="booking_table">
                                    <tbody>
                                        <div id="append_date">

                                        </div>
                                        <tr>
                                            <td class="pl-4 w-50">
                                                <span id="total_night_count" value="">0</span>
                                                {{ __('Nights') }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="total_night_price" value=""> 0 </span>
                                                <span id="custom_price" class="fa fa-info-circle secondary-text-color"
                                                    data-html="true" data-toggle="tooltip" data-placement="top"
                                                    title=""></span></td>
                                        </tr>

                                        <tr>
                                            <td class="pl-4">
                                                {{ __('Service Fee') }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="service_fee" value=""> 0 </span></td>
                                        </tr>

                                        <tr class="additional_price">
                                            <td class="pl-4">
                                                {{ __('Additional Guest fee') }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="additional_guest" value=""> 0 </span>
                                            </td>
                                        </tr>

                                        <tr class="security_price">
                                            <td class="pl-4">
                                                {{ __('Security Fee') }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="security_fee" value=""> 0 </span></td>
                                        </tr>

                                        <tr class="cleaning_price">
                                            <td class="pl-4">
                                                {{ __('Cleaning Fee') }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="cleaning_fee" value=""> 0 </span></td>
                                        </tr>

                                        <tr class="iva_tax">
                                            <td class="pl-4">
                                                {{ __('I.V.A Tax') }}
                                            </td>
                                            <td class="pl-4 text-right"> <span id="iva_tax" value=""> 0 </span></td>
                                        </tr>

                                        <tr class="accomodation_tax">
                                            <td class="pl-4">
                                                {{ __('Accommodation Tax') }}
                                            </td>
                                            <td class="pl-4 text-right"> <span id="accomodation_tax" value=""> 0 </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="pl-4">
                                                {{ __("Discount") }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="discount" value="">0 </span></td>
                                        </tr>

                                        <tr>
                                            <td class="pl-4">{{ __('Total') }}</td>
                                            <td class="pl-4 text-right"><span id="total" value=""> 0 </span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="book_it_disabled" class="text-center d-none">
                            <p id="book_it_disabled_message" class="icon-rausch text-danger">
                                
                            </p>
                            <a href="{{ url('search?location=' . $result->property_address->city) }}"
                                class="btn btn-large btn-block text-14" id="view_other_listings_button">
                                {{ __('View Other Listing') }}
                            </a>
                        </div>

                        <div id="minimum_disabled" class="text-center d-none">
                            <p class="icon-rausch text-danger">
                                {{ __('You have to book minimum') }} <span
                                    id="minimum_disabled_message"></span>
                                {{ __('night\'s on this date') }}
                            </p>
                            <a href="{{ url('search?location=' . $result->property_address->city) }}"
                                class="btn btn-large btn-block text-14" id="view_other_listings_button">
                                {{ __('View Other Listing') }}
                            </a>
                        </div>
                        <div class="book_btn col-md-12 text-center {{ ($result->host_id == Auth()->user()?->id || $result->status == 'Unlisted') ? 'display-off' : '' }}">
                            @if ( ($adminPropertyApproval == 'Yes' && $result->is_verified != 'Pending') ||  $adminPropertyApproval == 'No')
                                <button type="submit"
                                    class="btn vbtn-outline-success text-14 font-weight-700 mt-3 pl-5 pr-5 pt-3 pb-3"
                                    id="save_btn">
                                    <i class="spinner fa fa-spinner fa-spin d-none"></i>
                                    <span class="{{ ($result->booking_type != 'instant') ? '' : 'display-off' }}">
                                        {{ __('Request to Book') }}
                                    </span>
                                    <span class="{{ ($result->booking_type == 'instant') ? '' : 'display-off' }}">
                                        <i class="icon icon-bolt text-beach h4"></i>
                                        {{ __('Instant Book') }}
                                    </span>
                                </button>
                            @endif
                        </div>

                        <p class="col-md-12 text-center mt-3">{{ __('You’ll be able to review before paying.') }}</p>

                        <ul class="list-inline text-center d-flex align-items-center justify-content-center">
                            <li class="list-inline-item">
                                @php
                                echo '<iframe
                                    src="https://www.facebook.com/plugins/share_button.php?href=' . $shareLink . '&layout=button&size=large&mobile_iframe=true&width=73&height=28&appId"
                                    width="76" height="28" class="overflow-hidden border-0" scrolling="no"
                                    frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>';
                                @endphp
                            </li>

                            <li class="list-inline-item">
                                <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=" . $title
                                    data-size="large" aria-label="tweet">Tweet</a>
                            </li>

                            <li class="list-inline-item">
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareLink }}&title={{ $title }}&summary={{ $result->property_description->summary }}"
                                    aria-label="linkedin"
                                    onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
                                    class="shareButton">
                                    <i class="fab fa-linkedin-in"></i> Share
                                </a>
                            </li>
                        </ul>
                    </div>
                    <input id="hosting_id" name="hosting_id" type="hidden" value="{{ $result->id }}">
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div>
{{-- erorr check here --}}
<div class="row mt-4 mt-sm-0 mobile">
    <div class="col-lg-8 col-xl-9 col-sm-12">
        <div class="row  justify-content-center border rounded pb-5" id="listMargin">
            <div class="col-md-12 mt-3 pl-4 pr-4">
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <h2><strong>{{ __('About this listing') }}</strong> </h2>
                            <p class="mt-4 text-justify">{{ $result->property_description->summary }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="d-flex h-100">
                                <div class="align-self-center">
                                    <h2 class="font-weight-700 text-18"> {{ __('The Space') }}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 col-sm-9">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    @if ($result?->bed_types->name != NULL)
                                        <div>
                                            <span class="font-weight-600">{{ __('Bed type') }}:</span>
                                            {{ $result?->bed_types?->name }}
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ __('Property type') }}:</strong> 
                                        {{ $result?->property_type_name }}
                                    </div>
                                    <div>
                                        <strong>{{ __('Accommodates') }}:</strong> 
                                        {{ $result?->accommodates }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div>
                                        <strong>{{ __('Bedrooms') }}:</strong> 
                                        {{ $result?->bedrooms }}
                                    </div>

                                    <div>
                                        <strong>{{ __('Bathrooms') }}:</strong> 
                                        {{ $result?->bathrooms }}
                                    </div>

                                    <div>
                                        <strong>{{ __('Beds') }}:</strong> 
                                        {{ $result?->beds }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="d-flex h-100">
                                <div class="align-self-center">
                                    <h2 class="font-weight-700 text-18"> {{ __('Amenities') }}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 col-sm-9">
                            <div class="row">
                                @php $i = 1 @endphp

                                @php $count = round(count($amenities)/2) @endphp
                                @foreach ($amenities as $all_amenities)
                                    @if ($i < 6)
                                        <div class="col-md-6 col-sm-6">
                                            <div>
                                                <i class="icon h3 icon-{{ $all_amenities->symbol }}" aria-hidden="true"></i>
                                                @if ($all_amenities->status == null)
                                                    <del>
                                                        {{ $all_amenities->title }}
                                                    </del>
                                                @else
                                                    {{ $all_amenities->title }}
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    @php $i++ @endphp
                                @endforeach

                                <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                    <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2" data-toggle="modal" data-target="#exampleModalCenter">
                                        + {{ __('More') }}
                                    </button>
                                </div>

                            </div>
                        </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="d-flex h-100">
                            <div class="align-self-center">
                                <h2 class="font-weight-700 text-18">{{ __('Prices') }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-sm-9">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div>
                                    <i class="fa fa-minus-circle mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                    {{ __('Extra people') }}:
                                    <strong>
                                        @if ($result->property_price->guest_fee !=0)
                                        <span> {!! moneyFormat($symbol, $result->property_price->guest_fee) !!} /
                                            {{ __('night after the') }}
                                            {{ $result->property_price->guest_after }}
                                            {{ __('guest') }}</span>
                                        @else
                                        <span>{{ __('No Charge') }}</span>
                                        @endif
                                    </strong>
                                </div>

                                <div>
                                    <i class="fa fa-arrow-down mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                    {{ __('Weekly discount') }} (%):
                                    @if ($result->property_price->weekly_discount != 0)
                                    <strong> <span id="weekly_price_string">{!! moneyFormat($symbol,
                                            $result->property_price->weekly_discount) !!}</span>
                                        /{{ __('week') }}</strong>
                                    @else
                                    <strong><span id="weekly_price_string">{!! moneyFormat($symbol,
                                            $result->property_price->weekly_discount) !!}</span>
                                        /{{ __('week') }}</strong>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div>
                                    <i class="fa fa-arrow-down mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                    {{ __('Monthly discount') }} (%):
                                    @if ($result->property_price->monthly_discount != 0)
                                    <strong>
                                        <span id="weekly_price_string">{!! moneyFormat($symbol,
                                            $result->property_price->monthly_discount) !!}</span>
                                        /{{ __('month') }}
                                    </strong>
                                    @else
                                    <strong><span id="weekly_price_string">{!! moneyFormat($symbol,
                                            $result->property_price->monthly_discount) !!}</span>
                                        /{{ __('month') }}</strong>
                                    @endif
                                </div>

                                <!-- weekend price -->
                                @if ($result->property_price->weekend_price > 0)
                                <div>
                                    <i class="fa fa-calendar-minus mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                    {{ __('Weekend pricing') }}:
                                    <strong>
                                        <span id="weekly_price_string">{!! $symbol !!} {{ $result->property_price->weekend_price }}</span> 
                                        / {{ __('Weekend Night') }}
                                    </strong>
                                </div>
                                @endif
                                <!-- end weekend price -->
                            </div>
                        </div>
                    </div>
                </div>

                @if (count($safetyAmenities) !=0)
                <hr>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="d-flex h-100">
                            <div class="align-self-center">
                                <h2 class="font-weight-700 text-18">{{ __('Safety Features') }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-sm-9">
                        <div class="row">
                            @php $i = 1 @endphp
                            @foreach ($safetyAmenities as $row_safety)
                                @if ($i < 6)
                                <div class="col-md-6 col-sm-6">
                                    <div>
                                        <i class="icon h3 icon-{{  $row_safety->symbol }}" aria-hidden="true"></i>
                                        @if ( $row_safety->status == null)
                                            <del>
                                                {{ $row_safety->title }}
                                            </del>
                                        @else
                                            {{ $row_safety->title }}
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @php $i++ @endphp
                            @endforeach

                            <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2" data-toggle="modal" data-target="#safetyModal">
                                    + {{ __('More') }}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                @endif

                @if (count($allNewAmenities) != 0)
                    @foreach ($allNewAmenities as $key => $newAmenities)
                        <hr>
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <div class="d-flex h-100">
                                    <div class="align-self-center">
                                        <h2 class="font-weight-700 text-18"> {{ $key }}</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 col-sm-9">
                                <div class="row">
                                    @php $i = 1 @endphp
                                    @foreach ($newAmenities as $row_safety)
                                        @if ($i < 6)
                                            <div class="col-md-6 col-sm-6">
                                                <i class="fa h3 fa-{{ $row_safety->symbol }}" aria-hidden="true"></i>
                                                @if ($row_safety->status == null)
                                                    <del>
                                                        {{ $row_safety->title }}
                                                    </del>
                                                @else
                                                    {{ $row_safety->title }}
                                                @endif
                                            </div>
                                        @endif
                                        @php $i++ @endphp
                                    @endforeach
                                    @if ($i>6)
                                        <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                            <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2"
                                                data-toggle="modal" data-target="#exampleModalCenter_{{ $key }}">
                                                + {{ __('More') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if ($result?->property_description?->about_place !='' ||
                $result->property_description->place_is_great_for !='' ||
                $result->property_description->guest_can_access !='' ||
                $result->property_description->interaction_guests !='' || $result->property_description->other ||
                $result->property_description->about_neighborhood || $result->property_description->get_around)
                <hr>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="d-flex h-100">
                            <div class="align-self-center">
                                <h2 class="font-weight-700 text-18">{{ __('Description') }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-sm-9">
                        @if ($result->property_description->about_place)
                        <strong class="font-weight-700">{{ __('About Place') }}</strong>
                        <p class="text-justify">{{ $result->property_description->about_place }}</p>
                        @endif

                        @if ($result->property_description->place_is_great_for)
                        <strong class="font-weight-700">{{ __('Place is Greate For') }}</strong>
                        <p class="text-justify">{{ $result->property_description->place_is_great_for }} </p>
                        @endif

                        <a href="javascript:void(0)" id="description_trigger" data-rel="description"
                            class="more-btn"><strong>+ {{ __('More') }}</strong></a>
                        <div class="d-none" id='description_after'>
                            @if ($result->property_description->interaction_guests)
                            <strong
                                class="font-weight-700">{{ __('Interaction with Guests') }}</strong>
                            <p class="text-justify"> {{ $result->property_description->interaction_guests }}</p>
                            @endif

                            @if ($result->property_description->about_neighborhood)
                            <strong
                                class="font-weight-700">{{ __('About Neighborhood') }}</strong>
                            <p class="text-justify"> {{ $result->property_description->about_neighborhood }}</p>
                            @endif

                            @if ($result->property_description->guest_can_access)
                            <strong class="font-weight-700">{{ __('Guest can Access') }}</strong>
                            <p class="text-justify">{{ $result->property_description->guest_can_access }}</p>
                            @endif

                            @if ($result->property_description->get_around)
                            <strong class="font-weight-700">{{ __('Get Around') }}</strong>
                            <p class="text-justify">{{ $result->property_description->get_around }}</p>
                            @endif

                            @if ($result->property_description->other)
                            <strong class="font-weight-700">{{ __('Other') }}</strong>
                            <p class="text-justify">{{ $result->property_description->other }}</p>
                            @endif
                            <a href="javascript:void(0)" id="description_less" data-rel="description"
                                class="less-btn"><strong> {{ __('- less') }}</strong></a>

                        </div>
                    </div>
                </div>
                @endif
                <hr>

                <!--popup slider-->
                <div class="d-none" id="showSlider-mobile">
                    <div id="ninja-slider-mobile">
                        <div class="slider-inner">
                            <ul>
                                @foreach ($result->property_photos as $row_photos)
                                <li>
                                    <a class="ns-img"
                                        href="{{ url('public/images/property/' . $result->id . '/' . $row_photos->photo) }}"
                                        aria-label="photo"></a>
                                </li>
                                @endforeach
                            </ul>
                            <div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
                        </div>
                    </div>
                </div>

                <!--popup slider end-->
                @if (count($result->property_photos) > 0)
                <div class="row mt-4">
                    <div class="col-md-12 col-sm-12 pl-3 pr-3">
                        <div class="row">
                            @php $i=0 @endphp

                            @foreach ($result->property_photos as $row_photos)
                            @if ($i == 0)
                            <div class="col-md-12 col-sm-12 mb-2 mt-2 p-2">
                                <div class="slider-image-container" onclick="lightbox({{ $i }})"
                                    style="background-image:url({{ url('public/images/property/' . $result->id . '/' . $row_photos->photo) }});">
                                </div>
                            </div>
                            @elseif ($i <= 4) @if ($i==4) <div class="p-2 position-relative">
                                <div class="view-all gal-img h-110px">
                                    <img src="{{ url('public/images/property/' . $result->id . '/' . $row_photos->photo) }}"
                                        alt="property-photo" class="img-fluid h-110px rounded"
                                        onclick="lightbox({{ $i }})" />
                                    <span class="position-center cursor-pointer"
                                        onclick="lightbox({{ $i }})">{{ __('View All') }}</span>
                                </div>
                        </div>

                        @else
                        <div class="p-2">
                            <div class="h-110px gal-img">
                                <img src="{{ url('public/images/property/' . $result->id . '/' . $row_photos->photo) }}"
                                    alt="property-photo" class="img-fluid h-110px rounded" onclick="lightbox({{ $i }})" />
                            </div>
                        </div>
                        @endif





                        @else
                        @php break; @endphp
                        @endif
                        @php $i++ @endphp
                        @endforeach
                    </div>
                </div>
            </div>
            <hr>
            @endif
        </div>

        <!--Start Reviews-->
        @if (!$result->reviews->count())
        <div class="mt-5">
            <div class="row">
                <div class="col-md-12">
                    <h2><strong>{{ __('No Reviews Yet') }}</strong></h2>
                </div>

                @if ($result->users->reviews->count())
                <div class="col-md-12">
                    <p>{{ __('This host has :count review for other properties.',['count'=>$result->users->guest_review]) }}</p>
                    <p class="text-center mt-5 mb-4">
                        <a href="{{ url('users/show/' . $result->users->id) }}" class="btn btn vbtn-outline-success text-14 font-weight-700 pl-5 pr-5 pt-3 pb-3">
                        {{ __('View Other Reviews') }}</a>
                    </p>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex">
                        <div>
                            <h2 class="text-20"><strong> {{ __('Review') }}</strong></h2>
                        </div>

                        <div class="ml-4">
                            <p> <i class="fa fa-star secondary-text-color"></i> {{ sprintf("%.1f",$result->avg_rating ) }}
                                ({{ $result->guest_review }})</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="font-weight-700 text-16">{{ __('Summary') }}</h3>
                </div>

                <div class="col-md-12">
                    <div class="mt-3 p-4 pt-3 pb-3 border rounded">
                        <div class="row justify-content-between">
                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ __('Accuracy') }}</h4>
                                    </div>

                                    <div>
                                        <progress max="5" value="{{ $result->accuracy_avg_rating }}">
                                            <div class="progress-bar">
                                                <span></span>
                                            </div>
                                        </progress>
                                        <span> {{ sprintf("%.1f",$result->accuracy_avg_rating) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ __('Location') }}</h4>
                                    </div>

                                    <div>
                                        <progress max="5" value="{{ $result->location_avg_rating }}">
                                            <div class="progress-bar">
                                                <span></span>
                                            </div>
                                        </progress>
                                        <span> {{ sprintf("%.1f",$result->location_avg_rating) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="text-truncate">{{ __('Communication') }}</h4>
                                    </div>

                                    <div>
                                        <progress max="5" value="{{ $result->communication_avg_rating }}">
                                            <div class="progress-bar">
                                                <span></span>
                                            </div>
                                        </progress>
                                        <span> {{ sprintf("%.1f",$result->communication_avg_rating) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ __('Check In') }}</h4>
                                    </div>

                                    <div>
                                        <progress max="5" value="{{ $result->checkin_avg_rating }}">
                                            <div class="progress-bar">
                                                <span></span>
                                            </div>
                                        </progress>
                                        <span> {{ sprintf("%.1f",$result->checkin_avg_rating) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ __('Cleanliness') }}</h4>
                                    </div>

                                    <div>
                                        <progress max="5" value="{{ $result->cleanliness_avg_rating }}">
                                            <div class="progress-bar">
                                                <span></span>
                                            </div>
                                        </progress>
                                        <span> {{ sprintf("%.1f",$result->cleanliness_avg_rating) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ __('Value') }}</h4>
                                    </div>

                                    <div>
                                        <ul>
                                            <li>
                                                <progress max="5" value="{{ $result->value_avg_rating }}">
                                                    <div class="progress-bar">
                                                        <span></span>
                                                    </div>
                                                </progress>
                                                <span> {{ sprintf("%.1f",$result->value_avg_rating) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="row">
                @foreach ($result->reviews as $row_review)
                    @if ($row_review->reviewer == 'guest')
                        <div class="col-12 mt-4 mb-2">
                            <div class="d-flex">
                                <div class="">
                                    <div class="media-photo-badge text-center">
                                        <a href="{{ url('users/show/' . $row_review->users->id) }}"><img
                                                alt="{{ $row_review->users->first_name }}" class=""
                                                src="{{ $row_review->users->profile_src }}"
                                                title="{{ $row_review->users->first_name }}"></a>
                                    </div>
                                </div>

                                <div class="ml-2 pt-2">
                                    <a href="{{ url('users/show/' . $row_review->users->id) }}">
                                        <h2 class="text-16 font-weight-700">{{ $row_review->users->full_name }}</h2>
                                    </a>
                                    <p class="text-14 text-muted"><i class="far fa-clock"></i> {{ dateFormat($row_review->date_fy) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="background text-15">
                                @for($i=1; $i <=5 ; $i++) @if ($row_review->rating >= $i)
                                    <i class="fa fa-star secondary-text-color"></i>
                                    @else
                                    <i class="fa fa-star"></i>
                                    @endif
                                    @endfor
                            </div>
                            <p class="mt-2 text-justify pr-4">{{ $row_review->message }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="mt-4">
            @if ($result->users->reviews->count() - $result->reviews->count())
            <div class="row">

                <div class="col-md-12">
                    <p class="text-center mt-2">
                        <a target="blank"
                            class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5"
                            href="{{ url('users/show/' . $result->users->id) }}">
                            <span>{{ __('View Other Reviews') }}</span>
                        </a>
                    </p>
                </div>
            </div>
            @endif
        </div>
        @endif
        <hr>
        <!--End Reviews-->
        <div class="mt-5">
            <div class="col-md-12">
                <div class="clearfix"></div>
                <h2><strong>{{ __('About the Host') }}</strong></h2>
                <div class="d-flex mt-4">
                    <div class="">
                        <div class="media-photo-badge text-center">
                            <a href="{{ url('users/show/' . $result->host_id) }}"><img
                                    alt="{{ $result->users->first_name }}" class=""
                                    src="{{ $result->users->profile_src }}"
                                    title="{{ $result->users->first_name }}"></a>
                        </div>
                    </div>

                    <div class="ml-2 pt-3">
                        <a href="{{ url('users/show/' . $result->host_id) }}">
                            <h2 class="text-16 font-weight-700">{{ $result->users->full_name }}</h2>
                        </a>
                        <p>{{ __('Member since') }} {{ date('F Y', strtotime($result->users->created_at)) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<div class="container-fluid container-fluid-90 mt-70">
    <div class="row mt-5">
        <div class="col-md-12">
            <div id="room-detail-map" class="single-map-w"></div>
        </div>
    </div>
</div>

<div class="container-fluid container-fluid-90 mt-70 mb-5">
    @if (count($similar)!= 0)
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center-sm text-20 font-weight-700">{{ __('Similar Listings') }}</h2>
        </div>
    </div>

    <div class="row m-0 mt-5 mb-5">
        @foreach ($similar->slice(0, 8) as $row_similar)
        <div class="col-md-6 col-lg-4 col-xl-3 p-2 mt-4 pl-4 pr-4">
            <div class="card h-100 border card-1">
                <div class="grid">
                    <a href="{{ $row_similar->slug }}">
                        <figure class="effect-milo">
                            <img src="{{ $row_similar->cover_photo }}" class="room-image-container200" alt="img11" />
                            <figcaption>
                            </figcaption>
                        </figure>
                    </a>
                </div>

                <div class="card-body p-0 pl-1 pr-1">
                    <div class="d-flex">
                        <div>
                            <div class="profile-img pl-2 pr-1">
                                <a href="{{ url('users/show/' . $row_similar->host_id) }}">
                                    <img src="{{ $row_similar->users->profile_src }}" alt="profile-photo"></a>
                            </div>
                        </div>

                        <div class="p-2 text">
                            <a class="text-color text-color-hover" href="{{ url('properties/' . $row_similar->slug) }}">
                                <h4 class="text-16 font-weight-700 text"> {{ $row_similar->name }}</h4>
                            </a>
                            <p class="text-14 mt-2 mb-0 text"><i class="fas fa-map-marker-alt"></i>
                                {{ $row_similar->property_address->city }}</p>
                        </div>
                    </div>

                    <div class="review-0 p-3">
                        <div class="d-flex justify-content-between">

                            <div>
                                <span><i class="fa fa-star text-14 secondary-text-color"></i>
                                    @if ( $row_similar->reviews_count)
                                        {{ $row_similar->avg_rating }}
                                    @else
                                        0
                                    @endif
                                    ({{ $row_similar->reviews_count }})</span>
                            </div>


                            <div>
                                <span class="font-weight-700">{!! moneyFormat(
                                    $row_similar->property_price->default_symbol, $row_similar->property_price->price)
                                    !!}</span> / {{ __('Weekend Night') }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-muted p-0 border-0">
                        <div class="d-flex bg-white justify-content-between pl-2 pr-2 pt-2 mb-3">
                            <div>
                                <ul class="list-inline">
                                    <li class="list-inline-item  pl-4 pr-4 border rounded-3 mt-4 bg-light text-dark">
                                        <div class="vtooltip"> 
                                            <i class="fas fa-user-friends"></i> {{ $row_similar->accommodates }}
                                            <span class="vtooltiptext text-14">{{ $row_similar->accommodates }}
                                                {{ __('Guest') }}</span>
                                        </div>
                                    </li>

                                    <li class="list-inline-item pl-4 pr-4 border rounded-3 mt-4 bg-light text-dark">
                                        <div class="vtooltip"> <i class="fas fa-bed"></i> {{ $row_similar->bedrooms }}
                                            <span class="vtooltiptext  text-14">{{ $row_similar->bedrooms }}
                                                {{ __('Bedrooms') }}</span>
                                        </div>
                                    </li>

                                    <li class="list-inline-item pl-4 pr-4 border rounded-3 mt-4 bg-light text-dark">
                                        <div class="vtooltip"> <i class="fas fa-bath"></i> {{ $row_similar->bathrooms }}
                                            <span class="vtooltiptext  text-14 p-2">{{ $row_similar->bathrooms }}
                                                {{ __('Bathrooms') }}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<div class="row">
    <!-- Modal -->
    <div class="modal fade mt-5 z-index-high" id="exampleModalCenter" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100 pt-3">
                        <h5 class="modal-title text-20 text-center font-weight-700"
                            id="exampleModalLongTitle">
                            {{ __('Amenities') }}</h5>
                    </div>

                    <div>
                        <button type="button" class="close text-28 mr-2 filter-cancel"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="modal-body pb-5">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                @php $i = 1 @endphp
                                @foreach ($amenities as $all_amenities)
                                @if ($i >= 6)
                                <div class="col-md-6 col-sm-6 mt-3">
                                    <div>
                                        <i class="icon h3 icon-{{ $all_amenities->symbol }}"
                                            aria-hidden="true"></i>
                                        @if ($all_amenities->status == null)
                                            <del>
                                                {{ $all_amenities->title }}
                                            </del>
                                        @else
                                            {{ $all_amenities->title }}
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @php $i++ @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade mt-5 z-index-high" id="safetyModal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100 pt-3">
                        <h5 class="modal-title text-20 text-center font-weight-700" id="exampleModalLongTitle">
                            {{ __('Safety Features') }}
                        </h5>
                    </div>

                    <div>
                        <button type="button" class="close text-28 mr-2 filter-cancel"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="modal-body pb-5">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                @php $i = 1 @endphp
                                @foreach ($safetyAmenities as $row_safety)
                                @if ($i >= 6)
                                <div class="col-md-6 col-sm-6 mt-3">
                                    <div>
                                        <i class="icon h3 icon-{{ $row_safety->symbol }}"
                                            aria-hidden="true"></i>
                                        @if ($row_safety->status == null)
                                            <del>
                                                {{ $row_safety->title }}
                                            </del>
                                        @else
                                            {{ $row_safety->title }}
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @php $i++ @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($allNewAmenities as $key => $newAmenities)
        <div class="modal fade mt-5 z-index-high" id="exampleModalCenter_{{ str_replace(" ","-",$key) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="w-100 pt-3">
                            <h5 class="modal-title text-20 text-center font-weight-700" id="exampleModalLongTitle">{{ $key }}</h5>
                        </div>

                        <div>
                            <button type="button" class="close text-28 mr-2 filter-cancel" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    @php $a = 1 @endphp
                                    @foreach ($newAmenities as $row_safety)
                                        @if ($a >= 6)
                                            <div class="col-md-6 col-sm-6">
                                                <i class="fa h3 fa-{{ $row_safety->symbol }}" aria-hidden="true"></i>
                                                @if ($row_safety->status == null)
                                                    <del>
                                                        {{ $row_safety->title }}
                                                    </del>
                                                @else
                                                    {{ $row_safety->title }}
                                                @endif
                                            </div>
                                        @endif
                                        @php $a++ @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="d-none" id="showSlider">
    <div id="ninja-slider">
        <div class="slider-inner">
            <ul>
                @foreach ($result->property_photos as $row_photos)
                <li>
                    <a class="ns-img"
                        href="{{ url('public/images/property/' . $result->id . '/' . $row_photos->photo) }}"
                        aria-label="photo"></a>
                </li>
                @endforeach
            </ul>
            <div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
        </div>
    </div>
</div>
@endsection

@section('validation_script')
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ config("vrent.google_map_key") }}&libraries=places'></script>
    @auth
    <script src="{{ asset('public/js/sweetalert.min.js') }}"></script>
    @endauth
    <script type="text/javascript" src="{{ asset('public/js/locationpicker.jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/ninja/ninja-slider.js') }}"></script>
    <!-- daterangepicker -->
    <script type="text/javascript" src="{{ asset('public/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/daterangecustom.js') }}"></script>
    <script type="text/javascript">
        'use strict'
        let back = 0;
        let dateFormat = '{{ $dateFormat }}';
        let getPriceURL = '{{ url("property/get-price") }}';
        var token = "{{ csrf_token() }}";
        let customPriceText = "{{ __('Custom Price') }}";
        let dateText = "{{ __('Date') }}";
        let priceText = "{{ __('Price') }}";
        let symbolText = "{{ $symbol }}";
		let host = "{{ ($result->host_id == Auth()->user()?->id) ? '1' : '' }}";
        let latitude = {{ $result->property_address->latitude }};
		let longitude = {{ $result->property_address->longitude }};
        let user_id = "{{ Auth::id() }}";
        let success = "{{ __('Success') }}";
        let yes = "{{ __('Yes') }}";
        let no = "{{ __('No') }}";
        let add = "{{ __('Add to Favourite List ?') }}";
        let remove = "{{ __('Remove from Favourite List ?') }}";
        let added = "{{ __('Added to favourite list.') }}";
        let removed = "{{ __('Removed from favourite list.') }}";
        const BaseURL = "{{ url('/') }}";

    </script>

    <script type="text/javascript" src="{{ asset('public/js/single-property.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/front.min.js') }}"></script>
    
@endsection



