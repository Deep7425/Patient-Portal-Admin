@extends('layouts.admin.Masters.Master')
@section('title', 'Notification Master')
@section('content')

<div class="layout-wrapper layout-2">
    <div class="layout-inner">
        <div class="layout-container" style="padding-top: 0px !important;">
            <div class="container-fluid flex-grow-1 container-p-y">
  <div class="row  form-top-row">             
@if(session()->get('successMsg'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{ session()->get('successMsg') }}
                </div>
                @endif
              
                    <div class="btn-group">
                        <a class="btn btn-success" href="javascript:void();">{{$notifications->total()}}</a>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-success" href="javascript::void(0)" data-toggle="modal" data-target="#AddModal"> New Notification Broadcast</a>
                  </div>

                    <div class="btn-group head-search">
                        <div class="dataTables_length">
                            {!! Form::open(array('route' => 'admin.notificationMaster', 'id' => 'chnagePagination',
                            'method'=>'POST')) !!}
                            <select class="form-control" name="page_no" onchange="chnagePagination(this.value);">
                                <!--<option value="10" @if(isset($_GET['page_no'])) @if(base64_decode($_GET['page_no']) == '10') selected @endif @endif>10</option>-->
                                <option value="25" @if(isset($_GET['page_no']))
                                    @if(base64_decode($_GET['page_no'])=='25' ) selected @endif @endif>25</option>
                                <option value="50" @if(isset($_GET['page_no']))
                                    @if(base64_decode($_GET['page_no'])=='50' ) selected @endif @endif>50</option>
                                <option value="100" @if(isset($_GET['page_no']))
                                    @if(base64_decode($_GET['page_no'])=='100' ) selected @endif @endif>100</option>
                            </select>
                        </div>

                        <div class="dataTables_length">
                            <div class="input-group custom-search-form">
                                <input name="search" type="text" class="form-control capitalizee"
                                    placeholder="Search By Module" value="{{ old('search') }}" />
                            </div>
                        </div>

                        <div class="dataTables_length">
                            <div class="input-group custom-search-form">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        SEARCH
                                    </button>
                                </span>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                   
                </div>

                <div class="layout-content card">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Title</th>
                                    <th>Notification</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($notifications->count() > 0)
                                @foreach($notifications as $index => $row)
                                <tr>
                                    <td>
                                        <label>{{$index+($notifications->currentpage()-1)*$notifications->perpage()+1}}.</label>
                                    </td>
                                    <td>{{$row->module_slug}}</td>
                                    <td>{{$row->notification}}</td>
                                    <td>{{date("d-m-Y",strtotime($row->created_at))}}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="9">No Record Found </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="page-nation text-right d-flex justify-content-end mb-2 mt-2">
                        <ul class="pagination pagination-large">
                            {{ $notifications->appends($_GET)->links() }}
                        </ul>
                    </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade notification-broadcast" id="AddModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">New Notification Broadcast</h4>
                </div>
                <div class="modal-body">
                    <div class="panel panel-bd">
                   
                        <div class="panel-body">
                            {!! Form::open(array('id' => 'newNotification','name'=>'newNotification')) !!}
                            <div class="form-group col-sm-12">
                                <label>Title</label>
                                <input value="" type="text" name="module_slug" class="form-control"
                                    placeholder="Enter Title" />
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Notification</label>
                                <textarea type="text" name="notification" class="form-control"
                                    placeholder="Enter Notification Message"></textarea>
                                <span class="help-block"></span>
                            </div>

                            <div class="reset-button col-sm-12">
                                <button type="reset" class="btn btn-warning">Reset</button>
                                <button type="submit" class="btn btn-success submit">Send</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EditModal" role="dialog" data-backdrop="static" data-keyboard="false"></div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>


<script>
$(document.body).on('click', '.submit', function() {
    jQuery("form[name='newNotification']").validate({
        rules: {
            module_slug: "required",
            notification: "required",
        },
        messages: {},
        errorPlacement: function(error, element) {
            error.appendTo(element.parent().find('.help-block'));
        },
        ignore: ":hidden",
        submitHandler: function(form) {
            $(form).find('.submit').attr('disabled', true);
            jQuery('.loading-all').show();
            jQuery.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{!! route('admin.newNotification')!!}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data == 1) {
                        jQuery('.loading-all').hide();
                        $(form).find('.submit').attr('disabled', false);
                        location.reload();
                    } else {
                        jQuery('.loading-all').hide();
                        $(form).find('.submit').attr('disabled', false);
                        alert("Oops Something Problem");
                    }
                },
                error: function(error) {
                    jQuery('.loading-all').hide();
                    alert("Oops Something goes Wrong.");
                }
            });
        }
    });
});

function chnagePagination(e) {
    $("#chnagePagination").submit();
}
</script>

@endsection