<!DOCTYPE html>
<html lang="en" class="default-style layout-fixed layout-navbar-fixed">

<!-- Mirrored from html.phoenixcoded.net/empire/bootstrap/default/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 21 Feb 2023 05:55:51 GMT -->
<head>
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Health Assessment By Health Gennie</title>
	<meta name="description" content="To learn more about your well-being, participate in this health assessment here."/>
	<meta name="keywords" content="health assessment, self health assessment, health impact assessment, health needs assessment"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description"
        content="Empire is one of the unique admin template built on top of Bootstrap 4 framework. It is easy to customize, flexible code styles, well tested, modern & responsive are the topmost key factors of Empire Dashboard Template" />
    <meta name="keywords" content="bootstrap admin template, dashboard template, backend panel, bootstrap 4, backend template, dashboard template, saas admin, CRM dashboard, eCommerce dashboard">
    <meta name="author" content="Codedthemes" />
    <link rel="shortcut icon" href="/img/favicon.ico"/>
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- Icon fonts -->
    <link rel="stylesheet" href="/quiz-asset/fonts/fontawesome.css">
    <link rel="stylesheet" href="/quiz-asset/fonts/ionicons.css">
    <link rel="stylesheet" href="/quiz-asset/fonts/linearicons.css">
    <link rel="stylesheet" href="/quiz-asset/fonts/open-iconic.css">
    <link rel="stylesheet" href="/quiz-asset/fonts/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="/quiz-asset/fonts/feather.css">
    <!-- Core stylesheets -->
    <link rel="stylesheet" href="/quiz-asset/css/bootstrap-material.css">
    <link rel="stylesheet" href="/quiz-asset/css/shreerang-material.css">
    <link rel="stylesheet" href="/quiz-asset/css/uikit.css">
    <!-- Libs -->
    <link rel="stylesheet" href="/quiz-asset/libs/flot/flot.css">
	    <!-- Libs -->
    <link rel="stylesheet" href="/quiz-asset/libs/bootstrap-table/bootstrap-table.css">
    <link rel="stylesheet" href="/quiz-asset/libs/bootstrap-datepicker/bootstrap-datepicker.css">

</head>
<body>
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
	
    <div class="layout-wrapper layout-2" id="cuP21" text-data="{{base64_encode($orgData->pwd)}}">

        <div class="layout-inner">
            <!-- [ Layout sidenav ] Start -->
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-white logo-dark">
                <!-- Brand demo (see assets/css/demo/demo.css) -->
                <div class="app-brand demo">
                    <span class="app-brand-logo demo">
                        <img src="/quiz-asset/img/Logo.png" alt="Brand Logo" class="img-fluid">
                    </span>
                    <a href="{{url("/")}}/assessment-admin/{{@$orgData->slug}}" class="app-brand-text demo sidenav-text font-weight-normal ml-2">Health Gennie</a>
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
                            <li class="sidenav-item">
                                <a href="{{url("/")}}/assessment-admin/{{$orgData->slug}}" class="sidenav-link">
                                    <div>Home</div>
                                </a>
                            </li>
							<li class="sidenav-item active">
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
                                <a href="{{url("/")}}/report-card/{{$orgData->slug}}" class="sidenav-link">
                                    <div>Report Card</div>
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
                        <h4 class="font-weight-bold py-3 mb-0">Report Card Details</h4>
                        <!--<div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active">Main</li>
                            </ol>
                        </div>-->
                      
                        
						 <div class="container-fluid flex-grow-1 container-p-y container-p-y-ss">

                         <!-- <div id="bootstrap-table-toolbar">
										<h4>Health Assessment Score</h4>
									</div> -->
                             
						 	<div class="row">

                             <div class="form-field">
                                                <label for="cars">Search By Status:</label>
                                                <select id="assesment" class="byassesement" name="assesment">
                                                <option value="">Select</option>
                                                    <option value="normal" @if((app('request')->input('assesment'))!='') @if(app('request')->input('assesment') == 'normal') selected @endif @endif>Normal</option>
                                                    <option value="mild" @if((app('request')->input('assesment'))!='') @if(app('request')->input('assesment') == 'mild') selected @endif @endif>Mild</option>
                                                    <option value="most_vulnerable"  @if((app('request')->input('assesment'))!='') @if(app('request')->input('assesment') == 'most_vulnerable') selected @endif @endif>Most Vulnerable</option>
                                                </select>
                                                <input type="hidden" name="file_type" id="file_type" value="{{ old('file_type') }}"/>
                                                 </div>


                            <p><h2>Current State: {{@$enquirys->assessement}} </h2></p>
                            <div class="talbeBlock">
                            <table class="table table-hover" style="width: 1037.17px;"><thead><tr><th>SR No</th><th>Name</th><th>Psycological Session </th><th>Session Assigned</th><th>Session Attendant</th> <th>Date Of Session</th><th>Status</th><th>Next Screening date</th></tr>
                            <?php $i=1; ?>
                          @foreach($SessionAssesdata as $resdata) 
                           <tr>
                            <td>{{$i}}</td><td>{{@$resdata->QuizForm->name}}</td>
                            <td>
                                @if($resdata->psyco_session==1)
                                Group
                                @else
                                Individual
                                @endif
                            </td>
                            <td>{{$resdata->session_assigned}}</td>
                            <td>{{$resdata->session_taken}}</td>
                            <td>{{$resdata->screening_date}}</td>
                            <td>@if($resdata->session_assigned==$resdata->session_taken) <span style="color:green">Completed</span> @else <span style="color:red">Pending </span> @endif</td>
                            <td><input name="next_session_date" class="datepicker1 next_date" type="text" id="datepicker1" placeholder="To date" session_id="{{$resdata->id}}" value="{{$resdata->next_session_date}}"></td>
                             <input type="hidden" class="session_id"  name="session_id" value="{{$resdata->id}}">
                            <?php $i++; ?>
                          </tr>

                          @endforeach
                           
                        </thead></table>
