@php
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\HomeSlider;
use App\Models\Page;
use App\Models\UserPayment;

if (auth()->user()) {
	if($mainHeader == 'Login') {
@endphp
<script>
 window.location.href = '{{url("/profile/")}}';
</script>
@php
	} else if($mainHeader == 'Sign Up') {
@endphp
<script>
 window.location.href = '{{url("/subscribe/")}}';
</script>
@php
	} else if($mainHeader == 'Profile') {
		$id = Auth::user()->id;
		$userPaymentCount = UserPayment::where([['user_payments.user_id', '=' ,$id]])->get()->count();
		if($userPaymentCount == 0) {
@endphp
<script>
 window.location.href = '{{url("/subscribe/")}}';
</script>
@php
		}
	}
}
$headerMenus = Menu::where([['menus.status','=','Active'],['menus.parent_id','=',6]])->select('slugs.slug','slugs.slug_type','menus.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'menus.id'],['slugs.slug_type', '=', DB::raw("'Menus'")]])->orderBy('menus.ordering', 'ASC')->get();

$quickLinks = Menu::where([['menus.status','=','Active'],['menus.parent_id','=',10]])->select('slugs.slug','slugs.slug_type','menus.*')->leftJoin('slugs', [['slugs.parent_id', '=', 'menus.id'],['slugs.slug_type', '=', DB::raw("'Menus'")]])->get();

$homeSliders = HomeSlider::select('home_sliders.*')->get();

$aboutUs = Page::where([['pages.id','=',3]])->select('pages.*')->first();

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
		<link rel="shortcut icon" href="{{ URL::asset('public/assets/images/icon.png') }}" />
		@endif
		<title>{{ $mainHeader ?? '' }} - {{ SiteSetting::first()->site_name }}</title>
		<link rel="shortcut icon" href="{{ URL::asset('public/assets/site/images/favicon.png') }}">
		<link href="{{ URL::asset('public/assets/site/css/bootstrap.min.css') }}" rel="stylesheet"/>
		<linK href="{{ URL::asset('public/assets/site/css/font-awesome.min.css') }}" rel="stylesheet"/>
		<linK href="{{ URL::asset('public/assets/site/css/reality-icon.css') }}" rel="stylesheet"/>
		<link href="{{ URL::asset('public/assets/site/css/bootsnav.css') }}" rel="stylesheet"/>
		<link href="{{ URL::asset('public/assets/site/css/cubeportfolio.min.css') }}" rel="stylesheet"/>
		<link href="{{ URL::asset('public/assets/site/css/jquery.fancybox.css') }}" rel="stylesheet"/>
		<link href="{{ URL::asset('public/assets/site/css/owl.carousel.css') }}" rel="stylesheet"/>
		<link href="{{ URL::asset('public/assets/site/css/owl.transitions.css') }}" rel="stylesheet"/>
		<link href="{{ URL::asset('public/assets/site/css/settings.css') }}" rel="stylesheet"/>
		<link href="{{ URL::asset('public/assets/site/css/style.css') }}" rel="stylesheet"/>
		<link href="{{ URL::asset('public/assets/site/css/range-Slider.min.css') }}" rel="stylesheet"/>
		<link href="{{ URL::asset('public/assets/site/css/search.css') }}" rel="stylesheet"/>
		<script src="{{ URL::asset('public/assets/site/js/jquery-2.1.4.js') }}"></script>	
		<script src="{{ URL::asset('public/assets/js/jquery.blockUI.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('public/assets/js/sweetalert.min.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('public/assets/js/additional-methods.min.js') }}"></script>
		<script src="{{ URL::asset('public/assets/js/jquery.validate.min.js') }}"></script>
	</head>

	<body data-offset="200" data-spy="scroll" data-target=".primary-navigation">
	<!--Loader-->
<div class="loader">
  <div class="span">
    <div class="location_indicator"></div>
  </div>
</div>
 <!--Loader--> 

<!--Header-->
<header class="white_header">
  <div class="topbar default_clr">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <p>We are Best in Town With 40 years of Experience.</p>
        </div>
        <div class="col-md-8 text-right">
          <ul class="breadcrumb_top">
            <li><a href="javascript:void(0)"><i class="icon-icons43"></i>Favorites</a></li>
            <li><a href="javascript:void(0)"><i class="icon-icons215"></i>Submit Property</a></li>
            <li><a href="javascript:void(0)"><i class="icon-icons215"></i>My Property</a></li>
            <li><a href="javascript:void(0)"><i class="icon-icons230"></i>Profile</a></li>
            <li><a href="javascript:void(0)"><i class="icon-icons179"></i>Login / Register</a></li>
          </ul>
          <ul class="social_share left15">
            <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i></a></li>
            <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i></a></li>
            <li><a href="javascript:void(0)" class="google"><i class="icon-google4"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-default navbar-sticky bootsnav">
    <div class="container">
      <div class="attr-nav">
        <div class="upper-column info-box first">
          <div class="icons"><i class="icon-icons202"></i></div>
          <ul>
            <li><strong>Phone Number</strong></li>
            <li>{{ SiteSetting::first()->contact_number }}</li>
          </ul>
        </div>
      </div>
      <!-- Start Header Navigation -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
        <i class="fa fa-bars"></i>
        </button>
        @if (isset(SiteSetting::first()->site_logo) && SiteSetting::first()->site_logo != '')
        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ URL::asset('public/uploads/site_settings/normal/').'/'.SiteSetting::first()->site_logo }}" class="logo" alt=""></a>
        @else
				  {{ SiteSetting::first()->site_name }}
			  @endif
      </div><!-- End Header Navigation -->
      <div class="collapse navbar-collapse" id="navbar-menu">
        @if ($headerMenus)
        <ul class="nav navbar-nav navbar-right" data-in="fadeIn" data-out="fadeOut">
          @php
              $i = 0;
          @endphp
          @foreach ($headerMenus as $headerMenus1)
            @php
                    $class = ($i == 0) ? "active" : "";
            @endphp
              <li class="{{ $class }}">
                <a href="{{ url('/'.$headerMenus1->slug) }}">{{ $headerMenus1->title }}</a>
              </li>
            @php
              $i++;
            @endphp
          @endforeach
          </ul>
        @endif
      </div>
    </div>
  </nav>
