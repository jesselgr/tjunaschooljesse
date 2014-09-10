function fill_list_editor(){
	var content = '';
	
	$('.input_list').children().each(function(){
		
		field = $(this).find('.inputField');
		
		if(field.attr('value')){content+= field.attr('value')+';'};
		
	});
	
	$('#contentfield').val(content);
}


$(document).ready(function(){
	$(".input_list").sortable();
	$('.inputField').blur(function() {
		fill_list_editor();
	});
	
	$('#addButton').click(function(){	
		$('.input_list').append('<p><input type="text"  name="list-item" value="" class="inputField"/></p>');
	});
	
	$('.removeButton').click(function(e){
		$(e.target).parent().remove();
		fill_list_editor();
	});
	
	
	
	
});
