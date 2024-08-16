@extends('layouts.Masters.Master')
@section('title', 'Win exciting prizes and cash back | Health Gennie')
@section('description', "Refer and earn cash back in your paytm wallet upto Rs 100/- every time and get better chances of winning the prizes see terms and conditions for details.")
@section('content')
<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="{{ URL::asset('subcription-asset/style.css') }}" rel="stylesheet">
<link href="{{ URL::asset('subcription-asset/css/scrolling-nav.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
<div class="NewyearOffer">
<div class="NewyearOfferSection">
	<div class="NewyearOfferLogo">
	
	</div>
<div class="NewyearOfferBlock">
<div class="excitingprizes">
<div class="NewyearOfferContent">
	<span>Get your health problems resolved with</span>
	<h2>Health Gennie &</h2>
	 <p>Win exciting prizes and cash back</p>
</div>
<div class="NewyearOfferAppMobeli">
<img src="img/moblie-imageoffer.png" />	
</div>
</div>
<div class="excitingprizesSection">
<ul>
	<li><img src="img/macbook.png" /><p><span>1<sup>st</sup>  prize</span> 1 Mac book</p></li>
	<li><img src="img/smartphones.png" /><p><span>2<sup>nd</sup> prize</span>5 smart phone</p></li>
	<li><img src="img/boat.png" /><p><span>3<sup>rd</sup> prize</span> 5 Bluetooth Speaker</p></li>
	<li><img src="img/Bluetoothheadsets.png" /><p><span>4<sup>th</sup> prize </span>5 Bluetooth headsets</p></li>
	<li><img src="img/pendrives.png" /><p><span>5<sup>th</sup> prize</span>50 pen drives</p></li>
</ul>
</div>
<div class="HurrySection">
	<h2><span>Hurry!!</span> Limited Time Offer</h2>
</div>
<div class="Perday">
	<p>Get Health Gennie Plan for Only <span>Rs.1</span> Per day</p>
</div>

<div class="ApplyCouponCode">
	<p>Apply Coupon Code <span>“NEWYEAR”</span> on 599/- Plan and Get It For <span>365/-</span> Only</p>
</div>
<div class="BuyNowPlan">
<a class="btn btn-primary" href="{{route('driveDashboard')}}">Buy Now</a>
</div>
<div class="Refer-earn-cash-back">
	<p>Refer and earn cash back in your paytm wallet upto <span>Rs 100/-</span> every time and  get better chances of winning the prizes.</p>
</div>
<div class="Refer-earn-cash-back conditions">
	<p>See terms and conditions for details</p>
</div>
</div>
</div>	
<div class="table-winner">
<!--<div class="DocFilterSect search-top">
{!! Form::open(array('route' => 'hgOffers', 'id' => 'submitForm', 'method'=>'POST')) !!}
<div class="DocFilterBlg pos">
<input type="text" id="search" class="search-input" name="fname" placeholder="Search by name & mobile" data-table="doctor-list" value="@if(isset($_GET['fname'])) {{base64_decode($_GET['fname'])}} @endif">
</div>
<div class="dataTables_length">
	<span class="input-group-btn">
	<button class="btn btn-primary form-control" type="submit">
	  <span class="glyphicon glyphicon-search"></span>
	</button>
	</span>
</div>
{!! Form::close() !!}
</div>-->
<div class="table-winnerTop">
<div class="table-winner123">
<h2>Check your chances of winning the prizes !</h2>
<table id="myTable" class="table table-striped table-bordered" style="width: 100%;margin-bottom: 0px; margin-bottom:40px;">
<thead class="mdb-color darken-3">
<tr style="text-align:left;">
  <th><b>Name</b></th>
  <th><b>No. of Referrals</b></th>
  <th><b>No. of entries in lucky draw</b></th>
  <th><b>Chances of winning 1st prize</b></th>
  <th><b>Chances of winning any prize</b></th>
  <th><b>Rank</b></th>