</header>
<!--Header Ends-->
@if ($mainHeader == 'Home')
<!--Slider-->
  @if ($homeSliders)
<div class="rev_slider_wrapper">
  <div id="rev_slider_full" class="rev_slider"  data-version="5.0">
    <ul>
    @php
        $i = 0;
    @endphp
    @foreach ($homeSliders as $homeSliders1)
      <!-- SLIDE  -->
      <li data-transition="fade">
        <!-- MAIN IMAGE -->
        @if (isset($homeSliders1->image) && $homeSliders1->image!= '')
        <img src="{{ URL::asset('public/uploads/home_sliders/normal/').'/'.$homeSliders1->image }}" alt="" data-bgposition="center center" data-bgfit="cover">
        @endif
        <!-- LAYER NR. 1 -->
        <h1 class="tp-caption tp-resizeme uppercase" 
          data-x="left" data-hoffset="15"
          data-y="275"  
          data-transform_idle="o:1;"
          data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" 
          data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" 
          data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
          data-mask_out="x:0;y:0;s:inherit;e:inherit;" 
          data-start="500" 
          data-splitin="none" 
          data-splitout="none"
          style="z-index: 6;">{{ $homeSliders1->title ?? '' }}
        </h1>
        <p class="tp-caption  tp-resizeme" 							
          data-x="left" data-hoffset="15"
          data-y="320"
          data-transform_idle="o:1;"
          data-transform_in="opacity:0;s:2000;e:Power3.easeInOut;" 
          data-transform_out="opacity:0;s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"  
          data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
          data-mask_out="x:0;y:0;s:inherit;e:inherit;" 							 
          data-start="800">@php echo strip_tags(html_entity_decode($homeSliders1->content)) ?? '' @endphp
        </p>
        <div class="tp-caption  tp-resizeme" 							
          data-x="left" data-hoffset="15"
          data-y="400"							
          data-width="full"
          data-transform_idle="o:1;"
          data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" 
          data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" 
          data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
          data-mask_out="x:0;y:0;s:inherit;e:inherit;" 							 
          data-start="800">
          <a href="javascript:void(0)" class="btn-blue border_radius uppercase active">our services</a>
          <a href="javascript:void(0)" class="btn-white border_radius uppercase">Contact Us</a>
        </div>
      </li>
    @php
        $i++;
    @endphp
    @endforeach
    </ul>
  </div>
  <!-- END REVOLUTION SLIDER -->
</div>
  @endif
@endif
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

