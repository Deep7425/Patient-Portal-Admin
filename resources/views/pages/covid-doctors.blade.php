@extends('layouts.Masters.Master')
@section('title', 'Covid Doctors | Health Gennie')
@section('description', "See a list of Covid Doctors with phone numbers, If you think you have COVID-19, notify the doctor on call at the comfort of Home and follow their instructions. ")
@section('content')
<style>
.HospitalBed { 
	width:100%;
	float:left;
}  
.HospitalBed table thead tr th { 
	background: #14bef0; 
	color:#fff;
	border: 1px solid #ddd; 
	font-size:16px;
	position: -webkit-sticky;
	position: sticky;
	top: 0;
	z-index: 2;
}
.HospitalBed table tbody .bg-sectionTr td {
	background: #f94e00;
	color:#fff;
	font-size:16px;
}
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
<h1 style="display:none;">Covid Doctors</h1>
<div class="covid-wrapper">
  <div class="container">
    <div class="container-inner">
      <h2 style="margin-bottom:15px;"> <span>COVID-19</span> Treating Doctors</h2>
      <p class="treat-doc" style="">For Free Covid Doctor Consultation Download Helath Gennie App Now. <a style="" href="https://www.healthgennie.com/download">Click Here</a></p>
    </div>
  </div>
  
  <div class="container-fluid">
    <div class="container">
      <div class="DocFilterSect search-top">
        <div class="DocFilterBlg">
          <label>Search</label>
          <input type="text" id="search" class="search-input" name="fname" placeholder="Search from data" data-table="doctor-list">
        </div>
        
        {!! Form::open(array('route' => 'covidDoctors', 'id' => 'submitForm', 'method'=>'POST')) !!}
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
      <div class="HospitalBed">
        <table class="table table-striped table-bordered doctor-list" style="width: 100%;margin-bottom: 0px;">
          <thead class="mdb-color darken-3">
            <tr style="text-align:left;">
              <th style=""><b>S.No.</b></th>
              <th><b>Doctor Name</b></th>
              <th><b>Hospital / Clinic</b></th>
              <th><b>Contact Number</b></th>
            </tr>
          </thead>
          <tbody>
          <?php $i = 0; ?>
          @if(count($hgDocs)>0)
          @foreach($hgDocs as $raw)
			<?php $i = $i+1; ?>
          <tr>
            <td>{{$i}}</td>
            <td><b><a href="{{$raw->url}}">{{$raw->name}}</a><b></td>
            <td>{{$raw->clinic}}</td>
            <td><a href="tel:{{$raw->mobile}}">{{$raw->mobile}}</a></td>
          </tr>
          @endforeach
		  @endif
		  
		  @if(count($doctors)>0)
          @foreach($doctors as $raw)
			<?php $i = $i+1; ?>
          <tr>
            <td>{{$i+1}}</td>
            <td><b>{{$raw->name}}<b></td>
            <td>{{$raw->CovidHospital->name}}</td>
            <td><a href="tel:{{@$raw->CovidHospital->help_line}}">{{@$raw->CovidHospital->help_line}}</a></td>
          </tr>
          @endforeach
		  @else
			<tr><td colspan="4">Data not found in this city.</td></tr>
          @endif
            </tbody>
          
        </table>

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