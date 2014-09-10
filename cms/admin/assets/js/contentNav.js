

$(function(){
	
	$('#contentNav').find('.addContent').click(function(e)
	{
		var $link 	= $(this);
		var $dialog = $link.prev();
		$dialog.stop();
		$link.removeClass('highlight');
		
		if($link.attr('data-switch') == 0)
		{
			$link.attr('data-switch', 1);
			$dialog.hide();
			
		
			$dialog.slideDown(300);
		
			
			$link.text('x');
			$link.switchClass('collapsed','expanded',300);	
		}
		else
		{
			$link.attr('data-switch', 0);
			$link.switchClass('expanded','collapsed',300);
			
			$link.text('+');
			$dialog.slideUp(300);
		}
		
		e.preventDefault();
				
	});
		
});
