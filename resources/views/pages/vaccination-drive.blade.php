@extends('layouts.Masters.Master')
@section('title', 'Health Gennie | Book Doctor Appointments')
@section('description', 'Book Appointment with doctors by Health Gennie. Order Medicine and lab from the comfort of your home. Read about health issues and get solutions.')
@section('content')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<div class="container wrapper-appoint">
    <div id="AppointmentWrapper" class="container-inner slot-details NewtestNew">
		 <div class="doctor-listtop doctor-listtop2 ap-section-new RegistrationFeeTop VaccinationDriveSection">
           <img class="vaccination-driveTop" src="{{ URL::asset('img/vaccination-drive-image.jpg') }}" />

		 </div>

		 <div class="from-widget-top from-widget-topnew">
        {!! Form::open(array('route' => 'vaccinationDrive', 'action' => route('vaccinationDrive'), 'method' => 'POST', 'id' => 'vaccinationDrive')) !!}
				 <div class="form-fields from-widget PatientDetails">
						 <div class="ThisAppointment">
				              <h2>Register Here</h2>
						<div class="form-fields from-widget-section">
							 <label>Full Name<i class="required_star">*</i></label>
							 <input type="text" name="name" placeholder="Full Name..." value="" />
							 <span class="help-block"></span>
						 </div>
             <div class="form-fields from-widget-section">
              <label>Mobile Number <i class="required_star">*</i></label>
              <input class="NumericFeild" type="text" name="mobile_no" placeholder="Mobile Number..." value="" />
              <span class="help-block"></span>
            </div>
            <div class="form-fields from-widget-section gender">
             <label>Dose Type<i class="required_star">*</i></label>
             <div class="radio-wrap radioBtn">
             <input type="radio" name="dose_type" id="dose_type1" value="First Dose" >
             <label for="dose_type1">First Dose</label>
             </div>
             <div class="radio-wrap">
             <input type="radio" name="dose_type" id="dose_type2" value="Second Dose">
             <label for="dose_type2">Second Dose</label>
             </div>
             <span class="help-block"></span>
           </div>
           <div class="form-fields from-widget-section">
            <label>No. Of Person (who want vaccination) <i class="required_star">*</i></label>
            <input class="NumericFeild" type="number" min="0" name="persons" placeholder="No. Of Person..." value="" />
            <span class="help-block"></span>
          </div>
          <div class="form-fields from-widget-section">
            <label>Preferred Date<i class="required_star">*</i></label>
            <div class="date-formet-section">
            <input type="text" class="form-control PreferredDate" name="preferred_date"  placeholder="Preferred Date" readonly />
            <i class="fa fa-calendar datepicker" aria-hidden="true"></i>
            </div>
            <span class="help-block"></span>
          </div>
            <div class="form-fields form-group addressSecion">
             <label>Address <i class="required_star">*</i></label>
             <textarea class="form-control" name="address" rows="2" id="address"></textarea>
             <span class="help-block"></span>
           </div>
           <div class="write-us-submit">
             <div class="g-recaptcha" data-sitekey="6Le6KYoUAAAAAOBx_xpvhxYYH2qE3HN92bjSz6IR"></div>
             <div class="loding" style="display:none;"><img src="{{ URL::asset('img/turningArrow.gif') }}" /></div>
           </div>
						 </div>
				</div>
					<div class="from-widget-btn">
						<button type="submit" class="btn btn-default subbtn" >Submit</button>
            <div class="success-data" style="display:none;"></div>
					 </div>
			{!! Form::close() !!}
			 </div>

	</div>
</div>
<script>
jQuery(document).ready(function () {
  $( ".PreferredDate" ).datepicker({
  	dateFormat: 'dd-MM-yy',
    minDate: 0,
  	// maxDate: 0,
  	// changeMonth: true,
    // changeYear: true,
    yearRange: '2021:2022',
   });
   $('.datepicker').click(function(){
       $(document).ready(function(){
           $(".PreferredDate").datepicker().focus();
       });
   });
});
jQuery("#vaccinationDrive").validate({
  rules: {
    name:  {required:true,minlength:3,maxlength:50},
    mobile_no:{required:true,minlength:10,maxlength:10,number: true},
    dose_type: {required: true},
    persons: {required:true,number: true},
    persons: {required:true},
    preferred_date: {required: true},
  },
  messages: {
  },
  errorPlacement: function(error, element) {
     error.appendTo(element.closest('.form-fields').find('.help-block '));
    },ignore: ":hidden",
  submitHandler: function(form) {
    var response = grecaptcha.getResponse();
    var test = 1;
    if(response.length == 0) {
    //if(test == 0) {
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
                $("#vaccinationDrive")[0].reset();
                $.alert({
                  title: 'Success !',
                  content: 'Thank you for vaccination registration',
                  draggable: false,
                  type: 'green',
                  typeAnimated: true,
                  buttons: {
                      ok: function(){
                        location.reload();
                      },
                  }
                });
              }
              else {
                $.alert({
                  title: 'Alert !',
                  content: 'Oops Something goes Wrong',
                  draggable: false,
                  type: 'red',
                  typeAnimated: true,
                  buttons: {
                      ok: function(){
                      location.reload();
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
