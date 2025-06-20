@extends('admin.template')
@section('main')
	<div class="content-wrapper">
		<!-- Main content -->
		<section class="content-header">
			<h1>Amenities<small>Amenities</small></h1>
			<ol class="breadcrumb">
				<li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			</ol>
		</section>

		<section class="content">
			<div class="row gap-2">
				<div class="col-md-3 settings_bar_gap">
					@include('admin.common.property_bar')
				</div>

				<div class="col-md-9">
					<form method="post" action="{{ url('admin/listing/' . $result->id . '/' . $step) }}" class='signup-form login-form' accept-charset='UTF-8'>
						{{ csrf_field() }}
						<div class="box box-info">
							<div class="box-body">
								@foreach ($amenities_type as $row_type)
									<div class="row">
										<div class="col-md-12">
											<p class="f-18">
												{{ $row_type->name }}

												@if ($row_type->name == 'Common Amenities')
													<span class="text-danger">*</span>
												@endif
											</p>
										</div>
									</div>

									<div class="row">
										@if ($row_type->description != '')
											<p class="text-muted">{{ $row_type->description }}</p>
										@endif
										<div class="col-md-6 col-sm-12 col-xs-12">
											<ul class="list-unstyled fw-bold">
												@foreach ($amenities as $amenity)
													@if ($amenity->type_id == $row_type->id)
														<li>
															<span>&nbsp;&nbsp;</span>
															<label class="label-large label-inline amenity-label">
																<input type="checkbox" value="{{ $amenity->id }}" name="amenities[]" data-saving="{{ $row_type->id }}" {{ in_array($amenity->id, $property_amenities) ? 'checked' : '' }}> &nbsp;&nbsp;
																<span>{{ $amenity->title }}</span>
															</label>
															<span>&nbsp;</span>

															@if ($amenity->description != '')
																<span data-bs-toggle="tooltip" class="icon" title="{{ $amenity->description }}"></span>
															@endif
														</li>
													@endif
												@endforeach
											</ul>
										</div>
									</div>
								@endforeach
								<p id='error'></p>
								<br>
								<div class="row">
									<div class="col-6 text-left">
										<a data-prevent-default="" href="{{ url('admin/listing/' . $result->id . '/location') }}" class="btn btn-large btn-primary f-14">Back</a>
									</div>

									<div class="col-6 text-right">
										<button type="submit" class="btn btn-large btn-primary next-section-button f-14">
										    Next
										</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
	</div>
	@endsection
