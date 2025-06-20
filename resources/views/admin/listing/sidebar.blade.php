<div class="col-md-3">
    <div class="row">
      <div class="naviga_tion_sidebar">
        <ul class="nav nav-pills nav-stacked">
          <li class="{{ Request::segment(3) == 'basics' ? 'lnk-active' : '' }}"><a href='{{ $result->status != "" ? url("listing/" . $result->id . "/basics") : "#" }}'><div class="radius"><span class="margin-top6">1</span></div>{{ __('Basics') }}</a></li>
          <li class="{{ Request::segment(3) == 'description' ? 'lnk-active' : '' }}"><a href='{{ $result->status != "" ? url("listing/" . $result->id . "/description") : "#" }}'><div class="radius"><span class="margin-top6">2</span></div>{{ __('Description') }}</a></li>
          <li class="{{ Request::segment(3) == 'location' ? 'lnk-active' : '' }}"><a href='{{ $result->status != "" ? url("listing/" . $result->id . "/location") : "#" }}'><div class="radius"><span class="margin-top6">3</span></div>{{ __('Location') }}</a></li>
          <li class="{{ Request::segment(3) == 'amenities' ? 'lnk-active' : '' }}"><a href='{{ $result->status != "" ? url("listing/" . $result->id . "/amenities") : "#" }}'><div class="radius"><span class="margin-top6">4</span></div>{{ __('Amenities') }}</a></li>
          <li class="{{ Request::segment(3) == 'photos' ? 'lnk-active' : '' }}"><a href='{{ $result->status != "" ? url("listing/" . $result->id . "/photos") : "#" }}'><div class="radius"><span class="margin-top6">5</span></div>{{ __('Photos') }}</a></li>
          <li class="{{ Request::segment(3) == 'pricing' ? 'lnk-active' : '' }}"><a href='{{ $result->status != "" ? url("listing/" . $result->id . "/pricing") : "#" }}'><div class="radius"><span class="margin-top6">6</span></div>{{ __('Pricing') }}</a></li>
          <li class="{{ Request::segment(3) == 'booking' ? 'lnk-active' : '' }}"><a href='{{ $result->status != "" ? url("listing/" . $result->id . "/booking") : "#" }}'><div class="radius"><span class="margin-top6">7</span></div>{{ __('Booking') }}</a></li>
          <li class="{{ Request::segment(3) == 'calendar' ? 'lnk-active' : '' }}"><a href='{{ $result->status != "" ? url("listing/" . $result->id . "/calendar") : "#" }}'><div class="radius"><span class="margin-top6">8</span></div>{{ __('Calender') }}</a></li>
        </ul>
      </div>
  </div>   
</div>