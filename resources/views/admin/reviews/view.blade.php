@extends('admin.template') 
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Reviews<small>Control panel</small></h1>
@include('admin.common.breadcrumb')
</section>
<!-- Main content -->
<section class="content">
	<!--Filtering Box Start -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body">
					<form class="form-horizontal" enctype='multipart/form-data' action="{{ url('admin/reviews') }}" method="GET" accept-charset="UTF-8">
						{{ csrf_field() }}
						<div class="col-md-12  d-none">
							<input class="form-control" type="text" id="startDate"  name="from" value="{{ isset($from) ? $from : '' }}" hidden>
							<input class="form-control" type="text" id="endDate"  name="to" value="{{ isset($to) ? $to : '' }}" hidden>
						</div>

                        <div class="row align-items-center date-parent">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label>Date Range</label>
                                <div class="input-group col-xs-12">
                                    <button type="button" class="form-control" id="daterange-btn">
                                    <span class="pull-left">
                                        <i class="fa fa-calendar"></i>  Pick a date range
                                    </span>
                                    <i class="fa fa-caret-down pull-right"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-3 col-xs-12">
                                <label>Property</label>
                                <select class="form-control" name="property" id="property">
                                    <option value="">All</option>
                                    @if (!empty($property))
                                        @foreach ($property as $properties)
                                        <option value="{{ $properties->id }}" {{ $properties->id == $allproperties ? ' selected = "selected"' : '' }}>{{ $properties->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-2 col-xs-12">
                                <label>Reviewer</label>
                                <select class="form-control" name="reviewer" id="reviewer">
                                    <option value="" >All</option>
                                    <option value="guest" {{ $allreviewer == "guest" ? ' selected = "selected"' : '' }}>Guest</option>
                                    <option value="host" {{ $allreviewer == "host" ? ' selected = "selected"' : '' }}>Host</option>
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
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Reviews Management</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive parent-table f-14">
						{!! $dataTable->table(['class' => 'table table-striped table-hover dt-responsive', 'width' => '100%', 'cellspacing' => '0']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
@endsection
@push('scripts')
<script src="{{ asset('public/backend/plugins/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/Responsive-2.2.2/js/dataTables.responsive.min.js') }}"></script>
{!! $dataTable->scripts() !!} 
@endpush 
@section('validate_script')
	<script type="text/javascript">
		'use strict'
		var from      = $('#startDate').val();
		var to        = $('#endDate').val();
		var sessionDate  = '{{strtoupper(Session::get('date_format_type'))}}';
		var page = 'review'
		
	</script>
	<script src="{{ asset('public/backend/js/reset-btn.min.js') }}"></script>
	<script src="{{ asset('public/backend/js/admin-date-range-picker.min.js') }}"></script>
@endsection