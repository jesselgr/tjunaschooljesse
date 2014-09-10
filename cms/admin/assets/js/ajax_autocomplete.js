function call_ajax_autocomplete(field){
		$.ajax({  
	     type: "POST",  
	     data: {},
	  	 dataType: "json",
	     url: base_url+'datahandler/get_component_for_ajax/'+field,  
	   	 success: function(output) {
	   	 
  			$( "#"+field ).autocomplete({
				source: output
			});
		 }
	}); 
}
