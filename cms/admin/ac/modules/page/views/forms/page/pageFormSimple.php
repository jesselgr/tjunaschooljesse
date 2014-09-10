
<div class="contentMain">
<p><?= lang('form_page_edit_descr');?></p>
<?php if(validation_errors()):?>
<div class="formErrorMessage"><img src="<?=base_url()?>assets/img/error.png"><p>	 <?=validation_errors(); ?></p></div>
<?endif;?>
</div>

<?=form_open()?>
	<?=form_hidden('fixed',$page->fixed)?>
	<?=form_hidden('publish_state', ( isset($page->publish_state) ) ? $page->publish_state : 0)?>
	<?=form_hidden('fixed',$page->fixed)?>
	<?=form_hidden('in_menu',($page->in_menu) ? $page->in_menu : 0);?>
	<?=form_hidden('template_id',$page->template_id)?>
	<?=form_hidden('nav_prio', $page->nav_prio)?>
	<?=form_hidden('page_id',$page->page_id)?>
	<?=form_hidden('in_menu',$page->in_menu)?>
	<?=form_hidden('parent_page_id', $page->parent_page_id)?>
	
	<div class="contentMain">
		
		<div id="tabs" class="ambLangTab">
			<?if(count($languages) > 1):?>	
			<ul>
				<?foreach($languages as $i => $language):?>
					<li>
						<a class="ambLangTab" href="#tabs-<?=($language->code)?>" title="<?=$language->name?>">
							<span class="flag flag-<?=$language->code?>">&nbsp;</span>
						</a>
					</li> 
				<?endforeach;?>
			</ul>
			
			<?endif;?>
			
			
			<?foreach($languages as $i => $language):?>
			
				<?=form_hidden('attributes['.$i.'][url_name]', $page->attributes[$i]['url_name'])?>
				<?=form_hidden('attributes['.$i.'][page_description_id]',$page->attributes[$i]['page_description_id'])?>
				
				<div id="tabs-<?=($language->code)?>" class="multi-lang-tabs">
					<div class="contentMain ">
						<p><h3><?=$language->name?></h3></p>
					</div>
					<div class="inputContainer ">
						<?= form_label(lang('form_page_title'), 'title')?>
						<p><?=form_input('attributes['.$i.'][title]',$page->attributes[$i]['title'],'class="inputField"')?></p>
					</div>
					<div class="inputContainer odd">
						<?=form_label(lang('form_page_sub_title'), 'sub_title')?>
						<p><?=form_input('attributes['.$i.'][sub_title]',$page->attributes[$i]['sub_title'],'class="inputField"')?></p>
					</div>
					
					<div class="inputContainer ">
						<?= form_label(lang('form_page_publish_state'),'publish_state')?>
						<p>
							<input type="radio" name="attributes[<?=$i?>][publish_state]" value="1" <?if($page->attributes[$i]['publish_state']=='1') echo 'checked'?>> 
							<span for="in_menu_1"> <?=lang('form_yes')?> </span>
							<input type="radio" name="attributes[<?=$i?>][publish_state]" value="0" <?if($page->attributes[$i]['publish_state']!='1') echo 'checked'?>>
							<span for="in_menu_2"> <?=lang('form_no')?> </span>	
						</p>
						
					</div>
				</div>
			
			<?endforeach;?>
		
		</div>
	</div>
	
	<div class="inputContainer contentMain ">
		<?= form_label(lang('form_page_thumb'), 'thumb')?>
		<?=form_file_button('thumb',$page->thumb,'image');?>
	</div>

	<?if(!$page->parent_page_id):?>
	<div class="inputContainer contentMain odd">
		<?= form_label(lang('form_page_parent_page'), 'parent_page_id')?>
		<p><?= form_dropdown('parent_page_id',($pageNames) ? $pageNames : array('root'=>lang('form_page_no_available_page')), $page->parent_page_id)?></p>
	</div>
	<?endif;?>
	<?if(!$page->template_id):?>
	<div class="inputContainer contentMain ">
		<?= form_label(lang('form_page_template'), 'template_id')?>
		<p><?= form_dropdown('template_id',$pageTemplates, $page->template_id)?></p>
	</div>
	<?endif;?>
	

<?=form_close();?>


</div>
<?if(count($languages) > 1):?>
<script>
	$(function() {
		$("#tabs").tabs();
	});
</script>
<?endif;?>