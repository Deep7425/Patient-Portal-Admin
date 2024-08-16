<!DOCTYPE html>
<html lang="en"> 
<head>

<style>



.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>

<style type="text/css"> .horizontal-scroll-wrapper{transform-origin:right top;display:-webkit-box;flex-wrap:nowrap}.horizontal-scroll-wrapper>div{width:60%;height:230px;padding-right:10px;margin-top:5px}.horizontal-scroll-wrapper{width:100%;overflow-y:hidden;overflow-x:auto}.horizontal-scroll-wrapper{transform-origin:right top}.horizontal-scroll-wrapper>div{transform-origin:right top}.mobile-case-speciality::-webkit-scrollbar{width:0;background:0 0}  
body .navbar-nav li.dropdown.sub-nev-tool.paytmSet {right:10px !important;}
body .navbar-default .paytmSet ul#g-account-menu {
    position: absolute;
    width: 175px;
    height: 163px;
    top: 46px;
    background: #fff;
    padding: 0 10px!important;
    left: -126px;
    box-shadow: 0 1px 4px 0 #c1c0c0;
}
body .navbar-default ul#g-account-menu::after {
    top: -11px;
    left:161px;
    margin-left: 0;
    content: "";
    border-bottom-color: #fff!important;
    position: absolute;
    width: 0;
    height: 0;
    border-color: transparent;
    border-top-color: transparent;
    border-style: solid;
    border-width: 5px;
}
.download-app-paytmchangeDiv{
	display: none;
}
</style> 
@php
    $title = "Book FREE Doctor Consultation & Appointment | Health Gennie";
	$description = "All-in-one online health services are available on Health Gennie at the best prices. Avail now of all our services—book a Free doctor appointment.";
	$og_type = url("/");
	$og_image = url("/").'/img/imgpsh_fullsize_anim.webp';
	$canonicalUrl = URL::current();
@endphp
<title>Talk to the Doctor Online | Book Appointment & Consultation</title>
<meta name="description" content="{{$description}}"/>

<meta property="og:description" content="{{$description}}"/>
<meta property="og:title" content="{{$title}}"/>
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo url("/").$_SERVER['REQUEST_URI'];?>" />
<meta property="og:image" content="{{@$og_image}}"/>
<meta property="og:site_name" content="Health Gennie"/>
<meta name="twitter:card" content="summary">
<meta name="twitter:creator" content=“@Healthgennie1”>
<meta property="twitter:url" content="https://www.healthgennie.com/" />
<meta property="twitter:title" content="Book FREE Doctor Consultation and Appointment | Health Gennie" />
<meta property="twitter:description" content="Book free doctor consultation and appointment from the comfort of your home via phone/video call and get digital prescriptions on your phone. Also read about health issues and get solutions." />
<meta property="fb:app_id" content="2377613272544920" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="Cache-control: max-age=31536000" content="public">
<!--<meta http-equiv="Pragma" content="no-cache" />-->
<!--<meta http-equiv="Expires" content="0" />-->
<meta name="google-site-verification" content="cyIzmJahbpMDVzOW3EP7TROPGr8-7nkOCKUdygkEDpk" />
<meta name="robots" content="index, follow" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="canonical" href="<?php echo $canonicalUrl;?>"/>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="preload" as="style" href="css/assets/bootstrap/css/bootstrap.min.css" media="all" type="text/css" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/assets/bootstrap/css/bootstrap.min.css"></noscript>
<link rel="preload" as="style" href="css/homestyle.css" type="text/css" media="all" onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/homestyle.css"></noscript>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WCSD8NM');</script>
<!-- End Google Tag Manager -->
<link rel="preload" as="style" href="css/common.css?v=12" type="text/css" media="all"  onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/common.css?v=12"></noscript>
<link rel="preload" as="style" href="css/fonts/font-awesome.min.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/fonts/font-awesome.min.css"></noscript>
<link rel="preload" as="style" href="css/fonts/font_google.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/fonts/font_google.css"></noscript>
<!--
<link href="https://fonts.googleapis.com/css2?family=Yantramanav:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="preload" as="style" href="css/fonts/font_raleway.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/fonts/font_raleway.css"></noscript>
<link rel="preload" as="style" href="css/fonts/font_kerala.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/fonts/font_kerala.css"></noscript>
-->
<link rel="preload" as="style" href="css/fonts/font_family.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/fonts/font_family.css"></noscript>
<script src="css/assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript" rel="preload"></script>
<script src="js/bootstrap.min.js" type="text/javascript" async ></script>
<script src="js/jquery.validate.js" type="text/javascript" ></script>
<script src="js/cookieMin.js" type="text/javascript" ></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="home" onLoad="initialize();">
<div id="mySidenav" class="sidenavHome">
    <ul>
<!--<li><a href="{{route('hgOffers')}}"> Health Gennie Offer<blink class="blink_me"><img width="20" height="20" alt="Health Gennie Offer" src="img/SpecialOffer.png" /></blink></a></li>-->
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <li><a href="{{route('aboutUs')}}">About Us</a></li>
        <li><a href="{{route('driveDashboard')}}">Health Care Plans</a></li>
        <li><a href="{{route('corporate',['home'])}}">For Doctors</a></li>
        <li><a href="{{route('corporate',['home'])}}">Corporate</a></li>
        <li><a href="{{route('termsConditions')}}">Terms & Conditions</a></li>
        <li><a href="{{route('privacyPolicy')}}">Privacy Policy</a></li>
        <li><a href="{{route('blogList')}}">Blogs</a></li>
        <li><a href="{{route('contactUs')}}">Contact Us</a></li>
    </ul>
</div>

<!-- Header -->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WCSD8NM"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<header class="top-navbaar float-panel">
<input id="session_lat" type="hidden" value='{{@Session::get("session_lat")}}'/>
<input id="session_lng" type="hidden" value='{{@Session::get("session_lng")}}'/>
<input id="search_data_by_search_id" type="hidden" value="{{ Session::get('search_from_search_bar') }}"/>
<input id="profileStatusSess" type="hidden" @if(Auth::user() != null && Request::path() != "user-profile") value="{{ Session::get('profile_status') }}" @else value="" @endif/>

<input id="userLoginStatus" type="hidden" @if(Auth::user() != null) value="1" @else value="" @endif />

<style>
	.btn1InstallApp{ margin-top:30px;}
</style>
<div class="download-app-paytmchangeDiv">
<?php $wltSts = Session::get('wltSts'); ?>
<div class="download-app download-app-paytm">
@if(empty($wltSts))
	<div class="download-app-inner">
	<p>Download The App</p>
	<a href="https://www.healthgennie.com/download">
		<img width="115" height="36" src="img/download-app.png" alt="health-gennie-app" />
	</a>
	</div>
@endif	
</div>
<div class="call_btn_div remove_btn download-app-paytm">
<p><a href='tel:{{getSetting("helpline_number")[0]}}'><img width="100" height="82" src="img/call-btn.webp" alt="call-icon" /></a></p>
</div>

<nav class="navbar navbar-default">
	<div class="wrapper-header">
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
	  <a class="navbar-brand" href="{{route('index')}}"><img width="144" height="60" src="img/logo.webp" alt="short-logo" /></a>
	  <!--<a class="navbar-brand mobile-vaccination" href="{{route('vaccinationDrive')}}"><div class="icon-top" style=" width:28px;"><img src="{{ URL::asset('img/vaccinationDriveIcon.webp') }}" alt="vaccine-drive" width="46" height="44" /></div><div class="nav-section"><h3>Vaccination Drive</h3></div></a>-->
      
	</div>
    <div class="cart-header" style="float:right;">
        <div class="top-bar">
	<ul class="top-order-list">
		<li class="login covid-info"><a class="login-btn-top" href="{{route('covidGuide')}}"><button type="button" class="btn btn-default"><i class="" aria-hidden="true"><img width="22" height="19" src="{{ URL::asset('img/covid-icon.webp') }}" alt="covid-icon" /></i>Covid Guide</button></a></li>
		@if(Auth::user())
			<?php $user = Auth::user(); ?>
			<?php
			if(!empty($user->image)) {
				$image_url = getPath("public/patients_pics/".$user->image);
			}
			else{
				$image_url = null;
			} ?>
		<li class="dropdown sub-nev-tool">
		  <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="javascript:void(0);"><img  class="top-user-img" @if($image_url != null) src="{{$image_url}}" @else src="img/avatar_2x.png" @endif/> <span class="user-nametop">@if(!empty($user->first_name)) {{@$user->first_name}} {{@$user->last_name}} @else {{@$user->mobile_no}} @endif</span><span class="caret"></span>
		  </a>
		  <ul id="g-account-menu" class="dropdown-menu" role="menu">
		  @if(Auth::id() != null && checkUserSubcriptionStatus(Auth::id()))
			<div class="elite-member">
				<div class="bg">&nbsp;</div>
				<div class="text">Elite</div>
			</div>
			@endif
			<li><a href="{{ route('drive') }}">
				My Profile
			</a></li>
			<li><a href="{{ route('drive') }}">
		<img width="50" height="50"/>
		<div class="nav-section">Wallet:@if(@$user->userDetails->wallet_amount) {{@$user->userDetails->wallet_amount}} @else 0.00 @endif </div>
		</a></li>
			<!--<li><a href="{{route('changePassword',['id'=>base64_encode(Auth::id())])}}"><i class="fa fa-lock"></i>Change Password</a></li>-->
			<li class="hideforPaytm"><a href="javascript:void(0);" class="logoutUser" ><i class="fa fa-sign-out"></i>Logout</a></li>
		  </ul>
		</li>
		@else
			<li class="login paytmDivforreplace"><a class="login-btn-top" href="{{ route('login') }}"><button type="button" class="btn btn-default"><i class="" aria-hidden="true"><img width="15" height="19" src="img/login.png" /></i> Login</button></a></li> 
		@endif
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
			<li class="doctor hideforPaytm"><a target="_blank" href='https://doc.healthgennie.com'><button type="button" class="btn btn-warning doctor_btn_Hg"><i class="" aria-hidden="true"><img width="15" height="17" src="img/doctor.webp" /></i>For Doctors</button></a></li>
            </ul>
