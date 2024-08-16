<!DOCTYPE html>
<html lang="en"> 
<head>
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
	$description = "Book online free doctor consultation & appointment from the comfort of your home and get a digital prescription. Also read about health issues & get solutions.";
	$og_type = url("/");
	$og_image = url("/").'/img/imgpsh_fullsize_anim.webp';
	$canonicalUrl = URL::current();
@endphp
<title>{{$title}}</title>
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
<link rel="canonical" href="<?php echo $canonicalUrl;?>"/>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="preload" as="style" href="css/assets/bootstrap/css/bootstrap.min.css" media="all" type="text/css" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/assets/bootstrap/css/bootstrap.min.css"></noscript>
<link rel="preload" as="style" href="css/common.css?v=12" type="text/css" media="all"  onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/common.css?v=12"></noscript>
<link rel="stylesheet" href="css/style.css" type="text/css" media="all"  />
<link rel="preload" as="style" href="css/fonts/font-awesome.min.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/fonts/font-awesome.min.css"></noscript>
<link rel="preload" as="style" href="css/fonts/font_google.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/fonts/font_google.css"></noscript>
<link rel="preload" as="style" href="css/fonts/font_family.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/fonts/font_family.css"></noscript>
<script src="css/assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript" rel="preload"></script>
<script src="js/bootstrap.min.js" type="text/javascript" async ></script>
<script src="js/jquery.validate.js" type="text/javascript" ></script>
<script src="js/cookieMin.js" type="text/javascript" ></script>
</head>
<body class="home">
<div class="dashboard-wrapper dashboard-plan-wrapper container doit-landing">
      @if(session()->get('message'))
	  <div class="alert alert-success">
		<strong>Success!</strong> {{ session()->get('message') }}
	  </div>
	  @endif
      <!--<div class="HG_plan_Section">
        <div class="HG_plan_Block">
            <img src="img/HG-club-health-gennie-banner.jpg" />
        </div>
	  </div>-->
      
      <div class="emitra-heading">
      	<div class="container">
      		<h1><span>Health</span> Gennie Online Doctor Consultation</h1>
      		<img src="img/24-7.png" alt="Doctor Available">
        </div>
      </div>
	 <div class="HG_plan">
      	<h2>Choose <span>Health</span>  Gennie Subscription Plan</h2>
        <p>Health Gennie offers different plans. Choose one that suits your needs.</p>
        <div class="hg-plan-wrapper">
			<?php $plan = getPlanDetails(23);?>
			<div class="healthcare_plan plan-section1">
				<div class="title-bg">
					<h2>{{$plan->plan_title}}</h2>
					<div class="actual-price-wrapper"><strike><strong>₹{{$plan->price}}</strong></strike> <strong>₹{{$plan->price - $plan->discount_price}}</strong></div>
				</div>
				<h3></h3>
				<div class="plan-content">{!!$plan->content!!}</div>
				<a class="btn" href='{{route("choosePlan",["id" => base64_encode($plan->id)])}}'>Buy Plan</a>
			</div>
			@if(count($plans) > 0)
				@foreach($plans as $i => $plan)
				<div class="healthcare_plan plan-section{{$i+2}}">
					<div class="title-bg">
						<h2>{{$plan->plan_title}}</h2>
                        <div class="actual-price-wrapper"><strike><strong>₹{{$plan->price}}</strong></strike> <strong>₹{{$plan->price - $plan->discount_price}}</strong></div>
					</div>
					<h3></h3>
					<div class="plan-content">{!!$plan->content!!}</div>
					<a class="btn" href='{{route("choosePlan",["id" => base64_encode($plan->id)])}}'>Buy Plan</a>
				</div>
				@endforeach
			@endif
        </div>
      </div>
      <div class="singl-click">
      	<h2>Single Online <span>Doctor </span>Consultation </h2>
        <p>Get your appointment done on single click at afordable cost.</p>
        <a href="javascript:void(0);" class="bookFreeAppt" apptDate="{{base64_encode(date('d-m-Y'))}}" apptTime="{{base64_encode(strtotime(date('h:i A')))}}" doc_id='{{base64_encode(getSetting("direct_appt_doc_id")[0])}}'>Book Now</a>
      </div>
      
      <!--<div class="appoint-banner bookFreeAppt" apptDate="{{base64_encode(date('d-m-Y'))}}" apptTime="{{base64_encode(strtotime(date('h:i A')))}}" doc_id='{{base64_encode(getSetting("direct_appt_doc_id")[0])}}'><img src="img/plan-banner-inner.jpg" /></div>
      <div class="appoint-banner-mobile bookFreeAppt" apptDate="{{base64_encode(date('d-m-Y'))}}" apptTime="{{base64_encode(strtotime(date('h:i A')))}}" doc_id='{{base64_encode(getSetting("direct_appt_doc_id")[0])}}'><img src="img/doit-landing-mobile.png" /></div>-->
      
      
      
      <div class="hg-club">
      	{!!getTermsBySLug('subscription-plan-page-content-bottomapp','en')!!}
      </div>	 
</div>
<script>
$(document).on("click", ".bookFreeAppt", function () {
	jQuery('.loading-all').show();
	date = $(this).attr("apptDate");
	time = $(this).attr("apptTime");
	doc_id = $(this).attr("doc_id");
	var type = btoa('1');
	var url = '{!! url("/doctor/appointment-book?doc='+doc_id+'&date='+date+'&time='+time+'&conType='+type+'&isDirect=1") !!}';
	window.location = url;
});
</script>
</body>
</html>