</div>
					
							</div>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="modal-content">
                    <div class="modal-body pb-1">
                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>-->
                        <div class="text-center">
                            <h3 class="mt-3">Welcome To {{$orgData->title}}<span class="text-primary"> Health Assessment</span></h3>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-interval="50000">
                                <div class="row align-items-center">
                                    <div class="col-md-6 text-center text-center-welcome">
                                        <img src="/quiz-asset/img/pages/welcome.png" class="img-fluid my-4" alt="images">
                                    </div>
                                    <div class="col-md-6">
                                        <p class="f-16"><strong>Health Assessment </strong> will come with student score list.</p>
                                        <p class="f-16"> it include <strong>5 Personality Trait Domain Scoring</strong> like</p>
                                        <p class="mb-2 f-16"><i class="feather icon-check-circle mr-2 text-primary"></i>Negative Affect</p>
                                        <p class="mb-2 f-16"><i class="feather icon-check-circle mr-2 text-primary"></i>Detachment</p>
                                        <p class="mb-2 f-16"><i class="feather icon-check-circle mr-2 text-primary"></i>Antagonism</p>
                                        <p class="mb-2 f-16"><i class="feather icon-check-circle mr-2 text-primary"></i>Disinhibition</p>
                                        <p class="mb-2 f-16"><i class="feather icon-check-circle mr-2 text-primary"></i>Psychoticism</p>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-9">
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item" data-interval="50000">
                            	<div class="row">
                            	<div class="col-lg-6">
                                <img src="../quiz-asset/img/admin-1.png" class="img-fluid mt-0" alt="images">
								</div>
								
								<div class="col-lg-6">
								 <div class="card mb-4">
									<h6 class="card-header">Login</h6>
									<div class="card-body">
									<div class="alert alert-dark-primary alert-dismissible show" id="redAlert" style="display:none;">
										Incorrect Password — check it out!
									</div>
									
									<div class="alert alert-dark-success alert-dismissible show" id="greenAlert" style="display:none;">
										Login Successfully !
									</div>
											<div class="form-row">
												<div class="form-group col-md-12 form-group-topnew">
													<label class="form-label">User</label>
													<input type="text" class="form-control" placeholder="User" value="{{$orgData->title}}" readonly>
													<div class="clearfix"></div>
												</div>
												<div class="form-group col-md-12">
													<label class="form-label">Password</label>
													<input type="password" class="form-control" id="cPwd" placeholder="Password">
													<div class="clearfix"></div>
												</div>
											</div>
											<!--<div class="form-group">
												<label class="custom-control custom-checkbox m-0">
													<input type="checkbox" class="custom-control-input">
													<span class="custom-control-label">Remember me</span>
												</label>
											</div>-->
											<button type="button" class="btn btn-primary signInBtn">Sign in</button>
									</div>
								</div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none" style="transform:rotate(180deg);margin-bottom:-1px">
                        <path class="elementor-shape-fill" fill="#2c3134" opacity="0.33"
                            d="M473,67.3c-203.9,88.3-263.1-34-320.3,0C66,119.1,0,59.7,0,59.7V0h1000v59.7 c0,0-62.1,26.1-94.9,29.3c-32.8,3.3-62.8-12.3-75.8-22.1C806,49.6,745.3,8.7,694.9,4.7S492.4,59,473,67.3z">
                        </path>
                        <path class="elementor-shape-fill" fill="#2c3134" opacity="0.66"
                            d="M734,67.3c-45.5,0-77.2-23.2-129.1-39.1c-28.6-8.7-150.3-10.1-254,39.1 s-91.7-34.4-149.2,0C115.7,118.3,0,39.8,0,39.8V0h1000v36.5c0,0-28.2-18.5-92.1-18.5C810.2,18.1,775.7,67.3,734,67.3z"></path>
                        <path class="elementor-shape-fill" fill="#2c3134" d="M766.1,28.9c-200-57.5-266,65.5-395.1,19.5C242,1.8,242,5.4,184.8,20.6C128,35.8,132.3,44.9,89.9,52.5C28.6,63.7,0,0,0,0 h1000c0,0-9.9,40.9-83.6,48.1S829.6,47,766.1,28.9z">
                        </path>
                    </svg>
                    <div class="modal-body text-center py-4" style="background:#2c3134">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <!-- <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> -->
                        </ol>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="ml-2">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="mr-2">Next</span>
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <script src="/quiz-asset/js/pace.js"></script>
    <script src="/quiz-asset/js/jquery-3.2.1.min.js"></script>
    <script src="/quiz-asset/libs/popper/popper.js"></script>
    <script src="/quiz-asset/js/bootstrap.js"></script>
    <script src="/quiz-asset/js/sidenav.js"></script>
    <script src="/quiz-asset/js/layout-helpers.js"></script>
    <script src="/quiz-asset/js/material-ripple.js"></script>

    <!-- Libs -->
    <script src="/quiz-asset/libs/eve/eve.js"></script>
    <script src="/quiz-asset/libs/flot/flot.js"></script>
    <script src="/quiz-asset/libs/flot/curvedLines.js"></script>
    <script src="/quiz-asset/libs/chart-am4/core.js"></script>
    <script src="/quiz-asset/libs/chart-am4/charts.js"></script>
    <script src="/quiz-asset/libs/chart-am4/animated.js"></script>
	
	<script src="/quiz-asset/libs/tableexport/tableexport.js"></script>
    <script src="/quiz-asset/libs/moment/moment.js"></script>
    <script src="/quiz-asset/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="/quiz-asset/libs/bootstrap-table/bootstrap-table.js"></script>
    <script src="/quiz-asset/libs/bootstrap-table/extensions/export/export.js"></script>

    <!-- Demo -->
    <script src="/quiz-asset/js/demo.js"></script>
	<script src="/quiz-asset/js/analytics.js"></script>
    <script src="/quiz-asset/js/pages/tables_bootstrap-table.js"></script>
  
    <!-- CSS CDN -->
    <link rel="stylesheet"
          href=
