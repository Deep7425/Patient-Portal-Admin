@extends('layouts.Masters.Master')
@section('title', 'Plasma Donation | Health Gennie')
@section('description', "If you have recovered from COVID and are interested in Plasma Donation then please contact us via query form, and we will get back to you.")
@section('content') 
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<h1 style="display:none;">Plasma Donation</h1>
<div class="container"> @if (Session::has('message'))
  <div class="alert alert-info sessionMsg">{{ Session::get('message') }}</div>
  @endif
  <div class="container-inner contact-wrapper plasma-wrapper">
    <h2>Plasma Donation</h2>
    {!! Form::open(array('route' => 'donatePlasma','method' => 'POST', 'id' => 'plasama')) !!}
    <div class="form-fields">
      <label>Blood Group<i class="required_star">*</i></label>
	  <select class="form-control" name="blood_group">
		<option value="">Select</option>
		<option value="o+">O+</option>
		<option value="o-">O-</option>
		<option value="A+">A+</option>
		<option value="A-">A-</option>
		<option value="B+">B+</option>
		<option value="B-">B-</option>
		<option value="AB+">AB+</option>
		<option value="AB-">AB-</option>
	  </select>
      <span class="help-block">
		@if($errors->has('blood_group'))
		<label for="blood_group" generated="true" class="error">
			 {{ $errors->first('blood_group') }}
		</label>
		@endif
	  </span> </div>
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
          <label>State<i class="required_star">*</i></label>
           <select class="form-control state_id multiSelect" name="state">
			  <option value="">Select State</option>
				@foreach (getStateList(101) as $state)
					<option value="{{ $state->id }}" @if($state->id == '33') selected @endif >{{ $state->name }}</option>
				@endforeach
		   </select>
          <span class="help-block">
			@if($errors->has('state'))
			<label for="state" generated="true" class="error">
				 {{ $errors->first('state') }}
			</label>
			@endif
		  </span>
        </div>
		<div class="form-fields">
          <label>City<i class="required_star">*</i></label>
		  <select class="form-control city_id multiSelect" name="city">
			<option value="">Select City</option>
			@foreach (getCityList(33) as $city)
				<option value="{{ $city->id }}" @if($city->id == '3378') selected @endif >{{ $city->name }}</option>
			@endforeach
		  </select>
          <span class="help-block">
			@if($errors->has('city'))
			<label for="city" generated="true" class="error">
				 {{ $errors->first('city') }}
			</label>
			@endif
		  </span>
        </div>
		
        <!-- <div class="form-fields">
          <label>Your Message(Max: 255 Character)<i class="required_star">*</i></label>
          <textarea name="message" placeholder="Enter Your Message"></textarea>
          <span class="help-block">
			@if($errors->has('message'))
			<label for="message" generated="true" class="error">
				 {{ $errors->first('message') }}
			</label>
			@endif
		  </span>
        </div> -->
    <div class="">
          <div class="write-us-submit">
            <div class="g-recaptcha" data-sitekey="6Le6KYoUAAAAAOBx_xpvhxYYH2qE3HN92bjSz6IR"></div>
            <div class="loding" style="display:none;"><img src="{{ URL::asset('img/turningArrow.gif') }}" /></div>
          </div>

          <div class="button-contact text-right">
            <input type="submit" id="submit" value="Submit" />
            <div class="success-data" style="display:none;"></div>
          </div>

      {!! Form::close() !!}
      
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="container"> </div>
</div>

<script>

	jQuery("#plasama").validate({
		rules: {
			name:  {required:true,minlength:2,maxlength:30},
			mobile:{required:true,minlength:10,maxlength:10,number: true},
			subject: {required: true,maxlength:50},
			blood_group: {required:true},
			city: {required:true},
			state: {required:true},
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

jQuery(document).on("change", ".state_id", function (e) {
	  var cid = this.value;
	  var $el = jQuery('.city_id');
	  $el.empty();
	  jQuery.ajax({
		  url: "{!! route('getCityList') !!}",
		  // type : "POST",
		  dataType : "JSON",
		  data:{'id':cid},
		  success: function(result){
		  jQuery("#plasama").find("select[name='city_id']").html('<option value="">Select City</option>');
		  jQuery.each(result,function(index, element) {
			  $el.append(jQuery('<option>', {
				 value: element.id,
				 text : element.name
			  }));
		  });
	  }}
	  );
});
jQuery(document).ready(function(){
$(".multiSelect").select2();
});
	</script> 
@endsection 