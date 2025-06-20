@extends('admin.template') 
@section('main')

	<div class="content-wrapper">
		<!-- [ Main Content ] start -->
		<div class="row">
			<div class="col-sm-12 list-container" id="brand-list-container">
				<section class="content-header">

					<h1>
						Addons
						<small>Control panel</small>
					</h1>

					@include('admin.common.breadcrumb')
					
				</section>

				<section class="content">

					@include('addons::index')

				</section>

			</div>
		</div>
		<!-- [ Main Content ] end -->
	</div>


@endsection
