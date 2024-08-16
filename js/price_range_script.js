
$(document).ready(function(){
	jQuery("."+filtered_div).find('#price-range-submit').hide();

	jQuery("."+filtered_div).find("#min_price,#max_price").on('change', function () {

	  jQuery("."+filtered_div).find('#price-range-submit').show();

	  var min_price_range = parseInt(jQuery("."+filtered_div).find("#min_price").val());

	  var max_price_range = parseInt(jQuery("."+filtered_div).find("#max_price").val());

	  if (min_price_range > max_price_range) {
		jQuery("."+filtered_div).find('#max_price').val(min_price_range);
	  }

	  jQuery("."+filtered_div).find("#slider-range").slider({
		values: [min_price_range, max_price_range]
	  });
	  
	});


	jQuery("."+filtered_div).find("#min_price,#max_price").on("paste keyup", function () {                                      

	  jQuery("."+filtered_div).find('#price-range-submit').show();

	  var min_price_range = parseInt(jQuery("."+filtered_div).find("#min_price").val());

	  var max_price_range = parseInt(jQuery("."+filtered_div).find("#max_price").val());
	  
	  if(min_price_range == max_price_range) {

			max_price_range = min_price_range + 0;
			
			jQuery("."+filtered_div).find("#min_price").val(min_price_range);		
			jQuery("."+filtered_div).find("#max_price").val(max_price_range);
	  }

	  jQuery("."+filtered_div).find("#slider-range").slider({
		values: [min_price_range, max_price_range]
	  });

	});

	$(function () {
		var min_val = 0;
		var max_val = 10000; 
			
		if(jQuery("."+filtered_div).find("#min_price").val() != '') { 
			min_val = jQuery("."+filtered_div).find("#min_price").val();
		}
		if(jQuery("."+filtered_div).find("#max_price").val() != ''){
			max_val = jQuery("."+filtered_div).find("#max_price").val();
		}
		  if(jQuery("."+filtered_div).find("#min_price").val() != '' && jQuery("."+filtered_div).find("#max_price").val() != '') {
			jQuery("."+filtered_div).find("#searchResults").text("Doctors whose consultation fee is between "+min_val  +" & "+max_val+" will be displayed");
		  }
		  jQuery("."+filtered_div).find("#slider-range").slider({
			range: true,
			orientation: "horizontal",
			min: 0,
			max: 10000,
			values: [min_val, max_val],
			step: 1,
			slide: function (event, ui) {
			  if (ui.values[0] == ui.values[1]) {
				  return false;
			  }
			  jQuery("."+filtered_div).find("#min_price").val(ui.values[0]);
			  jQuery("."+filtered_div).find("#max_price").val(ui.values[1]);
			  jQuery("."+filtered_div).find('#price-range-submit').show();	
			}
		  });
		  setTimeout(function() {
				jQuery("."+filtered_div).find("#min_price").val(jQuery("."+filtered_div).find("#slider-range").slider("values", 0));
				jQuery("."+filtered_div).find("#max_price").val(jQuery("."+filtered_div).find("#slider-range").slider("values", 1));
		  }, 1500);
	 });
	
		jQuery("."+filtered_div).find("#slider-range,#price-range-submit").click(function () {
		var min_price = jQuery("."+filtered_div).find('#min_price').val();
		var max_price = jQuery("."+filtered_div).find('#max_price').val();
		jQuery("."+filtered_div).find("#searchResults").text("Doctors whose consultation fee is between "+min_price  +" & "+max_price+" will be displayed");
	});

});