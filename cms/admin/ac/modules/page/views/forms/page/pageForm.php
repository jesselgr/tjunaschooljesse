
<div class="contentMain">
<p><?= lang('form_page_edit_descr');?></p>
</div>

<?php if(validation_errors()):?>
<div class="formErrorMessage">	 <?=validation_errors('<p>','</p>'); ?></div>
<?endif;?>


<?=form_open($formAction)?>
<?=form_hidden('nav_prio', 			$page->nav_prio);?>
<?=form_hidden('fixed', 			$page->fixed);?>
<?=form_hidden('parent_page_id', 	$page->parent_page_id);?>
<div class="contentMain ">
	
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
		
			<div class="inputContainer odd">
				<?= form_label(lang('form_page_title'), 'title')?>
				<p><?=form_input('attributes['.$i.'][title]',$page->attributes[$i]['title'],'class="inputField titleField" ')?></p>
			</div>
		
			<?php if($page->fixed != 'home'):?>
			<div class="inputContainer odd">
					<?=form_label(lang('form_page_url_name'), 'name')?>
			
			<p>
				
					<?=form_input('attributes['.$i.'][url_name]',$page->attributes[$i]['url_name'],'class="inputField tiny urlTitleField"')?>
					<a href="#" class="urlSwitch" state="0">
					<span class="urlSwitchOnText">Zelf bepalen</span>
					<span class="urlSwitchOffText">Synchroniseren met titel</span>
					</a>
			</p>
			
			</div>
			<?php endif;?>
		
			<div class="inputContainer ">
				<?=form_label(lang('form_page_sub_title'), 'sub_title')?>
				<p><?=form_input('attributes['.$i.'][sub_title]',$page->attributes[$i]['sub_title'],'class="inputField"')?></p>
			</div>
			
			<div class ="inputContainer odd">
				<?=form_label(lang('form_page_meta_description'), 'meta_description')?>
				<p><?=form_textarea('attributes['.$i.'][meta_description]',$page->attributes[$i]['meta_description'],'class="inputField textAreaSmall"')?></p>
			</div>
			
			
			
			<div class="inputContainer">
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


<?if(!$form_will_create || ($form_will_create && $page->parent_page_id == null)):?>
<div class="inputContainer contentMain odd">
	<?= form_label(lang('form_page_parent_page'), 'parent_page_id')?>
	<p><?= form_dropdown('parent_page_id',$pageNames, $page->parent_page_id)?></p>
</div>
<?endif;?>
<div class="inputContainer contentMain ">
	<?= form_label(lang('form_page_template'), 'template_id')?>
	<p><?= form_dropdown('template_id',$pageTemplates, $page->template_id)?></p>
</div>
			
<div class="inputContainer contentMain odd">
	<?= form_label(lang('form_page_in_menu'),'in_menu')?>
	<p>
		<input type="radio" id="in_menu_1" name="in_menu" value="1" <?if($page->in_menu=='1' || !$page->in_menu) echo 'checked'?>>
		<span for="in_menu_1"> <?=lang('form_yes')?> </span>
		<input type="radio" id="in_menu_2" name="in_menu" value="0" <?if($page->in_menu=='0') echo 'checked'?>> 
		<span for="in_menu_2"> <?=lang('form_no')?> </span>		
	</p>
</div>






<?php if($this->permission->get('tjuna')):?>
<div class=" inputContainer contentMain ">
	<?=form_label('Fixed Name','fixed')?>
	<p><?=form_input(array('name' =>'fixed', 'class'=>'inputField'),$page->fixed)?></p>
</div>
<?endif;?>


<?=form_close();?>
	


<?if(count($languages) > 1):?>
<script>
	$(function() {
		$("#tabs").tabs();
	});
</script>	
<?endif;?>