$(document).ready(function()
{
	$('.multi-lang-tabs').each(function(){
		setUrlSync($(this));
	});

});
function setUrlSync($parent)
{
	var urlTitleFieldLocked = true;
	
	var $titleField 	= 	$parent.find('.titleField');
	var $urlTitleField 	= 	$parent.find('.urlTitleField');
	var $urlSwitch 		= 	$parent.find('.urlSwitch');
	$urlSwitch.state 	= 	$urlSwitch.attr('state');
	$urlSwitch.lock = function()
	{
		urlTitleFieldLocked =  true;
		$(this).attr('state','0');
		$(this).find('.urlSwitchOnText').hide();
		$(this).find('.urlSwitchOffText').show();
		$(this).removeClass('locked');
		$(this).addClass('unlocked');

//		$urlTitleField.attr('disabled', 'disabled');
	}
	$urlSwitch.unlock  = function()
	{
		urlTitleFieldLocked =  false;
		$(this).attr('state','1');
		$(this).find('.urlSwitchOnText').show();
		$(this).find('.urlSwitchOffText').hide();
		$urlTitleField.attr('value', urlEncode($titleField.attr('value')));
		$(this).removeClass('unlocked');
		$(this).addClass('locked');
//		$urlTitleField.removeAttr('disabled');
	}
	
	$urlSwitch.click(function(e)
	{	
		
		e.preventDefault();
		var state = $(this).attr('state');
		if (state == 1)
		{
			$urlSwitch.lock();
		}else{
			$urlSwitch.unlock();
		}
	});

	if($urlTitleField.attr('value') == urlEncode($titleField.attr('value')))
	{
		$urlSwitch.unlock();		
	}else{
		$urlSwitch.lock();

	}
	$titleField.keyup(function()
	{
		if(!urlTitleFieldLocked)
		{
			$urlTitleField.attr('value', urlEncode($(this).attr('value')));
		}
	});
}

