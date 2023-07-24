@php
use App\Models\SiteSetting;
if (!auth()->user()) {
@endphp
<script>
 window.location.href = '{{url("/admin/login/")}}';
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
		<link rel="stylesheet" href="{{ URL::asset('public/assets/admin/fonts/style.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('public/assets/admin/css/main.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('public/assets/css/custom.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('public/assets/admin/css/chat.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('public/assets/datatables/dataTables.bs4.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('public/assets/datatables/dataTables.bs4-custom.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/bootstrap-multiselect-master/dist/css/bootstrap-multiselect.css') }}" media="screen"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/bootstrap4-datetimepicker-master/css/bootstrap-datetimepicker.min.css') }}" media="screen"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/font_awesome_5/css/all.css') }}" media="screen"/>
		<script src="{{ URL::asset('public/assets/admin/js/jquery.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('public/assets/js/jquery.blockUI.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('public/assets/js/sweetalert.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('public/assets/js/additional-methods.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/js/jquery.validate.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('public/assets/bootstrap4-datetimepicker-master/js/moment.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/bootstrap4-datetimepicker-master/js/bootstrap-datetimepicker.min.js') }}"></script>
	</head>

	<body class="authentication">
		<!-- Loading starts -->
		<div id="loading-wrapper">
			<div class="spinner-border" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
		<!-- Loading ends -->
		
		<!-- Page wrapper start -->
		<div class="page-wrapper">
			
			<!-- Sidebar wrapper start -->
			<nav id="sidebar" class="sidebar-wrapper">

				<!-- Sidebar brand start  -->
				<div class="sidebar-brand">
					<a href="{{ url('/admin/dashboard') }}" class="logo">
					@if (isset(SiteSetting::first()->admin_logo) && SiteSetting::first()->admin_logo != '')
						<img src="{{ URL::asset('public/uploads/site_settings/normal/').'/'.SiteSetting::first()->admin_logo }}" alt="Chat" />
					@else
						{{ SiteSetting::first()->site_name }}
					@endif
					</a>
				</div>
				<!-- Sidebar brand end  -->
				
				<!-- User profile start -->
				<!--<div class="sidebar-user-details">
					<div class="user-profile">
						<img src="{{ URL::asset('public/assets/admin/img/user2.png') }}" class="profile-thumb" alt="User Thumb">
						<span class="status-label"></span>
					</div>
					<h6 class="profile-name">Yuki Hayashi</h6>
					<div class="profile-actions">
						<a href="account-settings.html" data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
							<i class="icon-settings1"></i>
						</a>
						<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Twitter">
							<i class="icon-twitter1"></i>
						</a>
						<a href="login.html" class="red" data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout">
							<i class="icon-power1"></i>
						</a>
					</div>					
				</div>-->
				<!-- User profile end -->

				<!-- Sidebar content start -->
				<div class="sidebar-content">

					<!-- sidebar menu start -->
					<div class="sidebar-menu">
						<ul>
							<li class="{{ ($mainHeader == 'Dashboard') ? 'active' : '' }}">
								<a href="{{ url('/admin/dashboard') }}" class="{{ ($mainHeader == 'Dashboard') ? 'current-page' : '' }}">
									<i class="icon-home2"></i>
									<span class="menu-text">Dashboard</span>
								</a>
							</li>
							<li class="{{ ($mainHeader == 'Menus' || $mainHeader == 'Add Menu' || $mainHeader == 'Edit Menu') ? 'active' : '' }}">
								<a href="{{ url('/admin/menus') }}" class="{{ ($mainHeader == 'Menus' || $mainHeader == 'Add Menu' || $mainHeader == 'Edit Menu') ? 'current-page' : '' }}">
									<i class="icon-add-to-list"></i>
									<span class="menu-text">Menus</span>
								</a>
							</li>
							<li class="{{ ($mainHeader == 'Pages' || $mainHeader == 'Add Page' || $mainHeader == 'Edit Page') ? 'active' : '' }}">
								<a href="{{ url('/admin/pages') }}" class="{{ ($mainHeader == 'Pages' || $mainHeader == 'Add Page' || $mainHeader == 'Edit Page') ? 'current-page' : '' }}">
									<i class="icon-documents"></i>
									<span class="menu-text">Pages</span>
								</a>
							</li>
							<li class="{{ ($mainHeader == 'Packages' || $mainHeader == 'Add Package' || $mainHeader == 'Edit Package') ? 'active' : '' }}">
								<a href="{{ url('/admin/packages') }}" class="{{ ($mainHeader == 'Packages' || $mainHeader == 'Add Package' || $mainHeader == 'Edit Package') ? 'current-page' : '' }}">
									<i class="icon-attach_money"></i>
									<span class="menu-text">Packages</span>
								</a>
							</li>
							<li class="{{ ($mainHeader == 'Home Sliders' || $mainHeader == 'Add Home Slider' || $mainHeader == 'Edit Home Slider') ? 'active' : '' }}">
								<a href="{{ url('/admin/home-sliders') }}" class="{{ ($mainHeader == 'Home Sliders' || $mainHeader == 'Add Home Slider' || $mainHeader == 'Edit Home Slider') ? 'current-page' : '' }}">
									<i class="icon-box"></i>
									<span class="menu-text">Home Sliders</span>
								</a>
							</li>
							<li class="sidebar-dropdown {{ ($mainHeader == 'Properties' || $mainHeader == 'Add Property' || $mainHeader == 'Edit Property' || $mainHeader == 'Property Types' || $mainHeader == 'Add Property Type' || $mainHeader == 'Edit Property Type' || $mainHeader == 'Property Terms' || $mainHeader == 'Add Property Term' || $mainHeader == 'Edit Property Term') ? 'active' : '' }}">
								<a href="javascript:void(0)">
									<i class="icon-shopping-basket"></i>
									<span class="menu-text">Properties</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="{{ url('/admin/properties') }}" class="{{ ($mainHeader == 'Properties' || $mainHeader == 'Add Property' || $mainHeader == 'Edit Property' || $mainHeader == 'Payment Lists' || $mainHeader == 'Add Payment List' || $mainHeader == 'Edit Payment List') ? 'current-page' : '' }}">Properties</a>
										</li>
										<li>
											<a href="{{ url('/admin/property-types') }}" class="{{ ($mainHeader == 'Property Types' || $mainHeader == 'Add Property Type' || $mainHeader == 'Edit Property Type') ? 'current-page' : '' }}">Property Types</a>
										</li>
										<li>
											<a href="{{ url('/admin/property-terms') }}" class="{{ ($mainHeader == 'Property Terms' || $mainHeader == 'Add Property Term' || $mainHeader == 'Edit Property Term') ? 'current-page' : '' }}">Property Terms</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="{{ ($mainHeader == 'Contacts' || $mainHeader == 'Contact Details') ? 'active' : '' }}">
								<a href="{{ url('/admin/contacts') }}" class="{{ ($mainHeader == 'Contacts' || $mainHeader == 'Contact Details') ? 'current-page' : '' }}">
									<i class="icon-drafts"></i>
									<span class="menu-text">Contacts</span>
								</a>
							</li>
							<li class="{{ ($mainHeader == 'Users' || $mainHeader == 'Add User' || $mainHeader == 'Edit User') ? 'active' : '' }}">
								<a href="{{ url('/admin/users') }}" class="{{ ($mainHeader == 'Users' || $mainHeader == 'Add User' || $mainHeader == 'Edit User') ? 'current-page' : '' }}">
									<i class="icon-users"></i>
									<span class="menu-text">Users</span>
								</a>
							</li>
							<li class="{{ ($mainHeader == 'Blogs' || $mainHeader == 'Add Blog' || $mainHeader == 'Edit Blog') ? 'active' : '' }}">
								<a href="{{ url('/admin/blogs') }}" class="{{ ($mainHeader == 'Blogs' || $mainHeader == 'Add Blog' || $mainHeader == 'Edit Blog') ? 'current-page' : '' }}">
									<i class="icon-box"></i>
									<span class="menu-text">Blogs</span>
								</a>
							</li>
							<li class="{{ ($mainHeader == 'Testimonials' || $mainHeader == 'Add Testimonial' || $mainHeader == 'Edit Testimonial') ? 'active' : '' }}">
								<a href="{{ url('/admin/testimonials') }}" class="{{ ($mainHeader == 'Testimonials' || $mainHeader == 'Add Testimonial' || $mainHeader == 'Edit Testimonial') ? 'current-page' : '' }}">
									<i class="icon-border_color"></i>
									<span class="menu-text">Testimonials</span>
								</a>
							</li>
							<li class="{{ ($mainHeader == 'Email Templates' || $mainHeader == 'Add Email Template' || $mainHeader == 'Edit Email Template') ? 'active' : '' }}">
								<a href="{{ url('/admin/email-templates') }}" class="{{ ($mainHeader == 'Email Templates' || $mainHeader == 'Add Email Template' || $mainHeader == 'Edit Email Template') ? 'current-page' : '' }}">
									<i class="icon-layers2"></i>
									<span class="menu-text">Email Templates</span>
								</a>
							</li>
						</ul>
					</div>
					<!-- sidebar menu end -->

				</div>
				<!-- Sidebar content end -->
				
			</nav>
			<!-- Sidebar wrapper end -->

			<!-- Page content start  -->
			<div class="page-content">
				<!-- Header start -->
				<header class="header">
					<div class="toggle-btns">
						<a id="toggle-sidebar" href="#">
						<i class="icon-menu"></i>
						</a>
						<a id="pin-sidebar" href="#">
						<i class="icon-menu"></i>
						</a>
					</div>
					<div class="header-items">

						<!-- Header actions start -->
						<ul class="header-actions">
						<li class="dropdown user-settings">
							<a href="#" id="userSettings" data-toggle="dropdown" aria-haspopup="true">
							@if (isset(Auth::user()->profile_image) && Auth::user()->profile_image != '')
							<img src="{{ URL::asset('public/uploads/profile_images/thumb/').'/'.Auth::user()->profile_image }}" class="user-avatar" alt="Avatar">
							@endif
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
							<div class="header-profile-actions">
								<div class="header-user-profile">
								<div class="header-user">
								@if (isset(Auth::user()->profile_image) && Auth::user()->profile_image != '')
								<img src="{{ URL::asset('public/uploads/profile_images/thumb/').'/'.Auth::user()->profile_image }}" class="user-avatar" alt="Avatar">
								@endif
								</div>
								<h5>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</h5>
								</div>
								<a href="{{ url('/admin/profile') }}"><i class="icon-user1"></i> My Profile</a>
								<a href="{{ url('/admin/change-password') }}"><i class="icon-user1"></i> Change Password</a>
								<a href="{{ url('/admin/site-settings') }}"><i class="icon-settings1"></i> Site Settings</a>
								<a href="{{ url('/admin/logout') }}"><i class="icon-log-out1"></i> Sign Out</a>
							</div>
							</div>
						</li>
						</ul>						
						<!-- Header actions end -->
					</div>
					</header>
					<!-- Header end -->
				<!-- Main container start -->
					<div class="main-container">

					<!-- Page header start -->
					<div class="page-header">
					
					<!-- Breadcrumb start -->
					<ol class="breadcrumb">
						<li class="breadcrumb-item">{{ $mainHeader ?? '' }}</li>
					</ol>
					<!-- Breadcrumb end -->

					<!-- App actions start -->
					@if (isset($mainHeader) && $mainHeader == 'Dashboard')
					<div class="app-actions">
						<button type="button" class="btn">Today</button>
						<button type="button" class="btn">Yesterday</button>
						<button type="button" class="btn">7 days</button>
						<button type="button" class="btn">15 days</button>
						<button type="button" class="btn active">30 days</button>
					</div>
					@endif
					<!-- App actions end -->

					</div>
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
					<!-- Page header end -->
					
				@yield('content')
				</div>
				<!-- Main container end -->
				
				<!-- Container fluid start -->
				<div class="container-fluid">
					<!-- Row start -->
					<div class="row gutters">
						<div class="col-12">
							<!-- Footer start -->
							<div class="footer">
							&copy; {{ date("Y") }} Sirchend Software Pvt. Ltd. 
							</div>
							<!-- Footer end -->
						</div>
					</div>
					<!-- Row end -->
				</div>
				<!-- Container fluid end -->
				
				<!-- Chat start -->
				<div id="chat-box">
					<div id="chat-circle" class="btn btn-raised">
						<img src="{{ URL::asset('public/assets/admin/img/chat.svg') }}" alt="Chat" />
					</div>
					<div class="chat-box">
						<div class="chat-box-header">
							Chat
							<span class="chat-box-toggle"><i class="icon-close"></i></span>
						</div>
						<div class="chat-box-body">
							<div class="chat-logs">
								<div class="chat-msg self">
									<img src="{{ URL::asset('public/assets/admin/img/user2.png') }}" class="user" alt="">
									<div class="chat-msg-text">Hello</div>
								</div>
								<div class="chat-msg user">
									<img src="{{ URL::asset('public/assets/admin/img/user15.png') }}" class="user" alt="">
									<div class="chat-msg-text">Are we meeting today?</div>
								</div>
								<div class="chat-msg self">
									<img src="{{ URL::asset('public/assets/admin/img/user2.png') }}" class="user" alt="">
									<div class="chat-msg-text">Yes, what time suits you?</div>
								</div>
								<div class="chat-msg user">
									<img src="{{ URL::asset('public/assets/admin/img/user15.png') }}" class="user" alt="">
									<div class="chat-msg-text">Can we connect at 3pm?</div>
								</div>
								<div class="chat-msg self">
									<img src="{{ URL::asset('public/assets/admin/img/user2.png') }}" class="user" alt="">
									<div class="chat-msg-text">Sure, Thanks. I will send you some important files.</div>
								</div>
								<div class="chat-msg user">
									<img src="{{ URL::asset('public/assets/admin/img/user15.png') }}" class="user" alt="">
									<div class="chat-msg-text">Great. Thanks!</div>
								</div>
							</div>
						</div>
						<div class="chat-input">
							<form>
								<input type="text" id="chat-input" placeholder="Send a message..."/>
							<button type="submit" class="chat-submit" id="chat-submit"><i class="icon-send"></i></button>
							</form>
						</div>
					</div>
				</div>
				<!-- Chat end -->

			</div>
			<!-- Page content end -->

		</div>
		<!-- Page wrapper end -->
		<script src="{{ URL::asset('public/assets/admin/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/admin/js/moment.js') }}"></script>
		<script src="{{ URL::asset('public/assets/admin/vendor/slimscroll/slimscroll.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/admin/vendor/slimscroll/custom-scrollbar.js') }}"></script>
		<!-- Polyfill JS -->
		<script src="{{ URL::asset('public/assets/admin/vendor/polyfill/polyfill.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/admin/vendor/polyfill/class-list.min.js') }}"></script>
		<!-- Apex Charts -->
		<script src="{{ URL::asset('public/assets/admin/vendor/apex/apexcharts.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/admin/vendor/apex/custom/home/lineRevenueGradientGraph.js') }}"></script>
		<script src="{{ URL::asset('public/assets/admin/vendor/apex/custom/home/radialTasks.js') }}"></script>
		<script src="{{ URL::asset('public/assets/admin/vendor/apex/custom/home/lineNewCustomersGradientGraph.js') }}"></script>
		<!-- Peity Charts -->
		<script src="{{ URL::asset('public/assets/admin/vendor/peity/peity.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/admin/vendor/peity/custom-peity.js') }}"></script>
		<!-- Circleful Charts -->
		<script src="{{ URL::asset('public/assets/admin/vendor/circliful/circliful.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/admin/vendor/circliful/circliful.custom.js') }}"></script>
		<script src="{{ URL::asset('public/assets/datatables/dataTables.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/datatables/dataTables.bootstrap.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/datatables/custom/custom-datatables.js') }}"></script>
		<script src="{{ URL::asset('public/assets/datatables/custom/fixedHeader.js') }}"></script>
		<script src="{{ URL::asset('public/assets/datatables/buttons.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/datatables/jszip.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/datatables/vfs_fonts.js') }}"></script>
		<script src="{{ URL::asset('public/assets/datatables/html5.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/datatables/buttons.print.min.js') }}"></script>
		<!-- Main JS -->
		<script src="{{ URL::asset('public/assets/admin/js/main.js') }}"></script>
		<script src="{{ URL::asset('public/assets/ckeditor/ckeditor.js') }}"></script>
		<script src="{{ URL::asset('public/assets/admin/js/jquery.nestable.js') }}"></script>
<script>
(function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 1e3; // 1 second default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                // Chrome Fix (Use keyup over keypress to detect backspace)
                // thank you @palerdot
                $el.is(':input') && $el.on('keyup keypress paste',function(e){
                    // This catches the backspace button in chrome, but also prevents
                    // the event from triggering too preemptively. Without this line,
                    // using tab/shift+tab will make the focused element fire the callback.
                    if (e.type=='keyup' && e.keyCode!=8) return;
                    
                    // Check if timeout has been set. If it has, "reset" the clock and
                    // start over again.
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        // if we made it here, our timeout has elapsed. Fire the
                        // callback
                        doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                    // If we can, fire the event since we're leaving the field
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);
</script>
	</body>
</html>