@extends('layouts.Masters.Master')
@section('title', 'Covid Testing Centres | Health Gennie')
@section('description', "Find the nearest Covid testing centers in your state to get a COVID‑19 test.  You can also check which testing center is providing covid test at home or not.")
@section('content')
<style>
.HospitalBed { width:100%; float:left;}  
.HospitalBed table thead tr th { background: #14bef0; color:#fff;border: 1px solid #ddd; position: -webkit-sticky;
  position: sticky;
  top: 0;
  z-index: 2;font-size:16px;}
.HospitalBed table tbody .bg-sectionTr td {background: #0b326d; color:#fff; font-size:16px;}
.HospitalBed table tbody tr td { font-size:16px;}
.DocFilterSect { width:100%; float:left; padding:10px;background: #f1f1f1; margin-bottom:25px; text-align:center;}
.DocFilterBlg {
    width: 24%;
    float: left;
    padding: 0px;
    margin-right: 2%;
}
.covid-info table {
    border: 1px solid #ddd;
    padding: 20px;
    margin-top: 15px;
    width: 100%;
    float: left;
    margin-bottom: 15px;
}
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
	background:#fff;
    float: left;
    padding: 0px 10px 0px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    height: 37px;
	font-size: 16px;
}
.DocFilterBlg label { width:100%; float:left; padding:0px 0px 0px 0px;font-size: 16px;}
.rt-pcr-data h3{width:100%; float:left;}
</style>
<h1 style="display:none;">Covid Testing Centers</h1>
<DIV class=" covid-wrapper">
  <div class="container ">
    <div class="container-inner">
      <h2 style=" margin-bottom:15px;"> <span>COVID-19</span> Testing Laboratories</h2>
    </div>
    
  </div>
  <div class="container-fluid covid-info">
    <div class="container">
	 <div class="DocFilterSect search-top">
        <div class="DocFilterBlg">
          <label>Search</label>
          <input type="text" id="search" class="search-input" name="fname" placeholder="Search from data" data-table="doctor-list">
        </div>
		{!! Form::open(array('route' => 'covidTesting', 'id' => 'submitForm', 'method'=>'POST')) !!}
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
	  <div class="container-fluid covid-info" style="padding:0px;">
	  <div class="container" style="padding:0px;">
	  <div class="rt-pcr-data">
		    <h2>RT PCR TEST REPORT</h2>

<p>Real-Time RT-PCR (Reverse Transcription Polymerase Chain Reaction) is a sensitive and fast test used for detecting the presence of specific genetic materials within a sample. This genetic material can be specific to humans, bacteria, and viruses like SARS-CoV-2.</p>


<h3>Upper respiratory tract specimens</h3>
<p>Most RT-PCR specimens are collected from the upper respiratory tract using nasopharyngeal swabs, although oropharyngeal swabs, and more recently, saliva, may also be used. The sensitivity and time course are thought to be similar between all three sample types. </p>
<p>These samples are most accurate within the first week after symptoms appear, and viral loads decline over the next couple of weeks. Four weeks after symptom onset, the RT-PCR is more likely to be negative than positive. </p>

<h3>CYCLE THRESHOLD VALUES</h3>

<p> A CT value signals the number of cycles for a sample to go through to amplify and bring up the viral DNA to a traceable level under given settings.</p>


<h3>HRCT (high-resolution computerised tomography</h3>
<p> HRCT (high-resolution computerised tomography) scanning uses X-rays to produce detailed images of the inside of your body. These images show cross sections (slices) through the heart and lungs.</p>
<p>HRCT scanning can also show possible blood clots in the lungs</p>

<p>CT SEVERITY SCORE</p>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><b>SCORE</b></td>
	<td><b>CT SEVERITY</b></td>
</tr>

<tr>
	<td><8</td>
	<td>MILD</td>
</tr>

<tr>
	<td>9-15</td>
	<td>MODERATE </td>
</tr>

<tr>
	<td>>15</td>
	<td>SEVERE</td>
</tr>
</table>

 








<h3>CRP TEST</h3> 
<p>C-reactive protein (CRP) is a protein made by the liver. CRP levels in the blood increase when there is a condition causing inflammation somewhere in the body. A CRP test measures the amount of CRP in the blood to detect inflammation due to acute conditions or to monitor the severity of disease in chronic conditions.</p>
<p>CRP is a non-specific indicator of inflammation and one of the most sensitive acute phase reactants. That means that it is released into the blood within a few hours after an injury, the start of an infection, or other cause of inflammation. Markedly increased levels can occur, for example, after trauma or a heart attack, with active or untreated autoimmune disorders, and with serious bacterial infections, such as in sepsis. The level of CRP can jump as much as a thousand-fold in response to bacterial infection, and its rise in the blood can precede pain, fever, or other signs and symptoms.</p>

<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><b>CRP(mg/dl)</b></td>
	<td><b>SEVERITY OF INFLAMMATION</b></td>
</tr>

<tr>
	<td>0-6</td>
	<td>NORMAL</td>
</tr>

<tr>
	<td>26-100</td>
	<td>MODERATE </td>
</tr>

<tr>
	<td>>100</td>
	<td>SEVERE</td>
</tr>
</table>


<h3>D –dimer TEST</h3>

<p>D-dimer is a fibrin degradation product that is often used to measure and assess clot formation. Amid the COVID-19 pandemic, elevated D-dimer levels have been associated with disease severity and mortality trends.</p>
<p>The presence of D-dimer in the blood plasma, which has a half-life of roughly 8 hours until kidney clearance occurs, is often used as a clinical biomarker to identify thrombotic activity and therefore diagnose conditions like pulmonary embolism (PE), deep vein thrombosis (DVT), venous thromboembolism (VTE) and disseminated intravascular coagulation (DIC).</p>

<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><b>-dimer( micro gram/ml)</b>	</td>
	<td><b>SEVERITY OF INFLAMMATION</b></td>
</tr>

<tr>
	<td><0.5</td>
	<td>MILD</td>
</tr>

<tr>
	<td><1 </td>
	<td>MODERATE </td>
</tr>

<tr>
	<td>>1</td>
	<td>SEVERE</td>
</tr>
</table>

<p>If D-dimer is measured in ng/ml then multiply above reading by 1000</p>


<h3>INTER-LEUKIN-6 TEST</h3>
<p>Interleukin-6 (IL-6) is a protein produced by various cells. It helps regulate immune responses, which makes the IL-6 test potentially useful as a marker of immune system activation. IL-6 can be elevated with inflammation, infection, autoimmune disorders, cardiovascular diseases, and some cancers. The test measures the amount of IL-6 in the blood.</p>
<p>Interleukin-6 is one of a large group of molecules called cytokines. Cytokines have multiple roles to play within the body and act especially within the immune system to help direct the body's immune response. They are a part of the "inflammatory cascade" that involves the coordinated, sequential activation of immune response pathways.</p>
<p>IL-6 acts on a variety of cells and tissues. It promotes differentiation of B-cells (white blood cells that produce antibodies), promotes cell growth in some cells, and inhibits growth in others. It stimulates the production of acute phase proteins. IL-6 also plays a role in body temperature regulation, bone maintenance, and brain function. It is primarily pro-inflammatory but can also have anti-inflammatory effects.</p>


<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><b>IL-6 PG/ML</b></td>
	<td><b>SEVERITY OF INFLAMMATION</b></td>
</tr>

<tr>
	<td>0-7</td>
	<td>NORMAL</td>
</tr>

<tr>
	<td><15  </td>
	<td>MILD </td>
</tr>

<tr>
	<td>15-100</td>
	<td>MODERATE</td>
</tr>

<tr>
	<td>100-500</td>
	<td>SEVERE</td>
</tr>

<tr>
	<td>>500</td>
	<td>CRITICAL</td>
</tr>
</table>







<h3>NEUTOPHIL TO LYMPHOCYTE RATION (NLR)</h3>

<p>In medicine neutrophil to lymphocyte ratio (NLR) is used as a marker of subclinical inflammation. It is calculated by dividing the number of neutrophils by number of lymphocytes, usually from peripheral blood sample.</p>
<h3>CELL RATIO	SEVERITY OF INFLAMMATION</h3>

<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><b>CELL RATIO</b></td>
	<td><b>SEVERITY OF INFLAMMATION</b></td>
</tr>

<tr>
	<td><3.5</td>
	<td>MILD</td>
</tr>

<tr>
	<td>>3.5 </td>
	<td>MODERATE/ SEVERE </td>
</tr>

</table>

<p>Disease severity is an independent predictor of poor outcome. Age and NLR may be related to the severity of the infection and may also indicate the outcome of the condition. The conclusions of this study support that elevated NLR is an independent prognostic biomarker for COVID-19 patients.</p>



<h3>FERRITIN/ LDH AND ESR TEST</h3>

<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td></td>
	<td><b>NORMAL RANGE</b></td>
</tr>

<tr>
	<td>FERRITIN</td>
	<td>13-150 ng/ml</td>
</tr>

<tr>
	<td>LDH</td>
	<td>0-250 U/L</td>
</tr>
<tr>
	<td>ESR</td>
	<td>0-22mm/hour </td>
</tr>
</table>


<P><b>FERRITIN</b> -Ferritin is a blood protein that contains iron. A ferritin test helps your doctor understand how much iron your body stores. If a ferritin test reveals that your blood ferritin level is lower than normal, it indicates your body's iron stores are low and you have iron deficiency.</P>
<P>An analysis of the peripheral blood of 69 patients with severe COVID-19 revealed elevated levels of ferritin compared with patients with non-severe disease. Therefore, it was concluded that serum ferritin levels were closely related to the severity of COVID-19</P>
<P><b>LDH</b>- This test measures the level of lactate dehydrogenase (LDH), also known as lactic acid dehydrogenase, in your blood or sometimes in other body fluids. LDH is a type of protein, known as an enzyme. LDH plays an important role in making your body's energy.</P>

<P><b>ESR</b> -Erythrocyte sedimentation rate (ESR or sed rate) is a test that indirectly measures the degree of inflammation present in the body. The test actually measures the rate of fall (sedimentation) of erythrocytes (red blood cells) in a sample of blood that has been placed into a tall, thin, vertical tube</P>

	  </div>
	  </div>
	  </div>
	  
	  
	  
      <div class="HospitalBed">
        <table class="table table-striped table-bordered doctor-list" style="width: 100%;margin-bottom: 0px;">
          <thead class="mdb-color darken-3">
            <tr style="text-align:left;">
              <th width="500"><b>Labs</b></th>
              <th width="100" align="center">RT PCR Test</th>
              <th width="100" align="center">HRCT</th>
              <th width="150" align="center">Home Services</th>
              <th><b>Contact Number</b></th>
              <th><b>City</b></th>
              <th><b>State</b></th>
            </tr>
          </thead>
          <tbody>
		   @if(count($testings)>0)
          @foreach($testings as $i => $raw)
            <tr>
              <td width="5 00"><strong>{{$raw->labs}}</strong></td>
              <td width="100" align="center">{{$raw->rtpcr_test}}</td>
              <td width="100" align="center">{{$raw->hrct}}</td>
              <td width="150" align="center">{{$raw->home_service}}</td>
              <td>{{$raw->contact}}</td>
			  <td>{{getCityName($raw->city)}}</td>
            <td>{{getStateName($raw->state)}}</td>
            </tr>
			 @endforeach
		  @else
			<tr><td colspan="7">Data not found in this city.</td></tr>
          @endif
          </tbody>
        </table>
        <h4 style=" width:100%; margin:30px 0 0 0; text-align:left; font-size:15px; font-style:italic; color:#222; float:left;"><strong>Note:</strong> This data is collected from various sources. In case of emergency please reach out to your nearest hospital.</h4>
      </div>
    </div>
  </DIV>
</DIV>

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