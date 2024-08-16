@extends('layouts.Masters.Master')
@section('title', 'Covid Guide | Health Gennie')
@section('description', "Complete COVID guide, Check here to know about Covid-19 treatment according to symptoms, Covid-19 vaccine registration, hospitals, doctors & many more.")	
@section('content')
<h1 style="display:none;">Covid Guide</h1>
<section class="cta-section cta-sectionTop">
	<h2 class="jumbotron text-center JumbotronTextCenter">
<span class="subtitle">Covid Cases</span>Covid Cases</h2>
<p>Health experts say the third wave may not be as severe.</p>
<div class="container">
<div class="cta position-relative">
	
		
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4">
					<div class="counter-stat">
						<!--<i class="coronaicon"><img src="img/corona-iconimage.png" /></i>-->
						<span class="h3 counter" data-count="200000">335314</span>
						<p>India Cases</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4">
					<div class="counter-stat">
						<!--<i class="coronaicon"><img src="img/corona-iconimage.png" /></i>-->
						<span class="h3 counter" data-count="30000">16878</span>
						<p>Rajasthan Cases</p>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-4 col-sm-4">
					<div class="counter-stat">
						<!--<i class="coronaicon"><img src="img/corona-iconimage.png" /></i>-->
						<span class="h3 counter" data-count="400000">4035</span>
						<p>Jaipur Cases</p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</section>
<DIV class=" covid-wrapper">
<div class="container ">
  <div class="container-inner">
    <h2><span>COVID-19</span> Information Centre</h2>
    <p>The latest COVID-19 news and resources, as well as tips to protect you and your family.</p>
  </div>
</div> 
<div class="container-fluid">
  <div class="container">
	  <div class="banner-covid"><a href="{{route('covidTreatment')}}"><img src="img/covid-banner2.jpg" /></a></div>
      <div class="banner-covid mar-lr"><a href="{{route('covidTesting',['state'=>base64_encode(33),'city'=>base64_encode(3378)])}}"><img src="img/testing.jpg" /></a></div>
      <div class="banner-covid"><a href="{{route('covidDoctors',['state'=>base64_encode(33),'city'=>base64_encode(3378)])}}"><img src="img/covid-banner3.jpg" /></a></div>
       <div class="banner-covid"><a href="{{route('covidHospital',['state'=>base64_encode(33),'city'=>base64_encode(3378)])}}"><img src="img/covid-banner4.jpg" /></a></div>
      <div class="banner-covid  mar-lr"><a href="{{route('oxygenAvailablity',['state'=>base64_encode('RAJASTHAN'),'city'=>base64_encode('Jaipur')])}}"><img src="img/covid-banner5.jpg" /></a></div>
      <div class="banner-covid"><a href="{{route('homeService')}}"><img src="img/home-services.jpg" /></a></div>
      <div class="banner-covid"><a href="{{route('plasama',['state'=>base64_encode(33),'city'=>base64_encode(3378)])}}"><img src="img/plasma.jpg" /></a></div>
      <div class="banner-covid  mar-lr"><a href="{{route('meal')}}"><img src="img/free-food.jpg" /></a></div>
      <div class="banner-covid"><a href="{{route('covidVaccine')}}"><img src="img/covid-banner1.jpg" /></a></div>
  </div> 
</div>
</DIV>
<script>
	$('.counter').each(function () {
	$(this).prop('Counter',0).animate({
		Counter: $(this).text()
	}, {
		duration: 3000,
		easing: 'swing',
		step: function (now) {
			$(this).text(Math.ceil(now));
		}
	});
});
</script>
@endsection