</div>
        <ul class="cart-top">
        	<li class="medicine main-nav-desktop cart-wrapper hideforPaytmCart"  data-toggle="tooltip" title="@if(!empty($LabCart)) Cart @else Cart is Empty! @endif">
				<a href="{{ route('LabCart') }}"><img src="img/cart-new.png"  alt="cart-icon" /><div class="nav-section"><p> <span class="cartTotal" id="cartTotal">@if(!empty($LabCart)) {{count($LabCart)}} @else 0 @endif</span> </p></div></a>
				<ul class="cart-dd" id="miniCart"
				style='display:@if(empty($LabCart) || $LabCart == null || Request::route()->getName() == "LabCart") none @endif;'>
					<li>
						<div class="dd-title">
							<h4>Order Summary</h4>
						</div>
						<div id="miniCartList">
							@if(!empty($LabCart))
								@foreach($LabCart as $package)
								@if(isset($package['DefaultLabs']))
									<?php $type = "TEST"; if($package['lab_cart_type'] == 'package'){ $type = "PACKAGE"; } ?>
									<div class="list" title="{{$package['DefaultLabs']['title']}}" data-name="{{$package['DefaultLabs']['title']}}"><img width="15" height="15" src="{{asset('img/OurStore-icon.png')}}" alt="store-icon" /><h5> <a href="{{route('LabDetails', ['id'=> base64_encode($package['DefaultLabs']['title']), 'type' => base64_encode($type)])}}">{{$package['DefaultLabs']['title']}}</a></h5> <span><strong>1 x ₹ @if(isset($package['offer_rate'])) {{@$package['offer_rate']}} @else {{@$package['cost']}} @endif</strong></span>
									<a class="close deleteFromMiniCart" href="javascript:void(0);"  Pcode="{{$package['id']}}" Pname="{{$package['DefaultLabs']['title']}}"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
									</div>
								@else
									<div class="list" title="{{$package['name']}}" data-name="{{$package['name']}}"><img width="15" height="15" src="{{asset('img/OurStore-icon.png')}}" alt="store-icon" /><h5> <a href="{{route('LabDetails', ['id'=> base64_encode($package['name']), 'type' => base64_encode($package['type'])])}}">{{$package['name']}}</a></h5> <span><strong>1 x ₹ @if($package['rate']['offerRate'] == "null") {{$package['rate']['b2C']}} @else {{$package['rate']['offerRate']}} @endif </strong></span>
									<a class="close deleteFromMiniCart" href="javascript:void(0);"  Pcode="{{$package['code']}}" Pname="{{$package['name']}}"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
									</div>
								@endif	
								@endforeach
							@endif
						</div>
						<div class="cartButtons">
							<a  href="{{ route('LabCart') }}" class="cart">View Cart</a>
						</div>
					</li>
				</ul>
			</li>
        </ul>
        </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	  
      
	    <ul class="nav navbar-nav navbar-right">
	  <!--<li class="active apoointment main-nav-desktop">
        <a  class="dd" href="{{route('vaccinationDrive')}}"><span class="text" style="display:none;">Vaccination Drive</span><div class="icon-top" style=" width:46px;"><img src="{{ URL::asset('img/vaccinationDriveIcon.webp') }}" alt="vaccine-drive" width="46" height="44" /></div><div class="nav-section"><h3>Vaccination Drive</h3><p>Information Center</p></div></a>
   </li>-->
   <li class="lab-test main-nav-desktop"><a href="{{route('LabDashboard')}}" ><div class="icon-top"><img width="35" height="35" src="img/lab-icon-top.webp" alt="lab-icon" /></div><div class="nav-section"><h3>Lab Test</h3><p>Book Health Packages</p></div></a>
		</li>
	  	<li class="active apoointment main-nav-desktop" style=" width: 190px;">
		<a  class="dd" href="{{route('covidGuide')}}"><span class="text" style="display:none;">COVID</span><div class="icon-top"><img src="{{ URL::asset('img/covid-icon.webp') }}" width="46" height="43" alt="covid-icon" /></div><div class="nav-section"><h3>Covid Guide</h3><p>Information Center</p></div></a>
		</li>
		<li class="active apoointment main-nav-desktop lab-test">
			<a search_type="1" data_id="0" info_type="doctor_all" class="dd searchDoctorModalDoctor" @if($controller == "LabController") href="{{route('index')}}" @else href="javascript:void(0);" @endif ><span class="text" style="display:none;">Doctor</span><div class="icon-top"><img width="35" height="35" src="img/appointment-ico-top.webp" alt="appointment-icon" /></div><div class="nav-section"><h3>Find Doctors</h3><p>Book Appointment</p></div></a>
		</li>

	

		<!--<li class="active apoointment main-nav-desktop lab-test">
			<a search_type="1" data_id="0" info_type="doctor_all" class="dd refRralcode" @if($controller == "LabController") href="{{route('index')}}" @else href="javascript:void(0);" @endif ><span class="text" style="display:none;">Doctor</span><div class="icon-top"><img width="35" height="35" src="img/appointment-ico-top.webp" alt="appointment-icon" /></div></a>
		</li>-->
		


		<li class="NewRightSideMenudesk"><span style="font-size:30px;cursor:pointer" onclick="openNav()"><i class="fa fa-bars" aria-hidden="true"></i></span></li>
		
			<?php
			if(Auth::user() != null){
			  $LabCart = getLabCart();
			}
			else{
			  $LabCart = Session::get("CartPackages");
			}
			?>
			
		</ul>
        
	</div>
    
	
	<!-- Collect the nav links, forms, and other content for toggling -->
	
    <div class="navbaar-bottom  mobile-search">
		<button type="button" class="btn btn-default searchDoctorModalArea" data-toggle="modal" ><i class="fa fa-map-marker" aria-hidden="true"></i><span class="area_name">@if(!empty(Session::get("search_from_locality_name"))) {{ Session::get("search_from_locality_name") }} @else Location @endif</span></button>
		
        <button type="button" class="btn btn-default searchDoctorModalDoctor" data-toggle="modal" ><i class="fa fa-user" aria-hidden="true"></i>
<span>Search Doctors/Specialties</span></button>
	</div>
    
    <!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
<?php $latestApptFeedback = latestAppointmentFeedback();?>
<input name="latestApptFeedback" type="hidden" class="latestApptFeedback" value='@if(!empty($latestApptFeedback)) {{ json_encode($latestApptFeedback) }} @endif'/>
{!! Form::open(array('route' => 'doctorInfo', 'id' => 'searchDocInfo', 'method' => 'POST')) !!}
<div class="navbaar-bottom desktop-search">
	<input name="info_type" type="hidden" value="@if(isset($_GET['info_type'])){{base64_decode($_GET['info_type'])}}@else{{@Session::get('info_type')}}@endif"/>
	<input name="id" type="hidden" value="@if(isset($_GET['id'])){{base64_decode($_GET['id'])}}@else{{@Session::get('search_id')}}@endif"/>
	<input name="grp_id" type="hidden" value="@if(isset($_GET['grp_id'])){{base64_decode($_GET['grp_id'])}}@else{{@Session::get('grp_id')}}@endif" />
	<input name="lat" type="hidden" value='{{@Session::get("session_lat")}}'/>
	<input name="lng" type="hidden" value='{{@Session::get("session_lng")}}'/>
	<input name="state_id" type="hidden" value='{{ Session::get("state_id") }}'/>
	<input name="city_id" type="hidden" value='{{ Session::get("city_id") }}'/>
	<input name="locality_id" type="hidden" value='{{ Session::get("locality_id") }}'/>
	<input name="state_name" type="hidden" class="locality_state_area" value='{{ Session::get("search_from_state_name") }}'/>
	<input name="city_name" type="hidden" class="locality_city_area" value='{{ Session::get("search_from_city_name") }}'/>
	<input name="city_slug" type="hidden" class="locality_city_slug" value='{{ Session::get("search_from_city_slug") }}'/>
	<input name="locality_slug" type="hidden" class="locality_slug" value='{{ Session::get("locality_slug") }}'/>
	<div class="container">
    	<div class="main-menu">
        	<ul>
<li><a href="{{route('aboutUs')}}">About Us</a></li>
				<li><a href="{{route('driveDashboard')}}">Health Care Plans</a></li>
                <li><a href="{{route('corporate',['home'])}}">Corporate</a></li>
				<li><a href="{{route('blogList')}}">Blogs</a></li>
				<li><a href="{{route('contactUs')}}">Contact Us</a></li>
            </ul>    
        </div>
    
		<div class="navbaar-bottom-section is_website" @if(isset($_COOKIE['in_mobile']) && $_COOKIE['in_mobile'] == '0') style="display: block;" @else style="display: none;" @endif>
		<div class="navbaar-bottom-block local-area-search ">
			<i class="fa fa-map-marker" aria-hidden="true"></i>
			<input id="pac-input" class="pac-input" autocomplete="off" type="text" placeholder="city" name="locality" value='{{ Session::get("search_from_locality_name") }}'/>
			<div class="ldd-btn"><button type="button" class="btn btn-default search_close_locality" style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></button></div>
			<!--<div class="location-div-detect">
			<button type="button" class="btn btn-default search_close_locality" style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></button>
			<span class="location-div"><span data-qa-id="current_location" class="btn-detect detect_location"><img width="15" height="13" src="img/loc-detect.png" alt="location-detect-icon" /><i class="icon-ic_gps_system"></i><span>Detect</span></span></span></div>-->
			<div class="dd-wrapper localAreaSearchList" style="display:none;"></div>
		</div>
		<div class="navbaar-bottom-box2">
			<div class="navbaar-bottom-box">
				<input type="search" class="docSearching" placeholder="Search by Name and Specialities" value="{{ Session::get('search_from_search_bar') }}" name="data_search" autocomplete="off" />
				<button type="button" class="btn btn-default search_close" style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></button>
				<div class="dd-wrapper doctorSearchByInput" style="display:none;"></div>
			</div>
		</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
</header>
<!-- header -->
<div class="is_mobile">
<div class="modal fade" id="searchDoctorModalDoctor" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="container">
		<div class="location-top">
			<div class="location-top1">
			<h2>Search Doctors</h2>
			<button data-dismiss="modal" type="button" class="btn btn-primary"><i class="fa fa-times" aria-hidden="true"></i></button>
		</div>
		</div>
		<div class="navbaar-bottom-section">
		<div class="navbaar-bottom-box2">
			<div class="navbaar-bottom-box"> 
				<input type="search" class="docSearching" placeholder="Search by Name and Specialities" value="{{ Session::get('search_from_search_bar') }}" name="data_search" autocomplete="off" />
				<button type="button" class="btn btn-default search_close" style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></button>
				<div class="dd-wrapper doctorSearchByInput" style="display:none;"></div>
			</div>
		</div>
		</div>
	</div>
</div>
<div class="modal fade" id="searchDoctorModalArea" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="container">
		<div class="location-top">
			<div class="location-top1">
			<h2>Search Location</h2>
			<button data-dismiss="modal" type="button" class="btn btn-primary"><i class="fa fa-times" aria-hidden="true"></i></button>
			</div>
		</div>
		<div class="navbaar-bottom-section">
			<div class="navbaar-bottom-block local-area-search">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
				<input class="form-control pac-input" id="pac-input" autocomplete="off" type="text" placeholder="city" name="locality" value='{{ Session::get("search_from_locality_name") }}'/>
				<div class="location-div-detect">
				<button type="button" class="btn btn-default search_close_locality" style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></button>
				<span class="location-div"><span data-qa-id="current_location" class="btn-detect detect_location"><img width="15" height="13"  src="img/loc-detect.png" alt="location-detect-icon" /><i class="icon-ic_gps_system"></i></span></span></div>
				<div class="dd-wrapper localAreaSearchList" style="display:none;"></div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="banner-mob is_mobile" @if(isset($_COOKIE['in_mobile']) && $_COOKIE['in_mobile'] == '1') style="display: block;" @else style="display: none;" @endif>
@if(empty($wltSts))
<div class="slider home-slider-ss">	
<a href="javascript:void();" apptDate="{{base64_encode(date('d-m-Y'))}}" apptTime="{{base64_encode(strtotime(date('h:i A')))}}" doc_id='{{base64_encode(getSetting("direct_appt_doc_id")[0])}}' class="slide homePageDoctors hideforPaytm bookFreeAppt"><img loading="lazy" width="362" height="160" src="img/mobile-new1.png" alt="health-gennie-banner"/></a>
<!--<a @if(Auth::user()) href="{{route('drive')}}" @else href="{{route('driveDashboard')}}" @endif class="slide homePageDoctors hideforPaytm"><img loading="lazy" width="362" height="160" src="img/mobile-new2.png" alt="health-gennie-banner"/></a>-->
<a href="{{route('LabDashboard')}}" class="slide homePageDoctors"><img loading="lazy" width="362" height="160" src="img/mobile-new3.png" alt="health-gennie-banner"/></a>
</div>
@else
<a @if(Auth::user()) href="{{route('drive')}}" @else href="{{route('driveDashboard')}}" @endif class="homePageDoctors hideforPaytm"><img loading="lazy" width="362" height="160" src="img/mob-banner0.webp" alt="health-gennie-banner"/></a>
@endif

<a @if(Auth::user()) href="{{route('drive')}}" @else href="{{route('driveDashboard')}}" @endif class="homePageDoctorsforPaytm" style="display: none;"><img loading="lazy"  width="362" height="160" src="img/main-banner-mobile.webp" alt="health-gennie-banner1"/></a>
</div>

<div class="banner-section is_website" @if(isset($_COOKIE['in_mobile']) && $_COOKIE['in_mobile'] == '0') style="display: block;" @else style="display: none;" @endif ><div class="banner-content"><div class="slider home-slider-ss">
<a href="javascript:void();" apptDate="{{base64_encode(date('d-m-Y'))}}" apptTime="{{base64_encode(strtotime(date('h:i A')))}}" doc_id='{{base64_encode(getSetting("direct_appt_doc_id")[0])}}' class="slide homePageDoctors bookFreeAppt"><img loading="lazy" width="1349" height="473" src="img/slide-1.jpg" alt="health-gennie-banner2"/></a>

<a href="javascript:void();" apptDate="{{base64_encode(date('d-m-Y'))}}" apptTime="{{base64_encode(strtotime(date('h:i A')))}}" doc_id='{{base64_encode(getSetting("direct_appt_doc_id")[0])}}' class="slide homePageDoctors bookFreeAppt"><img loading="lazy" width="1349" height="473" src="img/slide-2.jpg" alt="health-gennie-banner2"/></a>
<a href="{{route('LabDashboard')}}" class="slide homePageDoctors"><img loading="lazy" width="1349" height="473" src="img/slide-3.jpg" alt="health-gennie-banner2"/></a>
</div></div>
</div>

