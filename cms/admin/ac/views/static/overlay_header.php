 <html lang="en" class="">
 <body class="ac_overlay">	 
	<script type="text/javascript">
		var base_url 	= 	"<?=base_url()?>",
		 	site_url 	= 	"<?=site_url()?>",
		 	current_url = 	"<?=current_url()?>",
		 	changeurl	=	'<?=base_url()?>'+'page/change_navprio',
			cdi_url 	=  	"<?=site_url().conf('url_cdi')?>";
	
	</script>
	<?if(isset($scripts) && $scripts):
	foreach($scripts as $script):
		if(!strstr('http://', $script))$script = base_url().$script;?>
		<script type="text/javascript" src="<?=$script?>"></script>
		<?endforeach;
	endif;?>