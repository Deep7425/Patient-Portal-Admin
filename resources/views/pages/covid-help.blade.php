@extends('layouts.Masters.Master')
@section('title', 'Covid Help')
@section('content')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<!--
<div class="au-banner">
	<img src="{{ URL::asset('img/jaipur-marathon.jpg') }}" />
</div>
-->
 
<div class="au-banner">
    	<img class="deshtopBanner" src="{{ URL::asset('img/banner-inner.jpg') }}" />
<img class="MobileBannerTop" src="{{ URL::asset('img/banner-inner-mobile.jpg') }}" />
    </div>
<div class="container">

  <div class="container-inner contact-wrapper registration-wrapper EachOneHelpOne">
    <div class="errors-section">
      <ul class="ul-error">

      </ul>
    </div>
    <h2>each one help one</h2>
    <p class="gray">The same situation has come again where beds are not available in the Hospitals, Covid patients are increasing at an exorbitant pace, and businesses are getting closed and people again are struggling for their survival.</p>
    
 <p class="gray">Daily wages workers, dependents, people in tier3, tier 4 and villages are not able to travel to cities for treatments of Covid and non covid problems. </p>
 
 <p>We think its time to think about the survival and help mankind in atleast what each person should get to survive. We at Health Gennie has taken this initiative to help needy persons who are getting deprived on the Health care they need no matter where they are. With our slogan of <strong>EACH ONE HELP ONE</strong>, we have pledged to give our subscription of our Health care plan free of cost to such families who really need help in this difficult time. With every purchase of a subscription plan, one family will get a similar plan free of cost. You can choose a family of your choice or we can assign a family who is in dire need of such health care.</p>
    
    <p>With your small help, a family may survive this pandemic and help their children grow in an environment which they deserve. We want to help 10000 such families and each of your contribution can make a big difference. <br>To subscribe to a Health Gennie plan download the app from <a href="https://www.healthgennie.com/download" target="_blank">https://healthgennie.com/download</a></p>
    
    <h4> Plan start from only Rs. 599/-</h4>

            {!! Form::open(array('route' => 'covidHelp', 'action' => route('covidHelp'), 'method' => 'POST', 'id' => 'covidHelpForm')) !!}
        <div class="form-fields">
          <label>Your registered mobile number on Health Gennie</label>
          <input type="text" value="" class="NumericFeild" name="helper_no" placeholder="You registered mobile number on Health Gennie
" />
          <span class="help-block"></span>
        </div>
        <div class="form-fields">
          <label>Mobile number of a family who you want to help</label>
          <input type="text" value="" class="NumericFeild" name="target_no" placeholder="Mobile number of a family who you want to help" />
          <span class="help-block"></span>
        </div>
        <div class="col-sm-12" style=" padding:0px;">
          <div class="write-us-submit">
            <div class="g-recaptcha" data-sitekey="6Le6KYoUAAAAAOBx_xpvhxYYH2qE3HN92bjSz6IR"></div>
            <div class="loding" style="display:none;"><img src="{{ URL::asset('img/turningArrow.gif') }}" /></div>
          </div>
          <div class="btn-register">
                <div class="button-contact text-right">
                  <input type="submit" id="submit" value="Send" />
                  <div class="success-data" style="display:none;"></div>
                </div>
          </div>
        </div>
        {!! Form::close() !!}

        
        <!-- <div class="col-sm-12">
          <div class="au-terms-condi-section">
              <h3><strong>Terms & Conditions</strong></h3>
            <div class="au-terms-conditions">
              <p>1.	Health Gennie will provide free entry and kit for only Dream Run category (6 K.M).</p>
              <p>2. Dream Run will start from Albert Hall at 6:30 am and will end at WTP.</p>
              <p>3.	You must show the Health Gennie app on your phone while collecting the Kit.</p>
              <p>4.	You must collect the Kit from Diggi Palace, Jaipur on 31st  Jan or 1st Feb 2020.</p>
              <p>5.	First 500 entries will get the free kit. </p>
              <p>6.	To download the Health Gennie app visit healthgennie.com/download or search <strong>Health Gennie – Healthcare at Home</strong> on Play Store and App Store. </p>
              <p>7.	Health Gennie holds the right to cancel any registration entry based on situations. </p>
              <p>8.	All rights regarding registration through health gennie are reserved by Health Gennie. </p>
            </div>
          </div>
        </div> -->

  </div>
</div>
<div class="container-fluid">
  <div class="container"> </div>
</div>
<script>
jQuery(document).ready(function () {
  $( ".DOB" ).datepicker({
  	dateFormat: 'dd-MM-yy',
  	maxDate: 0,
  	changeMonth: true,
    changeYear: true,
    yearRange: '1950:2020',
   });
});
	jQuery("#covidHelpForm").validate({
		rules: {
      helper_no:{required:true,minlength:10,maxlength:10,number: true},
			target_no:{minlength:10,maxlength:10,number: true}
		},
		messages: {
		},
		errorPlacement: function(error, element) {
			 error.appendTo(element.closest('.form-fields').find('.help-block '));
		  },ignore: ":hidden",
		submitHandler: function(form) {
      var response = grecaptcha.getResponse();
      var test = 1;
      if(test == 0) {
        // if(response.length == 0) {
				alert("Robot verification failed, please try again.");
			 }
			else {
				jQuery('.loading-all').show();
        // jQuery('#submit').attr('disabled',true);
        jQuery.ajax({
        type: "POST",
        dataType : "JSON",
        url: $(form).attr('action'),
        data:  new FormData(form),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data)
            {
              // console.log(data);
              jQuery('.loading-all').hide();
              if (data.status == 0) {
                  $('.errors-section .ul-error li').remove()
                $.each(data.error, function(k, v) {
                  var li = "<li>"+v+"</li>"
                  $('.errors-section .ul-error').append(li)
              });
              }
              else{
                if (data == 1) {
                  $("#covidHelpForm")[0].reset();
                  $.alert({
                    title: 'Success !',
                    content: 'Thank you for registered',
                    draggable: false,
                    type: 'green',
                    typeAnimated: true,
                    buttons: {
                        ok: function(){
                          window.location = "{{ route('index') }}";
                        },
                    }
                  });
                }
              }

           },
            error: function(error)
            {
              if(error.status == 401)
              {
                  alert("Session Expired,Please logged in..");
                  location.reload();
              }
              else
              {
                jQuery('.loading-all').hide();
                alert("Oops Something goes Wrong.");
                jQuery('#submit').attr('disabled',false);
              }
            }
         });

			}
		}
	});
	</script>
@endsection
