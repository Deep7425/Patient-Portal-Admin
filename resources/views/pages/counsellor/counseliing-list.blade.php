<!DOCTYPE html>
<html lang="en" class="default-style layout-fixed layout-navbar-fixed">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<!-- Mirrored from html.phoenixcoded.net/empire/bootstrap/default/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 21 Feb 2023 05:55:51 GMT -->


@extends('pages.counsellor.header')
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
                                <a href="{{url("/")}}/counseling-dashboard/{{$orgData->slug}}" class="sidenav-link">
                                    <div>Home</div>
                                </a>
                            </li>
							<li class="sidenav-item">
                                <a href="{{url("/")}}/counseling-list/{{$orgData->slug}}" class="sidenav-link">
                                    <div>List</div>
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
                        <h4 class="font-weight-bold py-3 mb-0">Counseling List</h4>
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
                                    <div class=" dd-wrapper">
                                    	<div id="bootstrap-table-toolbar">
                                          <form id="chnagePagination" action="{{route('counseling-list',$orgData->slug)}}">
										  @csrf
                                            <div class="form-field">
                                                <label for="cars">Search By Status:</label>
                                                <select id="assesment" class="byassesement" name="status">
                                                <option value="">Select</option>
                                                    <option value="1" @if((app('request')->input('status'))!='') @if(app('request')->input('status') == '1') selected @endif @endif>Normal</option>
                                                    <option value="2" @if((app('request')->input('status'))!='') @if(app('request')->input('status') == '2') selected @endif @endif>Mild</option>
                                                    <option value="3"  @if((app('request')->input('status'))!='') @if(app('request')->input('status') == '3') selected @endif @endif>Most Vulnerable</option>
                                                </select>
                                                <input type="hidden" name="file_type" id="file_type" value="{{ old('file_type') }}"/>
                                                 </div>

                                                 <div class="form-field">
                                                <label for="cars">Search By Counseling Status:</label>
                                                <select id="assesment" class="byassesement" name="session_status">
                                                <option value="">Select</option>
                                                    <option value="0" @if((app('request')->input('session_status'))!='') @if(app('request')->input('session_status') == '0') selected @endif @endif>Pending</option>
                                                    <option value="1" @if((app('request')->input('session_status'))!='') @if(app('request')->input('session_status') == '1') selected @endif @endif>Done</option>
                                                    
                                                </select>
                                                <input type="hidden" name="file_type" id="file_type" value="{{ old('file_type') }}"/>
                                                 </div>

                                               <div class="form-field form-fieldNext">  
                                               	<div class="form-field123">
                                               		<div class="form-field1234">
                                               <label>From Date: </label><input type="text" name="from_date" id="datepicker" placeholder="From date" value="@if((app('request')->input('from_date'))!=''){{ app('request')->input('from_date') }}@endif"></div><div class="form-field1234"> <label> To Date:</label> <input name="to_date" type="text" id="datepicker1" placeholder="To date" value="@if((app('request')->input('to_date'))!=''){{ app('request')->input('to_date') }}@endif">
                                            </div>
                                             </div>
                                              </div>

                                              <div class="form-field">  
                                               <label>Name/Mobile: </label><input type="text" name="candidate" id="datepicker" placeholder="Name/Mobile" value="@if((app('request')->input('candidate'))!=''){{ app('request')->input('candidate') }}@endif"> <label> 
                                                
                                              </div>

                                              <button type="submit">Search</button>
                                              <button type="button" id="councelingp">Counceling</button>

                                         </form>
                                         <div class="btn-group">
                                      <a href="javascript:void(0);" class="btn btn-defaultp" onClick='ForExcel()' title='Excel'><img src='{{ url("/img/excel-icon.png") }}'/></a>
                                    </div>
									</div>
                                    </div>
                                    </div>
						 	<div class="row">
							<!--<h4 class="font-weight-bold py-3 mb-0">Bootstrap table</h4>
							<div class="text-muted small mt-0 mb-4 d-block breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
									<li class="breadcrumb-item" >Tables</li>
									<li class="breadcrumb-item active" >Bootstrap table</li>
								</ol>
							</div>-->
							<!-- <div class="card" id="cuP21" text-data="{{base64_encode($orgData->pwd)}}">
								<div class="card-body">
									<div id="bootstrap-table-toolbar">
										<h4>Health Assessment Score</h4>
									</div>
									<table id="bootstrap-table-example" data-toolbar="#bootstrap-table-toolbar" data-search="true" data-show-refresh="true" data-show-columns="true" data-show-export="true" data-detail-view="true" data-minimum-count-columns="2"
										data-show-pagination-switch="false" data-pagination="true" data-id-field="id" data-show-footer="true" data-url="/assessment-table-data/{{$orgData->slug}}">
									</table>
								</div>
							</div> -->
                            <form id="counceling" action="{{url('councilingdone')}}">
                            <div class="talbeBlock">
                            <table class="table table-hover" style="width: 1037.17px;"><thead><tr><th>SR No </th><th><input class="custom_css" onclick="CheckAll(this)" type="checkbox" name="counce_id[]" ></th><th>Name</th><th>Gender</th><th>Mobile</th><th>Age</th><th>Session Status</th><th>Note</th><th>Detachment</th><th>Antgonism</th><th>Disinhibition</th><th>Psuchoticism</th><th>Total Score</th><th>Status</th></tr>
                            <?php $i=1; ?>
                            @foreach($enquirys as $enquirysres)
                           

                           <tr>
                            <td>{{$i}}  <label></td><td><input class="custom_css"  type="checkbox" name="counce_id[]" value="{{$enquirysres['id']}}"></td><td><a href="{{url("/")}}/report-card/{{base64_encode($enquirysres->id)}}/{{$orgData->slug}}">{{@$enquirysres->QuizForm->name}}</a></td><td>{{@$enquirysres->QuizForm->gender}}</td><td>{{@$enquirysres->QuizForm->mobile}}</td><td>{{@$enquirysres->QuizForm->age}}</td><td>   @if($enquirysres['session_status']==0) <b style="color:red">Pending</b> @endif
                                @if($enquirysres['session_status']==1) <b style="color:green">Done</b> @endif</td>
                                <td><input type="text" name="note" value="{{@$enquirysres['note']}}" class="addNote" counsellor_id={{$enquirysres['id']}} style="width:250px; height:60px;" ondblclick="this.readOnly='';" readonly="true"></td>
                                <td>{{$enquirysres['detechment']}}</td><td>{{$enquirysres['detechment']}}</td><td>{{$enquirysres['antagonism']}}</td><td>{{$enquirysres['disinhibition']}}</td><td>{{$enquirysres['psychoticism']}}</td>
                            <td>{{$enquirysres['finalTotalScore']}}</td>
                            <td>
                                @if($enquirysres['status']==0) Pending @endif
                                @if($enquirysres['status']==2) Done @endif
                                
                            </td>
                           
                             
                            <?php $i++; ?>
                            @endforeach
                             </form>
                        </thead></table>
