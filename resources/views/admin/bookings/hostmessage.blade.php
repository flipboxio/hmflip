@extends('admin.template')

@section('main')
<div class="content-wrapper">
	<section class="content-header">
		<h1>Message<small>host message</small></h1>
		@include('admin.common.breadcrumb')
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<div class="container">
							<div class="container margin-top30 mb30">
                                <div class="row">
                                    <div class="col-md-9 col-sm-9 col-12">
                                        @if ($messages[0]->type_id == 4)
                                            <div class="dialogbox text-center">
                                                <div class="body">
                                                    <div class="message padding-top10 padding-bottom10">
                                                        <h4>{{ __('Request sent') }}</h4>
                                                        <h5>{{ __('Your booking isn’t confirmed yet. You’ll get reply within 24 hours.') }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($messages[0]->type_id == 5)
                                            <div class="dialogbox text-center">
                                                <div class="body">
                                                    <div class="message padding-top10 padding-bottom10">
                                                        <h4>{{ __('Booking confirmed.') }} {{ optional($messages[0]->bookings)->properties->property_address->city }}, {{  optional($messages[0]->bookings)->properties->property_address->country_name }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($messages[0]->type_id == 6)
                                            <div class="dialogbox text-center">
                                                <div class="body">
                                                    <div class="message padding-top10 padding-bottom10">
                                                        <h4>{{ __('Request declined') }}</h4>
                                                        <h5>{{ __('There are more place around.') }}</h5>
                                                        <span><a href="{{ url('search?location=' . optional($messages[0]->bookings)->properties->property_address->city) }}" class="btn ex-btn navbar-btn topbar-btn">{{ __('Keep Searching') }}</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-lg-12 row ml-0">
                                            <form action="{{ url('admin/reply/' . $messages[0]->booking_id ) }}" method="post" id="msg_reply">
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{ $messages[0]->booking_id }}" name="booking_id">
                                                <input type="hidden" name="property_id" value="{{  optional($messages[0]->bookings)->property_id }}">
                                                <input type="hidden" name="start_date" value="{{  optional($messages[0]->bookings)->start_date }}">
                                                <input type="hidden" name="end_date" value="{{  optional($messages[0]->bookings)->end_date }}">
                                                <input type="hidden" name="price" value="{{  optional($messages[0]->bookings)->total }}">
                                                <textarea rows="3" placeholder="" class="form-control" id="message_text" name="message"></textarea>
                                                <span class="pull-right"><input type="submit" class="btn ex-btn navbar-btn topbar-btn btn-success mt-2 mb-2" id="reply_message" value="{{ __('Send Message') }}"></span>
                                            </form>
                                            @if ($errors->has('message')) <p class="error-tag">{{ $errors->first('message') }}</p> @endif
                                            <div class="clearfix"></div>
                                        </div>

                                        <div id="message-list">
                                            @for ($i=0; $i<count($messages); $i++)
                                                @if ($messages[$i]->sender_id == optional($messages[0]->bookings)->host_id)
                                                    <div class="col-lg-12 row">
                                                        <div class="col-md-3 col-sm-3 col-3">
                                                            <div class="media-photo-badgeSMS text-center">
                                                                <a href="{{ url('admin/edit-customer/'. optional($messages[$i]->bookings)->host_id ) }}" ><img class="" src="{{  optional($messages[$i]->bookings)->properties->users->profile_src }}"></a>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-9 col-sm-9 col-9">
                                                            <div class="dialogbox">
                                                                <div class="body">
                                                                    <span class="tip tip-left"></span>
                                                                    <div class="message">
                                                                        <span>{{ $messages[$i]->message }}</span><br/>
                                                                        <span>{{ dateFormat($messages[$i]->created_at) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($messages[$i]->sender_id !=  optional($messages[0]->bookings)->host_id)
                                                    @if ($messages[$i]->type_id == 4)
                                                        <div class="col-lg-12 row">
                                                            <div class="col-md-9 col-sm-9 col-9">
                                                                <div class="dialogbox">
                                                                    <div class="body">
                                                                        <div class="h5">
                                                                            {{ __('Inquiry about') }} <a locale="en" data-popup="true" href="{{ url('properties/' . optional($messages[$i]->bookings)->properties->slug) }}">{{  optional($messages[$i]->bookings)->properties->name }}</a>
                                                                        </div>

                                                                        <p class="text-muted">
                                                                            {{  optional($messages[$i]->bookings)->date_range }}
                                                                            ·
                                                                            {{  optional($messages[$i]->bookings)->guest }} {{ __('Guests') }}{{ ( optional($messages[$i]->bookings)->guest > 1) ? 's' : '' }}
                                                                            <br>
                                                                            {{ __('You will get') }} {!! moneyFormat( optional($messages[$i]->bookings)->currency->symbol,  optional($messages[$i]->bookings)->host_payout) !!}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if (( optional($messages[$i]->bookings)->users->profile_image !='') && ( optional($messages[$i]->bookings)->users->profile_image != NULL))
                                                        <div class="col-lg-12 row">
                                                            <div class="col-md-9 col-sm-9 col-9">
                                                                <div class="dialogbox">
                                                                    <div class="body">
                                                                        <span class="tip tip-right"></span>
                                                                        <div class="message">
                                                                            <span>{{ $messages[$i]->message }}</span><br/>
                                                                            <span>{{ dateFormat($messages[$i]->created_at) }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-sm-3 col-3">
                                                                <div class="media-photo-badgeSMS text-center">
                                                                    <a href="{{ url('admin/edit-customer/'. optional($messages[$i]->bookings)->user_id) }}" ><img src="{{  optional($messages[$i]->bookings)->users->profile_src }}"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-lg-12 row">
                                                            <div class="col-md-9 col-sm-9 col-9">
                                                                <div class="dialogbox">
                                                                    <div class="body">
                                                                    <span class="tip tip-right"></span>
                                                                    <div class="message">
                                                                        <span>{{ $messages[$i]->message }}</span><br/>
                                                                        <span>{{ dateFormat($messages[$i]->created_at) }}</span>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-sm-3 col-3">
                                                                <div class="media-photo-badgeSMS text-center">
                                                                    <a href="{{ url('admin/edit-customer/'.optional($messages[$i]->bookings)->user_id) }}" > <img src="{{  optional($messages[0]->bookings)->users->profile_src }}"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-3 col-12 user_profile_pic">
                                        <div class="panel panel-default row-space-4">
                                            <div class="mini-profile va-container media panel-body row">
                                                <div class="va-top d-flex justify-content-center">
                                                    <a class="media-photo" href="{{ url('admin/edit-customer/'. optional($messages[0]->bookings)->user_id) }}">
                                                        <img width="130" height="130" class="center" alt="{{  optional($messages[0]->bookings)->users->first_name }}" src="{{  optional($messages[0]->bookings)->users->profile_src }}">
                                                    </a>
                                                </div>

                                                <div class="va-middle">
                                                    <div class="h4">
                                                        <center><a class="text-normal" href="{{ url('admin/edit-customer/'. optional($messages[0]->bookings)->user_id) }}">{{  optional($messages[0]->bookings)->users->first_name . ' ' .  optional($messages[0]->bookings)->users->last_name }}</a></center>
                                                        &nbsp;<!-- <i data-tooltip-sticky="true" data-tooltip-position="bottom" data-tooltip-el="#verifications-tooltip" class="icon icon-verified-id icon-lima" id="verified-id-icon"></i> -->
                                                        <br>
                                                        <small>
                                                            <center class="member_since"> {{ __('Member since') }} {{ date('Y',strtotime( optional($messages[0]->bookings)->users->created_at)) }}</center>
                                                        </small>
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
		</div>
	</section>
</div>
@push('scripts')
    <script src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
@endpush
@stop
