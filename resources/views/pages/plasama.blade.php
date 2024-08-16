@extends('layouts.Masters.Master')
@section('title', 'Plasma Donation | Health Gennie')
@section('description', "If you have recovered from COVID and are interested in Plasma Donation then please contact us via query form, and we will get back to you.")
@section('content')
<style>
.HospitalBed { width:100%; float:left;}  
.HospitalBed table thead tr th { background: #14bef0; color:#fff;border: 1px solid #ddd; font-size:16px;position: -webkit-sticky;
  position: sticky;
  top: 0;
  z-index: 2;}
.HospitalBed table tbody .bg-sectionTr td {background: #f94e00; color:#fff; font-size:16px;}
.HospitalBed table tbody tr td {font-size:16px;}
.DocFilterSect { width:100%; float:left; padding:10px;background: #f1f1f1; margin-bottom:10px; text-align:center;}
.DocFilterBlg {
    width: 24%;
    float: left;
    padding: 0px;
    margin-right: 2%;
}
.DocFilterBlg:nth-child(4n+0) {margin-right:0%;}
.DocFilterBlg input {
    width: 100%;
    float: left;
    padding: 0px 10px 0px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    height: 37px;
	font-size: 16px;
}
.DocFilterBlg select {
    width: 100%;
    float: left;
    padding: 0px 10px 0px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    height: 37px;
	font-size: 16px;
}
.DocFilterBlg label { width:100%; float:left; padding:0px 0px 0px 0px;font-size: 16px;}
</style>
<h1 style="display:none;">Plasma Donation</h1>
<DIV class="  covid-plasma  covid-wrapper">
  <div class="container ">
    <div class="container-inner">
      <h2 style=" margin-bottom:15px;"><span>COVID-19</span> CONVALESCENT PLASMA</h2>
      <p class="subtit">To Donate Plasma, Please <a href="{{route('donatePlasma')}}">Register Here</a> </p>
    </div>
  </div>
  <div class="container-fluid">
    <div class="container">
      <div class="DocFilterSect search-top">
        <div class="DocFilterBlg">
          <label>Search</label>
          <input type="text" id="search" class="search-input" name="fname" placeholder="Search from data" data-table="doctor-list">
        </div>
          {!! Form::open(array('route' => 'plasama', 'id' => 'submitForm', 'method'=>'POST')) !!}
		  <div class="DocFilterBlg pos">
			<label>State </label>
		   <select class="form-control state_id multiSelect" name="state">
			  <option value="">Select State</option>
				@foreach (getStateList(101) as $state)
					<option value="{{ $state->id }}" @if(isset($_GET['state'])) @if(base64_decode($_GET['state']) == $state->id) selected @endif @endif >{{ $state->name }}</option>
				@endforeach
		   </select>
		  </div>
		  <div class="DocFilterBlg pos">
			<label>City</label>
			<select class="form-control city_id multiSelect" name="city" onchange="submitForm(this.value);">
				<option value="">Select City</option>
				@foreach (getCityList(33) as $city)
					<option value="{{ $city->id }}" @if(isset($_GET['city'])) @if(base64_decode($_GET['city']) == $city->id) selected @endif @endif >{{ $city->name }}</option>
				@endforeach
			  </select>
		  </div>
	  {!! Form::close() !!}
      </div>
      
      <h3 style=" width:100%; float:left; text-align:left;">Plasma Donors</h3>
      <div class="HospitalBed">
        <table class="table table-striped table-bordered doctor-list" style="width: 100%;margin-bottom: 0px; margin-bottom:40px;">
          <thead class="mdb-color darken-3">
            <tr style="text-align:left;">
              <th style=""><b>S.No.</b></th>
             
              <th><b>Name</b></th>
               <th><b>Blood Group</b></th>
              <th><b>Contact Number</b></th>
              <th><b>City</b></th>
              <th><b>State</b></th>
            </tr>
          </thead>
          <tbody>
          @if(count($plasama)>0)
          @foreach($plasama as $i => $raw)
          <tr>
            <td>{{$i+1}}</td>
           
            <td><b>{{$raw->name}}<b></td>
             <td><b>{{$raw->blood_group}}<b></td>
            <td><a href="tel:{{$raw->mobile}}">{{$raw->mobile}}</a></td>
            <td>{{getCityName($raw->city)}}</td>
            <td>{{getStateName($raw->state)}}</td>
          </tr>
          @endforeach
		  @else
			<tr><td colspan="4">Data not found in this city.</td></tr>
          @endif
            </tbody>
        </table>
<h3>What is Convalescent Plasma?</h3>
  <p class="light">Convalescent refers to anyone recovering from a disease. Plasma is the yellow, liquid part of blood that contains antibodies. Nearly 55% of your blood is plasma. Antibodies are proteins made by the body in response to infections.  Laboratories can separate plasma from blood with special devices called plasma tubes through a process called centrifugation.</p>
  <p>
What makes plasma a candidate for COVID cure is that it contains antibodies. When your body has fought an infection, the antibodies produced are stored in the plasma. That means if you’ve contracted COVID, then antibodies that can fight the COVID infection will be present in your plasma. The plasma from a person who has recovered from a disease is called convalescent plasma. </p>
<p>Doctors have found evidence that injecting a person who has been infected with COVID with convalescent plasma from someone who has recovered from COVID can help the patient heal faster having Early or Moderate disease.</p>


<h3>WHO CAN DONATE</h3>
<p>According to the FDA, the best time to donate is about 2 weeks after you have completely recovered from your COVID infection. </p>
<p>To meet donor qualification, you need to produce evidence that you did indeed contract COVID. That means you will need your COVID positive test results The donor must visit the hospital/plasma bank centre where she/he will undergo tests to map the status of serum protein, CBC (complete blood counts) and ABO RhD blood group. Other tests include checking for the hepatitis B virus, hepatitis C virus, HIV, malaria, and syphilis. Depending on how many days have passed since the recovery, the donor will also have to take an antibody screening test as per the ICMR kit method.</p>

<h3>Eligibility Criteria: </h3>

<ul>
    <li>The donor should weigh 50 kilos and above </li>
    <li>They must be between the ages of 18 and 60.</li>
    <li>They should preferably have had symptoms (fever, cold, cough, etc) since such patients have a greater possibility of possessing anti-SARS-Cov-2 IgG antibodies as compared to an asymptomatic patient. Asymptomatic recovered patients can also donate if antibodies are present.</li>
    <li>28 days after a complete resolution of symptoms.</li>
</ul>
<h3>Why should you donate?</h3>

<p>Donating plasma can save lives. Your antibodies can help someone fight the infection and emerge victoriously. If your COVID symptoms have been absent for more than 14 days, kindly consider donating as a service to humanity.</p>

<p>Just like during any regular blood donation session, blood will be drawn from your arm. It will be sent through special tubes that will separate the plasma from the blood.  </p>
<h3>Where can you donate?</h3>

<p>Major blood banks accept plasma donations. You can call their helpline numbers and enquire. You can also search plasma donation camps near your area on the internet. </p>

<h3>Who are not eligible to donate plasma? </h3>

<p><strong>Donors ineligible for convalescent plasma donation:</strong></p>
<ul>
<li>Those weighing less than 50 kilos.</li>
<li>Diabetics on insulin.</li>
<li>Those with B.P more than 140, and diastolic less than 60 or more than 90. </li>
<li>Uncontrolled diabetes or hypertension with a change in medication taken place in the last 28 days.</li>
<li>Cancer survivors.</li>
<li>Chronic kidney/heart/lung or liver disease.</li>
<li>Women who have been pregnant in the past.</li>
<li>Persons with comorbidities.</li>
</ul>

<h3>Who can receive plasma? </h3>
<ul>
<li>Those in the early stages of COVID-19.</li>
<li>Plasma should be administered within 3-7 days of the onset of symptoms, but no later than 10 days.</li>
<li>Those who have no IgG Antibody against COVID-19.</li>
</ul>

<p style=" font-size:20px; margin-top:20px; margin-bottom:10px;"><strong>The number of times one can donate, and how much. </strong></p>

<p>As per ICMR guidelines, a donor can donate up to 500 ml of plasma (according to weight) more than once, with a gap of 15 days. 400 ml of plasma can save two lives. The process can last up to four hours (from tests to transfusion), and if the donor experiences discomfort, the machine can be detached immediately.</p>

<h3>How many can benefit from one plasma donor? </h3>
<p>One person can help up to two people. The donor is advised against donating plasma more than two times a month. </p>




<h4 style=" width:100%; margin:30px 0 0 0; text-align:left; font-size:15px; font-style:italic; color:#222; float:left;"><strong>Note:</strong> This data is collected from various sources. In case of emergency please reach out to your nearest hospital.</h4>

 



      </div>
    </div>
  </div>
</div>
<script>
(function(document) {
'use strict';
var TableFilter = (function(myArray) {
	var search_input;

	function _onInputSearch(e) {
		search_input = e.target;
		var tables = document.getElementsByClassName(search_input.getAttribute('data-table'));
		myArray.forEach.call(tables, function(table) {
			myArray.forEach.call(table.tBodies, function(tbody) {
				myArray.forEach.call(tbody.rows, function(row) {
					var text_content = row.textContent.toLowerCase();
					var search_val = search_input.value.toLowerCase();
					row.style.display = text_content.indexOf(search_val) > -1 ? '' : 'none';
				});
			});
		});
	}

	return {
		init: function() {
			var inputs = document.getElementsByClassName('search-input');
			myArray.forEach.call(inputs, function(input) {
				input.oninput = _onInputSearch;
			});
		}
	};
})(Array.prototype);

document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') {
		TableFilter.init();
	}
});

})(document);

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

jQuery(document).ready(function () {
	$(".multiSelect").select2();
});
function submitForm(e) {
	$("#submitForm").submit();
}
</script> 
@endsection