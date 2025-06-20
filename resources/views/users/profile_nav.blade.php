<nav class="navbar navbar-expand-lg navbar-light list-bacground border rounded-3 p-3">
	<ul class="list-inline">
		<li class="list-inline-item p-2">
			<a class="text-color {{ (request()->is('users/profile')) ? 'secondary-text-color font-weight-700' : '' }} text-color-hover" href="{{ url('users/profile') }}">
				{{ __('Edit Profile') }}
			</a>
		</li>

		<li class="list-inline-item p-2">
			<a class="text-color {{ (request()->is('users/profile/media')) ? 'secondary-text-color font-weight-700' : '' }} text-color-hover" href="{{ url('users/profile/media') }}">
				{{ __('Photos') }}
			</a>
		</li>

		<li class="list-inline-item p-2">
			<a class="text-color {{ (request()->is('users/edit-verification')) ? 'secondary-text-color font-weight-700' : '' }} text-color-hover" href="{{ url('users/edit-verification') }}">
				{{ __('Verification') }}
			</a>
		</li>

		<li class="list-inline-item p-2">
			<a class="text-color {{ (request()->is('users/security')) ? 'secondary-text-color font-weight-700' : '' }}   text-color-hover" href="{{ url('users/security') }}">
				{{ __('Change Password') }}

			</a>
		</li>
	</ul>
</nav>
