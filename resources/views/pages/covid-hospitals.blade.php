@extends('layouts.Masters.Master')
@section('title', 'Covid Hospital | Health Gennie')
@section('description', "See a list of Covid Hospitals that treat COVID-19 patients, all hospitals are listed with beds availability and helpline number. Contact Now!")
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
</style>
<h1 style="display:none;">Covid Hospital</h1>
<DIV class=" covid-wrapper">
<div class="container" style=" margin-bottom:15px;">
  <div class="container-inner">
    <h2>Hospital Bed Availability</h2>
  </div>
</div>

<div class="container-fluid">
  <div class="container">
   
    <div class="DocFilterSect">
    
      
      
      <div class="DocFilterBlg">
        <label>Filter With Bed</label>
        <select class="bedType">
          <option value="general_beds">General Beds</option>
          <option value="oxygen_beds">Oxygen Beds</option>
          <option value="icu_bed_w_v">ICU Beds without Ventilator</option>
          <option value="icu_bed_v">ICU Beds with Ventilator</option>
        </select>
      </div>
      
      
       
      <div class="DocFilterBlg">
        <label>Search</label>
        <input type="text" id="search" class="search-input" name="fname" placeholder="Search from data" data-table="hospital-list">
      </div>
	  {!! Form::open(array('route' => 'covidHospital', 'id' => 'submitForm', 'method'=>'POST')) !!}
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
    
    <h2 class="info-text">For immediate doctor consultation please call us on <span>+91 8929920932</span></h2>
    
	 <h4 style=" width:100%; text-align:center; float:left;"> Data Source: <a style=" color:#0b316d" href="https://covidinfo.rajasthan.gov.in/" target="_blank">https://covidinfo.rajasthan.gov.in/</a></h4>
    <div class="HospitalBed">
      <table class="table table-striped table-bordered hospital-list" style="width: 100%;margin-bottom: 0px;">
        <thead class="mdb-color darken-3">
          <tr style="text-align: center;">
            <th rowspan="2" valign="top" align="center" style="width:50px; vertical-align:top; text-align:center; padding-bottom: 5px;"><b>S.No.</b></th>
            <th rowspan="2"  valign="top" style="width: 200px;vertical-align:top; padding-bottom: 40px; border: 0;"><b>Hospital Name</b></th>
            <th colspan="3"  valign="top" style="padding-bottom: 10px;vertical-align:top; width: 80px; text-align: center;" class="gen_beds"><b>General Beds</b></th>
            <th colspan="3"	 valign="top" style="padding-bottom: 10px; vertical-align:top; text-align: center; width: 80px; display:none;" class="oxy_beds"><b>Oxygen Beds</b></th>
            <th colspan="3"  valign="top" style="width: 100px; vertical-align:top;text-align:  center; display:none;" class="icu_w_beds"><b>ICU Beds without Ventilator</b></th>
            <th colspan="3"  valign="top" style="width: 100px;vertical-align:top; text-align: center; display:none;" class="icu_beds"><b>ICU Beds with Ventilator</b></th>
            <th rowspan="2"  valign="top" style="width: 110px;vertical-align:top; padding-bottom: 40px;"><b>Hospital Helpline No.</b></th>
            <th rowspan="2"  valign="top" style="width:160px; vertical-align:top;padding-bottom: 40px;"><b>Nodal Officer</b></th>
            <th rowspan="2"  valign="top" style="width: 160px;vertical-align:top; padding-bottom: 40px;"><b>Asst. Nodal Officer</b></th>
          </tr>
          <tr style="text-align: center;">
            <th class="gen_beds"  style="width: 25px;"><b>T</b></th>
            <th class="gen_beds" style="width: 25px;"><b>O</b></th>
            <th class="gen_beds" style="width: 25px;"><b>A</b></th>
            <th class="oxy_beds" style="width: 25px; display:none;"><b>T</b></th>
            <th class="oxy_beds" style="width: 25px; display:none;"><b>O</b></th>
            <th class="oxy_beds" style="width: 25px; display:none;"><b>A</b></th>
            <th class="icu_w_beds" style="display:none;"><b>T</b></th>
            <th class="icu_w_beds" style="display:none;"><b>O</b></th>
            <th class="icu_w_beds" style="display:none;"><b>A</b></th>
            <th class="icu_beds" style="display:none;"><b>T</b></th>
            <th class="icu_beds" style="display:none;"><b>O</b></th>
            <th class="icu_beds" style="display:none;"><b>A</b></th>
          </tr>
        </thead>
        <tbody>
          <tr></tr>
          <?php 
		$t_general_beds = 0;
		$t_o_gen_beds = 0;
		$t_a_gen_beds = 0;
		$t_oxygen_beds = 0;
		$t_o_oxy_beds = 0;
		$t_a_oxy_beds = 0;
		$t_icu_beds_w_v = 0;
		$t_o_icu_beds_w_v = 0;
		$t_a_icu_beds_w_v = 0;
		$t_icu_beds_v = 0;
		$t_o_icu_beds_v = 0;
		$t_a_icu_beds_v = 0;
	  ?>
        @if(count($hospitals)>0)
        @foreach($hospitals as $i => $raw)
        <?php 
				$t_general_beds += $raw->total_general_beds;
				$t_o_gen_beds += $raw->o_gen_beds;
				$t_a_gen_beds += $raw->a_gen_beds;
				$t_oxygen_beds += $raw->total_oxygen_beds;
				$t_o_oxy_beds += $raw->o_oxy_beds;
				$t_a_oxy_beds += $raw->a_oxy_beds;
				$t_icu_beds_w_v += $raw->total_icu_beds_w_v;
				$t_o_icu_beds_w_v += $raw->o_icu_beds_w_v;
				$t_a_icu_beds_w_v += $raw->a_icu_beds_w_v;
				$t_icu_beds_v += $raw->total_icu_beds_v;
				$t_o_icu_beds_v += $raw->o_icu_beds_v;
				$t_a_icu_beds_v += $raw->a_icu_beds_v;
			?>
        <tr>
          <td align="center" width="60">{{$i+1}}</td>
          <td><b><a href="{{$raw->url}}">{{$raw->name}}</a></b></td>
          <td class="gen_beds" style="width: 25px; ">{{$raw->total_general_beds}}</td>
          <td class="gen_beds" style="width: 25px;">{{$raw->o_gen_beds}}</td>
          <td class="gen_beds" style="color:@if($raw->a_gen_beds == 0)red;@else #12bd0f;@endif font-size:18px;width:25px;">{{$raw->a_gen_beds}}</td>
          <td class="oxy_beds" style="width: 25px;display:none;">{{$raw->total_oxygen_beds}}</td>
          <td class="oxy_beds" style="width: 25px;display:none;">{{$raw->o_oxy_beds}}</td>
          <td class="oxy_beds" style="color:@if($raw->a_oxy_beds == 0)red;@else #12bd0f;@endif font-size:18px;display:none;">{{$raw->a_oxy_beds}}</td>
          <td class="icu_w_beds" style="display:none;">{{$raw->total_icu_beds_w_v}}</td>
          <td class="icu_w_beds" style="display:none;">{{$raw->o_icu_beds_w_v}}</td>
          <td class="icu_w_beds" style="color:@if($raw->a_icu_beds_w_v == 0)red;@else #12bd0f;@endif font-size:18px;display:none;">{{$raw->a_icu_beds_w_v}}</td>
          <td class="icu_beds" style="display:none;">{{$raw->total_icu_beds_v}}</td>
          <td class="icu_beds" style="display:none;">{{$raw->o_icu_beds_v}}</td>
          <td class="icu_beds" style="color:@if($raw->a_icu_beds_v == 0)red;@else #12bd0f;@endif font-size:18px;display:none;">{{$raw->a_icu_beds_v}}</td>
          <td><a href="tel:{{$raw->help_line}}">{{$raw->help_line}}</a></td>
          <td style=" display: inline-block; border-bottom: 0;">{{$raw->nodal_officer}}</td>
          <td>{{$raw->asst_nodal_officer}}</td>
        </tr>
        @endforeach
		@else
			<tr><td colspan="17">Data not found in this city.</td></tr>
        @endif
		
		<tr class="bg-sectionTr">
			 <td colspan="1"></td>
			 <td> <b>Total</b></td>
			 <td class="gen_beds"><b><?=$t_general_beds?></b></td>
			 <td class="gen_beds"><b><?=$t_o_gen_beds?></b></td>
			 <td class="gen_beds"><b><?=$t_a_gen_beds?></b></td>
			 <td class="oxy_beds" style="display:none;"><b><?=$t_oxygen_beds?></b></td>
			 <td class="oxy_beds" style="display:none;"><b><?=$t_o_oxy_beds?></b></td>
			 <td class="oxy_beds" style="display:none;"><b><?=$t_a_oxy_beds?></b></td>
			 <td class="icu_w_beds" style="display:none;"><b><?=$t_icu_beds_w_v?></b></td>
			 <td class="icu_w_beds" style="display:none;"><b><?=$t_o_icu_beds_w_v?></b></td>
			 <td class="icu_w_beds"style="display:none;"><b><?=$t_a_icu_beds_w_v?></b></td>
			 <td class="icu_beds" style="display:none;"><b><?=$t_icu_beds_v?></b></td>
			 <td class="icu_beds" style="display:none;"><b><?=$t_o_icu_beds_v?></b></td>
			 <td class="icu_beds" style="display:none;"><b><?=$t_a_icu_beds_v?></b></td>
		  </tr>
          </tbody>
        
      </table>
      
      <div class="note">Note: This data is based on rajasthan govt. website.</div>
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
 
jQuery(document).on("change", ".bedType", function (e) {
	if($(this).val() == "general_beds"){
		$(".gen_beds").show();
		$(".oxy_beds").hide();
		$(".icu_w_beds").hide();
		$(".icu_beds").hide();
	}
	else if($(this).val() == "oxygen_beds"){
		$(".gen_beds").hide();
		$(".oxy_beds").show();
		$(".icu_w_beds").hide();
		$(".icu_beds").hide();
	}
	else if($(this).val() == "icu_bed_w_v"){
		$(".gen_beds").hide();
		$(".oxy_beds").hide();
		$(".icu_w_beds").show();
		$(".icu_beds").hide();
	}
	else if($(this).val() == "icu_bed_v"){
		$(".gen_beds").hide();
		$(".oxy_beds").hide();
		$(".icu_w_beds").hide();
		$(".icu_beds").show();
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

jQuery(document).ready(function () {
	$(".multiSelect").select2();
});
function submitForm(e) {
	$("#submitForm").submit();
}
</script> 
@endsection