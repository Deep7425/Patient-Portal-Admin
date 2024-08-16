@extends('layouts.Masters.Master')
@section('title', 'Contact Us | Health Gennie')
@section('description', "Have questions about Health Gennie's products, support services, or anything else? Let us know, we would be happy to answer your questions & set up a meeting with you.")	
@section('content') 
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="container">
		<form method="POST" action="{{route('patientFeedbacksave')}}" accept-charset="UTF-8" id="feedback-form" class="clinic-details" data-gtm-form-interact-id="1"> @csrf
		<input type="hidden" value="{{$RandId}}" name="randomid">
		<div class="modal-header forfeedback1234">
		  <h2>Patient Feedback Form</h2>
		    @if (session('message'))
				<div class="alert alert-success text-center">
					{{ session('message') }}
				</div>
            @endif
		  <span>Your experience will help over many people choose the right Doctor.</span>
		</div>
		 <div class="modal-body forfeedback">
				 <div class="doctor-listtop doctor-listtop2">
					<div class="doctor-listtop-img">
                        <p>
                            Dear Patient / Relative / Visitor,
                            Your continuing suggestions &amp; feedback help to make our Hospital a better organization. Kindly spare a
                            few moments to complete the following, so that we can strive to fulfill your expectations.
                            <br>
                            

                        </p>
					</div>
                    <div class="scroller">
                    <div class="form-fields">
                    	<p style="margin: 0px; padding: 0px 0px 5px;">Warm Regards,</p>
                    	<strong>Dr. Chandra Kishore Sharma</strong>
                    </div>
					<div class="form-fields form-field-mid pad-r1 form-group">
						  <label>Would you recommend this professional?<i class="required_star">*</i></label>
								<div class="recommend-field form-control">
									<input type="radio" id="radio-one" name="recommendation" value="1" checked="" data-gtm-form-interact-field-id="3">
									<label for="radio-one">Yes</label>
									<input type="radio" id="radio-two" name="recommendation" value="0" data-gtm-form-interact-field-id="2">
									<label for="radio-two">No</label>
								</div>
								   @if ($errors->has('recommendation'))
                                <li class="text-danger">{{ $errors->first('recommendation') }}</li>
                                    @endif
								<span class="help-block"><label for="recommendation" generated="true" class="error" style="display:none;"></label></span>




					</div>

					<div class="form-fields form-field-mid pad-r1 form-group">
					  <label>How long was the wait time in the office before you were seen?<i class="required_star">*</i></label>
						<div class="waitingTime form-control">
							<p>
						    <input type="radio" id="test1" value="1" name="waiting_time" checked="">
						    <label for="test1">Less than 5 min</label>
						  </p>
						  <p>
						    <input type="radio" id="test2" value="2" name="waiting_time">
						    <label for="test2">5 min to 10 min</label>
						  </p>
						  <p>
						    <input type="radio" id="test3" value="3" name="waiting_time">
						    <label for="test3">10 min to 30 min</label>
						  </p>
						 <p>
							<input type="radio" id="test4" value="4" name="waiting_time">
							<label for="test4">30 min to 1 hour</label>
						</p>
						<p>
						 <input type="radio" id="test5" value="5" name="waiting_time">
						 <label for="test5">More than 1 hour</label>
					 </p>
					 	<span class="help-block"></span>
						 @if ($errors->has('waiting_time'))
                                <li class="text-danger">{{ $errors->first('waiting_time') }}</li>
                         @endif
						</div>


					 	<div class="tooltip"><i class="fa fa-question-circle-o" aria-hidden="true"></i>
							<span class="tooltiptext">5 Stars : Right Away
								<br>4 Stars : Less than 30 minutes<br>3 Stars : Between 30 and 60 minutes<br>2 Stars : Over an hour
								<br>1 Stars : Over 2 hours!
							</span>
						</div>
						
					</div>

					<div class="form-fields form-field-mid pad-r1 form-group">
					  <label>Reason to visit?<i class="required_star">*</i></label>
						<div class="form-control">
							<select name="visit_type">
								<option value="">Select Reason</option>
								<option value="1">Consultation</option>
								<option value="2">Procedure</option>
								<option value="3">Follow up</option>
							</select>
							<span class="help-block"></span>
							
						</div>
						 @if ($errors->has('visit_type'))
                                <li class="text-danger">{{ $errors->first('visit_type') }}</li>
                         @endif
					</div>

					<div class="form-fields form-field-mid pad-r1 form-group">
					  <label>Compliment</label>
						<div class="checkbox-wrapper">
							<div class="form-control complimentCheckBox">
								<input type="checkbox" id="comple1" name="suggestions[]" value="1">
								<label for="comple1">Quality of Medical Care</label>

								<input type="checkbox" id="comple2" name="suggestions[]" value="2">
								<label for="comple2">Staff Assistance/ Support</label>

								<input type="checkbox" id="comple3" name="suggestions[]" value="3">
								<label for="comple3">Caring &amp; Compassionate</label>

								<input type="checkbox" id="comple4" name="suggestions[]" value="4">
								<label for="comple4">Outstanding Customer Service</label>

								<input type="checkbox" id="comple5" name="suggestions[]" value="5">
								<label for="comple5">Timely Problem/ Issue Resolution</label>

								<input type="checkbox" id="comple6" name="suggestions[]" value="6">
								<label for="comple6">Superior Facilities</label>
							</div>

						</div>
							 @if ($errors->has('suggestions'))
                                <li class="text-danger">{{ $errors->first('suggestions') }}</li>
                            @endif
					</div>


					<div class="form-fields form-field-mid pad-r1 form-group">
					  <label>How would you rate this professional’s bedside manner?<i class="required_star">*</i></label>
					  <div class="star-rate-div form-control">
						<input type="radio" id="rating5" name="rating" value="5" checked="">
						<label for="rating5" title="5 star"></label>
						<input type="radio" id="rating4" name="rating" value="4">
						<label for="rating4" title="4 star"></label>
						<input type="radio" id="rating3" name="rating" value="3">
						<label for="rating3" title="3 star"></label>
						<input type="radio" id="rating2" name="rating" value="2">
						<label for="rating2" title="2 star"></label>
						<input type="radio" id="rating1" name="rating" value="1">
						<label for="rating1" title="1 star"></label>
					  </div>

					 	<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							<span class="tooltiptext">5 Stars : Excellent
								<br>4 Stars : Good<br>3 Stars : Satisfactory<br>2 Stars : Unsatisfactory
								<br>1 Stars : Awful!
							</span>
						
					  <span class="help-block"></span>
					   @if ($errors->has('rating'))
                                <li class="text-danger">{{ $errors->first('rating') }}</li>
                            @endif
					</div>

					<div class="form-fields form-field-mid pad-r1 form-group">
					  <label>What did you think about your visit?<i class="required_star">*</i></label>
					  <div class="form-control">
						<textarea name="experience" class="" placeholder="Experience" cols="10"></textarea>
						<span class="help-block"></span>
					  </div>
					  <span class="help-block"></span>
					    @if ($errors->has('experience'))
                                <li class="text-danger">{{ $errors->first('experience') }}</li>
                            @endif
					</div>

					<div class="form-fields form-field-mid pad-r1 form-group">
					  <div class="form-control">
						<label><input style="margin-top: 3px;" type="checkbox" name="publish_status" value="1">Make it publicly unidentified.</label>
						<p><strong>Note:</strong> Doctor can access identity, if required.</p>
					  </div>
					  <span class="help-block"></span>
					</div>

				 </div>
				<div class="slotsMainDiv tab-content"></div>
		  </div>
          </div>
		  <div class="modal-footer">
			<button name="submit" type="submit" class="btn btn-default feedback-form-submit">Save</button>
			<button type="reset" class="btn btn-default">Clear</button>
		  </div>
		 </form>
		</div>
<div class="container-fluid">
  <div class="container"> </div>
</div>
<script>


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
	</script> 
@endsection 