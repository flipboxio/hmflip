@extends('emails.template')

@section('emails.main')
<div class="mt-20 text-left">
    <p>
		<?=$content?>
	</p>
	@if($result['status'] == 'Pending')
	<p class="mt-20 text-center">
		<a href="{{ $url . ('booking/'.$result['id']) }}" target="_blank">
			<button type="button" class="learn-more">{{ __('Accept / Decline')}}</button>
		</a>
	</p>
	@endif
</div>

@stop
