<!DOCTYPE html><html lang="en"> 
<body class="home quiz-registration">
<head class="top-navbaar float-panel">
<title>Health Assessment By Health Gennie</title>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<meta name="description" content="To learn more about your well-being, participate in this health assessment here."/>
<meta name="keywords" content="health assessment, self health assessment, health impact assessment, health needs assessment"/>
<link rel="preload" as="style" href="/patient_portal_live/css/assets/bootstrap/css/bootstrap.min.css" media="all" type="text/css" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="/patient_portal_live/css/assets/bootstrap/css/bootstrap.min.css"></noscript>
<link rel="preload" as="style" href="/patient_portal_live/css/homestyle.css" type="text/css" media="all" onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="/patient_portal_live/css/homestyle.css"></noscript>
<link rel="shortcut icon" href="/patient_portal_live/img/favicon.ico"/>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WCSD8NM');</script>
<!-- End Google Tag Manager -->
<link rel="preload" as="style" href="/patient_portal_live/css/style.css?v=12" type="text/css" media="all"  onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="/patient_portal_live/css/style.css?v=12"></noscript>
<link rel="preload" as="style" href="/patient_portal_live/css/common.css?v=12" type="text/css" media="all"  onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="/patient_portal_live/css/common.css?v=12"></noscript>
<link rel="preload" as="style" href="/patient_portal_live/css/fonts/font-awesome.min.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="/patient_portal_live/css/fonts/font-awesome.min.css"></noscript>
<link rel="preload" as="style" href="/patient_portal_live/css/fonts/font_google.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="/patient_portal_live/css/fonts/font_google.css"></noscript>
<link rel="preload" as="style" href="/patient_portal_live/css/fonts/font_family.css" media="all" defer async onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" href="/patient_portal_live/css/fonts/font_family.css"></noscript>
<script src="/patient_portal_live/css/assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript" rel="preload"></script>
<script src="/patient_portal_live/js/bootstrap.min.js" type="text/javascript" async ></script>
<script src="/patient_portal_live/js/jquery.validate.js" type="text/javascript" ></script>
<script src="/patient_portal_live/js/cookieMin.js" type="text/javascript" ></script>
<meta content="width=device-width, initial-scale=1" name="viewport" />
<link rel="stylesheet" as="style" href="/patient_portal_live/css/fonts/font-awesome.min.css" media="all" defer="" async="" onload="this.onload=null;this.rel='stylesheet'">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class=""> 
<div class="container"> @if (Session::has('message'))
  <div class="alert alert-info sessionMsg">{{ Session::get('message') }}</div>
  @endif
  <div class="container-inner contact-wrapper contact-us medical-form medical-form123">
  	<div class="left-data-content">
  	<h2>Patient <span>Feedback</span></h2>
	
    </div>
	<form action="{{ route('addfeedback') }}" method="POST" id="mediacl-form"> 
		{!! csrf_field() !!}

    <h3>Feedback Details</h3>
    
	<h3>Patient Name : Kumawat Singh</h3>

    <div class="QuizRegistration">
        <div class="form-fields">
          <label>Rating<i class="required_star">*</i></label>
		  <select id="class" name="hg_rating">
		  <option value="">Please Select Rating</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
        </div>
		<!-- <div class="form-fields">
          <label>Your Name<i class="required_star">*</i></label>
          <input type="text" value="" name="name" placeholder="Enter Full Name" />
          <span class="help-block">
			@if($errors->has('name'))
			<label for="name" generated="true" class="error">
				 {{ $errors->first('name') }}
			</label>
			@endif
		  </span>
        </div> -->
        <div class="form-fields">
          <label>Feedback<i class="required_star">*</i></label>
		  <textarea name="counselor_feedback" id="editor1"></textarea>
          <span class="help-block">
			@if($errors->has('mobile'))
			<label for="mobile" generated="true" class="error">
				 {{ $errors->first('mobile') }}
			</label>
			@endif
		  </span>
        </div>
		<div class="form-fields">
          <label>Quality<i class="required_star"></i></label>
          <input type="text" value="" name="quality" class="NumericFeild" placeholder="Your Quality" />
		  <span class="help-block">
			@if($errors->has('age'))
			<label for="age" generated="true" class="error">
				 {{ $errors->first('age') }}
			</label>
			@endif
		  </span>
        </div>

		<div class="form-fields">
          <label>Content<i class="required_star"></i></label>
		  <input type="text" value="" name="content" class="NumericFeild" placeholder="Your Content" />
		  <span class="help-block">
			@if($errors->has('class'))
			<label for="class" generated="true" class="error">
				 {{ $errors->first('class') }}
			</label>
			@endif
		  </span>
        </div>


	
	
    	<div class="form-submit">
			<div class="write-us-submit">
				<div  ></div>
				<div class="loding" style="display:none;"><img src="{{ URL::asset('img/turningArrow.gif') }}" /></div>
			</div>
          <div class="button-contact text-right">
            <input type="submit" id="submit" value="Submit" />
            <div class="success-data" style="display:none;"></div>
          </div>
		</div>
		</div>
	</form>
  </div>
</div>
<div class="container-fluid">
  <div class="container"> </div>
</div>
<script>
jQuery("#mediacl-form").validate({
	rules: {
		counselor_feedback: {required:true},
		hg_rating: {required:true},
		
		
		
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



</script>
<script>
  CKEDITOR.replace( 'editor1' );
</script>
</body></html>