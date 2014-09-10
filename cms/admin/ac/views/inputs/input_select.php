
<?if(count($list) <= 1):?>
<?
	reset($list);
	$first_key = key($list);
?>
	<?=form_hidden($key, $first_key)?>
	<span><?=reset($list)?></span>
<?else:?>
	<?if(!$forced):
		$list = array('' => '--geen voorkeur--') + $list;
	endif;?>

<?=form_dropdown($key, $list, $value, 'class="inputSelect" id="select_'.$key.'"')?>
<?endif;?>
