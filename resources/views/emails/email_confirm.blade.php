@extends('emails.template')

@section('emails.main')

<div class="mt-20 text-left">
  <p>Hi {{ $first_name }},</p>
  <p>
    @if($type == 'register')
        Welcome to {{ siteName() }}!
    @elseif($type == 'change')
        Please click the link below to complete the process of changing your email address.
    @else
        Please Confirm your email address:
    @endif
  </p>

  <p class="mt-20 text-center">
    <a href="{{ $url . ('users/confirm_email?code=' . $token) }}" target="_blank">
      <button type="button" class="learn-more">{{ __('Confirm Email') }}</button>
    </a>
  </p>
</div>


@stop



