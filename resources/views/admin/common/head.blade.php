	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			
			<title> {{ siteName() }} | Dashboard </title>
			
			<meta name="csrf-token" content="{{ csrf_token() }}">

			<!-- Tell the browser to be responsive to screen width -->
			<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			<!-- Bootstrap v5.3.2 -->
			<link rel="stylesheet" href="{{ asset('public/backend/bootstrap/css/bootstrap.min.css') }}">
			<!-- Font Awesome -->
			<link rel="stylesheet" href="{{ asset('public/backend/font-awesome/css/font-awesome.min.css') }}">
			<!-- Theme style -->
			<link rel="stylesheet" href="{{ asset('public/backend/dist/css/AdminLTE.min.css') }}">
			<!-- Custom css -->
			<link rel="stylesheet" href="{{ asset('public/backend/dist/css/custom.min.css') }}">

			<!-- AdminLTE Skins. Choose a skin from the css/skins
				folder instead of downloading all of them to reduce the load. -->
			<link rel="stylesheet" href="{{ asset('public/backend/dist/css/skins/_all-skins.min.css') }}">
			<!-- iCheck -->
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/iCheck/flat/blue.min.css') }}">
			<!-- Morris chart -->
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/morris/morris.min.css') }}">
			<!-- jvectormap -->
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.css') }}">
			<!-- Daterange picker -->
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/daterangepicker/daterangepicker.min.css') }}">
			<!-- Date Picker -->
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/datepicker/datepicker3.min.css') }}">

			<!-- bootstrap wysihtml5 - text editor -->
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

			<!--datatable style-->
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/datatables/dataTables.bootstrap.min.css') }}">
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/datatables/jquery.dataTables.min.css') }}">
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/DataTables-1.10.18/css/jquery.dataTables.min.css') }}">
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/Responsive-2.2.2/css/responsive.dataTables.min.css') }}">
			<!--Select2-->

			<link rel="stylesheet" type="text/css" href="{{ asset('public/js/intl-tel-input-13.0.0/build/css/intlTelInput.min.css') }}">
			<link href="{{ asset('public/backend/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
			<link href="{{ asset('public/backend/css/style2.min.css') }}" rel="stylesheet" type="text/css" />
			<link href="{{ asset('public/backend/css/style.min.css') }}" rel="stylesheet" type="text/css" />
			<link href="{{ asset('public/css/glyphicon.min.min.css') }}" rel="stylesheet" type="text/css" />
			@stack('css')
		</head>
	<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
