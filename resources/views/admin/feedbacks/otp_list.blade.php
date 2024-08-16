@extends('layouts.admin.Masters.Master')
@section('title', 'Otp List')
@section('content')
<!-- Content Wrapper. Contains page content -->


<div class="layout-wrapper layout-2">
    <div class="layout-inner">
        <div class="layout-container" style="padding-top: 0px !important;">
            <div class="container-fluid flex-grow-1 container-p-y">


                <div class="row form-top-row">

                    <div class="btn-group">
                        <a class="btn btn-success" href="javascript:void();">{{$otps->total()}}</a>
                    </div>

                    <div class="btn-group head-search">

                        <div class="ml-sm-2">
                            
                            {!! Form::open(array('route' => 'admin.otpList', 'id' => 'chnagePagination',
                            'method'=>'POST')) !!}

                            <select class="form-control" name="page_no" onchange="chnagePagination(this.value);">
                                <!--<option value="10" @if(isset($_GET['page_no'])) @if(base64_decode($_GET['page_no']) == '10') selected @endif @endif>10</option>-->
                                <option value="25" @if(isset($_GET['page_no']))
                                    @if(base64_decode($_GET['page_no'])=='25' ) selected @endif @endif>25</option>
                                <option value="50" @if(isset($_GET['page_no']))
                                    @if(base64_decode($_GET['page_no'])=='50' ) selected @endif @endif>50</option>
                                <option value="100" @if(isset($_GET['page_no']))
                                    @if(base64_decode($_GET['page_no'])=='100' ) selected @endif @endif>100</option>
                                <option value="300" @if(isset($_GET['page_no']))
                                    @if(base64_decode($_GET['page_no'])=='300' ) selected @endif @endif>300</option>
                            </select>
                        </div>

                        <div class="ml-sm-3">
                      
                            <input name="search" type="text" placeholder="Enter Mobile Number" class="form-control capitalizee" 
                                value="@if(isset($_GET['search'])) {{base64_decode($_GET['search'])}}  @endif">
                        </div>

                        <div class=" ml-sm-2">
                        
                            <div class="input-group custom-search-form">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary form-control" type="submit">
                                        SEARCH
                                    </button>
                                </span>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>


                <div class="layout-content">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Mobile</th>
                                    <th>OTP</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($otps->count() > 0)
                                @foreach($otps as $index => $element)
                                <tr>
                                    <td>
                                        <label>{{$index+($otps->currentpage()-1)*$otps->perpage()+1}}.</label>
                                    </td>
                                    <td>{{$element->mobile_no}}</td>
                                    <td>{{$element->otp}}</td>
                                    <td>{{date('d M Y', strtotime($element->created_at))}} </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8">No Record Found </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="page-nation text-right d-flex justify-content-end mb-2 mt-2">
                    <ul class="pagination pagination-large">
                        {{ $otps->appends($_GET)->links() }}
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>




<script>
function chnagePagination(e) {
    $("#chnagePagination").submit();
}
</script>
@endsection