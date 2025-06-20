@extends('admin.template')

@section('main')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <section class="content-header">
          <h1>
            Metas
            <small>Control panel</small>
          </h1>
        @include('admin.common.breadcrumb')
      </section>

    <!-- Main content -->
      <section class="content">
          <div class="row">
              <div class="col-lg-3 col-12 settings_bar_gap">
                  @include('admin.common.settings_bar')
              </div>
              <div class="col-lg-9 col-12">
                  <div class="box">
                      <div class="box-header">
                          <h3 class="box-title">Metas Management</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                            <div class="parent-table filters-parent f-14">
                                {!! $dataTable->table(['class' => 'table table-striped dt-responsive', 'width' => '100%', 'cellspacing' => '0']) !!}
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