</div>
						{{ $enquirys->links() }}
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
    @extends('pages.counsellor.footer')
</body>

<script>
 function CheckAll(x)
    {
        var allInputs = document.getElementsByName(x.name);
        for (var i = 0, max = allInputs.length; i < max; i++) 
        {
            if (allInputs[i].type == 'checkbox')
            if (x.checked == true)
                allInputs[i].checked = true;
            else
                allInputs[i].checked = false;
        }
    }

    $(function () {
        
            $("#councelingp").on("click", function () {
               
                $("#counceling").trigger('submit');
            });
        });

        $(".addNote").keyup(function(){
            
           var counsellor_id= $(this).attr('counsellor_id');
         
                $.ajax({           
                type: 'GET',           
                url: "{{route('addNote')}}",        
                data:{'note': $(this).val(),'counsellor_id':counsellor_id},     
                success: function(result) {           
                if(result.success) {               
                location.reload();       
                }           
                },           
                error: function() {               
                console.log(error);            
                }       
                });
        

                // $.ajax({
                //     url: "{{route('addNote')}}",
                //     type: 'GET',
                //     data:{'note': $(this).val(),'counsellor_id':counsellor_id},
                //     processData: false,
                //     success: (response) => {
                //         // success
                //         console.log("success",response);
            
                
                //     },
                //     error: (response) => {
                //         console.log("error",response);
                //     }
                // });
             

        });

</script>    
<!-- Mirrored from html.phoenixcoded.net/empire/bootstrap/default/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 21 Feb 2023 05:57:22 GMT -->
</html>