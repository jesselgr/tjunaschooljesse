

$(function(){
	

	$('#image').imgAreaSelect({
	    handles: true
	});
	
	$('#save_crop').click(function() {
		submit_thumb();
		$('#crop').imgAreaSelect({remove : true});
	
		return false;
	});
	
	
		
		
});

function closeImgAreaSelect(inputId){
	$('div.imgareaselect-selection').hide();
	$('div.imgareaselect-border1').hide();
	$('div.imgareaselect-border2').hide();
	$('div.imgareaselect-border3').hide();
	$('div.imgareaselect-border4').hide();
	$('div.imgareaselect-handle').hide();
	$('div.imgareaselect-outer').hide();
	$('#save_crop').hide();
}
