<div class="box">
	<div class="box-body no-padding d-block">
		<ul class="nav nav-pills nav-stacked d-flex flex-column">
			@if(Helpers::has_permission(Auth::guard('admin')->user()->id, 'manage_email_template'))
				<li {{ isset($list_menu) &&  $list_menu == 'menu-1' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/1") }}">Account Info Default Update</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-2' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/2") }}">Account Info Update</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-3' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/3") }}">Account Info Delete</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-4' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/4") }}">Booking</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-5' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/5") }}">Email Confirm</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-6' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/6") }}">Forget Password</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-7' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/7") }}">Need Payment Account</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-8' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/8") }}">Payout Sent</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-9' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/9") }}">Booking Cancelled</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-10' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/10") }}">Booking Accepted/Declined</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-11' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/11") }}">Booking Request Send</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-12' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/12") }}">Booking Confirmation</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-13' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/13") }}">Property Booking Notify</a></li>

				<li {{ isset($list_menu) &&  $list_menu == 'menu-14' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/14") }}">Property Booking Payment</a></li>
				
				<li {{ isset($list_menu) &&  $list_menu == 'menu-15' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/15") }}">Payout Request Received</a></li>
				
				<li {{ isset($list_menu) &&  $list_menu == 'menu-16' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/16") }}">Property Listing Approve</a></li>
				
				<li {{ isset($list_menu) &&  $list_menu == 'menu-17' ? 'class = active' : '' }}><a href="{{ url("admin/email-template/17") }}">Payout Request Approved</a></li>
			@endif
		</ul>
	</div>
	
</div>