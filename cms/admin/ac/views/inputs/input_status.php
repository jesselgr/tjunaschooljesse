<p>
	<?=form_hidden($key, 0);?>
	<input type="radio" name="<?=$key?>" <?if($value)  echo 'checked'?> value="1" /> actief
	<input type="radio" name="<?=$key?>" <?if(!$value) echo 'checked'?> value="0" /> inactief
	
</p>