<?php 
$link = route('index');
$text = 'Go Home';
$slug = $_SERVER['REQUEST_URI'];
$isAdmin = 0;
if(strpos($slug, 'admin') !== false) {
	$link = route('admin.login');
	$text = 'Go Admin Login';
	$isAdmin = 1;
}
?>
<?php if($isAdmin == 1) {?>
<html lang="en">
@include('layouts.admin.partials.header')
<body class="hold-transition sidebar-mini SidebarMiniqwe12">
<div class="wrapper wrapperNextTop">
<header class="main-header DivToogle" id="headerMainDiv">
<a href="{{ route('admin.home') }}" class="logo"> <!-- Logo -->
<span class="logo-lg">
	<img src="{{ URL::asset('css/assets/dist/img/logo.png') }}" alt=""/>
</span>
</a>
<nav class="navbar navbar-static-top ">
<div class="navbar-custom-menu">
	<h3>Health Gennie Admin</h3>
</div>
</nav>
</header>

<div class="container listing-right-wrapper box-errors-404">
	<div class="block-errors-404">
	<div class="left-errors-404">
		<img width="300" src="{{ URL::asset('img/404-errors.png')}}"/>
		<h2>Sorry, Page Expired</h2>
		<a href="{{$link}}" ><button type="button" class="btn btn-primary">{{$text}}</button></a>
	</div>
	</div>
</div>
</div>
<footer class="main-footer">
	<strong>Copyright &copy; 2020-2021 <a href="#">HealthGennie Patient Portal</a>.</strong> All rights reserved.
</footer>
<div class="loading-all" style="display:none"><span><img src="{{ URL::asset('img/turningArrow.gif') }}"/></span></div>
</body>
@include('layouts.admin.partials.footer_scripts')
</html>
<?php }
else if($isAdmin == 0){
 ?>
<!DOCTYPE html>
<html lang="en"> 
@include('layouts.partials.header') 
@section('title', 'Page Expired | Health Gennie')
@section('code', '419')
<body class="home">
@include('layouts.partials.top-nav') 
<div class="container listing-right-wrapper box-errors-404">
	<div class="block-errors-404">
	<div class="left-errors-404">
		<img width="300" src="{{ URL::asset('img/404-errors.png')}}"/>
		<h2>Sorry, Page Expired</h2>
		<a href="{{$link}}" ><button type="button" class="btn btn-primary">{{$text}}</button></a>
	</div>	
	<div class="bottom-errors-404">
		<div class="container">
		<div class="bottom-errors-content">
			<h2>Top specialities Doctors</h2>
			<ul>
				@if(count(getTopDocSpeciality()) > 0)
					@foreach(getTopDocSpeciality() as $spe)
					<li><a href="javascript:void(0);" title="{{$spe->spaciality}} in @if(Session::get('search_from_city_name')){{Session::get('search_from_city_name')}}@else Jaipur @endif" class="view_information" slug="{{$spe->slug}}" info_type="Speciality">{{$spe->spaciality}} in @if(Session::get('search_from_city_name')){{Session::get('search_from_city_name')}}@else Jaipur @endif</a></li>
					@endforeach
				@endif
			</ul>
		</div>
		<div class="bottom-errors-content">
			<h2>Benefits Health Gennie Doctors</h2>
			<ul>
				@php if(Session::get('city_id')){ $city = Session::get('city_id'); } else { $city = 3378;} @endphp
				@if(count(getPrimeDoctorsByCity($city)) > 0)
					@foreach(getPrimeDoctorsByCity($city) as $doc)
					<li>
						<a href="javascript:void(0);" class="view_information" slug="{{@$doc->DoctorSlug->clinic_name_slug}}" info_type="Clinic"><img width="15px" title="Subcribed" src="{{ URL::asset('img/verification-icon.png')}}" alt="icon"/> {{$doc->clinic_name}} @if(!empty($doc->docSpeciality)) ({{@$doc->docSpeciality->spaciality}} ,{{@$doc->qualification}})@endif
						</a>
					</li>
					@endforeach
				@endif
			</ul>
		</div>
		<div class="bottom-errors-content">
			<h2>Read Articles</h2>
			<ul>
				<div class="artical-btn txt-center">
                    <a href="{{route('blogList')}}" >Blogs</a>
                </div>
			</ul>
		</div>
	</div>
	</div>
	</div>
</div>	
@include('layouts.partials.footer') 
@include('layouts.partials.footer_scripts')
</body></html>
<?php } ?>