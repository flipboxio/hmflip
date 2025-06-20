<ul class="sidenav-list">
	@if (Route::current()->uri() == 'properties' || Route::current()->uri() == 'booking/{id}' || Route::current()->uri() == 'my-bookings')
		<li>
			<a href="{{ url('properties') }}" aria-selected="{{ (Route::current()->uri() == 'properties') ? 'true' : 'false' }}" class="sidenav-item">{{ __('Your Listings') }}</a>
		</li>

		<li>
			<a href="{{ url('my-bookings') }}" aria-selected="{{ (Route::current()->uri() == 'my-bookings') ? 'true' : 'false' }}" class="sidenav-item">{{ __('Property Bookings') }}</a>
		</li>
	@endif

	@if (Route::current()->uri() == 'trips/active' || Route::current()->uri() == 'trips/previous')
		<li>
			<a class="sidenav-item" aria-selected="{{ (Route::current()->uri() == 'trips/active') ? 'true' : 'false' }}" href="{{ url('trips/active') }}">{{ __('Your Trips') }}</a>
		</li>

		<li>
			<a class="sidenav-item" aria-selected="{{ (Route::current()->uri() == 'trips/previous') ? 'true' : 'false' }}" href="{{ url('trips/previous') }}">{{ __('Previous Trips') }}</a>
		</li>
	@endif

	@if (Route::current()->uri() == 'users/profile' || Route::current()->uri() == 'users/reviews' || Route::current()->uri() == 'users/profile/media' || Route::current()->uri() == 'users/edit-verification' || Route::current()->uri() == 'reviews/details/{id}')
		<li>
			<a href="{{ url('users/profile') }}" aria-selected="{{ (Route::current()->uri() == 'users/profile') ? 'true' : 'false' }}" class="sidenav-item">{{ __('Edit Profile') }}</a>
		</li>

		<li>
			<a href="{{ url('users/profile/media') }}" aria-selected="{{ (Route::current()->uri() == 'users/profile/media') ? 'true' : 'false' }}" class="sidenav-item">{{ __('Photos') }}</a>
		</li>

		<li>
			<a href="{{ url('users/reviews') }}" aria-selected="{{ (Route::current()->uri() == 'users/reviews' || Route::current()->uri() == 'reviews/details/{id}') ? 'true' : 'false' }}" class="sidenav-item">{{ __('Reviews') }}</a>
		</li>

		<li>
			<a href="{{ url('users/edit-verification') }}" aria-selected="{{ (Route::current()->uri() == 'users/edit-verification') ? 'true' : 'false' }}" class="sidenav-item">{{ __('Verification') }}</a>
		</li>
	@endif

	@if (Route::current()->uri() == 'users/security' || Route::current()->uri() == 'users/account-preferences' || Route::current()->uri() == 'users/transaction-history' || Route::current()->uri() == 'users/payout' || Route::current()->uri() == 'users/payout/setting' || Route::current()->uri() == 'users/payout/edit-payout/{id}')
		<li>
			<a href="{{ url('users/account-preferences') }}" aria-selected="{{ (Route::current()->uri() == 'users/account-preferences') ? 'true' : 'false' }}" class="sidenav-item">{{ __('Payout Settings') }}</a>
		</li>
			<li>
			<a href="{{ url('users/payout-list') }}" aria-selected="{{ (Route::current()->uri() == 'users/payout-list') ? 'true' : 'false' }}" class="sidenav-item">Add Bank</a>
		</li>

		<li>
			<a href="{{ url('users/security') }}" aria-selected="{{ (Route::current()->uri() == 'users/security') ? 'true' : 'false' }}" class="sidenav-item">{{ __('Change Password') }}</a>
		</li>
	@endif
</ul>
