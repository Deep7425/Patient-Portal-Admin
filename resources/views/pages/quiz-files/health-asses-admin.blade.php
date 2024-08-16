<!DOCTYPE html>
<html lang="en" class="default-style layout-fixed layout-navbar-fixed">
@extends('pages.quiz-files.header')

<!-- Mirrored from html.phoenixcoded.net/empire/bootstrap/default/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 21 Feb 2023 05:55:51 GMT -->

<body>
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
	
    <div class="layout-wrapper layout-2">
	<input type="hidden" value="{{json_encode($chartArray)}}" id="chartArray" />
	<input type="hidden" value="{{json_encode($piChartArray)}}" id="piChartArray" />
	<input type="hidden" value="{{json_encode($piChartRegArray)}}" id="piChartRegArray" />
	<input type="hidden" value="{{json_encode($wildChart)}}" id="wildChart" />
	<input type="hidden" value="{{$totChartVal}}" id="totChartVal" />
	<input type="hidden" value="{{$totChartVal}}" id="wildtotChartVal" />
        <div class="layout-inner">
            <!-- [ Layout sidenav ] Start -->
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-white logo-dark">
                <!-- Brand demo (see assets/css/demo/demo.css) -->
                <div class="app-brand demo">
                    <span class="app-brand-logo demo">
                        <img src="/quiz-asset/img/Logo.png" alt="Brand Logo" class="img-fluid">
                    </span>
                    <a href="{{url("/")}}/assessment-admin/{{$orgData->slug}}" class="app-brand-text demo sidenav-text font-weight-normal ml-2">Health Gennie</a>
                    <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
                        <i class="ion ion-md-menu align-middle"></i>
                    </a>
                </div>
                <div class="sidenav-divider mt-0"></div>

                <!-- Links -->
                <ul class="sidenav-inner py-1">

                    <!-- Dashboards -->
                    <li class="sidenav-item open active">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon feather icon-home"></i>
                            <div>Dashboards</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item active">
                                <a href="{{url("/")}}/assessment-admin/{{$orgData->slug}}" class="sidenav-link">
                                    <div>Home</div>
                                </a>
                            </li>
							<li class="sidenav-item">
                                <a href="{{url("/")}}/assessment-list/{{$orgData->slug}}" class="sidenav-link">
                                    <div>List</div>
                                </a>
                            </li>
							<li class="sidenav-item">
                                <a href="{{url("/")}}/programme/{{$orgData->slug}}" class="sidenav-link">
                                    <div>Programme</div>
                                </a>
                            </li>
                            <li class="sidenav-item">
                                <a href="{{url("/")}}/counceling-dashboard/{{$orgData->slug}}" class="sidenav-link">
                                    <div>Counceling Dashboard</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- [ Layout sidenav ] End -->
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <!-- [ Layout navbar ( Header ) ] Start -->
                <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-dark container-p-x" id="layout-navbar">

                    <!-- Brand demo (see assets/css/demo/demo.css) -->
                    <a href="index-2.html" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
                        <span class="app-brand-logo demo">
                            <img src="/quiz-asset/img/logo-dark.png" alt="Brand Logo" class="img-fluid">
                        </span>
                        <span class="app-brand-text demo font-weight-normal ml-2">Empire</span>
                    </a>

                    <!-- Sidenav toggle (see assets/css/demo/demo.css) -->
                    <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
                        <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
                            <i class="ion ion-md-menu text-large align-middle"></i>
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
                        <!-- Divider -->
                        <hr class="d-lg-none w-100 my-2">

                        <div class="navbar-nav align-items-lg-center">
                            <!-- Search -->
                            <label class="nav-item navbar-text navbar-search-box p-0 active">
                                <i class="feather icon-search navbar-icon align-middle"></i>
                                <span class="navbar-search-input pl-2">
                                    <input type="text" class="form-control navbar-text mx-2" placeholder="Search...">
                                </span>
                            </label>
                        </div>

                        <div class="navbar-nav align-items-lg-center ml-auto">
                            <!-- Divider -->
                            <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
                            <div class="demo-navbar-user nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                        <img @if(!empty($orgData->logo)) src="{{url("/")}}/public/organization_logo/{{$orgData->logo}}" @else src="/img/user-icon-sidebar.png" @endif alt class="d-block ui-w-30 rounded-circle">
                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0">{{$orgData->title}}</span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:" class="dropdown-item logOut">
                                        <i class="feather icon-power text-danger"></i> &nbsp; Log Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- [ Layout navbar ( Header ) ] End -->

                <!-- [ Layout content ] Start -->
                <div class="layout-content">

                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">Health Assessment Dashboard</h4>
                        <!--<div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active">Main</li>
                            </ol>
                        </div>-->
                        <div class="row" id="cuP21" text-data="{{base64_encode($orgData->pwd)}}">
                            <!-- 1st row Start -->
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card mb-4 cardtop">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="">
                                                    	<span class="badge badge-primary">Total Registration</span>
                                                        <h2 class="mb-2"> {{$totalReg}} </h2>
                                                        <p class="text-muted mb-0"> </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card mb-4 cardtop">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="">
                                                    	<span class="badge badge-success">All Assessment</span>
                                                        <h2 class="mb-2">{{$totalAssessment}}</h2>
                                                        <p class="text-muted mb-0"> </p>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card mb-4 cardtop">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="">
                                                    	<span class="badge badge-danger">Today Assessment</span>
                                                        <h2 class="mb-2"> {{$totalAssessmentToday}} <small></small></h2>
                                                        <p class="text-muted mb-0">  </p>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   <!-- <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="">
                                                        <h2 class="mb-2">158</h2>
                                                        <p class="text-muted mb-0"><span class="badge badge-warning">$143.45</span> Profit</p>
                                                    </div>
                                                    <div class="lnr lnr-cart display-4 text-warning"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="card d-flex w-100 mb-4">
                                            <div class="row no-gutters row-bordered row-border-light h-100">
                                                <div class="d-flex col-md-6 align-items-center">
                                                    <div class="card-body">
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                                <i class="lnr lnr-users text-primary display-4"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="mb-0 text-muted">Unique <span class="text-primary">Visitors</span></h6>
                                                                <h4 class="mt-3 mb-0">652<i class="ion ion-md-arrow-round-down ml-3 text-danger"></i></h4>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 text-muted">36% From Last 6 Months</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex col-md-6 align-items-center">
                                                    <div class="card-body">
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                                <i class="lnr lnr-magic-wand text-primary display-4"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="mb-0 text-muted">Monthly <span class="text-primary">Earnings</span></h6>
                                                                <h4 class="mt-3 mb-0">5963<i class="ion ion-md-arrow-round-up ml-3 text-success"></i></h4>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 text-muted">36% From Last 6 Months</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                            <!--<div class="col-lg-7">
                                <div class="card mb-4">
                                    <div class="card-header with-elements">
                                        <h6 class="card-header-title mb-0">Statistics</h6>
                                        <div class="card-header-elements ml-auto">
                                            <label class="text m-0">
                                                <span class="text-light text-tiny font-weight-semibold align-middle">SHOW STATS</span>
                                                <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2"><input type="checkbox" class="switcher-input" checked><span class="switcher-indicator"><span
                                                            class="switcher-yes"></span><span class="switcher-no"></span></span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="statistics-chart-1" style="height:300px"></div>
                                    </div>
                                </div>
                            </div>-->
							
							
                            <!-- 1st row Start -->
                        </div>
                        <div class="row">
							<div class="col-md-12">
                                <div class="card mb-4">
                                    <h6 class="card-header">Registration Chart</h6>
                                    <div class="card-body card-body1123">
                                        <div id="am-pie-2" style="height: 400px"></div>
                                    </div>
                                </div>
                            </div>
							<div class="col-md-12">
                                <div class="card mb-4">
                                    <h6 class="card-header">Assessment Pie Chart</h6>
                                    <div class="card-body card-body1123">
                                        <div id="am-pie-1" style="height: 400px"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- 1st row Start -->
                        </div>
						 <div class="row">
						 <div class="col-lg-12">
                                <div class="card mb-4">
                                    <h6 class="card-header">Most Vulnerable Chart</h6>
                                    <div class="card-body card-body1123">
                                        <div id="am-xy-10" style="height: 300px"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- 1st row Start -->
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <h6 class="card-header">Mild Chart</h6>
                                    <div class="card-body card-body1123">
                                        <div id="am-xy-20" style="height: 300px"></div>
                                    </div>
                                </div>
                            </div>
							
                            <!-- 1st row Start -->
                        </div>
                        <div class="RegistrationChart">
                        	<ul>
                        		<li><strong>Detachment : </strong> A feeling of emotional freedom resulting from a lack of involvement in a problem or situation with a person</li>
                        		<li><strong>Antagonism : </strong> Active hostility or opposition</li>
                        		<li><strong>Disinhibition : </strong> Disinhibition or loss of the normal control exerted by the cerebral cortex, resulting in poorly controlled or poorly restrained emotions or action. Disinhibition may be due to the effects of alcohol, drugs or brain injury particularly to the frontal lobes.</li>
                        		<li><strong>Negative Effect : </strong> The internal feeling state that occur when one has failed to achieve goal or to avoid threat or when one is not satisfied with the current of affairs.</li>
                        		<li><strong>Psychoticism : </strong> Dimension of personality in eysenck's dimensions characterised by aggression, impulsivity, aloofness and antisocial behaviour indicating a susceptibility to psychosis and psychopath disorders.</li>
                        	</ul>
                        </div>
                    </div>
                    <!-- [ content ] End -->

                    <!-- [ Layout footer ] Start -->
                    <nav class="layout-footer footer footer-light" >
                        <div class="container-fluid d-flex flex-wrap justify-content-between text-center container-p-x pb-3">
                            <div class="pt-3">
                                <span class="float-md-right d-none d-lg-block">© Copyright 2023 Health Gennie®. All rights reserved.</span>
                            </div>
                            <!--<div>
                                <a href="javascript:" class="footer-link pt-3">About Us</a>
                                <a href="javascript:" class="footer-link pt-3 ml-4">Help</a>
                                <a href="javascript:" class="footer-link pt-3 ml-4">Contact</a>
                                <a href="javascript:" class="footer-link pt-3 ml-4">Terms &amp; Conditions</a>
                            </div>-->
                        </div>
                    </nav>
                    <!-- [ Layout footer ] End -->
                </div>
                <!-- [ Layout content ] Start -->
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper] End -->

@extends('pages.quiz-files.footer')

</body>
<!-- Mirrored from html.phoenixcoded.net/empire/bootstrap/default/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 21 Feb 2023 05:57:22 GMT -->
</html>