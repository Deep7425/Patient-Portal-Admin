<html>
<head></head>
<body>
<div class="container">
  <div class="container-inner contact-wrapper contact-us">
    <h2>Set PDF Header</h2>
	<form method="POST" action="{{route('changePdfHeader')}}" enctype="multipart/form-data" accept="application/pdf">
	@csrf
    <div class="form-fields">
      <label>Upload File <i class="required_star">*</i></label>
		<input type="file" required value="" name="pdf_doc" placeholder="Upload PDF report File" />
		</div>
		<div class="form-submit">
          <div class="button-contact text-right">
            <input type="submit" id="submit" value="Submit" />
            <div class="success-data" style="display:none;"></div>
          </div>
		  </div>
     </form>
  </div>
</div> 
</body>
</html> 