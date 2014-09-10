$(function() {
	$(".order_reset").hide(); 
	//activate sortable on draglist
	$('.contentList').disableSelection();
    $(".contentList").sortable({
     
        forcePlaceholderSize: true,
		items: "li:not(.drag-disabled)",
        autoscroll: 'true',
        placeholder: 'placeholder',
        forcePlaceholderSize: true,
		connectWith: ".contentList",
		delay: 300
                
      });
	
	$( ".contentList" ).bind( "sortstop", function(event, ui){
	    $(".order_reset").fadeIn(500);       

       // call sortable_to_array to convert the html elements to php vars
       var list = ui.item.parent().sortable("toArray");

         
        var content_id = ui.item.context.id;
        var section_id = ui.item.parent().attr('id');
        
        
        var items = {'section_id' : section_id, 'content_id' :content_id, 'list' : list};
		 
         $.post(base_url+'page/content/update_section_order/', {items: items}, function(data) {
			console.log(data);
         });
         $('.changeMessage').show().delay(2000).fadeOut();        
    });

	
	$( ".order_reset" ).click(function(event, ui){
		if(confirmSubmit('reset?')){
			$(".contentList").sortable( "cancel" );
			
			 $('.changeMessage').show().delay(2000).fadeOut();	
		 }
		 $(".order_reset").fadeOut(300); 
	});
});