<div class="container-fluid most-visited-profile">
<div class="tcb-product-slider Top-Specialities123 mobile-case-speciality is_mobile" @if(isset($_COOKIE['in_mobile']) && $_COOKIE['in_mobile'] == '1') style="display: block;" @else style="display: none;" @endif> 
	<div class="container"> 
		<div class="covidHelp corona-banner">
    	<!--<a href="#"><img width="300" height="100%" src="img/covid-banner.webp"></a>-->
    </div> 
	  @if(empty($wltSts))
      <div class="freeconsult-mobbanner"><a href="javascript:void();" class="bookFreeAppt" apptDate="{{base64_encode(date('d-m-Y'))}}" apptTime="{{base64_encode(strtotime(date('h:i A')))}}" doc_id='{{base64_encode(getSetting("direct_appt_doc_id")[0])}}' style="margin-bottom: 10px;"><img width="300" height="100%" src="img/BannerImage.webp" alt="health-gennie-banner3"></a></div>
	  @else
	  <div class="freeconsult-mobbanner"><a href="javascript:void();" class="bookFreeAppt" apptDate="{{base64_encode(date('d-m-Y'))}}" apptTime="{{base64_encode(strtotime(date('h:i A')))}}" doc_id='{{base64_encode(getSetting("direct_appt_doc_id")[0])}}' style="margin-bottom: 10px;"><img width="300" height="100%" src="img/BannerImage.png" alt="health-gennie-banner3"></a></div>
	  @endif
      
      <h2>Services We Offer</h2>
      <div class="slider service-banner home-slider-ss-2">
      	<div class="row">
        	<div class="col-xs-3 col-sm-3 col-md-3">
            	<div class="service-block">
                	<div class="service-photo">
                    	<img width="55" height="55" src="img/video-consltation.jpg"  class="img-responsive" />
                    </div>
                    <div class="service-info">
                    	<div class="service-title">24x7 Doctor Available</div>
                        <div class="service-hline">Book Consultation Now</div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
            	<div class="service-block">
                	<div class="service-photo">
                    	<img width="55" height="55" src="img/doctor-img.jpg"  class="img-responsive" />
                    </div>
                    <div class="service-info">
                    	<div class="service-title">Surgeries</div>
                        <div class="service-hline">Large Hospitals Network</div>
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
        	<div class="col-xs-3 col-sm-3 col-md-3">
            	<div class="service-block">
                	<div class="service-photo">
                    	<img width="55" height="55" src="img/covid-help.jpg"  class="img-responsive" />
                    </div>
                    <div class="service-info">
                    	<div class="service-title">Full Body Checkup</div>
                        <div class="service-hline">Free Home Sample Collection</div>
                    </div> 
                </div>
            </div>
            
        </div>
      </div>
      
      <div class="lab-statics">
      	<img src="img/lab-statics.png" alt="health-gennie-banner3">
      </div>
      
      
	<!--<div class="covidHelp">
    <div class="covidHelpSection">
    <div class="covidHelpBlock">
    <h6>EACH ONE <span>HELP ONE</span></h6>
    <p>Give one family the healthcare they deserve</p>
    </div>
    <div class="covidHelpBox">
    	<div class="covidHelpText">
    	<div class="covidHelpText1"><label>Target</label></div><div class="covidHelpText1"> <div class="Families">10000</div><span>Families</span></div>
    	</div>
    	<div class="covidHelpText">
    	<div class="covidHelpText1"><label>Helped so far </label></div><div class="covidHelpText1"> <div class="Families">{{covidhelpersCount()+3996}}</div><span></span></div>
    	</div>
    	<div class="covidHelpText"> 
    	<div class="covidHelpText1"><label>Countdown </label></div><div class="covidHelpText1"> <div class="Families" id="co-help-mob"> </div><span>Left</span></div>
    	</div>
    </div>
    </div>
    <div class="CovidHelpBtn"><span>Want to Help? </span><a class="btn " href="{{route('covidHelp')}}">Click here</a></div> 
    </div>-->
  
	<div class="wrapper-specilist"><h2><span class="subtitle">HEALTH GENNIE</span>Top Specialities</h2> <div class="mobile-speciality-Block"> @if(count(getDocSpecialityMobile())>0)@foreach(getDocSpecialityMobile() as $val)<div class="view_information" slug="{{$val->slug}}" info_type="Speciality"><div class="tcb-product-item"><div class="tcb-product-photo"><img width="55" height="55" src="{{$val->speciality_icon}}" alt="{{$val->alt_tag}}" class="img-responsive" /></div><div class="tcb-product-info"><div class="tcb-product-title"><h4>{{$val->spaciality}}</h4></div><div class="tcb-hline"></div><div class="tcb-product-price">{{$val->spec_desc}}</div></div></div></div>@endforeach @endif </div></div>
    
    </div><div class="mobile-speciality-box"> <div class="container"> <h2>Top Specialities</h2><div class="horizontal-scroll-wrapper"> @if(count(getAllDocSpecialityMobile())>0)@foreach(getAllDocSpecialityMobile() as $val)<div class="view_information" slug="{{$val->slug}}" info_type="Speciality"><div class="tcb-product-item"><div class="tcb-product-photo"><img width="55" height="55" src="{{$val->speciality_image}}" class="img-responsive" alt="{{$val->alt_tag}}"/></div><div class="tcb-product-info"><div class="tcb-product-title"><h4>{{$val->spaciality}}</h4></div><div class="tcb-hline"></div><div class="tcb-product-price">{{$val->spec_desc}}</div></div></div></div>@endforeach @endif </div></div></div></div> <div class="tcb-product-slider Top-Specialities123 desktop_topSpeciality is_website" @if(isset($_COOKIE['in_mobile']) && $_COOKIE['in_mobile'] == '0') style="display: block;" @else style="display: none;" @endif > 
		<div class="container"> 
		<!--<div class="covidHelp">
    <div class="covidHelpSection">
    <div class="covidHelpBlock">
    <h6>EACH ONE <span>HELP ONE</span></h6>
    <p>Give one family the healthcare they deserve</p>
    </div>
    <div class="covidHelpBox">
    	<div class="covidHelpText">
    	<div class="covidHelpText1"><label>Target</label></div><div class="covidHelpText1"> <div class="Families">10000</div><span>Families</span></div>
    	</div>
    	<div class="covidHelpText">
    	<div class="covidHelpText1"><label> Helped so far </label></div><div class="covidHelpText1"> <div class="Families">{{covidhelpersCount()+3996}}</div><span></span></div>
    	</div>
    	<div class="covidHelpText">
    	<div class="covidHelpText1"><label>Countdown </label></div><div class="covidHelpText1"> <div class="Families" id="co-help-desk"> </div><span>Left</span></div>
    	</div>
    </div>
    </div>
    <div class="CovidHelpBtn"><span>Want to Help? </span><a class="btn " href="{{route('covidHelp')}}">Click here</a></div>
     
    </div>-->
	  
		<h1 style="display:none;">free doctor appointment and consultation</h1> <h2>Top specialists to treat your health problems<span class="subtitle">Schedule Doctor Appointment to solve your problem</span></h2>
        
         <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> <div class="carousel-inner" role="listbox">@if(count(getDocSpeciality())>0)@foreach(getDocSpeciality() as $values)<div class="item @if(getDocSpeciality()[0]==$values) active @endif"><div class="row">@if(count($values)>0)@foreach($values as $val)<div class="col-xs-3 col-sm-3 col-md-3 view_information" slug="{{$val->slug}}" info_type="Speciality"><div class="tcb-product-item"><div class="tcb-product-photo"><img src="{{$val->speciality_image}}" class="img-responsive" alt="{{$val->alt_tag}}"/></div><div class="tcb-product-info"><div class="tcb-product-title"><h4>{{$val->spaciality}}</h4></div><div class="tcb-hline"></div><div class="tcb-product-price">{{$val->spec_desc}}</div></div></div></div>@endforeach @endif</div></div>@endforeach @endif </div><a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="fa fa-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> <span class="fa fa-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div></div></div>
</div>
<!--<div class="container bmi-wrapper"><div class="row"><div class="container"><div class="row"><div class="col-md-12"><h2 class="jumbotron text-center"><span class="subtitle">HEALTH GENNIE</span>BMI Calculator</h2><div class="BMICalculatorSection">
<div id="metric"><div class="form-field-bmi">
<div class="bmi-field">
<p>Height (in Cm.)</p><input class="form-control NumericFeild" type="text" id="height"/></div>
<div class="bmi-field">
<p>Weight (in Kg.)</p><input class="form-control NumericFeild" type="text" id="weight"/></div><div class="well text-center calculate_bmi_report_data"><div class="well text-center"> <h4 class="cat_class_change"><span class="cal_bmi label" id="result"></span></h4> <h4 class="text-muted text-muted-change" style="display:none;"></h4></div></div>
<button id="bmiBtn">Calculate</button></div></div>

</div></div></div></div></div></div>-->
<section class="cta-section ">
	<h2 class="jumbotron text-center JumbotronTextCenter">
Our Customer Profile</h2>
<div class="cta position-relative">
	<div class="container">
		
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4">
					<div class="counter-stat">
						<i class="fa fa-smile-o" aria-hidden="true"></i>
						<span class="h3 counter" data-count="200000">515525 </span><strong> +</strong>
						<p>Happy Customers</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4">
					<div class="counter-stat">
						<i class="fa fa-user-md" aria-hidden="true"></i>
						<span class="h3 counter" data-count="30000">30000 </span><strong>+</strong> 
						<p>Doctors</p>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-4 col-sm-4">
					<div class="counter-stat">
						<i class="fa fa-download" aria-hidden="true"></i>
						<span class="h3 counter" data-count="400000">180236 </span><strong> +</strong> 
						<p>App Downloads</p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</section>
<div class="container-fluid blog-wrapper"> <div class="container blog-wrapper-section"> <div class="blog-content"> <h3>Read and explore more about Health</h3>
 
 <p>Keep yourself updated with all the health information through Health Blogs.</p><a href="{{route('blogList')}}" ><button type="button" class="btn btn-default">See All Blogs</button></a> </div><div class="blog-crasuseal">@if(count(getBolgLastUpdated())>0)@foreach(getBolgLastUpdated() as $blog) <div class="blog-list"> <a href="{{route('blogInfo',['slug'=>$blog->slug])}}"> <img width="365" height="190" loading="lazy" alt="{{@$blog->keyword}}" src="@if(!empty($blog->image))<?php echo url("/")."/public/newsFeedFiles/".$blog->image;?> @else @endif"/> <h6>{{@$blog->keyword}}</h6> <div class="date-post">@if(!empty($blog->publish_date)){{date('F j , Y',strtotime($blog->publish_date))}}@endif</div><h4>{{@$blog->title}}</h4> </a></div>@endforeach @endif</div></div></div>
<section class="cta-section no-bg">
<div class="blog-content"><h3>Serving Healthy Smiles</h3> <p>Bringing together our clients to turn into a healthy family. We cherish and take care of your health.</p><a href="{{route('partners')}}"><button type="button" class="btn btn-default SeeAllClients">See All Clients</button></a></div>
<div class="container">
   <div class="customer-logos slider">
      <div class="slide"><img src="img/clogo-1.png"></div>
      <div class="slide"><img src="img/clogo-2.png"></div>
      <div class="slide"><img src="img/clogo-3.png"></div>
      <div class="slide"><img src="img/clogo-4.png"></div>
      <div class="slide"><img src="img/clogo-5.png"></div>
      <div class="slide"><img src="img/clogo-6.png"></div>
      <div class="slide"><img src="img/clogo-7.png"></div>
      <div class="slide"><img src="img/clogo-8.png"></div>
      <div class="slide"><img src="img/clogo-9.png"></div>
   </div>
</div>


</section>
    <div class="container-fluid download-app-wrapper">
        <div class="container download-app-sec">
        <div class="col-md-12">
            <div class="col-md-6 col-sm-6 mobile-img"><img style=" margin-top:20px;" src="img/dx.png" alt="doctor"/>
            
            
            
            </div>
            <div class="col-md-6 col-sm-6">
                <h2>Download The<br>Health Gennie App</h2>
                <p>Discuss your health concerns through video consultation with Top Specialists in India on the Health Gennie app. Book Appointment With Doctor anywhere, anytime from the comfort of your home.</p>
                <div class="send-sms Sendapp_Link">
                    <label>Get the link to download app</label>
                    <input type="text" class="LinkSendMobileNo NumericFeild" name="phone number" value="" placeholder="Enter Phone Number" />
					 <span class="appLinkSendSuccess" style="display:none;"></span>
                    <button type="button" class="SendLink">Send Link</button>
                </div> 
                
                <div class="store-btns">
                    <a href="https://play.google.com/store/apps/details?id=io.Hgpp.app" target="_blank"><img width="125" src="img/play-store-home.png" alt="play store"/></a>
                    <a href="https://apps.apple.com/in/app/health-gennie-care-at-home/id1492557472" target="_blank"><img width="125" src="img/app-store-home.png" alt="app store"/></a>
                </div>
                <div class="download-wrap">
                <h3><a href="javascript:void();" class="bookFreeAppt" apptDate="{{base64_encode(date('d-m-Y'))}}" apptTime="{{base64_encode(strtotime(date('h:i A')))}}" doc_id='{{base64_encode(getSetting("direct_appt_doc_id")[0])}}' style="margin-bottom: 10px;">Click to book free doctor consultations</a></h3>
                <img src="images/hand.png" alt="hand icon"/>
                <p>Only For New Users</p>
            </div>
                
            
            </div>
        </div>
        
    </div>
    </div>


