	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/js/shadowbox/shadowbox.css">
	
	<script type="text/javascript">
		// settings for cropper
		settings = new Object();
		settings.minWidth 		= '50';
		settings.minHeight 		= '50';
		
		// intialize the shadowbox and onfinish initialize the cropper
		Shadowbox.init({
			handleOversize: "resize",
			modal: true,
			onFinish: function(){ initialize_cropper(Shadowbox.getCurrent(),settings);},
			onClose: function(){ closeImgAreaSelect();}
		});
	</script>
	<script>
		$(function() {
			$("#tabs").tabs();
		});
	</script>	
	<section class="contentMain odd">
		<div id="tabs" class="ambLangTab">
			<ul>
				<?foreach($languages as $language):?>
					<li>
						<a class="ambLangTab" href="#tabs-<?=($language->language_id)?>" title="<?=$language->name?>">
							<span class="flag flag-<?=$language->code?>">&nbsp;</span>
						</a>
					</li> 
				<?endforeach;?>
			</ul>
				
			
			
			<?foreach($languages as $language_row):?>
				<?$lang_id = $language_row -> language_id;?>
				
				<div id="tabs-<?=($lang_id)?>">					
					<section class="">
						<p><?= form_label('Title:', 'title')?></p>
						<p><?=form_input('title['.$lang_id.']', $fields[$lang_id]['title'], 'class= "inputField"')?></p>
					</section>
					<section class=" odd">
						<p><?= form_label(lang('editor_form_descr'), 'sub_title')?></p>
						<p><?=form_input('sub_title['.$lang_id.']', $fields[$lang_id]['sub_title'], 'class ="inputField"')?></p>
					</section>
					
					
					
				</div>
			
			<?endforeach;?>
		
		</div>
	
	
	</section>
	<section class="contentMain ">
	<?=form_hidden('content_language_independant_array', 1);?>
	<?=form_hidden('language_dependant', 1);?>
	
	<?if(!$fields['content'])$fields['content'] = ',,,,';?>
	<?if($fields['content'])$fields['content'] = explode(',', $fields['content']);?>
	<?for($i=0;$i < 5;$i++):?>
	
		
		<?if($fields['content']):?>
			<label><?=lang('editor_img_form_preview')?>:</label>
			<a id="preview-content<?=$i?>" href="<?echo $fields['content'][$i];?>"  rel="shadowbox" ><img id="image-preview-content<?=$i?>" class="contentImgPreview" src="<?= $fields['content'][$i];?>"/></a>
		<?else:?>
			<p><p><?=lang('editor_img_form_nocontent')?></p></p>
		<?endif;?>
		

		<p><?= form_label(lang('editor_img_form_content'), 'content')?></p>
		<p><?=form_input('content['.$i.']', $fields['content'][$i], 'class ="inputField" id="content'.$i.'"')?>
		<?=form_button(array('name'=>'imgbutton', 'class'=>'buttonContent'), lang('editor_img_form_file_button'), 'onclick="openKCFinderFor(\'content'.$i.'\')"');?></p>
	
	
	<?endfor;?>
	</section>

