@extends('emails.template')

@section('emails.main')
<?=$content?>
<p class="mt-20 text-center">
  <a href="{{ $url . 'users/payout' }}" target="_blank"><button type="button" class="learn-more">{{ __('Add a payout method')}}</button></a>
</p>

@stop