<div class="modal fade" id="enquiryModal" role="dialog" data-backdrop="static" data-keyboard="false">
  {!! Form::open(array('route' => 'enquiryFromSubmit', 'id' => 'enquiryFromSubmit')) !!}
  {{ csrf_field() }}
	<?php
		$parts = @parse_url(basename($_SERVER['REQUEST_URI']));
		@parse_str($parts['query'], $query);
		$query_from =  isset($query['from'])?base64_decode($query['from']):0;
	?>
   <input type="hidden" class="form-control" value="{{$query_from}}" name="req_from"/>
  <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <div id="success-alert" style="display:none;"><p class="alert alert-success">Thanks for your interest we will contact soon..</p></div>
      
      <h2>Get Your First Instant Consultation</h2>
      <h3>Free</h3>
      <span>24*7 Available</span>
    </div>
    <div class="modal-body">
    	<div class="items-section12">
      <div class="items-section" id="name">
        <label>Name:<i class="required_star">*</i></label>
        <input type="text" class="form-control"  name="name"/>
        <span class="help-block"></span>
      </div>
	  <div class="items-section" id="mobile">
        <label>Mobile No.:<i class="required_star">*</i></label>
        <input type="text" class="form-control" name="mobile"/>
        <span class="help-block error"></span>
      </div>
    </div>
     <div class="items" id="email">
        <label>Email Id:</label>
        <input type="text" class="form-control"  name="email"/>
        <span class="help-block"></span>
      </div>
      
  </div>
  <div class="modal-footer">
    <button name ="submit" type="submit"  class="btn btn-default submitBtn">Submit</button>
    <button name ="clear" type="button" class="btn btn-default closePopup" data-dismiss="modal">No Thanks</button>
  </div>
</div>


<!-- <div class="modal fade" id="id-findModal" role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Health Gennie Cash</h5>
		<div style="text-align:center;"><p>Total 1000.00</p>
	  <p><a href=""> Refer Your Friend </a></p>
		</div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
	  <table class="table">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>200</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>100</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>400</td>
      </tr>
    </tbody>
  </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->

</div>
  {!! Form::close() !!}
</div>
<div class="modal fade AddEnquiry" id="AddEnquryModel" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" id="closeEnquiryModel" data-dismiss="modal">×</button>
				<h4 class="modal-title">Service Issue</h4>
			</div>
			<div class="modal-body">
				<div class="panel panel-bd lobidrag">
					<div class="panel-heading">
					</div>
					<div class="panel-body">
						<form   id="addEnquiryData"   name="addEnquiryData" enctype="multipart/form-data">
						@csrf
							<div class="form-group col-sm-6">

								<label for="name">Name<i class="required_star">*</i></label>
								<input id="name" type="text" title="Please enter valid name" class="form-control" name="name"  autofocus>
							</div>

							<div class="form-group col-sm-6">
								<label for="email">Email<i class="required_star">*</i></label>
								<input id="email" type="email" class="form-control" name="email" >
							</div>

							<div class="form-group col-sm-6">
								<label for="mobile_no">Mobile Number<i class="required_star">*</i></label>
								<input id="mobile_no" type="text" class="form-control" name="mobile_no" >
							</div>

							<div class="form-group col-sm-6">
								<label for="priority">Priority<i class="required_star">*</i></label>
								<select id="priority" class="form-control" name="priority" >
									<option value="">---Select---</option>
									<option>{{\App\Constants\AppConstants::PRIORITY_TYPE_HIGH}}</option>
									<option>{{\App\Constants\AppConstants::PRIORITY_TYPE_LOW}}</option>
									<option>{{\App\Constants\AppConstants::PRIORITY_TYPE_MEDIUM}}</option>
								</select>
							</div>
							<div class="form-group col-sm-6">
								<div class="form-check">
									<div class="DoctorImage">
										<label>Document</label><br>
										<input type="file" class="form-control" id="document" name="document[]" multiple placeholder="document" />
										<span class="help-block"></span>
									</div>
								</div>
							</div>
							<div class="form-group col-sm-12">
								<label for="name">Comments</label>
								<textarea title="Please enter valid comment" type="text" placeholder="Text here..." class="form-control comments" name="comments"  autofocus></textarea>
							</div>
							<div class="form-group col-sm-6">
							<button type="submit" class="btn submitEnquiry">
								Submit
							</button>
							</div>
                        </form>
					</div>
				</div>
			</div>

