$(function() {
	$('a.deleteImage').live('click',function(e){
		
		if(confirmSubmit('delete this image?')){
			var $parent = $(this).parent();
			
			$parent.remove();
		}
		
		e.preventDefault();
		
	});
	



});

function multiImageInput(field){
	$('.add_input').click(function(e) {
		e.preventDefault();
		field = $(this).attr('rel');

		window.KCFinder = {
		    callBack: function(url) {
		        window.KCFinder = null;
		       
		        var html = '<li class="imageThumb"><input type="hidden" name = "'+field+'[]" id ="imageField" value = "'+url+'"/><a rel="shadowbox" target="blank" href="'+url+'"><img class= "imageThumb"  src="'+url+'"/></a><a  class="deleteImage buttonContentRed small" href="#">x</a></li>';
	
				
		        $('.'+field+'_container').append(html);
	
		        Shadowbox.setup();
		    }
		};
		window.open(base_url +'/core/kcfinder/browse.php?type=files&dir=files', 'kcfinder_textbox',
		    'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
		    'resizable=1, scrollbars=0, width=800, height=600'
		);
	
	});
};