"https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
    />
    <!-- datetimepicker jQuery CDN -->
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
   </script>
<script src="/quiz-asset/js/pages/dashboards_index.js"></script>
    

<script>
      function ForExcel() {
     
	  jQuery("#file_type").val("excel");
	  $("#chnagePagination").submit();
	  jQuery("#file_type").val("");
	}

    $(function(){
    $("#datepicker").datepicker();
});

// $(".datepicker1").datetimepicker({
//   step: 30,
//   format:'d/m/Y H:m'
// });

$(".datepicker1").each(function () {
        $(this).datetimepicker();
});

// $(function(){
//     $(".datepicker1").datepicker();
// });
        $(document).ready(function() {
            checkCookie();
			// $('#example').dataTable({"responsive": true});
        });

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function checkCookie() {
            var ticks = getCookie("modelopen");
			console.log(ticks);
            if (ticks == "") {
                // ticks++;
                // setCookie("modelopen", ticks, 1);
                // if (ticks == "2" || ticks == "1" || ticks == "0") {
                    // $('#exampleModalCenter').modal();
                // }
            // } else {
                // $('#exampleModalCenter').modal();
				$("#exampleModalCenter").modal({
					show:true,
					backdrop:'static',
					 keyboard: false
				});
		    }
        }
		jQuery(document).on("click", ".logOut", function (e) {
			document.cookie = 'modelopen=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
			location.href = '';
		});
		jQuery(document).on("click", ".signInBtn", function (e) {
			let cPwd = $("#cPwd").val();
			let upwd =  atob($("#cuP21").attr('text-data'));
			if(cPwd  == upwd){
				$("#redAlert").hide();
				$("#greenAlert").show();
				setCookie("modelopen", 1,2);
				setTimeout(function(){
					$('#exampleModalCenter').modal('hide');
				}, 1000);
			}
			else{
				$("#redAlert").show();
				$("#greenAlert").hide();
			}
		});



        $(".next_date").change(function(){

            var datatime=$(this).val();
            // var session_id=$('.session_id').val();
            var session_id = $(this).attr("session_id");
         
            jQuery.ajax({
				type: "POST",
				dataType : "JSON",
				url: "{!! url('updateNextsessiondate') !!}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data:  { 
                    'session_id': session_id, 
                    'datatime': datatime // <-- the $ sign in the parameter name seems unusual, I would avoid it
               },
				
				success: function(data)
					{
					
				   },
					error: function(error)
					{
           
					}
				 });
           });


    

    </script>
</body>
<!-- Mirrored from html.phoenixcoded.net/empire/bootstrap/default/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 21 Feb 2023 05:57:22 GMT -->
</html>