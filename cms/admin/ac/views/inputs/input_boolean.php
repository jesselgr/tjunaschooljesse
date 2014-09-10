<p>
	<?if($forced):?>
		<?=form_dropdown($key, array('1'=>lang('form_yes'),'0'=>lang('form_no')),$value,' id="'.($key).'toggleswitch"');?>
		<script>
		$(function(){
			$('#<?=$key?>toggleswitch').toggleSwitch({
				highlight: true,
				width: 50
			});
		});
		</script>
	<?else:?>
	
		<input type="radio" name="<?=$key?>" <?if($value==1)  echo 'checked'?> value="1" /> ja
		<input type="radio" name="<?=$key?>" <?if($value==0) echo 'checked'?> value="0" /> Nee
		<input type="radio" name="<?=$key?>" value="" <?if(!$value)echo 'checked'?>/> n.v.t.
	
	<?endif;?>
</p>
