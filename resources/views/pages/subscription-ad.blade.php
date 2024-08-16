<!DOCTYPE html><html lang="en"> 
<body class="home">
<head class="top-navbaar float-panel ">
<title>Book Your Lab Test with Health Gennie</title>
<meta name="description" content="Book your lab tests with Health Gennie for an accurate result for your problem. NABL & ISO approved lab and home sample collection facilities."/>
<meta name="keywords" content="Lab test at home near me, book lab test online near me, pathology lab near me, lab test near me, book your lab, book lab tests online, book lab test online, book lab test online in Jaipur, home sample collection"/>
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
<link rel="preload" as="style" href="css/style.css?v=12" type="text/css" media="all"  onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/style.css?v=12"></noscript>
<link rel="preload" as="style" href="css/common.css?v=12" type="text/css" media="all"  onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="css/common.css?v=12"></noscript>
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
<meta content="width=device-width, initial-scale=1" name="viewport" />
</head>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="container"> @if (Session::has('message'))
  <div class="alert alert-info sessionMsg">{{ Session::get('message') }}</div>
  @endif
  <div class="container-inner contact-wrapper contact-us">
  	<div class="BookYourLabNewImage col-lg-8 col-md-8">
        <div class="contact-detail">
          <img src="img/LabOfferNew.jpg" alt="">
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
      	<div class="BookYourLabNew">
    <h2>Book Your Lab</h2>
    <p>Our support team will catch back to you soon!!!</p>
    {!! Form::open(array('route' => 'enquiryFromSubmit','method' => 'POST', 'id' => 'contact-form')) !!} 
        <div class="form-fields">
          <label>Your Name<i class="required_star">*</i></label>
          <input type="text" value="" name="name" placeholder="Enter Full Name" />
		  
          <span class="help-block">
			@if($errors->has('interest_in'))
			<label for="interest_in" generated="true" class="error">
				 {{ $errors->first('interest_in') }}
			</label>
			@endif
		  </span>
        </div>
		<input type="hidden" value="1" name="req_from" />
        <div class="form-fields">
          <label>Phone Number<i class="required_star">*</i></label>
          <input type="text" value="" name="mobile" class="NumericFeild" placeholder="Your Phone Number" />
          <span class="help-block">
			@if($errors->has('mobile'))
			<label for="mobile" generated="true" class="error">
				 {{ $errors->first('mobile') }}
			</label>
			@endif
		  </span>
        </div>
        <div class="form-fields">
          <label>City<i class="required_star">*</i></label>
          <input type="text" value="" name="city" placeholder="Your City"  required/>
          <span class="help-block">
			@if($errors->has('city'))
			<label for="email" generated="true" class="error">
				 {{ $errors->first('city') }}
			</label>
			@endif
		  </span>
        </div>
        
        
       <div class="form-fieldsButton">
	   <!-- <div class="write-us-submit">
            <div class="g-recaptcha" data-sitekey="6Le6KYoUAAAAAOBx_xpvhxYYH2qE3HN92bjSz6IR"></div>
            <div class="loding" style="display:none;"><img src="{{ URL::asset('img/turningArrow.gif') }}" /></div>
        </div> -->
       	<button type="submit" class="btn btn-default email_subcription_btn">Submit</button>
       </div>

      {!! Form::close() !!}
       
    </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="container"> 
  <div class="col-lg-12">
  <div class="LabContentTop">
  	<p>Under the great expertise of experienced doctors, Health Gennie is organizing a full-body checkup consisting of a thorough list of 71 tests on a platform that brings experts (doctors) together to offer their advanced diagnostics to analyze your entire body and deliver an accurate result of their analysis. With our expert guidance, we will provide you with the best treatments at a reasonable cost. Our portfolio includes the following lab tests: CBC, LFT, KFT/RFT, lipid profile, and urine routine. HBA1c; Vitamin B-12; Vitamin D. We also provide free home sample collection for our lab tests. Get your tests online with our best services, available 24 hours a day. Book now for a healthy life with us. Score your health card with great facilities and doctors. </p>
  </div>
  <div class="LabContentTopListing">
  	<h2>Why Book with Health Gennie?</h2>
  	<ul>
  		<li>NABL and ISO Approved Lab</li>
  		<li>Only Certified Professional will collect the sample from your location</li>
  		<li>Best price with extra savings.</li>
  		<li>Report available directly on the Health Gennie app and WhatsApp</li>
  		<li>Share the report with anyone directly from the Health Gennie app</li>
  		<li>Everything from the comfort of your home</li>
  	</ul>
  	<div class="form-fieldsBookNow">
       	<button type="button" class="btn btn-default email_subcription_btn">Book Now</button>
       </div>
  </div>	
  </div>
  </div>
</div>
<section class="cta-section ">
	<h2 class="jumbotron text-center JumbotronTextCenter">
<span class="subtitle">HEALTH GENNIE</span>Our Satisfied Customers </h2>
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
<section class="cta-section no-bg">
<div class="blog-content"><h3><span class="subtitle">Your Passion is our Satisfaction</span>Our Clients</h3> <p>We believe in turning clients into family and your <br> Passion is our Satisfaction.</p></div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script>
$(document).ready(function(){	
jQuery("#contact-form").validate({
	rules: {
		name:  {required:true,minlength:2,maxlength:30},
		mobile:{required:true,minlength:10,maxlength:10,number: true},
		email: {required: true,email: true,maxlength:30},
		message: {required: true,maxlength:255},
		subject: {required: true,maxlength:50},
		interest_in: {required:true},
	},
	messages: {
	},
	errorPlacement: function(error, element) {
		 error.appendTo(element.next());
	},ignore: ":hidden",
	submitHandler: function(form) {
		var response = grecaptcha.getResponse();
		if(response.length == 0) {
			alert("Robot verification failed, please try again.");
		}
		else {
			jQuery('.loading-all').show();
			form.submit();
		}
	}
});
});

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
</script>
</body></html>