<!--Footer-->
<footer class="padding_top footer2">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-6">
        <div class="footer_panel bottom30">
          <a href="javascript:void(0)" class="logo bottom30"><img src="{{ URL::asset('public/assets/site/images/logo-white.png') }}" alt="logo"></a>
          <p class="bottom15">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh 
            tempor cum consectetuer 
            adipiscing.
          </p>
          <p class="bottom15">If you are interested in castle do not wait and <a href="javascript:void(0)">BUY IT NOW!</a></p>
          <ul class="social_share">
            <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i></a></li>
            <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i></a></li>
            <li><a href="javascript:void(0)" class="google"><i class="icon-google4"></i></a></li>
            <li><a href="javascript:void(0)" class="linkden"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="footer_panel bottom30">
          <h4 class="bottom30">Search by Area</h4>
          <ul class="area_search">
            <li><a href="javascript:void(0)"><i class="icon-icons74"></i>Bayonne, New Jersey</a></li>
            <li class="active"><a href="javascript:void(0)"><i class="icon-icons74"></i>Greenville, New Jersey</a></li>
            <li><a href="javascript:void(0)"> <i class="icon-icons74"></i>The Heights, New Jersey</a></li>
            <li><a href="javascript:void(0)"><i class="icon-icons74"></i>West Side, New York</a></li>
            <li><a href="javascript:void(0)"><i class="icon-icons74"></i>Upper East Side, New York</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="footer_panel bottom30">
          <h4 class="bottom30">Latest News</h4>
          <div class="media">
            <a class="media-object"><img src="{{ URL::asset('public/assets/site/images/footer-news1.png') }}" alt="news"></a>
            <div class="media-body">
              <a href="javascript:void(0)">Nearest mall in high tech Goes your villa</a>
              <span><i class="icon-clock4"></i>Feb 22, 2017</span>
            </div>
          </div>
          <div class="media">
            <a class="media-object"><img src="{{ URL::asset('public/assets/site/images/footer-news1.png') }}" alt="news"></a>
            <div class="media-body">
              <a href="javascript:void(0)">Nearest mall in high tech Goes your villa</a>
              <span><i class="icon-clock4"></i>Feb 22, 2017</span>
            </div>
          </div>
          <div class="media">
            <a class="media-object"><img src="{{ URL::asset('public/assets/site/images/footer-news1.png') }}" alt="news"></a>
            <div class="media-body">
              <a href="javascript:void(0)">Nearest mall in high tech Goes your villa</a>
              <span><i class="icon-clock4"></i>Feb 22, 2017</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="footer_panel bottom30">
          <h4 class="bottom30">Get in Touch</h4>
          <ul class="getin_touch">
            <li><i class="icon-telephone114"></i>01 900 234 567 - 68</li>
            <li><a href="javascript:void(0)"><i class="icon-icons142"></i>info@brieflease.com</a></li>
            <li><a href="javascript:void(0)"><i class="icon-browser2"></i>www.brieflease.com</a></li>
            <li><i class="icon-icons74"></i>Castle Melbourne, Merrick Way,FL 12345 australia</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
<!--CopyRight-->
<div class="copyright index2">
  <div class="copyright_inner">
    <div class="container">
      <div class="row">
        <div class="col-md-7">
          <p>&copy; {{ date("Y") }} Sirchend Software Pvt. Ltd. </p>
        </div>
        <div class="col-md-5 text-right">
          <p>Designed by <a href="javascript:void(0)">Sirchend Software Pvt. Ltd.</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
	
	<!-- jQuery Include -->
	<script src="{{ URL::asset('public/assets/site/js/bootstrap.min.js') }}"></script><!-- Easing Animation Effect -->
	<script src="{{ URL::asset('public/assets/site/js/jquery.parallax-1.1.3.js') }}"></script> <!-- Core Bootstrap v3.2.0 -->
	<script src="{{ URL::asset('public/assets/site/js/jquery.appear.js') }}"></script> <!-- Modernizer -->
	<script src="{{ URL::asset('public/assets/site/js/bootsnav.js') }}"></script> <!-- It Loads jQuery when element is appears -->
	<script src="{{ URL::asset('public/assets/site/js/masonry.pkgd.min.js') }}"></script> <!-- Core Owl Carousel CSS File  *	v1.3.3 -->
	<script src="{{ URL::asset('public/assets/site/js/jquery.cubeportfolio.min.js') }}"></script> <!-- Check box -->
	<script src="{{ URL::asset('public/assets/site/js/range-Slider.min.js') }}"></script> <!-- Drag Drop file -->
	<script src="{{ URL::asset('public/assets/site/js/owl.carousel.min.js') }}"></script> <!-- Drag Drop File -->
	<script src="{{ URL::asset('public/assets/site/js/selectbox-0.2.min.js') }}"></script> <!-- Drag Drop File -->
	<script src="{{ URL::asset('public/assets/site/js/zelect.js') }}"></script> <!-- map -->
	<script src="{{ URL::asset('public/assets/site/js/jquery.fancybox.js') }}"></script> 
	<script src="{{ URL::asset('public/assets/site/js/jquery.themepunch.tools.min.js') }}"></script>
	<!-- Customized Scripts -->
	<script src="{{ URL::asset('public/assets/site/js/jquery.themepunch.revolution.min.js') }}"></script>
	<script src="{{ URL::asset('public/assets/site/js/revolution.extension.layeranimation.min.js') }}"></script>
	<script src="{{ URL::asset('public/assets/site/js/revolution.extension.navigation.min.js') }}"></script>
	<script src="{{ URL::asset('public/assets/site/js/revolution.extension.parallax.min.js') }}"></script>
	<script src="{{ URL::asset('public/assets/site/js/revolution.extension.slideanims.min.js') }}"></script>
	<script src="{{ URL::asset('public/assets/site/js/revolution.extension.video.min.js') }}"></script>
	<script src="{{ URL::asset('public/assets/site/js/custom.js') }}"></script>
	<script src="{{ URL::asset('public/assets/site/js/functions.js') }}"></script>
	</body>
</html>