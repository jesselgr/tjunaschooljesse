<?=form_open('page/content/update_content');?>
	<?=form_hidden($hidden)?>
	
	<!--content form starts here -->
	<?$this->load->view('forms/content/types/'.$content_type_form);?>
	
		
<!--	<section class="contentMain">
		<hr>
		<?=form_submit(array('class' => 'buttonContent left', 'value' => lang('form_submit')))?>
				
		
		<a id="cancelButton" class="buttonContent grey right" href="<?=site_url(array('page/content','overview',$pageID))?>" onclick="return confirmSubmit('<?=lang('editor_text_form_cancel_confirm');?>')">
			<?=lang('form_cancel');?>
		</a>	
		
	</section>-->
		
<?=form_close();?>