{{--			<div class="modal-footer">--}}
{{--				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
{{--			</div>--}}
		</div>

	</div>
</div>
<div class="modal fade enquiryStatus" id="statusModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" id="closeStatusModel" data-dismiss="modal">×</button>
                <h4 class="modal-title">Track Your Status</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form   id="trackStatus"   name="trackStatus" enctype="multipart/form-data">
                            @csrf
							<div class="form-group col-sm-12">
								<input type="search" id="status" placeholder="Track Your Status" name="ticket_no">
								<button type="submit" class="btn submitEnquiry">Search</button>
							</div>
                        </form>

                    </div>

                </div>

            </div>
			<form id="addCommentForm">
				<div class="form-group">
					<label for="newComment">Add a new comment:</label>
					<textarea class="form-control" id="newComment" name="newComment" rows="3"></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Submit Comment</button>
			</form>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div>

</div>
<div class='modal fade @if($controller == "DocController" && $action == "liveDoctors" || $action == "onCallDoctorDetalis") liveDocSts @endif' id="doctorAppointmentSlot" role="dialog" data-backdrop="static" data-keyboard="false"></div>
<div class="container-fluid footer_top">
<div class="container">
<div class="footer">
<div class="col-md-3">
<div class="footer_section">
    <h5>Health Gennie</h5>
    <p>Health Gennie is an IT-based concept that caters to preventive health care from anywhere. Health care at one place from anywhere anytime.</p>
</div>
</div>
<div class="col-md-3">
        <div class="footer_block">
            <h5>Learn More</h5>
            <ul>

				<li><a href="{{route('aboutUs')}}">About Us</a></li>
				<li><a href="{{route('termsConditions')}}">Terms & Conditions</a></li>
				<li><a href="{{route('privacyPolicy')}}">Privacy Policy</a></li>

				<li><a href="javascript::void(0)" data-toggle="modal" data-target="#AddEnquryModel">Service Issue</a>
				<li><a href="javascript::void(0)" data-toggle="modal" data-target="#statusModal">Track Your Status</a>
				</li>
                <!--<li><a href="{{route('driveDashboard')}}">Elite</a></li>-->
            </ul>
        </div>
    </div>
<div class="col-md-3">
<div class="footer_block">
            <h5>Learn More</h5>
            <ul>
                <li><a href="{{route('unlimitedPlan')}}">Latest Offer</a></li>
                <li><a href="http://192.168.2.141/HGlive/career">Careers</a></li>
                <li><a href="{{route('contactUs')}}">Contact Us</a></li>
                <!--<li><a href="{{route('driveDashboard')}}">Elite</a></li>-->
            </ul>
        </div>
<div class="footer_block  last hideforPaytm">
        <h5 class="ClassCallNow12" style=" margin-top: 15px;">Call Now </h5>
        <a class="ClassCallNow" href="tel:+91-8929920932"><div class="content-center">
            <div class="pulse"> <i class="fa fa-phone" aria-hidden="true"></i></div>
        </div>+91-8929920932
        </a>
    </div>
    
    
</div>


<div class="col-md-3 Get_company_top">
    <div class="Get">
      <div class="col-md-12">
        <div class="Get_company_search">
          <div class="Get_company_content">
            <h5>Subscribe for updates</h5>
          </div>
          <input class="email_subcription" type="email" placeholder="Enter Your Email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" />
          <button type="button" class="btn btn-default email_subcription_btn">Subscribe</button>

        </div>
        <span class="EmailSubcriptionMsg" style="color: rgb(255, 0, 0);"></span>
        
        <div class="footer_block  last hideforPaytm">
    	<h5 style="text-align: left; margin: 20px 0 0 0; padding: 0;">Follow Us </h5>
        <ul>
            <li><a title="Facebook" href="https://www.facebook.com/HealthGennie/" target="_blank" ><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
            <li><a title="Twitter" href="https://twitter.com/HEALTHGENNIE1" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
            <li><a title="Instagram" href="https://www.instagram.com/healthgennie/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a title="Linkedin" href="https://www.linkedin.com/company/health-gennie" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
        </ul>
    </div>
        
      </div>
  </div>
</div>
</div>
</div></div>
<div class="container-fluid footer_bottom">
<div class="container">
<div class="footer_bottom_section">
<div class="col-md-12">
<div class="footer_bottom_block" style="text-align:center;">
<p>© Copyright 2021 Health Gennie®. All rights reserved.</p>
</div>
</div>
</div></div>
</div>
<!--footer script-->
<script src="js/shopifyWidgetJs.js" type="text/javascript"></script>
<script src="js/custom.js" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrzKrcKQqGvZQjuMZtDQy3MHOpNjPmjnU&libraries=places" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script>
var acc = document.getElementsByClassName("accordion");
	var i;
	for (i = 0; i < acc.length; i++) {
	  acc[i].addEventListener("click", function() {
		this.classList.toggle("active");
		var panel = this.nextElementSibling;
		if (panel.style.display === "block") {
		  panel.style.display = "none";
		} else {
		  panel.style.display = "block";
		}
	  });
	}
$(".LinkSendMobileNo").on("keyup paste", function(){
  if(this.value.length == 10 ){
	$('.appLinkSendSuccess').hide();
	$('.appLinkSendSuccess').text('Please Enter 10 Digits Mobile No.');
	$('.appLinkSendSuccess').css({"color": "red"});
  }
});

$(".LinkSendMobileNo").on("keyup paste", function(){
  if(this.value.length == 10 ){
	$('.appLinkSendSuccess').hide();
	$('.appLinkSendSuccess').text('Please Enter 10 Digits Mobile No.');
	$('.appLinkSendSuccess').css({"color": "red"});
  }
});

jQuery(document).on("click", ".SendLink", function () {
		var mobileNo = $(".Sendapp_Link").find(".LinkSendMobileNo").val();
  flag = true;
	if(mobileNo == "") {
	  $(".Sendapp_Link").find(".email_subcription").css('border','1px solid red');
	  $('.appLinkSendSuccess').show();
	  $('.appLinkSendSuccess').text('Please Enter 10 Digits Mobile No.');
	  $('.appLinkSendSuccess').css({"color": "red"});

	  flag = false;
	}
	if(mobileNo.length < 10 ){
	  $(".Sendapp_Link").find(".email_subcription").css('border','1px solid red');
	  $('.appLinkSendSuccess').show();
	  $('.appLinkSendSuccess').text('Please Enter 10 Digits Mobile No.');
	  $('.appLinkSendSuccess').css({"color": "red"});
	  flag = false;
	}

	if (flag == true) {
	  jQuery('.loading-all').show();
	  jQuery.ajax({
		type: "POST",
		dataType : "JSON",
		url: "{!! route('SendAppLink') !!}",
		data:{'mobile_no':mobileNo},
		success: function(data) {
		  jQuery('.loading-all').hide();
		  if(data == 1) {
			$('.appLinkSendSuccess').show();
			$('.appLinkSendSuccess').text('Link Sent successfully ');
			$(".Sendapp_Link").find(".LinkSendMobileNo").val('');
			$('.appLinkSendSuccess').css({"color": "green"});
		  }
		  else {
			$('.appLinkSendSuccess').show();
			$('.appLinkSendSuccess').text(data[0]);
			$('.appLinkSendSuccess').css({"color": "red"});
		  }
		},
		error: function(error) {
		  if(error.status == 401 || error.status == 419) {
			//alert("Session Expired,Please logged in..");
			location.reload();
		  }
		  else{
			alert("Oops Something goes Wrong.");
		  }
		  jQuery('.loading-all').hide();
		},
	  });
	}
	});
$(document).ready(function(){
    $('.customer-logos').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 3
            }
        }]
    });
});
jQuery(document).on("click", ".logoutUser", function (e) {
	document.getElementById('logout-form').submit();
});
/** All Pages For Data**/
var  filtered_div = "filteredDivDesktop";
if (window.matchMedia("(max-width: 639px)").matches)  {
	filtered_div = "filteredDivMobile";
}

	var lat = ""; var lng = ""; var city = ""; var state = ""; var sub_locality = "";
	function initialize() {
		 if($.cookie('is_app_open') == '1') {
			$(".top-navbaar").find(".top-strip-wrtapper").hide();
			$('body').addClass('main-body-w-app');
		 }
		 if($("#profileStatusSess").val() != '' && $("#profileStatusSess").val() != '1'){
			$("#profileAlertModel").modal("show");
		 }
		if($("#session_lat").val()){
			lat = $("#session_lat").val();
		}
		if($("#session_lng").val()){
			lng = $("#session_lng").val();
		}
		if(!lat && !lng){
		 setTimeout(function(){
				getLatLngLocation(0);
		  }, 1100);
		}
	}
	function getLatLngLocation(x) {
		// var script = document.createElement('script');
		// script.src = 'js/google-map.js';
		// document.getElementsByTagName('head')[0].appendChild(script);
		setTimeout(function() {
			geocoder = new google.maps.Geocoder();
			if (navigator.geolocation) {
				if(x == 0){
					navigator.geolocation.getCurrentPosition(successFunctionOn,errorFunction);
				}
				else {
					navigator.geolocation.getCurrentPosition(successFunction,errorFunction);
				}
			}
		}, 500);
	}


		jQuery(document).on("keyup paste click", ".pac-input", function (e) {
			var localAreaSearchListDiv = jQuery('.localAreaSearchList').find('.search-data div').length;
			$(".doctorSearchByInput").hide();
			$(".doctorSearchByInput .search-data").remove();
			$(this).addClass('loder-show-search');
			if(e.originalEvent.detail == 1) {
				if(jQuery(this).val().length < 3) {
						if(localAreaSearchListDiv <= 0 ){
							getCurrentLocality(this,'');
						}
				}
				else{
					if(jQuery(this).val().length >= 3) {
						var currSearchh = jQuery(this).val();
						if(localAreaSearchListDiv <= 0 ){
							getCurrentLocality(this,currSearchh);
						}
						$(".search_close_locality").show();
					}
				}
			}
			else {
				if(jQuery(this).val().length >= 3) {
					var currSearchh = jQuery(this).val();
					getCurrentLocality(this,currSearchh);
					$(".search_close_locality").show();
				}
				else{
					getCurrentLocality(this,'');
				}
			}
		});
		var currentRequestCity ;
		function getCurrentLocality(current,cur_search) {
			var city_name_1 = $("#searchDocInfo").find(".locality_city_area").val();
			var state_name_1 = $("#searchDocInfo").find(".locality_state_area").val();
			if(currentRequestCity) {
				currentRequestCity.abort();
			}
			currentRequestCity = jQuery.ajax({
				type: "POST",
				url: "{!! route('getCurrentLocality') !!}",
				data: {'city_name':city_name_1,'state_name':state_name_1,'locality_area':cur_search},
				beforeSend: function() {
					$(current).css("background","#FFF url('https://healthgennie.com/img/LoaderIcon.gif') no-repeat right");
				},
				success: function(data) {
					$(current).removeClass('loder-show-search');
					$(current).css("background","");
					var rowToAppend = '<div class="dd select_area_by"><div class="entire_div_search detail"><span class="location-div"><span data-qa-id="current_location" class="btn-detect detect_location"><img width="15" height="13" src="img/loc-detect.png" alt="location-detect-icon" /><i class="icon-ic_gps_system"></i><span>Detect</span></span></span></div></div>';
					var city_name_2 = $("#searchDocInfo").find(".locality_city_area").val();
					var city_slug_2 = $("#searchDocInfo").find(".locality_city_slug").val();
					var state_name = $("#searchDocInfo").find(".locality_state_area").val();

					var city_id_1 = $('#searchDocInfo input[name="city_id"]').val();
					var state_id_1 = $('#searchDocInfo input[name="state_id"]').val();

					if(city_name_2 != '') {
						rowToAppend += '<div data_type="2" slug="'+city_slug_2+'" data_id="'+city_id_1+'" data_city_name="'+city_name_2+'" data_state_name="'+state_name+'" state_id="'+state_id_1+'" class="dd select_area_by"><i class="icon-ic_gps_system"><img width="15" height="12" src="{{ URL::asset("img/search-dd.png") }}" /></i><div class="entire_div_search detail"><span class="text">Search In entire '+city_name_2+'</span></div></div>';
					}
					if(data['city'].length > 0) {
						jQuery.each(data['city'],function(k,v) {
								var search_pic = '{{ URL::asset("img/search-dd.png") }}';
								state_name = ''; state_id = '';
								_name = '';
								var pic_width  = 15;
								var pic_height = 12;
								if(v.name != null) {
									_name = v.name;
								}
								if(v.state != null) {
									state_name = v.state.name;
									state_id = v.state.id;
								}
								rowToAppend += '<div slug="'+v.slug+'" data_type="2" data_id="'+v.id+'" data_city_name="'+_name+'" data_state_name="'+state_name+'" state_id="'+state_id+'" class="dd select_area_by"><i class="icon-ic_gps_system"><img width="'+pic_width+'" height="'+pic_height+'" src="'+search_pic+'" /></i><div class="detail"><span class="text">'+_name+'</span><span class="spec">'+state_name+'</span><div class="city-name-div"><span class="city-name-span">City</span></div></div></div>';
						});
					}
					if(data['locality'].length > 0) {
						jQuery.each(data['locality'],function(k,v) {
								var search_pic = '{{ URL::asset("img/search-dd.png") }}';
								city_name = '';
								state_name = '';
								slug = '';
								city_slug = '';
								_name = '';city_id = ''; state_id = '';
								var pic_width  = 15;
								var pic_height = 12;
								if(v.name != null) {
									_name = v.name;
								}
								if(v.city != null) {
									city_name = v.city.name;
									city_id = v.city.id;
									city_slug = v.city.slug;
								}
								if(v.state != null) {
									state_name = v.state.name;
									state_id = v.state.id;
								}
								rowToAppend += '<div slug="'+v.slug+'" city_slug="'+city_slug+'" data_type="1" data_id="'+v.id+'" data_name="'+_name+'" data_city_name="'+city_name+'" data_state_name="'+state_name+'" city_id="'+city_id+'" state_id="'+state_id+'" class="dd select_area_by"><i class="icon-ic_gps_system"><img width="'+pic_width+'" height="'+pic_height+'" src="'+search_pic+'" /></i><div class="detail"><span class="text">'+_name+'</span><span class="spec">'+city_name+'</span><div class="city-name-div"><span class="city-name-span">Locality</span></div></div></div>';
						});
					}

					if(data['state'].length > 0) {
						jQuery.each(data['state'],function(k,v) {
								var search_pic = '{{ URL::asset("img/search-dd.png") }}';
								con_name = '';
								_name = '';
								var pic_width  = 15;
								var pic_height = 12;
								if(v.name != null) {
									_name = v.name;
								}
								if(v.country != null) {
									con_name = v.country.name;
								}
								rowToAppend += '<div slug="'+v.slug+'" data_type="3" data_id="'+v.id+'" data_state_name="'+_name+'" class="dd select_area_by"><i class="icon-ic_gps_system"><img width="'+pic_width+'" height="'+pic_height+'" src="'+search_pic+'" /></i><div class="detail"><span class="text">'+_name+'</span><span class="spec">'+con_name+'</span><div class="city-name-div"><span class="city-name-span">State</span></div></div></div>';
						});
					}
					jQuery('.navbaar-bottom-block').find('.localAreaSearchList').css('display','block');
					jQuery('.navbaar-bottom-block').find('.localAreaSearchList').html('<div class="search-data">'+rowToAppend+'</div>');
				},
				error: function(error) {
					if(error.status == 401 || error.status == 419 || error.status == 500) {
						location.reload();
					}
				}
			});
		}

	jQuery(document).on("click", ".detect_location", function (e) {
		$(this).find("span").text('');
		$(this).css("width","25px");
		$(this).find("img").css('visibility','hidden');
		$(this).css("background","#FFF url('https://healthgennie.com/img/LoaderIcon.gif') no-repeat left");
		var current = this;
		getLatLngLocation(1);
		setTimeout(function() {
			$(current).find("img").css('visibility','visible');
			$(current).css("background","");
			$(".search_close").click();
			openDoctorSearchWithArea();
		},1500);
	});
	function setSessionLocality(lat,lng) {
		var locality = $(".pac-input").val();
		var city_name = $("#searchDocInfo").find(".locality_city_area").val();
		var state_name = $("#searchDocInfo").find(".locality_state_area").val();

		var locality_id = $('#searchDocInfo input[name="locality_id"]').val();
		var city_id = $('#searchDocInfo input[name="city_id"]').val();
		var state_id = $('#searchDocInfo input[name="state_id"]').val();

		var city_slug = $('#searchDocInfo input[name="city_slug"]').val();
		var locality_slug =	$('#searchDocInfo input[name="locality_slug"]').val();

		jQuery.ajax({
			type: "POST",
			url: "{!! route('setSessionLocality') !!}",
			cache: false,
			data: {'lat':lat,'lng':lng,'state_name':state_name,'city_name':city_name,'locality':locality,'locality_id':locality_id,'city_id':city_id,'state_id':state_id,'city_slug':city_slug,'locality_slug':locality_slug},
			beforeSend: function() {
			},
			success: function(data){
			},
			error: function(error) {
				if(error.status == 401 || error.status == 419){
					// location.reload();
				}
			}
		});
	}
	function successFunctionOn(position) {
		lat = position.coords.latitude;
		lng = position.coords.longitude;
		var latLng = new google.maps.LatLng(lat,lng);
		setTimeout(function(){
			if(geocoder) {
				geocoder.geocode({ 'latLng': latLng}, function (results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						console.log(results);
						if (results[1]) {
							for (var i = 0; i < results.length; i++) {
								if (results[i].types[0] === "locality") {
									city = results[i].address_components[0].long_name;
									state = results[i].address_components[2].long_name;
									console.log(results[i].address_components[1].short_name);
								}
							}
						}
						var localAreaName = results[3].address_components[1].long_name;
						$(".mobile-search").find(".searchDoctorModalArea .area_name").text(city);
						$(".pac-input").val(city);
						$("#searchDocInfo").find(".locality_city_area").val(city);
						$("#searchDocInfo").find(".locality_state_area").val(state);
						setTimeout(function() {
							setCityStateIds();
						},500);
						setTimeout(function() {
							setSessionLocality(lat,lng);
						},1000);
					}
					else {
						console.log("Geocoding failed: " + status);
					}
				});
			}
		},500);
	}

	function successFunction(position) {
		lat = position.coords.latitude;
		lng = position.coords.longitude;
		var latLng = new google.maps.LatLng(lat,lng);
		setTimeout(function(){
			if(geocoder) {
				geocoder.geocode({ 'latLng': latLng}, function (results, status) { console.log(results);
					if (status == google.maps.GeocoderStatus.OK) {
						if (results[1]) {
							for (var i = 0; i < results.length; i++) {
								if (results[i].types[0] === "locality") {
									city = results[i].address_components[0].long_name;
									state = results[i].address_components[2].long_name;
									console.log(results[i].address_components[1].short_name);
								}
							}
						}
						var localAreaName = results[3].address_components[1].long_name;
						$(".mobile-search").find(".searchDoctorModalArea .area_name").text(localAreaName);
						$(".pac-input").val(localAreaName);
						$("#searchDocInfo").find(".locality_city_area").val(city);
						$("#searchDocInfo").find(".locality_state_area").val(state);
						setTimeout(function() {
							setCityStateIds();
						},500);
						setTimeout(function() {
							setSessionLocality(lat,lng);
						},1000);
					}
					else {
						console.log("Geocoding failed: " + status);
					}
				});
			}
		},500);
	}
	function errorFunction() {
		if(!$("#searchDocInfo").find(".locality_city_area").val()) {
			$(".mobile-search").find(".searchDoctorModalArea .area_name").text("Jaipur");
			$(".pac-input").val("Jaipur");
			$("#searchDocInfo").find(".locality_city_area").val("Jaipur");
			$("#searchDocInfo").find(".locality_state_area").val("Rajasthan");
			setCityStateIds();
		}
	}

	function setCityStateIds() {
		var locality = $(".pac-input").val();
		var city_name = $("#searchDocInfo").find(".locality_city_area").val();
		var state_name = $("#searchDocInfo").find(".locality_state_area").val();
		jQuery.ajax({
			type: "POST",
			url: "{!! route('setCityStateIds') !!}",
			data: {'state_name':state_name,'city_name':city_name,'locality':locality},
			success: function(data){
				if(data) {
					if(data.locality_id){
						$('#searchDocInfo input[name="locality_id"]').val(data.locality_id);
					}
					else{
						$('#searchDocInfo input[name="locality_id"]').val('');
					}
					$('#searchDocInfo input[name="city_id"]').val(data.city_id);
					$('#searchDocInfo input[name="state_id"]').val(data.state_id);
					$('#searchDocInfo input[name="city_slug"]').val(data.city_slug);
					$('#searchDocInfo input[name="locality_slug"]').val(data.locality_slug);
				}
			},
			error: function(error) {
				if(error.status == 401 || error.status == 419){
					// location.reload();
				}
			}
		});
	}

	jQuery(document).ready(function() {
		var modal = document.getElementById("myModal");
		$("#myBtn").onclick = function() {
		  modal.style.display = "block";
		}
		$('.close').onclick = function() {
		  modal.style.display = "none";
		}
		window.onclick = function(event) {
		  if (event.target == modal) {
			modal.style.display = "none";
		  }
		}
	});
	jQuery(document).on("keyup paste click", ".docSearching", function (e) {
		var doctorSearchByInputDiv = jQuery('.doctorSearchByInput').find('.search-data div').length;
		$(".localAreaSearchList").hide();
		$(".localAreaSearchList .search-data").remove();
		if(e.originalEvent.detail == 1) {
			if(jQuery(this).val().length < 3){
				if(doctorSearchByInputDiv <= 0){
					getSpeciality(this);
				}
			}
			else{
				if(jQuery(this).val().length >= 3) {
					var currSearch = jQuery(this).val();
					if(doctorSearchByInputDiv <= 0){
						searchDoctor(currSearch,this);
					}
					$(".search_close").show();
				}
			}
		}
		else {
			if(jQuery(this).val().length >= 3) {
				var currSearch = jQuery(this).val();
				searchDoctor(currSearch,this);
				$(".search_close").show();
			}
			else{
				getSpeciality(this);
			}
		}
	});
    var currentRequest;
	function searchDoctor(currSearch,current) {
		var locality_ids = $('#searchDocInfo input[name="locality_id"]').val();
		var city_ids = $('#searchDocInfo input[name="city_id"]').val();
		var state_ids = $('#searchDocInfo input[name="state_id"]').val();
		var rowToAppend = "";

        if(currentRequest){
            currentRequest.abort();
        }
		 currentRequest = jQuery.ajax({
			type: "POST",
			url: "{!! route('searchDoctorsWeb') !!}",
			data: {'search_key':currSearch,'lat':lat,'lng':lng,'locality_id':locality_ids,'city_id':city_ids,'state_id':state_ids},
			beforeSend: function() {
				// $(current).css("background","#FFF url('https://healthgennie.com/img/LoaderIcon.gif') no-repeat right");
			},
			success: function(data){
				$(current).css("background","");
				if(data['Speciality'].length > 0) {
					rowToAppend += '<h3>Speciality</h3>';
					jQuery.each(data['Speciality'],function(k,v) {
						var pic_width  = 15;
						var pic_height = 12;
						var search_pic = '{{ URL::asset("img/search-dd.png") }}';
						var search_pic_class = 'search-data-icon';
						if(v.speciality_icon != null){
							search_pic = v.speciality_icon;
							pic_width  = 30;
							pic_height  = 30;
							search_pic_class  = '';
						}
						rowToAppend += '<div slug="'+v.slug+'" group_id="'+v.group_id+'" search_type="1" data_id="'+v.id+'" info_type="Speciality" class="dd view_information '+search_pic_class+'"><i class="icon-ic_gps_system"><img width="'+pic_width+'" height="'+pic_height+'" src="'+search_pic+'" /></i><div class="detail"><span class="text">'+v.spaciality+'</span><span class="spec">Speciality</span></div></div>';
					});
				}
				if(data['Doctors'].length > 0) {
					rowToAppend += '<div search_type="1" data_id="0" info_type="doctorsIn" class="dd view_information seeAllInfo"><h3>Doctors</h3><span>See All</span><p class="text" style="display:none;">'+currSearch+'</p></div>';
					jQuery.each(data['Doctors'],function(k,v) {
						var pic_width  = 15;
						var pic_height = 12;
						var locality = '';
						var city = '';
						var city_slug = '';
						var fName = '';
						var lName = '';
						var rating = 0;
						var rating_div = '';
						var search_pic_class = 'search-data-icon';
						var search_pic = '{{ URL::asset("img/search-dd.png") }}';
						if(v.profile_pic != null) {
							search_pic = v.profile_pic;
							pic_width  = 30;
							pic_height  = 30;
							search_pic_class  = '';
						}
						if(v.first_name != null){
							fName = v.first_name;
						}
						if(v.last_name != null){
							lName = v.last_name;
						}
						if(v.doc_rating){
							rating = v.doc_rating;
						}
						if(v.locality_id){
							locality = v.locality_id.name;
						}
						if(v.city_id){
							city_slug = v.city_id.slug;
						}
						if(v.city_id){
							slug = v.city_id.slug;
						}
						if(rating != 0) {
							console.log(rating);
							for(x=1;x<=rating;x++) {
									rating_div +=  '<span class="doc-star-rating fa fa-star checked"></span>';
							}
							if(rating % 1 != 0){
								rating_div += '<span class="doc-star-rating fa fa-star-half-full checked"></span>';
								x++;
							}
							while (x<=5) {
									rating_div += '<span class="doc-star-rating fa fa-star"></span>';
									x++;
							}

						}
						else{
							for(x=1;x<=5;x++) {
									rating_div += '<span class="doc-star-rating fa fa-star"></span>';
							}
						}
						rowToAppend += '<div slug="'+v.doctor_slug.name_slug+'" city_slug="'+city_slug+'" search_type="1" data_id="'+v.id+'" info_type="Doctors" class="dd view_information '+search_pic_class+'"><i class="icon-ic_gps_system"><img width="'+pic_width+'" height="'+pic_height+'" src="'+search_pic+'" /></i><div class="detail"><span class="text">'+fName+' '+lName+'</span><span class="spec">'+v.speciality.name+'</span><div class="star-rating-div">'+rating_div+'</div></div></div>';
					});
				}
				if(data['Doctors'].length <= 0 && data['Speciality'].length <= 0){
					var pic_width  = 15;
					var pic_height = 12;
					var search_pic = '{{ URL::asset("img/search-dd.png") }}';
					rowToAppend += '<div class="dd add_doc_claim search-data-icon"><i class="icon-ic_gps_system"><img width="'+pic_width+'" height="'+pic_height+'" src="'+search_pic+'" /></i><div class="detail"><span class="text"><b>'+currSearch+'</b> Not Found...</span></div></div>';
				}
				jQuery('.doctorSearchByInput').css('display','block');
				jQuery('.doctorSearchByInput').html('<div class="search-data">'+rowToAppend+'</div>');
			},
			error: function(error) {
				if(error.status == 401 || error.status == 419 || error.status == 500){
					location.reload();
				}
			}
		});
	}
	function getSpeciality(current) {
		jQuery.ajax({
			type: "POST",
			url: "{!! route('getSpecialityList') !!}",
			beforeSend: function() {
				// $(current).css("background","#FFF url('https://healthgennie.com/img/LoaderIcon.gif') no-repeat right");
			},
			success: function(data){
				$(current).css("background","");
				var rowToAppend = "";
				if(data.length > 0) {
					var search_pic = '{{ URL::asset("img/search-dd.png") }}';
					var pic_width  = 15;
					var pic_height = 12;
					jQuery.each(data,function(k,v) {
						if(v.speciality_icon != null){
							search_pic = v.speciality_icon;
							pic_width  = 30;
							pic_height  = 30;
						}
						rowToAppend += '<div slug="'+v.slug+'" group_id="'+v.group_id+'" search_type="1" data_id="'+v.id+'" info_type="Speciality" class="dd view_information"><i class="icon-ic_gps_system"><img width="'+pic_width+'" height="'+pic_height+'" src="'+search_pic+'" /></i><div class="detail"><span class="text">'+v.spaciality+'</span><span class="spec">Speciality</span></div></div>';
					});
				}
				jQuery('.doctorSearchByInput').css('display','block');
				jQuery('.doctorSearchByInput').html('<div class="search-data">'+rowToAppend+'</div>');
			},
			error: function(error) {
				if(error.status == 401 || error.status == 419){
					location.reload();
				}
			}
		});
	}

	jQuery(document).on("click", ".add_doc_claim", function (e) {
		location.href='{{route("addDoc")}}';
	});
	jQuery(document).on("click", ".view_information", function (e) {
		$("#searchDocInfo").find("input[name='lat']").val(lat);
		$("#searchDocInfo").find("input[name='lng']").val(lng);
		var data_search = $(this).find('.text').text();
		var data_info_type = $(this).attr('info_type');
		var data_info_id = $(this).attr('data_id');
		$("#searchDocInfo").find("input[name='bySpacialityId']").val("");
		$("#searchDocInfo").find("input[name='data_search']").val(data_search);
		$("#searchDocInfo").find("input[name='info_type']").val(data_info_type);
		$("#searchDocInfo").find("input[name='id']").val(data_info_id);

		var city = $("#searchDocInfo").find(".locality_city_slug").val();
		var locality = $('#searchDocInfo input[name="locality_slug"]').val();
		var locality_id = $('#searchDocInfo input[name="locality_id"]').val();
		if(!city){
			city = "jaipur";
		}
		var url = "";
		if(data_info_type == "Speciality") {
			var slug = $(this).attr('slug');
			if(locality_id) {
				url = '{{ route("findDoctorLocalityByType", ":city/:speciality/:locality") }}';
				url = url.replace(':locality', locality);
			}
			else {
				url = '{{ route("findDoctorLocalityByType", ":city/:speciality") }}';
			}
			url = url.replace(':city', city);
			url = url.replace(':speciality', slug);
			window.location = url;
		}
		else if(data_info_type == "doctor_all") {
			if(locality_id) {
				url = '{{ route("findDoctorLocalityByType", ":city/:doctors/:locality") }}';
				url = url.replace(':locality', locality);
				url = url.replace(':doctors', "doctors");
			}
			else {
				url = '{{ route("findAllDoctorsByCity", ":city") }}';
			}
			url = url.replace(':city', city);
			window.location = url;
		}
		else if(data_info_type == "clinic_all") {
			if(locality_id) {
				url = '{{ route("findDoctorLocalityByType", ":city/:clinics/:locality") }}';
				url = url.replace(':locality', locality);
				url = url.replace(':clinics', "clinics");
			}
			else {
				url = '{{ route("findAllClinicsByCity", ":city") }}';
			}
			url = url.replace(':city', city);
			window.location = url;
		}
		else if(data_info_type == "hos_all") {
			if(locality_id) {
				url = '{{ route("findDoctorLocalityByType", ":city/:hospitals/:locality") }}';
				url = url.replace(':locality', locality);
				url = url.replace(':hospitals', "hospitals");
			}
			else {
				url = '{{ route("findAllHospitalsByCity", ":city") }}';
			}
			url = url.replace(':city', city);
			window.location = url;
		}
		else if(data_info_type == "Clinic") {
			var slug = $(this).attr('slug');
			var url = '{{ route("findDoctorLocalityByType", ":city/:clinic/:slug") }}';
			url = url.replace(':slug', slug);
			url = url.replace(':clinic', "clinic");
			url = url.replace(':city', city);
			window.location = url;
		}
		else if(data_info_type == "Hospital") {
			var slug = $(this).attr('slug');
			var url = '{{ route("findDoctorLocalityByType", ":city/:hospital/:slug") }}';
			url = url.replace(':slug', slug);
			url = url.replace(':hospital', "hospital");
			url = url.replace(':city', city);
			window.location = url;
		}
		else if(data_info_type == "Doctors") {
			var slug = $(this).attr('slug');
			var	url = '{{ route("findDoctorLocalityByType", ":city/:doctor/:name") }}'
			var city = $(this).attr('city_slug');
			url = url.replace(':city', city);
			url = url.replace(':doctor', 'doctor');
			url = url.replace(':name', slug);
			window.location = url;
		}
		else if(data_info_type == "doctorsIn") {
			var	url = '{{ route("findDoctorLocalityByType", ":city/:doctor/:name") }}';
			url = url.replace(':city', city);
			url = url.replace(':doctor', 'doctorsIn');
			if(data_search) {
				data_search = data_search.replace(/ /g, "-").toLowerCase();
			}
			url = url.replace(':name', data_search);
			window.location = url;
		}
		else if(data_info_type == "clinicIn") {
			var	url = '{{ route("findDoctorLocalityByType", ":city/:doctor/:name") }}';
			url = url.replace(':city', city);
			url = url.replace(':doctor', 'clinicIn');
			if(data_search) {
				data_search = data_search.replace(/ /g, "-").toLowerCase();
			}
			url = url.replace(':name', data_search);
			window.location = url;
		}
		else if(data_info_type == "hospitalIn") {
			var	url = '{{ route("findDoctorLocalityByType", ":city/:doctor/:name") }}';
			url = url.replace(':city', city);
			url = url.replace(':doctor', 'hospitalIn');
			if(data_search) {
				data_search = data_search.replace(/ /g, "-").toLowerCase();
			}
			url = url.replace(':name', data_search);
			window.location = url;
		}
		else if(data_info_type == "symptoms") {
			$("#searchDocInfo").submit();
		}
	});
	jQuery(document).on("click", ".homePageDoctors", function (e) {
			// var city = $("#searchDocInfo").find(".locality_city_slug").val();
			// if(!city){
				// city = "jaipur";
			// }
			// url = '{{ route("healthgenniePatientApp") }}';
			// url = '{{ route("findDoctorLocalityByType", ":city/:speciality") }}';
			// url = url.replace(':city', city);
			// url = url.replace(':speciality', 'general-physician');
			// url = url+''+'?type=available'
			// window.location = url;
	});

	jQuery(document).on("click", ".homePageDoctorsforPaytm", function (e) {
			var city = $("#searchDocInfo").find(".locality_city_slug").val();
			if(!city){
				city = "jaipur";
			}
			url = '{{ route("findDoctorLocalityByType", ":city/:speciality") }}';
			url = url.replace(':city', city);
			url = url.replace(':speciality', 'general-physician');
			url = url+''+'?type=available'
			window.location = url;
	});
	function getDoctorInfobyId(id){
		jQuery('.loading-all').show();
		var url = '{!! url("/doctor-detail?id='+btoa(id)+'") !!}';
        window.location = url;
	}
	function getHospitalInfobyId(id,data_search){
		jQuery('.loading-all').show();
		var url = '{!! url("/hospital-detail?id='+btoa(id)+'&data_search='+btoa(data_search)+'") !!}';
        window.location = url;
	}
	jQuery(document).on("click", ".search_close", function (e) {
		$("#searchDoctorModalDoctor").find("input[name='data_search']").val('');
		$(this).hide();
		$(".docSearching").focus();
		getSpeciality(this);
	});
	jQuery(document).on("click", ".search_close_locality", function (e) {
		$("input[name='locality']").val('');
		$(this).hide();
		$(".pac-input").focus();
		getCurrentLocality(this,'');
	});
	jQuery(document).on("click", ".select_area_by", function (e) {
		var data_type = $(this).attr('data_type');
		var data_id = $(this).attr('data_id');
		var data_name = '';var city = '';var state = '';var state_id = '';
		var city_id = '';
		if(data_type == "1") {
			var slug = $(this).attr('slug');
			city_id = $(this).attr('city_id');
			state_id = $(this).attr('state_id');
			locality = $(this).attr('data_name');
			city = $(this).attr('data_city_name');
			state = $(this).attr('data_state_name');
			city_slug = $(this).attr('city_slug');
			$(".mobile-search").find(".searchDoctorModalArea .area_name").text(locality);
			$(".pac-input").val(locality);
			$("#searchDocInfo").find(".locality_city_area").val(city);
			$("#searchDocInfo").find(".locality_city_slug").val(city_slug);
			$("#searchDocInfo").find(".locality_slug").val(slug);
			$("#searchDocInfo").find(".locality_state_area").val(state);

			$('#searchDocInfo input[name="locality_id"]').val(data_id);
			$('#searchDocInfo input[name="city_id"]').val(city_id);
			$('#searchDocInfo input[name="state_id"]').val(state_id);
		}
		if(data_type == "2") {
			var slug = $(this).attr('slug');
			state_id = $(this).attr('state_id');
			locality = $(this).attr('data_city_name');
			state = $(this).attr('data_state_name');
			$(".mobile-search").find(".searchDoctorModalArea .area_name").text(locality);
			$(".pac-input").val(locality);
			$("#searchDocInfo").find(".locality_city_area").val(locality);
			$("#searchDocInfo").find(".locality_city_slug").val(slug);
			$("#searchDocInfo").find(".locality_slug").val("");
			$("#searchDocInfo").find(".locality_state_area").val(state);

			$('#searchDocInfo input[name="locality_id"]').val('');
			$('#searchDocInfo input[name="city_id"]').val(data_id);
			$('#searchDocInfo input[name="state_id"]').val(state_id);
		}
		if(data_type == "3") {
			locality = $(this).attr('data_state_name');
			$(".mobile-search").find(".searchDoctorModalArea .area_name").text(locality);
			$(".pac-input").val(locality);
			$("#searchDocInfo").find(".locality_city_area").val(locality);
			$("#searchDocInfo").find(".locality_state_area").val(locality);

			$('#searchDocInfo input[name="locality_id"]').val('');
			$('#searchDocInfo input[name="city_id"]').val('');
			$('#searchDocInfo input[name="state_id"]').val(data_id);
		}
		setTimeout(function(){
			setSessionLocality(lat,lng);
			$(".search_close").click();
			$(".docSearching").focus();
		}, 500);
		openDoctorSearchWithArea();
	});



	$(document).ready(function() {
		$(window).scroll(function() {
			if($("body").find(".top-navbaar").hasClass("fixed")) {
				$("body").addClass('main-body-banner-section');
				jQuery(".container").find(".dd-wrapper").hide();
				jQuery(".container").find(".dd-wrapper .search-data").remove();
			}
			else{
				$("body").removeClass('main-body-banner-section');
			}
		});
	});

	jQuery(document).on("click", ".searchDoctorModalDoctor", function (e) {
		if($.cookie('in_mobile') == '1') {
			$('#searchDoctorModalDoctor').modal('show');
			setTimeout(function(){
				$(".search_close").click();
			}, 500);
		}
		else{
			setTimeout(function(){
				$(".search_close").click();
			}, 500);
		}
	});


	jQuery(document).on("click", ".walletbutton", function (e) {

			$('#walletmodel').modal('show');
		
		
	});


	jQuery(document).on("click", ".searchDoctorModalArea", function (e) {
		$('#searchDoctorModalArea').modal('show');
		setTimeout(function() {
			$(".search_close_locality").click();
		}, 500);
	});
	function openDoctorSearchWithArea(){
		if($.cookie('in_mobile') == '1') {
			$('#searchDoctorModalArea').modal('hide');
			$('#searchDoctorModalDoctor').modal('show');
			$(".search_close").click();
		}
	}
	$(document.body).click( function(e) {
		var target = $(e.target);
		if(!target.is(".navbaar-bottom-section .pac-input") && !target.is(".navbaar-bottom-section .docSearching")) {
			jQuery(this).find(".dd-wrapper").hide();
			jQuery(this).find(".dd-wrapper .search-data").remove();
			$(".search_close").hide();
			$(".search_close_locality").hide();
		}
	});

	function DeleteMiniCart(product_array, action_type,replace_itm = null) {
		var returnValue;
		  jQuery.ajax({
		  type: "POST",
		  async: false,
		  dataType: 'json',
		  url: "{!! route('CartUpdate') !!}",
		  data: {'product_array':product_array,'action_type':action_type,"replace_itm":replace_itm},
			success: function(data) {
			  returnValue =  data;
			}
		  });
	   return returnValue;
	}
	jQuery(document).on("click", ".deleteFromMiniCart", function () {
			jQuery('.loading-all').show();
			$(this).parent().slideUp("slow");
			var current = this;
			var selectPackage = [];
			var cartTotal = jQuery('#cartTotal').text();
			var pname = $(this).attr('Pname');
			var pcode = $(this).attr('Pcode');
			selectPackage.push({pname:pname,pcode:pcode});
			DeleteMiniCart(selectPackage, 'remove_item');
			setTimeout(function(){ $(current).parent().remove();
				if ($("#miniCartList .list").length == '0') {
					$("#miniCart").css("display", "none");
					$(".cart-wrapper").removeClass('cart-open');
					$(".cart-wrapper").attr('title','Cart is Empty!');
				}
				location.reload();
				//jQuery('.loading-all').hide();
			}, 300);
			jQuery('#cartTotal').text(parseFloat(cartTotal)-1);
      jQuery('.totalTest').text(parseFloat(cartTotal)-1);
	});
	jQuery(document).on("click", ".email_subcription_btn", function () {
		var email = $(".Get_company_search").find(".email_subcription").val();
		if(email != "") {
			if (ValidateEmail(email)) {
				$(".Get_company_search").find(".email_subcription").css('border','1px solid red');
				jQuery('.loading-all').show();
				jQuery.ajax({
					type: "POST",
					dataType : "JSON",
					url: "{!! route('subcribedEmail')!!}",
					data:{'email':email},
					success: function(data) {
						jQuery('.loading-all').hide();
						if(data == 1) {
							$(".Get_company_search").html('<p class="form-control bg-success">Thanks For your Subcription..</p>');
							$(".Get_company_search").slideUp("slow");
							$(".Get_company_search").slideDown("slow");
						}
						else {
							$(".EmailSubcriptionMsg").text(data[0]);
						}
					},
					error: function(error) {
						if(error.status == 401 || error.status == 419) {
							location.reload();
						}
						jQuery('.loading-all').hide();
					}
				});
			}
			else {
				$(".Get_company_search").find(".email_subcription").css('border','1px solid red');
			}
		}
		else{
			$(".Get_company_search").find(".email_subcription").css('border','1px solid red');
		}
	});
	function ValidateEmail(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	};
	function FeedbackFormForLatestAppt(id, appointment_id) {
		jQuery('.loading-all').show();
		jQuery.ajax({
		type: "POST",
		dataType : "HTML",
		url: "{!! route('patients.showFeedbackForm')!!}",
		data:{'id':id,'appointment_id':appointment_id},
		success: function(data) {
		  jQuery('.loading-all').hide();
		  jQuery("#patientFeedBackForm").html(data);
		  jQuery('#patientFeedBackForm').modal('show');
		},
		error: function(error) {
			jQuery('.loading-all').hide();
			alert('Oops Something goes Wrong.');
		}
	  });
	}
