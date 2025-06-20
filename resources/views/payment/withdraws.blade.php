@extends('template')

@section('main')
<div class="controls" style="min-height:400px;">
	<div class="col-md-12" style="padding-left:30px;padding-right:30px">
		<div class="col-lg-1" style="float: none;margin:0 auto;padding-top:20px;padding-bottom:20px"><button class="btn btn-pinkbg" data-toggle="modal" data-target="#withdrawModal">{{ __('Withdraw Balance') }}</button></div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>
						<h5>{{ __('Date of Request') }}</h5>
					</th>
					<th>
						<h5>{{ __('Status') }}</h5>
					</th>
					<th>
						<h5>{{ __('Amount') }}</h5>
					</th>
				</tr>
			</thead>
			<tbody>
			@foreach($results as $result)
				<tr>
					<td>
						<h5>{{ date('d F Y',strtotime($result->created_at)) }}</h5>
					</td>
					<td>
						<h5>{{ $result->status }}</h5>
					</td>
					<td>
						<h5>{{ Session::get('symbol') . ' ' . $result->amount }}</h5>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div><!--controls end-->

<div class="container">
	<div class="clearfix"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="withdrawModal" role="dialog" style="z-index:1060;">
    <div class="modal-dialog" >
      <!-- Modal content-->
      <div class="modal-content" style="width:100%;height:100%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ __('Do withdraw request') }}</h4>
        </div>
        <div class="modal-body">
          <h4 style="text-align:center;color:red" id="error-message"></h4>
          <p>Your balance is {{ Session::get('symbol') . $total }}</p>
          @if(isset($details['paypal_email']) && $details['paypal_email'] != '')
          <div class="form-group">
		    <label for="email">{{ __('Withdraw Amount') }}</label>
		    <input type="text" class="form-control" name="amount" id="amount">
		  </div>
		  @else
		  	<p>{{ __('Please provide') }} <a style="color:#e7358d;" target="_blank" href="{{ url('settings/payment') }}"><b>{{ __('payment account') }}</b></a> {{ __('information to withdraw balance') }}.</p>
		  @endif
        </div>
        <div class="modal-footer">
        	<button type="button" class="btn btn-pinkbg" id="withdraw_submit">{{ __('Submit') }}</button>
        	<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
        </div>
      </div>
    </div>
</div>
@endsection

@section('validation_script')
	<script type= "text/javascript" >
		var notEnoughAmount = '{{ __("Inappropriate amount request")}}';
		var token = "{{ csrf_token() }}";
		var withdrawURL = "{{ url('withdraws') }}";
	</script>
	<script type="text/javascript" src="{{ asset('public/js/withdraw.min.js') }}"></script>
@endsection

