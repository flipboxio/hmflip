@extends('admin.template')

@section('main')
<div class="content-wrapper">
	<section class="content">
		@include('admin.customerdetails.customer_menu')
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body">
						<form class="form-horizontal" enctype='multipart/form-data' action="{{ url('admin/customer/bookings/' . $user->id) }}" method="GET" accept-charset="UTF-8">
							{{ csrf_field() }}
							<input class="form-control" id="startfrom" type="hidden" name="from" value="{{ isset($from) ? $from : '' }}">
							<input class="form-control" id="endto" type="hidden" name="to" value="{{ isset($to) ? $to : '' }}">
							<div class="col-md-12">
                                <div class="row row align-items-center date-parent">
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

                                    <div class="col-md-3 col-sm-3 col-xs-12">
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

                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <label>Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="" >All</option>
                                            <option value="Accepted" {{ $allstatus == "Accepted" ? ' selected = "selected"' : '' }}>Accepted</option>
                                            <option value="Cancelled"  {{ $allstatus == "Cancelled"  ? ' selected = "selected"' : '' }}>Cancelled</option>
                                            <option value="Declined" {{ $allstatus == "Declined" ? ' selected = "selected"' : '' }}>Declined</option>
                                            <option value="Expired"  {{ $allstatus == "Expired"  ? ' selected = "selected"' : '' }}>Expired</option>
                                            <option value="Pending"  {{ $allstatus == "Pending"  ? ' selected = "selected"' : '' }}>Pending</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1 col-sm-2 col-xs-4 d-flex gap-2 mt-4">
                                        <button type="submit" name="btn" class="btn btn-primary btn-flat f-14 rounded">Filter</button>
                                        <button type="button" name="reset_btn" id="reset_btn" class="btn btn-primary btn-flat f-14 rounded">Reset</button>
                                    </div>
                                </div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
			<div class="box">
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
		var sessionDate  = '{{ strtoupper(Session::get('date_format_type')) }}';
		var user_id      = '{{ $user?->id }}';
		var page 		 = 'customer_booking'

	</script>
	<script src="{{ asset('public/backend/js/property_customer_dropdown.min.js') }}"></script>
	<script src="{{ asset('public/backend/js/reset-btn.min.js') }}"></script>
    <script src="{{ asset('public/backend/js/admin-date-range-picker.min.js') }}"></script>
@endsection