$(document).ready(function(){
	if($("#userLoginStatus").val()) {
	  var latestApptFeedback = $('input[name="latestApptFeedback"]').val();
	  var closeFeedbackModal =  '{{Session::get("closeFeedbackModal")}}';
	  if (latestApptFeedback != "" && closeFeedbackModal == "") {
		latestApptFeedback =	JSON.parse(latestApptFeedback);
		setTimeout(function(){
			FeedbackFormForLatestAppt(latestApptFeedback.doc_id, latestApptFeedback.appointment_id);
	  }, 15000);

	  }
	}
});
</script>
<div id="modalpaytmPermissions" class="modal Granting-consent"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Granting consent is mandatory for proceeding with the flow.</p>
                <div class="modal-body-btn">
                <button class="btn fist-btn" onclick="closemini()">Exit</button><button class="btn last-btn" onclick="trymini()">Retry</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalpaytmPermissionsForLogin" class="modal Granting-consent"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Login is mandatory to proceed.</p>
                <div class="modal-body-btn">
                <button class="btn fist-btn" onclick="closemini()">Exit</button><button class="btn last-btn" onclick="tryminiForLogin()">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END footer script-->
<div class="loading-all" style="display:none"><span><img width="50" height="104" src="img/turningArrow.gif" alt="health-gennie-icon"/></span></div> <div class="modal-for-share-patient-experience"> <div class="modal fade" id="patientFeedBackForm" role="dialog" data-backdrop="static" data-keyboard="false"></div></div>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
  setTimeout(function(){
		var script = document.createElement('script');
		script.src = 'js/gtag-1.js';
		document.getElementsByTagName('head')[0].appendChild(script);
  }, 1000);
});
if (window.matchMedia("(max-width: 639px)").matches)  {
	$.cookie('in_mobile','1');
	$(".is_mobile").show();
	$(".is_website").hide();
}
else{
	$.cookie('in_mobile','0');
	$(".is_website").show();
	$(".is_mobile").hide();
}
$(window).scroll(function() {
if ($(this).scrollTop() > 1){  
    $('header').addClass("sticky");
  }
  else{
    $('header').removeClass("sticky");
  }
});
var isPaytmTab = false;
var pagedoc = '';
$(document).ready(function(){
	pagedoc = document;
	checkpermission();
	
}); 
function checkpermission(){
	const ua = window.navigator.userAgent;
	isPaytmTab = /AppContainer/i.test(ua);
	//console.log(isPaytmTab);
	if(isPaytmTab){ 
		pagedoc.title = 'Health Gennie';
		// document.title = 'blah';
		$('.download-app-paytm').hide();
		$('.download-app-paytmchangeDiv').show();
		//$('.download-app-paytm').attr('style', 'display: none !important; opacity: 0;');
		$('.hideforPaytm').hide();
		$('.hideforPaytmCart').attr('style', 'display: none !important; opacity: 0;');
	   // $('.hideforPaytmCart').hide();
		$('.homePageDoctorsforPaytm').show();
		$('.readOnlyforPaytm').attr("readonly",true);
		$(".sub-nev-tool").addClass("paytmSet");
		$(".mobile-vaccination").addClass("mbleVacPtm");
		var userPaytm = '{{Auth::user()}}';
		//console.log(userPaytm);
		if(!userPaytm){
			userApipaytm();
		}
	}else{
		$('.download-app-paytmchangeDiv').show();
	}
}
function closemini(){
	 jQuery('.loading-all').hide();
	JSBridge.call('popWindow');
}
function trymini(){
	jQuery('.loading-all').hide();
	$('#modalpaytmPermissions').modal('toggle'); 
	checkpermission();
}
function tryminiForLogin(){
	jQuery('.loading-all').hide();
	$('#modalpaytmPermissionsForLogin').modal('toggle'); 
	checkpermission();
}	
function userApipaytm(){
	jQuery('.loading-all').show();
	function ready (callback) {
		// call if jsbridge is injected
		if(window.JSBridge) {
		callback && callback();
		} else{// listen to jsbridge ready event
		document.addEventListener('JSBridgeReady', callback, false);
	}}
	ready(function () {
		JSBridge.call('paytmFetchAuthCode',{
		clientId:"merchant-health-gennie-prod"},
		function(result) { console.log(result);
			if(result.data){
				console.log(result.data);
				jQuery.ajax({
					type: "POST",
					url: "/loginUserByPaytm",
					data: {'code':result.data.authId},
					success: function(data)
					{
						console.log(data);
						jQuery('.loading-all').hide();
						if(data.success == 1){
							//location.reload();
					$(".paytmDivforreplace").removeClass( "login" ).addClass( "dropdown sub-nev-tool paytmSet" );
					
							$(".paytmDivforreplace").html(data.content);
							
						}
					}
				});
			}else{
				if(result.error){
					if(result.error == '-1'){
						jQuery('.loading-all').hide();
						$("#modalpaytmPermissions").modal('show');
					}else{
						jQuery('.loading-all').hide();
						$("#modalpaytmPermissionsForLogin").modal('show');
						//JSBridge.call('popWindow');
						//alert('laa');
					}
				}
			}
		});
	});
}
window.onload = () => {
@if(empty($wltSts))	
if(!isPaytmTab){
	jQuery(document).on("click", ".closePopup", function (e) {
		$.cookie('enquiryModal','1');
		
	});
	if(!$.cookie('enquiryModal')){
		 $("#enquiryModal").modal("show");
		// $("#id-findModal").modal("show");
	}
}
@endif


// let button = document.querySelector("#bmiBtn");
// button.addEventListener("click", calculateBMI);
};
/*function calculateBMI() {
    let height = parseInt(document.querySelector("#height").value);
    let weight = parseInt(document.querySelector("#weight").value);
	$(".text-muted-change").show();
    if (height === "" || isNaN(height)){
		$(".text-muted-change").text('Provide a valid Height!');
	}
    else if (weight === "" || isNaN(weight)) {
		$(".text-muted-change").text('Provide a valid Weight!');
	}
    else {
        let bmi = (weight / ((height * height) / 10000)).toFixed(2);
        if (bmi < 18.6) {
			$(".text-muted-change").text('Under Weight');
			$("#result").text(bmi);
		}
        else if (bmi >= 18.6 && bmi < 24.9){
			$(".text-muted-change").text('Normal');
			$("#result").text(bmi);
		}
        else{
			$(".text-muted-change").text('Over Weight');
			$("#result").text(bmi);
		}
    }
}*/

