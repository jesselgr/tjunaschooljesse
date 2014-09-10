<?$list = array(
	'Europees' 				=> 	'Europees',
	'Aziatisch' 			=> 	'Aziatisch',
	'Afrikaans'				=> 	'Afrikaans',
	'Arabisch' 				=> 	'Arabisch',
	'Mediteraans' 			=> 	'Mediteraans',
	'Afro-Amerikaans' 		=> 	'Afro-Amerikaans',
	'Indiaans' 				=> 	'Indiaans',
	'Latijns-Amerikaans' 	=> 	'Latijns-Amerikaans',
);
if(!$forced):
	$list = array('' => '--geen voorkeur--') + $list;
endif;?>
<?=form_dropdown($key, $list, $value, 'class="inputSelect"')?>