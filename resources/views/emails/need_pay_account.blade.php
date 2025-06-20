@extends('emails.template')

@section('emails.main')
<div>
	<div>
	  	<span>
	      Amount {{ $currency_symbol }}{{ $payout_amount }} is waiting for you but you did not add any payment account to send the money. Please log in to your {{ siteName() }} account and <a href="{{ $url . 'users/account-preferences' }}" target="_blank">Add a payout method</a>.
	    </span>
	</div>
</div>
@stop