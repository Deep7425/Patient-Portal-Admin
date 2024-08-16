@extends('layouts.Masters.Master')
@section('title', 'Health Gennie | Book Doctor Appointments')
@section('description', 'Book Appointment with doctors by Health Gennie. Order Medicine and lab from the comfort of your home. Read about health issues and get solutions.')
@section('content')
<style>
body .top-navbaar {
    display: none !important;
}
.footer_top {
    display: none !important;
}
</style>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<div class="container wrapper-appoint">
    <div id="AppointmentWrapper" class="container-inner slot-details NewtestNew runnersLeadForm">
		 <!-- <div class="doctor-listtop doctor-listtop2 ap-section-new RegistrationFeeTop VaccinationDriveSection">
           <img class="vaccination-driveTop" src="{{ URL::asset('img/vaccination-drive-image.jpg') }}" />

		 </div> -->

		 <div class="from-widget-top from-widget-topnew">
        {!! Form::open(array('route' => 'runnersLead', 'action' => route('runnersLead'), 'method' => 'POST', 'id' => 'runnersLead')) !!}
				 <div class="form-fields from-widget PatientDetails">
						 <div class="ThisAppointment">
				      <h2>Fill Information Here <span class="todayDate">{{date('l')}}, {{date('d M Y')}}</span> </h2>
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

               <div class="form-group form-fields from-widget-section">
                 <label>App Download<i class="required_star">*</i></label>
                 <select name="app_download" class="form-control">
                   <option selected="selected" value="">Please Select</option>
                   <option value="Yes">Yes</option>
                   <option value="No">No</option>
                 </select>
                 <span class="help-block"></span>
               </div>
               <div class="form-group form-fields from-widget-section">
                 <label>Appointment<i class="required_star">*</i></label>
                 <select name="appointment" class="form-control">
                   <option selected="selected" value="">Please Select</option>
                   <option value="Yes">Yes</option>
                   <option value="No">No</option>
                 </select>
                 <span class="help-block"></span>
               </div>
               <div class="form-group form-fields from-widget-section">
                 <label>Plan Sold<i class="required_star">*</i></label>
                 <select name="plan_sold" class="form-control">
                   <option selected="selected" value="">Please Select</option>
                   <option value="Yes">Yes</option>
                   <option value="No">No</option>
                 </select>
                 <span class="help-block"></span>
               </div>
               <div class="form-group form-fields from-widget-section">
                 <label>Agent Name<i class="required_star">*</i></label>
                 <select name="created_by" class="form-control">
                   <option selected="selected" value="">Please Select</option>
                   @foreach (getSalesTeam() as $key => $user)
                     <option value="{{$user->id}}">{{$user->name}}</option>
                   @endforeach
                 </select>
                 <span class="help-block"></span>
               </div>
               <div class="form-fields form-group addressSecion">
                <label>Address <i class="required_star">*</i></label>
                <textarea class="form-control" name="address" rows="2" id="address"></textarea>
                <span class="help-block"></span>
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
jQuery("#runnersLead").validate({
  rules: {
    name:  {required:true,minlength:3,maxlength:50},
    mobile_no:{required:true,minlength:10,maxlength:10,number: true},
    address: {required: true},
    app_download: {required: true},
    appointment: {required: true},
    plan_sold: {required: true},
    created_by: {required:true},
  },
  messages: {
  },
  errorPlacement: function(error, element) {
     error.appendTo(element.closest('.form-fields').find('.help-block '));
    },ignore: ":hidden",
  submitHandler: function(form) {
    // var response = grecaptcha.getResponse();
    var test = 1;
    // if(response.length == 0) {
    if(test == 0) {
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
              if (data > 0) {
                $("#runnersLead")[0].reset();
                $.alert({
                  title: 'Success !',
                  content: '<div>Registration success...</div><div class="regCount">Total Registrations <span>'+data+'</span> </div>',
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
