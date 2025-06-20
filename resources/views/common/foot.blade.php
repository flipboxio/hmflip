		<!-- New Js start-->
		<script src="{{ asset('public/js/jquery-2.2.4.min.js') }}"></script>
		<script src="{{ asset('public/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('public/js/main.min.js') }}"></script>

		  {!! $head_code ?? '' !!}

		<!-- New Js End -->
		<!-- Needed Js from Old Version Start-->
		<script type="text/javascript">
			var APP_URL = "{{ url('/') }}";
			var USER_ID = "{{ isset(Auth::user()->id)  ? Auth::user()->id : ''  }}";
			var sessionDate      = '{!! Session::get('date_format_type') !!}';
			var token = '{{ csrf_token() }}';

		</script>
		<script src="{{ asset('public/js/front-foot.min.js') }}"></script>

		<!-- Needed Js from Old Version End -->
		@stack('scripts')
	</body>
</html>