$(document).ready(function(){
 if(!isPaytmTab){
 window.history.pushState(null, "", window.location.href);        
  window.onpopstate = function() {
	 window.history.pushState(null, "", window.location.href);
  };
 } 
$(".call_btn").click(function(){1==$(".call_btn_div").hasClass("remove_btn")?($(".call_btn_div").removeClass("remove_btn"),$(".call_btn_div").css("width","auto")):($(".call_btn_div").addClass("remove_btn"),$(".call_btn_div").css("width","30px")),$(".call_btn_div_new").animate({width:"toggle"})})}); 

jQuery(document).ready(function(){
	 jQuery("#enquiryFromSubmit").validate({
		 rules: {
			name: {required:true,maxlength:255},
			mobile:{required:true,minlength:10,maxlength:10,number: true},
			email: {email: true,maxlength:100},
		 },
		  messages: {
			mobile: {
				required:"Please enter valid phone number.",
				minlength:"Please enter at least 10 number.",
				maxlength:"Please enter no more than 10 number.",
			},
			email: {
				required:"Please enter valid email."
			},
		  },
			errorPlacement: function(error, element) {
			error.appendTo(element.next());
		},
		submitHandler: function(form) {
			jQuery('.loading-all').show();
			jQuery("#enquiryFromSubmit").find('.submitBtn').attr('disabled',true);
			var newMobile = $("input[name='mobile']").val();
        if (newMobile.charAt(0) == '0') {
            alert('Mobile number can\'t start from zero');
			return false;
       }
			jQuery.ajax({
			type: "POST",
			dataType : "JSON",
			url: "{!! route('enquiryFromSubmit')!!}",
			data:  new FormData(form),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				 jQuery('.loading-all').hide();
				 jQuery("#enquiryFromSubmit").find('.submitBtn').attr('disabled',false);
				 if(data.status==1) {
				  // location.reload();
				  $("#success-alert").show();
				  $.cookie('enquiryModal','1');
				  setTimeout(function(){
						jQuery("#enquiryFromSubmit").trigger('reset');
						jQuery('#enquiryModal').modal('hide');
				  }, 1000);
				 }
				 else if(data.status == 3) {
					console.log(data.errors);
					if(data.errors.email){
						jQuery.each(data.errors.email, function(key, value){
							$("#email").find(".help-block").append('<label for="email" generated="true" class="error">'+value+'</label>');
						});
					}
					if(data.errors.mobile){
						jQuery.each(data.errors.mobile, function(key, value){
							$("#mobile").find(".help-block").append('<label for="mobile" generated="true" class="error">'+value+'</label>');
						});
					}
					if(data.errors.name){
						jQuery.each(data.errors.name, function(key, value){
							$("#name").find(".help-block").append('<label for="name" generated="true" class="error">'+value+'</label>');
						});
					}
				 }
				 else if(data.status == 2){
					jQuery('#enquiryModal').modal('hide');
				 }
				 else{
					jQuery('#enquiryModal').modal('hide');
				 }
			   }
			});
		}
	});
});
jQuery(document).on("click", ".radioTab", function () {
	$(this).closest(".wrapper").each(function() {
		$(this).find(".radioTab ").removeClass("active");
	});
	$(this).addClass("active");
});
$(document).on("click", ".bookFreeAppt", function () {
	jQuery('.loading-all').show();
	date = $(this).attr("apptDate");
	time = $(this).attr("apptTime");
	doc_id = $(this).attr("doc_id");
	var type = btoa('1');
	var url = '{!! url("/doctor/appointment-book?doc='+doc_id+'&date='+date+'&time='+time+'&conType='+type+'&isDirect=1") !!}';
	window.location = url;
});
$(document).on("click", ".bookFreeApptPaytm", function () {
	jQuery('.loading-all').show();
	date = $(this).attr("apptDate");
	time = $(this).attr("apptTime");
	doc_id = $(this).attr("doc_id");
	var type = btoa('1');
	var url = '{!! url("/doctor/appointment-book?doc='+doc_id+'&date='+date+'&time='+time+'&conType='+type+'&isDirect=1&isPaytm=1") !!}';
	window.location = url;
});
function gtag(){dataLayer.push(arguments)}window.dataLayer=window.dataLayer||[],gtag("js",new Date),gtag("config","UA-118614143-1");
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
$('.counter').each(function () {
	$(this).prop('Counter',0).animate({
		Counter: $(this).text()
	}, {
		duration: 3000,
		easing: 'swing',
		step: function (now) {
			$(this).text(Math.ceil(now));
		}
	});
});
$('.home-slider-ss').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	autoplay: true,
	autoplaySpeed: 4000,
	arrows: true,
	dots: false,
	pauseOnHover: false,
	responsive: [{
		settings: {
		breakpoint: 768,
			slidesToShow: 1
		}
	}, {
		breakpoint: 520,
		settings: {
			slidesToShow: 1
		}
	}]
});
$('.home-slider-ss-2').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	autoplay: true,
	autoplaySpeed: 2500,
	arrows: true,
	dots: false,
	pauseOnHover: false,
	responsive: [{
		settings: {
		breakpoint: 768,
			slidesToShow: 1
		}
	}, {
		breakpoint: 520,
		settings: {
			slidesToShow: 1
		}
	}]
});
jQuery(document).ready(function($) {
	$.validator.addClassRules({
		'comments': {
		    required: true,
		    maxlength: 250,
			minlength:30
		}
	});
	$("form[name='addEnquiryData']").validate({
		rules: {
			name: { required: true, maxlength: 30 },
			email: { required: true, email: true, maxlength: 100 },
			mobile_no: { required: true, minlength: 10, maxlength: 10, number: true },
		},
		messages: {
			mobile_no: {
				required: "Please enter a valid phone number.",
				minlength: "Please enter at least 10 digits.",
				maxlength: "Please enter no more than 10 digits."
			},
			email: {
				required: "Please enter a valid email address."
			}
		},
		submitHandler: function(form) {
			$('.loading-all').show();
			var formData = new FormData(form);
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type: 'POST',
				url: "{!! route('store') !!}",
				data: formData,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('.loading-all').show();
				},
				success: function(data) {
					if (data) {
						$('.loading-all').hide();
						location.reload();
						alert('Enquiry Added Successfully');
					}
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
					$('.loading-all').hide();
					alert('An error occurred while adding the enquiry.');
				}
			});
		}
	});
});
$(document).ready(function() {
	$('#closeEnquiryModel').click(function() {
		location.reload();
	});
});
$(document).ready(function() {
	$('#closeStatusModel').click(function() {
		location.reload();
	});
});
$(document).ready(function() {
	// Hide the addCommentForm by default
	$('#addCommentForm').hide();

	$('#trackStatus').submit(function(event) {
		event.preventDefault();

		// Collect form data
		var formData = $(this).serialize();

		$.ajax({
			url: '{{ route("track-status") }}',
			type: 'POST',
			data: formData,
			success: function(response) {
				// Clear previous data
				$('#statusModal .modal-body').empty();

				// Check if ticket exists
				if(response.length > 0) {
					var ticket = response[0];
					var statusColors = {
						"In-Progress": '#f4ab55',
						"Pending": '#ff4961',
						"Complete": '#4bb240',
						"Cancelled": '#f00',
					};
				
					// Display ticket status
					var status = ticket.status;
					var statusColor = statusColors[status];

					$('#statusModal .modal-body').append('<h3>Status: <span style="background-color: ' + statusColor + '; padding: 3px; color: white;">' + status + '</span></h3>');

					// Display comments and replies
					if(ticket.comments.length > 0) {
						$('#statusModal .modal-body').append('<h4>Comments:</h4>');
						var commentsList = $('<ul></ul>');
						$.each(ticket.comments, function(index, comment) {
							commentsList.append('<li>' + comment.comments + '</li>');

							if(comment.ticket_reply.length > 0) {
								var repliesList = $('<ul></ul>');
								$.each(comment.ticket_reply, function(index, reply) {
									repliesList.append('<li style="color: dodgerblue ">' + reply.message + '</li>');
								});
								commentsList.append(repliesList);
							}
						});
						$('#statusModal .modal-body').append(commentsList);

						// Show the "Add a new comment" form
						$('#addCommentForm').show();
						console.log('ticket', ticket);

						$('#addCommentForm').data('ticket-id', ticket.id);
					} else {
						// Hide the "Add a new comment" form if no comments found
						$('#addCommentForm').hide();
					}
				} else {
					alert("Invalid ticket number!");
					$('#statusModal .modal-body').empty();
					// $('#statusModal .modal-body').find('#status').show();
					// $('#statusModal .modal-body').find('.submitEnquiry').show();
					$('#addCommentForm').hide();
				}
			},
			error: function(xhr, status, error) {
				alert("Invalid ticket number!");
				console.error(error);
			}
		});
	});

	$('#addCommentForm').validate({
		rules: {
			newComment: { required: true, minlength: 50 },

		},
		messages: {
			newComment: {
				required: "Please enter a valid comments.",
				minlength: "Please enter at least 50 Char.",
			},
		},
		submitHandler: function(form) {
			$('.loading-all').show();
			var newComment = $('#newComment').val();
			var ticketId = $('#addCommentForm').data('ticket-id');
			// var newComment = $('#newComment').val();
			// var ticketId = $(this).data('ticket-id'); // Retrieve ticket ID from the form data attribute

			console.log('ticketId', ticketId);
			$.ajax({
				url: '{{ route("add-comment") }}',
				type: 'POST',
				data: {
					ticketId: ticketId,
					comment: newComment
				},
				success: function(response) {
					// Update comments section
					$('#statusModal .modal-body ul').append('<li>' + newComment + '</li>');
					$('#newComment').val(''); // Clear the textarea
					alert('Comment Added Successfully')
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});
		}
	})
});
</script>
<script>
// Set the date we're counting down to
var countDownDate = new Date("May 31, 2021 12:00:00").getTime();
/*
// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("co-help-mob").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
  document.getElementById("co-help-desk").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);id="co-help-mob"
    document.getElementById("co-help-mob").innerHTML = "EXPIRED";
    document.getElementById("co-help-desk").innerHTML = "EXPIRED";
  }
}, 1000);*/
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Health Gennie",
  "url": "https://www.healthgennie.com/",
  "logo": "https://www.healthgennie.com/img/logo.webp",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+91 8929920932",
    "contactType": "appointment",
    "contactOption": "technical support",
    "areaServed": "India",
    "availableLanguage": "en"
  },
  "sameAs": [
    "https://www.facebook.com/HealthGennie/",
    "https://twitter.com/healthgennie1",
    "https://www.instagram.com/healthgennie/",
    "https://www.youtube.com/channel/UCejlGuFFdjrlURsJeFJzOVw",
    "https://www.linkedin.com/company/health-gennie/",
    "https://in.pinterest.com/gennie0070/"
  ]
}
</script>
@if(empty($wltSts))
<script>
var options = {
  "enabled":true,
  "chatButtonSetting":{
      "backgroundColor":"#4dc247",
      "ctaText":"Message Us",
      "borderRadius":"25",
      "marginLeft":"0",
      "marginBottom":"20",
      "marginRight":"15",
      "position":"right"
  },
  "brandSetting":{
      "brandName":"Health Gennie",
      "brandSubTitle":"Typically replies within a day",
      "brandImg":"https://www.healthgennie.com/img/wpp_lgimg.webp",
      "welcomeText":"Hi there!\nHow can I help you?",
      "messageText":"",
      "backgroundColor":"#0a5f54",
      "ctaText":"Start Chat",
      "borderRadius":"25",
      "autoShow":false,
      "phoneNumber":"918690006254"
  }
};
$(document).ready(function(){
if(!isPaytmTab){
CreateWhatsappChatWidget(options);
}


jQuery(document).on("click", ".refRralcode", function (e) {
	$("#id-findModal").modal("show");
	});

});

function copyToclipboard() {
  var copyText = document.getElementById("wallet_code");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied: " + copyText.value;
}

function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy to clipboard";
}

let copy = (textId) => {
	
  //Selects the text in the <input> elemet
  document.getElementById(textId).select();
  //Copies the selected text to clipboard
  document.execCommand("copy");
  $("#toCoppied").delay(500).fadeIn();
};

</script>
@endif	
</body>
</html>
