<div class="modal-dialog modal-dialog111">
    <!-- Modal content-->
    <div class="modal-content ">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h4 class="modal-title">Lab Companies
</h4>
		</div>
		<div class="modal-body">
			<div class="panel panel-bd lobidrag">
				<div class="">
					<div class="btn-group" style="padding-bottom:10px;">
						<a class="btn btn-primary" href="{{ route('lab.company') }}"> <i class="fa fa-list"></i>  Lab Companies
 List</a>
					</div>
				</div>
				<div class="panel-body">
					{!! Form::open(array('id' => 'editLab','name'=>'admin.labCollection.edit')) !!}
					<div class="row">
					<input type=hidden value="{{$lab->id}}" name="id"/>
          <div class="col-md-6 pad-left0">
  				<div class="form-group">
  					<label>Company Name</label>
  			<input  name="title"  type="text" class="form-control" value="{{$lab->title}}"/>
  					<span class="help-block"></span>
  				</div>
  				</div>
  				<div class="col-md-6">
  				<div class="form-group labDropDown">
  					<label>Discount</label>
  				<input  name="discount"  type="text" class="form-control" value="{{$lab->discount}}" />
  					<span class="help-block"></span>
  				</div>
  				</div>
  				<div class="col-md-6">
  				<div class="form-group">
  					<label>Desiccation</label>
  					<input name="desc"  type="text" class="form-control" value="{{$lab->desc}}" />
  					<span class="help-block"></span>
  					<div class="suggesstion-box" style="display:none;"></div>
  				</div>
  				</div>
  				<div class="col-md-6">
  				<div class="form-group">
  					<label>Start Time</label>
  					<input type="time" name="start_time" class="form-control" value="{{$lab->start_time}}"  />
  					<span class="help-block"></span>
  				</div>
  				</div>
  				<div class="col-md-6">
  				<div class="form-group">
  					<label>End Time</label>
  					<input  type="time" name="end_time" class="form-control" value="{{$lab->end_time}}"  />
  					<span class="help-block"></span>
  				</div>
  				</div>
  				<div class="col-md-6">
  				<div class="form-group">
  					<label>Slot Duration</label>
  					<input  type="number" name="slot_duration" class="form-control" value="{{$lab->slot_duration}}" />
  					<span class="help-block"></span>
  				</div>
  				</div>
					<div class="col-md-6">
					<div class="form-group">
						<label>Company Logo</label>
						<input type="file" name="icon" class="form-control" />
						<input type="hidden" name="old_icon" class="form-control" value="{{$lab->icon}}"/>
						<span class="help-block"></span>
					</div>
					</div>
					<div class="col-md-6">
					<div class="form-group">
						<label style="width:100%;float:left;">Existing Logo</label>
						<img src="{{url("/")}}/public/others/company_logos/{{$lab->icon}}" height="50" width="50"/>
						<span class="help-block"></span>
					</div>
					</div>
					<div class="col-md-12">
						<div class="reset-button">
						   <button type="reset" class="btn btn-warning">Reset</button>
						   <button type="submit" class="btn btn-success submit">Update</button>
						</div>
					</div></div>
				 {!! Form::close() !!}
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>

<script src="{{ URL::asset('assets/js/bootstrap.js') }}"></script>
<!-- <script src="{{ URL::asset('js/validate.js') }}"></script> -->

<script type="text/javascript">
$(document).ready(function() {
setValue();
});
function setValue(){
	$('#exampleSelect2').multiselect({
		includeSelectAllOption: true,
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
	});
}
// When the browser is ready...
jQuery(document).ready(function () {
$(document.body).on('click', '.submit', function(){
		jQuery("#editLab").validate({
		rules: {
			company_id: {required:true},
			title: {required:true},
			price: {required:true,number:true},
			discount_price: {required:true,number:true},
		},
		// Specify the validation error messages
		messages: {
		},
		errorPlacement: function(error, element) {
		  error.appendTo(element.next());
		},
		submitHandler: function(form) {
			jQuery('.loading-all').show();
			jQuery('.submit').attr('disabled',true);
			jQuery.ajax({
				type: "POST",
				dataType : "JSON",
				url: "{!! route('admin.LabCompany.update')!!}",
				data:  new FormData(form),
				contentType: false,
				cache: false,
				processData:false,
				success: function(data) {
					 if(data==1) {
						jQuery('.submit').attr('disabled',false);
						location.reload();
					 }
					 else {
						alert("System Problem");
					 }
					 jQuery('.submit').attr('disabled',false);
					 jQuery('.loading-all').hide();
				 },
				 error: function(error){
					 jQuery('.submit').attr('disabled',false);
					 jQuery('.loading-all').hide();
					 alert("Oops Something goes Wrong.");
				 }
			});
		}
	});
  });
});
jQuery(document).on("change", ".company_id", function () {
	var company_id = $(this).val();
	console.log(company_id);
	getLabsByCompany(company_id);
});
function getLabsByCompany(company_id) {
var company_id = jQuery(".company_id").val();
  clinicSearchRequest = jQuery.ajax({
  type: "POST",
  url: "{!! route('getLabByCompany') !!}",
  data: {'company_id':company_id},
  success: function(response){
	  var liToAppend = "";
		if(response.length > 0){
		  jQuery.each(response,function(k,v) {
			 var title = null;
			 var short_name = null;
			 if(v.default_labs.title){
				title = v.default_labs.title;
			 }
			 if(v.default_labs.short_name){
				short_name = v.default_labs.short_name;
			 }
			liToAppend += '<option value="'+v.id+'" class="dataLabList">'+title+' '+short_name+'</option>';
		  });
		}else{
			liToAppend += '<option value="0">'+jQuery(currSearch).val()+'Lab Not Found.</option>';
	  }
	  $(".labDropDown").find(".selectpicker:first").html('');
	  $(".labDropDown").find(".selectpicker:first").html(liToAppend);
	  $("#exampleSelect2").multiselect('destroy');
	  setValue();
  }
  });
}
</script>
