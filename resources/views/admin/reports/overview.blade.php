@extends('admin.template')
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Overview & Statisics</h1>
		@include('admin.common.breadcrumb')
	</section>
	
	<!-- Main content -->
	<section class="content">
		
		<!--Filtering Box Start -->
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body">
						<form class="form-horizontal" enctype='multipart/form-data' action="{{ url('admin/overview-stats') }}" method="GET" accept-charset="UTF-8">
							{{ csrf_field() }}
							<div class="col-md-12  d-none">
								<input class="form-control" type="text" id="startDate"  name="from" value="{{ isset($from) ? $from : '' }}" hidden>
								<input class="form-control" type="text" id="endDate"  name="to" value="{{ isset($to) ? $to : '' }}" hidden>
							</div>

                            <div class="row align-items-center date-parent">
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label>Date Range</label>
                                    <div class="input-group  col-xs-12">
                                        <button type="button" class="form-control" id="daterange-btn">
                                            <span class="pull-left">
                                                <i class="fa fa-calendar"></i>  Pick a date range
                                            </span>
                                            <i class="fa fa-caret-down pull-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <label>Property</label>
                                    <select class="form-control select2" name="property" id="property">
                                        <option value="">All</option>
                                        @if (!empty($properties))
                                            @foreach ($properties as $property)
                                                <option value="{{ $property->id }}" {{ $property->id == $allproperties ? ' selected = "selected"' : '' }}>{{ $property->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-2 col-xs-4 d-flex gap-2 mt-4">
                                    <button type="submit" name="btn" class="btn btn-primary btn-flat f-14 rounded">Filter</button>
                                    <button type="button" name="reset_btn" id="reset_btn" class="btn btn-primary btn-flat f-14 rounded">Reset</button>
                                </div>
                            </div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--Filtering Box End -->
		<div class="row">
			<div class="col-md-8 col-xs-12">
				<div class="box">
					<!-- /.box-header -->
					<div class="box-body">
						<div id="main" class="w-100-p h-100-p"></div>
						<br>
					</div>
				</div>
			</div>
			<input type="hidden" value="{{  $collections  }}" id="collections" name="collections[]" >
			<div class="col-md-4 col-xs-12">
				<div class="box">
					<!-- /.box-header -->
					<div class="box-body">
						<h5>
							Number of Reservations from per Country
						</h5>
						@if ($countryCodes != null)
						<table class="scroll wide f-14">
							@foreach ($countryCodes as $countryCode)
							<tr>
								<td>
									{{ $countryCode->value }}
									@php
									$percentage = ($countryCode->value/$totalReservations) * 100;
									@endphp
									( {{ round($percentage) }}% )
								</td>
							</tr>
							<tr>
								<td width="25%">
									<img src='{{ asset("public/images/flags/flags-medium/" . strtolower($countryCode->code) . ".png") }}' width="35px" height="20px">
								</td>
								<td>
									{{ $countryCode->name }}
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							@endforeach
						</table>
						
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@stop

@section('validate_script')
<script src="{{ asset('public/backend/js/reset-btn.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/ECharts/echarts.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/ECharts/echarts-gl.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/ECharts/ecStat.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/ECharts/dataTool.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/ECharts/china.js') }}"></script>
<script src="{{ asset('public/backend/plugins/ECharts/world.js') }}"></script>
<script src="{{ asset('public/backend/plugins/ECharts/simplex.js') }}"></script>
<script src="{{ asset('public/backend/js/report.min.js') }}" type="text/javascript"></script>
@endsection