<header class="main-header">
	<a href="{{ url('admin/dashboard') }}" class="logo">
		
	<span class="logo-lg fw-bold">{{ siteName() }}</span>
		
	</a>

	<nav class="navbar navbar-static-top header_controls px-3">
		<a href="#" class="sidebar-toggle f-14" data-toggle="offcanvas" role="button">
		</a>
	
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav admin-nav">
				<li class="dropdown user user-menu profile-parent f-14">
					<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
						<img src="{{ Auth::guard('admin')->user()->profile_src }}" class="user-image" alt="User Image">
						<span class="hidden-xs">{{ ucfirst(Auth::guard('admin')->user()->username) }}</span>
					</a>

					<ul class="dropdown-menu">
						<li class="user-header">
							<img src="{{ Auth::guard('admin')->user()->profile_src }}" class="img-circle" alt="User Image">
							<p>
								{{ ucfirst(Auth::guard('admin')->user()->username) }}
								<small>Member since {{ date('M, Y', strtotime(Auth::guard('admin')->user()->created_at)) }}</small>
							</p>
						</li>
						<li class="user-footer">
							<div class="pull-left">
							<a href="{{ url('admin/profile') }}" class="btn btn-default btn-flat f-14">Profile</a>
							</div>
							<div class="pull-right">
							<a href="{{ url('admin/logout') }}" class="btn btn-default btn-flat f-14">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>

<div class="flash-container">
	@if (Session::has('message'))
		<div class="alert {{ Session::get('alert-class') }} text-center mb-0" role="alert">
			{{ Session::get('message') }}
			<a href="#" class="pull-right" class="alert-close" data-bs-dismiss="alert">&times;</a>
		</div>
	@endif

	<div class="alert alert-success text-center mb-0 d-none" id="success_message_div" role="alert">
		<a href="#" class="pull-right" class="alert-close" data-bs-dismiss="alert">&times;</a>
		<div id="success_message"></div>
	</div>

	<div class="alert alert-danger text-center mb-0 d-none" id="error_message_div" role="alert">
		<p><a href="#" class="pull-right" class="alert-close" data-bs-dismiss="alert">&times;</a></p>
		<div id="error_message"></div>
	</div>
</div>
