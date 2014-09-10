<section class="contentMain"> 

		<p><?= lang('comp_'.$this->uri->segment(3).'_descr');?></p>
		<?=validation_errors()?>
</section>

	
	
	<?=form_open($formAction)?>
		<?=$formHtml?>
		

		<?if(!$in_dialog):?>
		<section class="contentMain <?=$switch?>"> 
			<p>
				<?if($form[$idVal]):?>
					<?=form_submit(array('class' => 'buttonContent','value'=>lang('form_page_edit_submit')))?>
					
					<a class="buttonContent grey " href="<?=$this->input->server('HTTP_REFERER')?>" onclick="return confirmSubmit('<?=lang('form_cancel_confirm');?>')">
						Annuleren
					</a>
						<a class="buttonContent red floatRight" href="<?=site_url(array('component','delete', $component, $form[$idVal]))?>" onclick="return confirmSubmit('<?=lang('form_delete_confirm');?>')">Verwijderen
					</a>
				<?else:?>
					<?=form_submit(array('class' => 'buttonContent','value'=>lang('form_page_create_submit')))?>
					<a class="buttonContent grey " href="<?=$this->input->server('HTTP_REFERER')?>" onclick="return confirmSubmit('<?=lang('form_cancel_confirm');?>')">
					Annuleren
					</a>
				<?endif;?>
				
			</p>
		</section>
		<?endif;?>
	<?=form_close();?>
	
</div>
