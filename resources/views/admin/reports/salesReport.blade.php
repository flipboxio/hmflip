@extends('admin.template')
@section('main')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
     <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{!! moneyFormat($default_cur_code->org_symbol, $totalIncome ?? '') !!}</h3>

              <p>Total Income</p>
              <p></p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <p class="small-box-footer">Income from Past 12 Months</p>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $totalNights ?? '' }}</h3>

              <p>Total Nights</p>
            </div>
            <div class="icon">
              <i class="fa fa-building"></i>
            </div>
            <p class="small-box-footer">Reserved Nights from Past 12 Months</p>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $totalReservations ?? ''}}</h3>

              <p>Total Reservations</p>
            </div>
            <div class="icon">
              <i class="fa fa-plane"></i>
            </div>
            <p class="small-box-footer">Reservations from Past 12 Months</p>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- /.content -->
      <div class="row">
        <div id="container" class="sale-container"></div>
      </div>

      <!-- /.content -->
      <div class="row">
        
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('validate_script')
<script src="{{ asset('public/backend/plugins/highcharts/highcharts.js') }}"></script>
<script src="{{ asset('public/backend/plugins/highcharts/exporting.js') }}"></script>
<script type="text/javascript">
  'use strict'
  let currencyCode = "{{ $default_cur_code->code }}";
  let totalIncome = "{{ $totalIncome }}";
  let totalNight = "{{ $totalNights }}";
  let months = '{!! $months !!}';
  let monthlyNights = '{!! $monthlyNights !!}';
	
</script>
<script src="{{ asset('public/backend/js/sales-report.min.js') }}"></script>

@endsection