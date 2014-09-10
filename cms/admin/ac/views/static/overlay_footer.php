		</section><!-- contentMain --> 
		
	</section><!-- contentSection -->	
				
</section><!-- contentContainer --> 
	
	<?if(isset($scripts) && $scripts):
	foreach($scripts as $script):
		if(!strstr('http://', $script))$script = base_url().$script;?>
		<script type="text/javascript" src="<?=$script?>"></script>
		<?endforeach;
	endif;?>
</body>
</html>