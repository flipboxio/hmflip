@extends('template')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/daterangepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/responsive.dataTables.min.css') }}">
@endpush
@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		@include('users.sidebar')
		<div class="col-lg-10 p-0">
			<div class="container-fluid min-height">
				<div class="main-panel">
					<div class="row justify-content-center mt-5 mb-4">
						<div class="col-md-12">
							<nav class="navbar navbar-expand-lg navbar-light list-bacground border rounded-3 p-4">
								<ul class="navbar-nav">
									<li class="nav-item pl-4 pr-4">
										<a class="text-color secondary-text-color font-weight-700 text-color-hover" href="{{ url('users/payout-list') }}">{{ __('Payouts') }}</a>
									</li>

									<li class="nav-item  pl-4 pr-4">
										<a class="text-color text-color-hover" href="{{ url('users/payout') }}">{{ __('Payout Settings') }}</a>
									</li>

                                    <li class="nav-item  pl-4 pr-4">
                                        <span class="text-color font-wight-700">
                                            {{ __('My Wallet') }}: {!! moneyFormat( $currentCurrency->symbol, $walletBalance->total) !!}
                                        </span>
                                    </li>
								</ul>
							</nav>
						</div>
					</div>
					@if (Session::has('message'))
						<div class="row justify-content-center mt-5 mb-5 pr-4 pl-4">
							<div class="col-md-12  alert {{ Session::get('alert-class') }} alert-dismissable fade in top-message-text opacity-1">
								<a href="#" class="close pt-2 text-18" data-dismiss="alert" aria-label="close">&times;</a>
								{{ Session::get('message') }}
							</div>
						</div>
					@endif

					<div class="row mt-5">
						<div class="col-md-12 p-0">
							<form class="form-horizontal pl-0 pr-0 pl-md-4 pr-md-4" enctype='multipart/form-data' action="{{ url('users/payout-list') }}" method="GET" id='filter_form' accept-charset="UTF-8">
								{{ csrf_field() }}
								<input class="form-control" type="text" id="startDate"  name="from" value="{{ isset($from) ? $from : '' }}" hidden>
								<input class="form-control" type="text" id="endDate"  name="to" value="{{ isset($to) ? $to : '' }}" hidden>

								<div class="row justify-content-between">
									<div class="d-flex rounded-3 pt-3 pb-3  border">
										<div class="pl-3 pr-3">
											<button type="button" class="form-control pick_date pick_date-width pick-btn" id="daterange-btn">
												<span class="float-left">
													<i class="fa fa-calendar pr-2"></i> {{ __('Pick a date range') }}
												</span>
												<i class="fa fa-caret-down float-right mt-2 mr-1"></i>
											</button>
										</div>

										<div class="text-right pl-3 pr-3">
											<button type="submit" name="btn" class="btn vbtn-outline-success text-14 font-weight-700 pl-4 pr-4 pt-3 pb-3 mr-2">{{ __('Filter') }}</button>

										</div>
									</div>

									<div class="mt-4 mt-sm-0">
										@if ($payouts->count() > 0)
											<button  type="button" class="btn vbtn-outline-success text-14 font-weight-700 pl-4 pr-4 pt-3 pb-3" data-toggle="modal" data-target="#exampleModal">
												{{ __('Payout Request') }}
												<i class="fa fa-arrow-up"></i>
											</button>
										@else
											<button type="button" class="btn vbtn-outline-success text-14 font-weight-700 pl-4 pr-4 pt-3 pb-3 no-payout">
												{{ __('Payout Request') }}
												<i class="fa fa-arrow-up"></i>
											</button>
										@endif

									</div>

								</div>
							</form>
						</div>
						<div class="col-md-12 mt-4">
							<div class="panel-footer">
								<div class="panel">
									<div class="panel-body">
										<div class="box mb-5">
											<div class="card-body p-0">
												<div class="table-responsive f-14">
													{!! $dataTable->table(['class' => 'table table-striped table-hover dt-responsive pt-4', 'width' => '100%', 'cellspacing' => '0']) !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header p-4">
					<h2 class="modal-title" id="exampleModalLabel">{{ __('Payout Request') }}</h2>
					<button type="button" class="close text-28" data-dismiss="modal" aria-label="Close" id="modalClose">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body p-4">
					<form action="{{ url('users/payout/success') }}" id="add_payout_request" method="post" name="add_payout_setting" accept-charset='UTF-8'>
						{{ csrf_field() }}
						<div class="row" id="paymentDiv">
							<div class="col-md-12">
								<div class="form-group">
									<label for="exampleInputPassword1" class="control-label">{{ __('Payment Method') }}</label>
									<select class="form-control text-14" name="payment_method_id" id="payment_method_id">
										@foreach ($payouts as $payout)
											<option value="{{ $payout->id }}">{{ ( $payout->type == 1) ? __('Paypal (:x)', ['x' => $payout->email]) :  __('Bank (:x)', ['x' => $payout->account_number]) }} </option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="exampleInputPassword1" class="control-label">{{ __('Currency') }}</label>
									<select class="form-control text-14" name="currency_id" id="currency_id">
										<option value="{{ $default_currency->id ?? Session::get('default_currency')}}">{{ $default_currency->code ?? Session::get('currency') }}</option>
									</select>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="exampleInputPassword1" class="control-label">{{ __('Amount') }}
                                        <span class="text-danger">* </span>
                                        ({!! $default_currency->symbol ?? Session::get('symbol'). convert_currency($walletBalance->currency->code, $default_currency->code ?? Session::get('currency'), $walletBalance->balance) . $default_currency->code ?? Session::get('currency') !!})
                                    </label>
									<input type="text" class="form-control text-14" name="amount" id="amount" value="{{ old('amount') }}">
									<span class="text-danger d-none" id="amount_high">{{ __("Don't have sufficient balance !") }}</span>

									@if ($errors->has('amount'))
										<p class="error-tag">
											{{ $errors->first('amount') }}
										</p>
									@endif
								</div>
							</div>

							<input type="text" name="balance" id="balance" value="{{ convert_currency($walletBalance->currency->code, $default_currency->code ?? Session::get('currency'), $walletBalance->balance) }}" hidden="">

							<div class="col-md-12 text-right mt-4">
								<button type="button" class="btn btn-outline-danger text-14 mt-2 pl-4 pr-4 mr-2 " id="close" data-dismiss="modal">{{ __('Close') }}</button>
								<button type="button" class="btn vbtn-outline-success text-14 mt-2 pl-4 pr-4 ml-2" disabled id="next_btn">  {{ __('Next') }} </button>
							</div>
						</div>

						<div class="row d-none" id="confirmDiv"></div>
					</form>
				</div>

			</div>
		</div>
	</div>
@endsection

@section('validation_script')
	<script type="text/javascript" src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/dataTables.responsive.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('public/js/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/daterangepicker.min.js') }}"></script>
	{!! $dataTable->scripts() !!}
	<script type="text/javascript" src="{{ asset('public/js/sweetalert.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/daterangecustom.min.js') }}"></script>

	<script type="text/javascript">
		'use strict'
		let noPayoutSettingsText = "{{ __('No Payout Setting!') }}";
		let addMethodText = "{{ __('Add Payout Method') }}";
        let okText = "{{ __('OK') }}";
        let saveText = "{{ __('Save') }}..";
		let payouts = {!! $payouts !!};
		var bank_holder = "{{ __('Account Holder Name') }}";
		var bank_account_num = "{{ __('Account Number/IBAN') }}";
		var swift_code = "{{ __('Swift Code') }}";
		var bank_name = "{{ __('Bank Name') }}";
		var symbol = "{!! $default_currency->code ?? Session::get('currency') !!}";
		var submit = "{{ __('Submit') }}";
		let totalPayoutText = "{{ __('Total Payout') }}";

		let page = 'payoutlists';
	</script>

	<script type="text/javascript" src="{{ asset('public/js/payout.min.js') }}"></script>
@endsection
