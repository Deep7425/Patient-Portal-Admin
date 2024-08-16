@extends('layouts.Masters.Master')
@section('title', 'Oxygen Suppliers in Jaipur | Health Gennie')
@section('description', "Looking for an oxygen cylinder supplier in Jaipur? Just visit www.healthgennie.com here is listed agency name with phone number. 
")
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
<h1 style="display:none;">Oxygen Suppliers in @if(isset($_GET['city'])) {{base64_decode($_GET['city'])}} @endif</h1>
<DIV class=" covid-wrapper">
<div class="container ">
  <div class="container-inner">
    <h2 style=" padding-bottom:15px;">Oxygen Suppliers In <span>@if(isset($_GET['city'])) {{base64_decode($_GET['city'])}} @endif</span></h2>
  </div>
</div>
<div class="container-fluid">
<div class="container">
<div class="DocFilterSect search-top">
<div class="DocFilterBlg">
  <label>Search</label>
  <input type="text" id="search" class="search-input" name="fname" placeholder="Search from data" data-table="doctor-list">
</div>
  {!! Form::open(array('route' => 'oxygenAvailablity', 'id' => 'submitForm', 'method'=>'POST')) !!}
  <div class="DocFilterBlg pos">
	<label>State </label>
   <select class="form-control state_id multiSelect" name="state">
	  <option value="">Select State</option>
	  @if(count($states)>0)
		@foreach($states as $raw)
			<option value="{{ $raw->state }}" @if(isset($_GET['state'])) @if(base64_decode($_GET['state']) == $raw->state) selected @endif @endif >{{$raw->state}}</option>
		@endforeach
	  @endif	
   </select>
  </div>
  <div class="DocFilterBlg pos">
	<label>City</label>
	<select class="form-control city_id multiSelect" name="city" onchange="submitForm(this.value);">
		<option value="">Select City</option>
		@if(count($cities)>0)
		@foreach($cities as $raw)
			<option value="{{ $raw->city }}" @if(isset($_GET['city'])) @if(base64_decode($_GET['city']) == $raw->city) selected @endif @endif >{{$raw->city }}</option>
		@endforeach
		@endif
	  </select>
  </div>
{!! Form::close() !!}
</div>
<div class="HospitalBed">
<table class="table table-striped table-bordered doctor-list" style="width: 100%;margin-bottom: 0px;">
	  <thead class="mdb-color darken-3">
		<tr style="text-align:left;">
		  <th style=""><b>S.No.</b></th>
		  <th><b>Agency Name</b></th>
		  <th><b>Contact Person</b></th>
		  <th width="300"><b>Contact Number</b></th>
		  <th><b>City</b></th>
		  <th><b>State</b></th>
		</tr>
	  </thead>
	  <tbody>
	  @if(count($oxygen)>0)
	  @foreach($oxygen as $i => $raw)
		  <tr>
			<td>{{$i+1}}</td>
			<td><b>{{$raw->agency_name}}<b></td>
			<td>{{$raw->contact_name}}</td>
			<td width="300"><b><a href="tel:{{@$raw->contact}}">{{$raw->contact}}</a><b></td>
			<td>{{$raw->city}}</td>
			<td>{{$raw->state}}</td>
		  </tr>
	  @endforeach
	  @else
		<tr><td colspan="6">Data not found in this city.</td></tr>
	  @endif
	 </tbody>
	</table>
	</div>
  </div>
</div>
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
		  url: "{!! route('getCityListByName') !!}",
		  // type : "POST",
		  dataType : "JSON",
		  data:{'id':cid},
		  success: function(result){
		  jQuery("#submitForm").find("select[name='city']").html('<option value="">Select City</option>');
		  jQuery.each(result,function(index, element) {
			  $el.append(jQuery('<option>', {
				 value: element.city,
				 text : element.city
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