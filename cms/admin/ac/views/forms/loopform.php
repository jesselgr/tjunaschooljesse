<? if($object){?>
		<?$switch='odd';?>
			<?=form_open($formAction)?>
			<?foreach($object as $field){
				$this->load->view('inputs/form_input_container', array_merge($field, array('switch' => $switch, 'label'=>humanize($field['key']))));
				$switch = ($switch=='even')? 'odd': 'even';
			 } ?>
			<section class="contentMain <?=$switch?>"> 
				<p>
					<?=form_submit(array('class' => 'buttonContent','value'=>lang('form_submit')))?>
					<a class="buttonContent grey" href="<?=site_url(array('dashboard'))?>" onclick="return confirmSubmit('<?=lang('form_cancel_confirm');?>')">
						<?=lang('form_cancel');?>
					</a>
				</p>
			</section>
			
		<?=form_close();?>
		
		<?}else{?>
		<section class="contentMain odd">
			<p><?=lang('form_empty')?></p>
		</section>
		<?}?>
</div>