@extends('layouts.Masters.Master')
@section('title', 'Mental Health Assessment | Health Gennie')
@section('description', "Have questions about Health Gennie's products, support services, or anything else? Let us know, we would be happy to answer your questions & set up a meeting with you.")	
@section('content') 
<div class="container"> @if (Session::has('message'))
  <div class="alert alert-info sessionMsg">{{ Session::get('message') }}</div>
  @endif
  <div class="container-inner contact-wrapper contact-us medical-form">
    <h2>Mental Health Assessment</h2>
    <p></p>
    {!! Form::open(array('route' => 'healthAsses','method' => 'POST', 'id' => 'mediacl-form')) !!}
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
		
		
		 <div class="panel">
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 1.</span>Overall, how would you rate your physical health?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_1" value="1" id="q11"/><label for="q11" class="opt1">Excellent</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_1" value="2" id="q12"/><label for="q12" class="q12">Good</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_1" value="3" id="q13"/><label for="q13" class="q13">Average</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_1" value="4" id="q14"/><label for="q14" class="q14">Poor</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 2.</span> Overall, how would you rate your mental health?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_2" value="1" id="q21"/><label class="opt1" for="q21">Excellent</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_2" value="2" id="q22"/><label class="opt2" for="q22">Good</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_2" value="3" id="q23"/><label class="opt3" for="q23">Average</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_2" value="4"  id="q24"/><label class="opt4" for="q24">Poor</label></div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 3.</span> During the past 4 weeks, have you had any problems with your work or daily life due to your physical health?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_3" value="4" id="q31"/><label  for="q31" class="opt1">Yes</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_3" value="3" id="q32"/><label  for="q32"  class="q32">Sometimes</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_3" value="2" id="q33"/><label  for="q33"  class="q33">Not sure</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_3" value="1" id="q34" /><label  for="q34"  class="q34">No</label></div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 4.</span> During the past 4 weeks, have you had any problems with your work or daily life due to any emotional problems, such as feeling depressed, sad or anxious? 
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_4" value="4" id="q41"/><label  for="q41" class="opt1">Yes</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_4" value="3" id="q42"/><label  for="q42" class="opt2">Sometimes</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_4" value="2" id="q43"/><label  for="q43" class="opt3">Not sure</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_4" value="1" id="q44"/><label  for="q44" class="opt4">No</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 5.</span> Have you felt particularly low or down for more than 2 weeks in a row?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_5" value="4" id="q51"/><label  for="q51" class="opt1">Very often</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_5" value="3" id="q52"/><label  for="q52" class="opt2">Somewhat often</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_5" value="2" id="q53"/><label  for="q53" class="opt3">Not so often</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_5" value="1" id="q54"/><label  for="q54" class="opt4">Not at all</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 6.</span> Have you noticed any change in your diet habits?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_6" value="4" id="q61"/><label  for="q61" class="opt1">Yes, I eat too much</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_6" value="3" id="q62"/><label  for="q62" class="opt2">Yes, I don't feel hungry</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_6" value="2" id="q63"/><label  for="q63" class="opt3">Not much</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_6" value="1" id="q64"/><label  for="q64" class="opt4">No change</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 7.</span> When was the last time you were really happy?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_7" value="1" id="q71"/><label  for="q71" class="opt1">Few days ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_7" value="2" id="q72"/><label  for="q72" class="opt2">Few weeks ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_7" value="3" id="q73"/><label  for="q73" class="opt3">Few months ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_7" value="4" id="q74"/><label  for="q74" class="opt4">I don’t remember</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 8.</span> When was the last time you felt good about yourself?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_8" value="1" id="q81"/><label  for="q81" class="opt1">Few days ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_8" value="2" id="q82"/><label  for="q82" class="opt2">Few weeks ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_8" value="3" id="q83"/><label  for="q83" class="opt3">Few months ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_8" value="4" id="q84"/><label  for="q84" class="opt4">I don’t remember</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 9.</span> How often do you feel positive about your life?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_9" value="4" id="q91"/><label  for="q91" class="opt1">Never</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_9" value="3" id="q92"/><label  for="q92" class="opt2">Once in a while</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_9" value="2" id="q93"/><label  for="q93" class="opt3">About half the time</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_9" value="1" id="q94"/><label  for="q94" class="opt4">Always	</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 10.</span> Have you  feel lack of self confidence?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_10" value="4" id="q101"/><label  for="q101" class="opt1">Always</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_10" value="3" id="q102"/><label  for="q102" class="opt2">Most of the time</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_10" value="2" id="q103"/><label  for="q103" class="opt3">Some times</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_10" value="1" id="q104"/><label  for="q104" class="opt4">Never</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 11.</span> When did you last get your mental health examination done?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_11" value="4" id="q111"/><label  for="q111" class="opt1">Less than 6 months ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_11" value="3" id="q112"/><label  for="q112" class="opt2">A year ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_11" value="2" id="q113"/><label  for="q113" class="opt3">More then a year ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_11" value="1" id="q114"/><label  for="q114" class="opt4">Never</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 12.</span> Have you face difficulty  to decide quickly?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_12" value="4" id="q121"/><label  for="q121" class="opt1">Always	</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_12" value="3" id="q122"/><label  for="q122" class="opt2">Most of the time</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_12" value="2" id="q123"/><label  for="q123" class="opt3">Some times</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_12" value="1" id="q124"/><label  for="q124" class="opt4">Never	</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 13.</span> How many hours do you sleep per day?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_13" value="4" id="q131"/><label  for="q131" class="opt1">Less than 4 hours</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_13" value="3" id="q132"/><label  for="q132" class="opt2">4-6 hours</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_13" value="2" id="q133"/><label  for="q133" class="opt3">9 + hours</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_13" value="1" id="q134"/><label  for="q134" class="opt4">7-9 hours</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 14.</span> How often do you experience calm and peaceful?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_14" value="4" id="q141"/><label  for="q141" class="opt1">Never</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_14" value="3" id="q142"/><label  for="q142" class="opt2">Once in a while</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_14" value="2" id="q143"/><label  for="q143" class="opt3">Most of the time</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_14" value="1" id="q144"/><label  for="q144" class="opt4">Always	</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 15.</span> How often  do you experience energetic?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_15" value="4" id="q151"/><label  for="q151" class="opt1">Never</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_15" value="3" id="q152"/><label  for="q152" class="opt2">Once in a while</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_15" value="2" id="q153"/><label  for="q153" class="opt3">Most of the time</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_15" value="1" id="q154"/><label  for="q154" class="opt4">Always	</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 16.</span> How is your quality of sleep?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_16" value="4" id="q161"/><label  for="q161" class="opt1">Very bad</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_16" value="3" id="q162"/><label  for="q162" class="opt2">Bad</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_16" value="2" id="q163"/><label  for="q163" class="opt3">Normal</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_16" value="1" id="q164"/><label  for="q164" class="opt4">Good</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 17.</span> Do you feel content with your relationships and family?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_17" value="1" id="q171"/><label  for="q171" class="opt1">Yes</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_17" value="2" id="q172"/><label  for="q172" class="opt2">Sometimes</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_17" value="3" id="q173"/><label  for="q173" class="opt3">Maybe	</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_17" value="4" id="q174"/><label  for="q174" class="opt4">No</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 18.</span> How often do you smoke?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_18" value="1" id="q181"/><label  for="q181" class="opt1">Never</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_18" value="2" id="q182"/><label  for="q182" class="opt2">Once in a few weeks	</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_18" value="3" id="q183"/><label  for="q183" class="opt3">Once everyday</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_18" value="4" id="q184"/><label  for="q184" class="opt4">More than once everyday</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 19.</span> How often do you drink?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_19" value="1" id="q191"/><label  for="q191" class="opt1">Never</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_19" value="2" id="q192"/><label  for="q192" class="opt2">Once in a few weeks	</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_19" value="3" id="q193"/><label  for="q193" class="opt3">Once everyday</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_19" value="4" id="q194"/><label  for="q194" class="opt4">More than once everyday	</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 20.</span> Have you changed your routine recently?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_20" value="4" id="q201"/><label  for="q201" class="opt1">Very much</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_20" value="3" id="q202"/><label  for="q202" class="opt2">Yes, slightly</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_20" value="2" id="q203"/><label  for="q203" class="opt3">Rarely	</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_20" value="1" id="q204"/><label  for="q204" class="opt4">Not at all</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 21.</span> How confidently you make your own decision?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_21" value="1" id="q211"/><label  for="q211" class="opt1">Always</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_21" value="2" id="q212"/><label  for="q212" class="opt2">Most of the time</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_21" value="3" id="q213"/><label  for="q213" class="opt3">Sometimes</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_21" value="4" id="q214"/><label for="q214"  class="opt4">Never </label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 22.</span> How often do you experience Gloomy and angry?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_22" value="4" id="q221"/><label  for="q221" class="opt1">Always	</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_22" value="3" id="q222"/><label  for="q222" class="opt2">Most of the time </label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_22" value="2" id="q223"/><label  for="q223" class="opt3">Once a while</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_22" value="1" id="q224"/><label  for="q224" class="opt4">Never</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 23.</span> Does your health limit you doing Moderate physical decision?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_23" value="4" id="q231"/><label  for="q231" class="opt1">Very much</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_23" value="3" id="q232"/><label  for="q232" class="opt2">Moderately</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_23" value="2" id="q233"/><label  for="q233" class="opt3">Very less</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_23" value="1" id="q234"/><label  for="q234" class="opt4">No problem</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 24.</span> When was the last time you felt lonely?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_24" value="1" id="q241"/><label  for="q241" class="opt1">Few days ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_24" value="2" id="q242"/><label  for="q242" class="opt2">Few weeks ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_24" value="3" id="q243"/><label  for="q243" class="opt3">Few months ago</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_24" value="4" id="q244"/><label  for="q244" class="opt4">I don’t remember</label> </div>
			</div>
			</div>
			
			<div class="ques_box">
			<div class="question-container">
				<span>Ques 25.</span> How is going your personal life?
			</div>
			<div class="option-container">
				<div class="span_wrapper"><input class="option" type="radio" name="ques_25" value="4" id="q251"/><label  for="q251" class="opt1">Very bad</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_25" value="3" id="q252"/><label  for="q252" class="opt2">Bad</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_25" value="2" id="q253"/><label  for="q253" class="opt3">Normal</label></div>
				<div class="span_wrapper"><input class="option" type="radio" name="ques_25" value="1" id="q254"/><label  for="q254" class="opt4">Good</label></div> 
			</div>
			</div>
			
			<div class="ques_box lastQues">
			<div class="question-container" id="question">
				Do you want to share any other information?
			</div>
			<div class="option-container">
				<textarea name="ques_26" class="" type="text"></textarea>
			</div>
			</div>
		</div>
    	<div class="form-submit">
          <div class="button-contact text-right">
            <input type="submit" id="submit" value="Submit" />
            <div class="success-data" style="display:none;"></div>
          </div>
		</div>
		{!! Form::close() !!}
  </div>
</div>
<div class="container-fluid">
  <div class="container"> </div>
</div>
<script>
jQuery("#mediacl-form").validate({
	rules: {
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
		jQuery('.loading-all').show();
		form.submit();
	}
});
</script> 
@endsection 