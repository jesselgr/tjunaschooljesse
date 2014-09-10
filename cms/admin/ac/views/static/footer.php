		</section><!-- contentMain --> 
		
	</section><!-- contentSection -->	
				
</section><!-- contentContainer --> 
	<script type="text/javascript">	
		var langLabels = {
		'save' 		: 'Save',
		'cancel' 	: 'Cancel',
		'edit'		: 'Edit',
		'cancelConfirm'	: 'Are you sure you wish to cancel?'
	};
	</script>
	<script src="<?=base_url()?>assets/js/plugins.js"></script>
	<script src="<?=base_url()?>assets/js/script.js"></script>
	<!--[if lt IE 7 ]>
	<script src="<?=base_url()?>assets/js/libs/dd_belatedpng.js"></script>
	<script> DD_belatedPNG.fix('img, .png_bg');</script>
	<![endif]-->
	
	<?if(isset($scripts) && $scripts):
	foreach($scripts as $script):
		if(!strstr('http://', $script))$script = base_url().$script;?>
		<script type="text/javascript" src="<?=$script?>"></script>
		<?endforeach;
	endif;?>
</body>
</html>