</tr>
</thead>
<tbody>
@if(count($subs)>0)
<tr>
<td><b>Chandra Mohan Kumawat</b></td>
<td><b>5</b></td>
<td><b>6</b></td>
<td><b>40%</b></td>
<td><b>50.00%</b></td>
<td><b>1</b></td>	
</tr>
<tr>
<td><b>Akash Joshi</b> </td>
<td><b>4</b></td>
<td><b>5</b></td>
<td><b>35%</b></td>
<td><b>45.00%</b></td>
<td><b>2</b></td>		
</tr>
<tr>
<td><b>Aamir Sohaib</b></td>
<td><b>3</b></td>
<td><b>4</b></td>
<td><b>30%</b></td>
<td><b>35.00%</b></td>
<td><b>3</b></td>		
</tr>
<tr>
<td><b>Kapil Khatri</b> </td>
<td><b>3</b></td>
<td><b>4</b></td>
<td><b>30%</b></td>
<td><b>35.00%</b></td>
<td><b>4</b></td>		
</tr>
@foreach($subs as $i => $raw)
<tr>
<td><b>{{@$raw['user']['first_name']}} {{@$raw['user']['last_name']}} @if(!empty($raw['user']['first_name'])) ({{replacewithStar(@$raw['user']['mobile_no'],4)}}) @else {{replacewithStar(@$raw['user']['mobile_no'],4)}} @endif
</b>
<p style="display:none;">{{@$raw['user']['mobile_no']}}"<p/>
</td>
<?php 
$total_ref = 0;	
if(!empty($raw['user_referral'])) {
	$total_ref = $raw['user_referral']['total_ref'];
} ?>
<td><b>{{$total_ref}}</b></td>
<td><b>{{$total_ref + 1}}</b></td>
<?php 
	$t_subs = count($subs);
	$tpw1p = 0;
	$tpwap = 0;
	$tpwap = (($total_ref + 1 )/ $t_subs) * 10000;
	$tpw1p = (($total_ref + 68)/ $t_subs) * 10000;
	if($tpw1p >= 100) {
		$tpw1p = 70;
	}
	if($tpwap >= 100){
		$tpwap = 70;
	}
?>
<td><b>{{number_format($tpwap,2)}}%</b></td>
<td><b> {{number_format($tpw1p,2)}}%</b></td>
<td><b>{{$i+5}}</b></td>
</tr>
@endforeach
@else
<tr><td colspan="6">Data not found in this list.</td></tr>
@endif
</tbody>
</table>
</div>
</div>
</div>
<div class="NewyearOfferTermsConditions">
	<h2>Terms and Conditions: - </h2>
	<ul>
		<li>To enter into Lucky draw, you need to buy a subscription plan of Health Gennie starting from Rs 365. </li>
		<li>Start referring Health Gennie plan to your friends and family. With every referral sale, you will also get a paytm  cashback of upto Rs 100 in your paytm wallet. Use your registered mobile number on health gennie as the coupon code for referral code</li>
		<li>For ex. If you bought the Health Gennie plan with mobile number 9876543210 then ask your friend to use this mobile number as the coupon code while buying the plan.</li>
		<li>With every referral, you will get an extra entry into the lucky draw. For ex. If you refer 10 people who buys the plan using your mobile number as the coupon code, then you will get 11 entries into the lucky draw. </li>
		<li>Health Gennie should receive minimum 10000 subscriptions before declaring the lucky draw winners. </li>
		<li>This offer is valid until January 2022. </li>
		<li>Health Gennie holds the right to stop this offer anytime without giving any prior notice in any unavoidable circumstances. </li>
		<li>Health Gennie lucky draw results will be final and no objections can be done on it. </li>
	</ul>
</div>
<!--<div class="container-fluid footer-offer">
    <ul>
      <li><strong>For More Details</strong> </li>
      <li><img width="30" src="img/accept-call.png" />Call: +918929920932</li>
      <li><img width="30" src="img/whatsapp-icon.png" />WhatsApp: +918690006254</li>
    </ul>
</div>-->
</div>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
	$('#myTable').DataTable({
		"order": [[ 5, "asc" ]], //or asc 

   "language": {
        searchPlaceholder: "Name/Mobile No."
    }
  
	});
});
</script>
@endsection