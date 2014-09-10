<?=form_password(array('id'=>$key, 'class'=> 'inputField'), $value);?>
<script>
$('#<?=$key?>').blur(function(){
	$(this).val('222');
});
</script>