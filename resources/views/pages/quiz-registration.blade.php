<!DOCTYPE html><html lang="en"> 
<body class="home quiz-registration">
<head class="top-navbaar float-panel">
<title>Health Assessment By Health Gennie</title>
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
  	<h2>Health <span>Assessment</span></h2>
	<p class="helth_para">Wouldn't it be interesting to learn how much we understand ourselves during our busy schedules? Assessing oneself is quite a fun part of this activity to know about our moods and behaviors in a way no one can. Indulge yourselves in a health assessment to get the "definition of you".</p>
    </div>
	<form action="{{ route('QuizRegistration', ['slug' => $slug]) }}" method="POST" id="mediacl-form"> 
		{!! csrf_field() !!}
	<input type="hidden" value="{{base64_encode($oid)}}" name="oid" placeholder="Enter Full Name" />
    <h3>Profile Details</h3>
    <div class="QuizRegistration">
        <div class="form-fields">
          <label>Institue Id<i class="required_star">*</i></label>
          <input type="text" value="" name="institute_id" placeholder="Enter Institute ID" />
          <span class="help-block">
			@if($errors->has('institute_id'))
			<label for="institute_id" generated="true" class="error">
				 {{ $errors->first('institute_id') }}
			</label>
			@endif
		  </span>
        </div>
		<div class="form-fields">
          <label>Your Name<i class="required_star">*</i></label>
          <input type="text" value="" name="name" placeholder="Enter Full Name" />
          <span class="help-block">
			@if($errors->has('name'))
			<label for="name" generated="true" class="error">
				 {{ $errors->first('name') }}
			</label>
			@endif
		  </span>
        </div>
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
          <label>Age<i class="required_star">*</i></label>
          <input type="text" value="" name="age" class="NumericFeild" placeholder="Your Age" />
		  <span class="help-block">
			@if($errors->has('age'))
			<label for="age" generated="true" class="error">
				 {{ $errors->first('age') }}
			</label>
			@endif
		  </span>
        </div>

		<div class="form-fields">
          <label>Class<i class="required_star">*</i></label>
		 <select id="class" name="class">
			<option value="1">8th</option>
			<option value="2">9th</option>
			<option value="3">10th</option>
			<option value="4">11th</option>
			<option value="5">12th</option>
		</select>
		  <span class="help-block">
			@if($errors->has('class'))
			<label for="class" generated="true" class="error">
				 {{ $errors->first('class') }}
			</label>
			@endif
		  </span>
        </div>

		<div class="form-fields">
          <label>Subject<i class="required_star">*</i></label>
       	<select id="subject" name="subject">
			<option value="1">JEE</option>
			<option value="2">NEET</option>
		</select>
		  <span class="help-block">
			@if($errors->has('subject'))
			<label for="subject" generated="true" class="error">
				 {{ $errors->first('subject') }}
			</label>
			@endif
		  </span>
        </div>

		<div class="form-fields pad-r0 gender">
		  <label>Gender<i class="required_star">*</i></label>
		  <div class="radio-wrap">
			<input type="radio" name="gender" id="male" value="Male"/>
			<label for="male">Male</label>
		  </div>
		  <div class="radio-wrap">
			<input type="radio" name="gender" id="female" value="Female"/>
			<label for="female">Female</label>
		  </div>
		  <div class="radio-wrap">
			<input type="radio" name="gender" id="other" value="Other"/>
			<label for="other">Other</label>
		  </div>
		  <span class="help-block"><label for="gender" generated="true" class="error" style="display:none;">This field is required.</label></span>
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
		institute_id: {required:true},
		name:  {required:true,minlength:2,maxlength:30},
		mobile:{required:true,minlength:10,maxlength:10,number: true},
		age: {required: true},
		gender: {required: true},
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
</body></html>