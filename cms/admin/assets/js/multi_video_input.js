$(function() {
	$('a.deleteVideo').live('click',function(e){
		
		var $nextInput = $(this).next();
		var $inputPreview = $nextInput.next();
		$nextInput.remove();
		$inputPreview.remove();
		
		$(this).remove();
		
		e.preventDefault();
	});

	$('.add_video_input').click(function(e) {
	
		e.preventDefault();
		var html = '<p><a class="deleteVideo buttonContentRed small" href="#">x</a><input type="text" name = "videos[]" id ="videoField" value = "" class="inputField"/></p>';
		 $('.videoContainer').append(html);
	
	});
});