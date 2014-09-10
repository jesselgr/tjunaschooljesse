$(function() {
	switchName();
	$('input[name="customurl"]').click(function() {
	  switchName();
	});
});
function switchName(){
  
  if( $('input[name="customurl"]').is(':checked')){
	$('input[name="name"]').removeAttr("disabled", "");
  }else{
     $('input[name="name"]').attr("disabled", "disabled");
  }
}