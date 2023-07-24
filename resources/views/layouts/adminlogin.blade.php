@php
use App\Models\SiteSetting;
if (auth()->user()) {
@endphp
<script>
 window.location.href = '{{url("admin/dashboard/")}}';
</script>
@php
}
@endphp
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Responsive Bootstrap4 Dashboard Template">
		<meta name="author" content="ParkerThemes">
		@if (isset(SiteSetting::first()->favicon) && SiteSetting::first()->favicon != '')
		<link rel="shortcut icon" href="{{ URL::asset('public/uploads/site_settings/normal/').'/'.SiteSetting::first()->favicon }}" />
		@else
		<link rel="shortcut icon" href="{{ URL::asset('public/assets/admin/img/fav.png') }}" />
		@endif
		<title>{{ $mainHeader ?? '' }} - {{ SiteSetting::first()->site_name }}</title>
		<link rel="stylesheet" href="{{ URL::asset('public/assets/admin/css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('public/assets/admin/css/main.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('public/assets/css/custom.css') }}" />
		<script src="{{ URL::asset('public/assets/admin/js/jquery.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('public/assets/js/jquery.blockUI.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('public/assets/js/sweetalert.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('public/assets/js/additional-methods.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/js/jquery.validate.min.js') }}"></script>
	</head>

	<body class="authentication">
		@php
		if(Session::get('successMsg')) {
		@endphp
		<script>
		swal(
			'Success!',
			"{{ Session::get('successMsg') }}",
			'success'
		);
		</script>
		@php
			Session::forget('successMsg');
		}
		if(Session::get('errorMsg')) {
		@endphp
		<script>
		swal(
			'Alert!',
			"{{ Session::get('errorMsg') }}",
			'error'
		);
		</script>
		@php
			Session::forget('errorMsg');
		}
		@endphp
		
        @yield('content')
	</body>
</html>