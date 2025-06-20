<ul class="list-group customlisting">
	<li>
		<a class="btn  text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ Request::segment(3) == 'basics'?'vbtn-outline-success active-side':'btn-outline-secondary' }} {{ $missed['basics'] == 1 ? '' : 'step-inactive'  }}" href="{{ $result->status != ""? url("listing/" . $result->id . "/basics"):"#" }}">{{ __('Basics') }}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ Request::segment(3) == 'description'?'vbtn-outline-success active-side':' btn-outline-secondary' }} {{ $missed['description'] == 1 ? '' : 'step-inactive'  }}" href="{{ $result->status != ""? url("listing/" . $result->id . "/description"):"#" }}">{{ __('Description') }}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ Request::segment(3) == 'location'?'vbtn-outline-success active-side':' btn-outline-secondary' }} {{ $missed['location'] == 1 ? '' : 'step-inactive'  }}" href="{{ $result->status != ""? url("listing/" . $result->id . "/location"):"#" }}"> {{ __('Location') }}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ Request::segment(3) == 'amenities'?'vbtn-outline-success active-side':' btn-outline-secondary' }} {{ $result->amenities == null ? 'step-inactive' : ''  }}" href="{{ $result->status != ""? url("listing/" . $result->id . "/amenities"):"#" }}"> {{ __('Amenities') }}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ Request::segment(3) == 'photos'?'vbtn-outline-success active-side':' btn-outline-secondary' }} {{ $missed['photos'] == 1 ? '' : 'step-inactive'  }}" href="{{ $result->status != ""? url("listing/" . $result->id . "/photos"):"#" }}"> {{ __('Photos') }}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ Request::segment(3) == 'pricing'?'vbtn-outline-success active-side':' btn-outline-secondary' }} {{ $missed['pricing'] == 1 ? '' : 'step-inactive'  }}" href="{{ $result->status != ""? url("listing/" . $result->id . "/pricing"):"#" }}"> {{ __('Pricing') }}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ Request::segment(3) == 'booking'?'vbtn-outline-success active-side':' btn-outline-secondary' }} {{ $missed['booking'] == 1 ? '' : 'step-inactive'  }}" href="{{ $result->status != ""? url("listing/" . $result->id . "/booking"):"#" }}"> {{ __('Booking') }}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ Request::segment(3) == 'calendar'?'vbtn-outline-success active-side':' btn-outline-secondary' }}" href="{{ $result->status != ""? url("listing/" . $result->id . "/calendar"):"#" }}"> {{ __('Calender') }}</a>
	</li>
</ul>
