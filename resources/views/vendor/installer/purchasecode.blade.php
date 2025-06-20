
@extends('vendor.installer.layout')

@section('content')
  <div class="card">
      <div class="card-content black-text">
          <div class="center-align">
              <p class="card-title">{{__('Verify Envato Purchase code')}}</p>
              <hr>
          </div>

          @if (isset($responseError))
              <div class="center-align red-text">
                  {{ $responseError }}
              </div>
          @endif

          <form class="form-horizontal" action="{{ url('install/verify-envato-purchase-code?old=' . $old) }}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                  <div class="col-md-8 offset-2">
                      <label for="envatoUsername">{{__('Envato username')}}</label>
                      <input type="text" class="form-control" id="envatoUsername" name="envatoUsername" placeholder="{{__('You Envato Username')}}" value="{{ old('envatoUsername') }}">
                      @if (isset($errors))
                          <span class="text-danger" style="color: red">{{$errors->first('envatoUsername')}}</span>
                      @endif
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-8 offset-2">
                      <label for="envatopurchasecode">{{__('Envato Purchase code')}}</label>
                      <input type="text" class="form-control" id="envatopurchasecode" name="envatopurchasecode" placeholder="{{__('Enter Purchase Code')}}">
                      @if (isset($errors))
                          <span class="text-danger" style="color: red">{{$errors->first('envatopurchasecode')}}</span>
                      @endif
                  </div>
              </div>

              <div class="card-action">
                  <div class="row">
                      <div class="left">
                        <a class="btn waves-effect blue waves-light" href="{{ url('install/permissions') }}">
                            {{ __('Back') }}
                            <i class="material-icons left">arrow_back</i>
                        </a>
                      </div>
                      <div class="right">
                        <button type="submit" class="btn waves-effect blue waves-light">
                            {{ __('Verify Purchase Code') }}
                            <i class="material-icons right">send</i>
                        </button>
                      </div>
                  </div>
              </div>
          </form>
      </div>
  </div>
@endsection
