<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script type="text/javascript">
  var APP_URL = "{{ (url('/')) }}";
</script>
<!-- jQuery 2.2.4 -->
<script type="text/javascript" src="{{ asset('public/backend/plugins/jQuery/jquery-3.6.3.min.js') }}"></script>
<!-- popper -->
<script type="text/javascript" href="{{ asset('public/backend/bootstrap/js/popper.min.js') }}"></script>
<!-- slim -->
<script type="text/javascript" src="{{ asset('public/backend/bootstrap/js/slim.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<!-- jQuery validation -->
<script type="text/javascript" src="{{ asset('public/backend/plugins/jQuery/jquery.validate.min.js') }}"></script>
<!-- jQuery validation -->
<script type="text/javascript" src="{{ asset('public/backend/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script type="text/javascript">
  $.widget.bridge('uibutton', $.ui.button);
  var sessionDate      = '{!! Session::get('date_format_type') !!}';
</script>
<!-- Bootstrap 3.3.6 -->
<script type="text/javascript" src="{{ asset('public/backend/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ config("vrent.google_map_key") }}&libraries=places'></script>
  <script type="text/javascript" src="{{ asset('public/backend/js/locationpicker.jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('public/backend/js/bootbox.min.js') }}"></script>
<!-- admin js -->
<script type="text/javascript" src="{{ asset('public/backend/dist/js/admin.min.js') }}"></script>
<!-- backend js -->
<script type="text/javascript" src="{{ asset('public/backend/js/backend.min.js') }}"></script>
<!-- CK Editor -->
<!-- Morris.js charts -->
@if (Route::current()->uri() == 'admin/dashboard')
@endif
<!-- Sparkline -->
<script type="text/javascript" src="{{ asset('public/backend/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script type="text/javascript" src="{{ asset('public/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script type="text/javascript" src="{{ asset('public/backend/plugins/knob/jquery.knob.js') }}"></script>
<!-- daterangepicker -->

<script type="text/javascript">

    var separator  = '{{ settings("date_separator") }}';
    var dateFormat = '{{ strtoupper(settings("date_format_type")); }}';
    var splitDate  = dateFormat.split(separator);

    if (splitDate[1] === 'M') {
        dateFormat  = dateFormat.replace('M', 'MMM');
    }

</script>
<script type="text/javascript" src="{{ asset('public/backend/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/backend/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script type="text/javascript" src="{{ asset('public/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script type="text/javascript" src="{{ asset('public/backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script type="text/javascript" src="{{ asset('public/backend/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="{{ asset('public/backend/dist/js/app.min.js') }}"></script>
<!--Select2-->
<script type="text/javascript" src="{{ asset('public/backend/plugins/select2/select2.full.min.js') }}"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@if (Route::current()->uri() == 'admin/dashboard')
@endif
<!-- AdminLTE for demo purposes -->
<script type="text/javascript" src="{{ asset('public/backend/dist/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/backend/dist/js/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/backend/js/daterangecustom.js') }}"></script>
</body>

@stack('scripts')
</html>
