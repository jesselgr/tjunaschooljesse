

$(function(){
	

	$('.pageButton').append('<div class=" hover"></div>').each(function () 
	{
		var $span = $('> div.hover', this).css('opacity', 0);
		
		$(this).hover(function () // hover in
		{
			$span.stop().fadeTo(200, 1);
		}, 
		function ()  // hover out
		{
			$span.stop().fadeTo(200, 0);
		});
	});
	
	
	$('.toggleButton').click(function() {
		 $(this).toggleClass('active');
		$(this).parent().parent().next().toggle('fast');
		return false;
	});	
		
});