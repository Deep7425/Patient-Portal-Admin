@extends('layouts.Masters.Master')
@section('title', 'Corporate | Health Gennie')
@section('description', "Corporate")
@section('content') 
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<h1 style="display:none;">Corporate</h1>

<div class="main-banner-corporate">
	<img src="{{ URL::asset('images/corporate-banner.jpg') }}" />
</div>

<div class="corporate-mobile-banner">
<img src="{{ URL::asset('images/mobile-banner-corporate.jpg') }}" />
</div>
<div class="banner-corporate">
    <div class="container-fluid">
        <div class="container">
            <h2>Health Gennie for Corporates</h2>
            <h4>Secure your employees health. For more information connect with us</h4>
        
        <div class="form-banner">
 @if (Session::has('message'))	
  <div class="alert alert-info sessionMsg">{{ Session::get('message') }}</div>
  @endif
  <div class="container-inner contact-wrapper plasma-wrapper">
   @php $slug = basename($_SERVER['REQUEST_URI']); @endphp
    {!! Form::open(array('route' => 'corporate','method' => 'POST', 'id' => 'corporate')) !!}
        <div class="form-fields">
          <label>Your Name<i class="required_star">*</i></label>
          <input type="hidden" value="{{$slug}}" name="qry_from" />
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
          <label>E-mail</label>
          <input type="text" value="" name="email" placeholder="Your Email" />
          <span class="help-block">
			@if($errors->has('email'))
			<label for="email" generated="true" class="error">
				 {{ $errors->first('email') }}
			</label>
			@endif
		  </span>
        </div>
		<div class="form-fields">
          <label>Organization Name<i class="required_star">*</i></label>
          <input type="text" value="" name="org_name" placeholder="Your Organization" />
          <span class="help-block">
			@if($errors->has('org_name'))
			<label for="org_name" generated="true" class="error">
				 {{ $errors->first('org_name') }}
			</label>
			@endif
		  </span>
        </div>
		<div class="form-fields">
          <label>Organization Size<i class="required_star">*</i></label>
		  <select name="org_size">
			<option value="">Select Organization</option>
			<option value="1"><=10</option>
			<option value="2">10-100</option>
			<option value="3">101-200</option>
			<option value="4">201-500</option>
			<option value="5">500+</option>
		  </select>
          <span class="help-block">
			@if($errors->has('org_size'))
			<label for="org_size" generated="true" class="error">
				 {{ $errors->first('org_size') }}
			</label>
			@endif
		  </span>
        </div>
		<div class="form-fields button-contact text-right">
			<input type="submit" id="submit" value="Submit" />
			<div class="success-data" style="display:none;"></div>
		  </div>
		<div>
		  <div class="write-us-submit">
			<div class="g-recaptcha" data-sitekey="6Le6KYoUAAAAAOBx_xpvhxYYH2qE3HN92bjSz6IR"></div>
			<div class="loding" style="display:none;"><img src="{{ URL::asset('img/turningArrow.gif') }}" /></div>
		  </div>
		  
		  {!! Form::close() !!}
		</div>
  </div>

</div>
	</div>


    </div>

</div>


<div class="choose-hg">
<div class="container">
	<h2>Choose the best  care for  your employees</h2>

<ul>
	<li><img src="{{ URL::asset('images/access.png') }}" /> <span>Access <br>Anywhere</span></li>
	<li><img src="{{ URL::asset('images/consultation.png') }}" /> <span>Affordable <br>consultation</span></li>
	<li><img src="{{ URL::asset('images/support-2.png') }}" /> <span>24/7 online doctor<br> consultations </span></li>
	<li><img src="{{ URL::asset('images/support.png') }}" /> <span>Health counselling <br>support</span></li>
	<li><img src="{{ URL::asset('images/deal.png') }}" /> <span>Exclusive<br> Deals</span></li>
	<li><img src="{{ URL::asset('images/call.png') }}" /> <span>Doctor call in<br> 5 mins</span></li>
</ul>
	 

</div></div>

<div class="why-hg">
<div class="container">
	<div class="why-hg-left">
    <h2>Why Health Gennie Corporate Health Plans?</h2>
	<ul>
		<li>Single destination for complete healthcare—Doctors, Online Consultations.</li>
		<li>24*7 Customer support for employees and their families.</li>
		<li>Better employee engagement through personalized health articles, and more.</li>
		<li>Dedicated key account manager to chart out the wellness calendar.</li>
		<li>Online Health Record and digital prescription by doctor. </li>
		<li>High adoption rates with easy implementation process.</li>
	</ul>
    </div>
	 <div class="why-hg-right" ><img src="{{ URL::asset('images/why-hg.jpg') }}" /></div>
 
</div></div>
<!--<div class="why-hg">
<div class="container">
<div class="CorporateHealthcareServicesTOp">
<div class="CorporateHealthcareServicesImg">
<img src="{{ URL::asset('images/OurCorporateHealthcareServicesImg.jpg') }}" />
</div>
<div class="CorporateHealthcareServices">
        <h2>Our Corporate Healthcare Services</h2>
        <p>Since the onset of the Covid-19 pandemic, providing our employees with easy and timely access to healthcare has been a challenge. With physical appointments becoming difficult under current circumstances, the need for online Doctor consultation has been on the rise. Employees have become more conscious in choosing the healthcare benefits and the services provided by doctors.</p>
        <p>
In today's increasingly competitive environment, your employees can give the strategic edge in your business. We have a wide range of comprehensive employee solutions designed to protect and take care of the well-being of your most valuable asset - your employees.</p>
        <p>We bring you the peace of mind with our flexible and wide-ranging choice of Corporate Health cover. Our corporate health plans enable you to make choices that reflect both your life stage and budget, and they can be adjusted as required to meet your changing health needs @ any time.</p>
        <p>For corporates who require medical coverage online, our qualified General physicians / specialists can provide routine consultation and follow-ups for employees at their work place for fixed hours on pre-specified weekdays. </p>
    </div>
    </div>
	</div>
</div>-->

<div class="container-fluid">
	<div class="container"> 
		<section class="our-clients-section">
			<div class="blog-content Nextblog-content">
				<h3>Our Clients</h3>
                <p>We believe in turning clients into family and your Passion is our Satisfaction.</p>
                <a href="{{route('partners')}}"><button type="button" class="btn btn-default SeeAllClients">See All Clients</button></a>
            </div>
                
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
  	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script>
jQuery("#corporate").validate({
	rules: {
		name: {required:true,minlength:2,maxlength:30},
		mobile:{required:true,minlength:10,maxlength:10,number: true},
		// email: {required: true,maxlength:50},
		org_name: {required:true},
		org_size: {required:true},
	},
	messages: {},
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
@endsection