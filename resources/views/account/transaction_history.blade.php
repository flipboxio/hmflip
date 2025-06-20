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
										<a class="text-color font-weight-700 text-color-hover" href="{{ url('users/transaction-history') }}">{{ __('Transactions') }}</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>

					<div class="row mt-4">
						<div class="col-md-12">
							<form class="form-horizontal pl-0 pr-0" enctype='multipart/form-data' action="{{ url('users/transaction-history') }}" method="GET" id='filter_form' accept-charset="UTF-8">
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

								</div>
							</form>
						</div>

						<div class="col-md-12">
							<div class="panel-footer">
								<div class="panel">
									<div class="panel-body">
										<div class="box mb-5">
											<div class="card-body p-0">
												<div class="table-responsive">
													{!! $dataTable->table(['class' => 'table table-striped table-hover dt-responsive pt-4 text-center', 'width' => '100%', 'cellspacing' => '0']) !!}
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
</div>
@endsection


@section('validation_script')
<script type="text/javascript" src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/dataTables.responsive.min.js') }}"></script>
{!! $dataTable->scripts() !!}
<script type="text/javascript" src="{{ asset('public/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/daterangepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/daterangecustom.min.js') }}"></script>

<script type="text/javascript">
	'use strict'
	var dt = 1;
	var startDate = $('#startDate').val();
	var endDate   = $('#endDate').val();	
</script>
<script type="text/javascript" src="{{ asset('public/js/transaction-history.min.js') }}"></script>

@endsection


