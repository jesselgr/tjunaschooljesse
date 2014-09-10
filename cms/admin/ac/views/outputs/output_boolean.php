<p>
	<input type="radio" name="<?=$key?>" <?if($value)  echo 'checked'?> value="1" /> Enabled
	<input type="radio" name="<?=$key?>" <?if(!$value) echo 'checked'?> value="0" /> Disabled
</p>