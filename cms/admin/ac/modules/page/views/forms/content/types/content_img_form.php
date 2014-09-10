	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/js/shadowbox/shadowbox.css">
	
	 <script type="text/javascript">
	 	// settings for cropper
	 	settings = new Object();
	 	settings.minWidth 		= '50';
	 	settings.minHeight 		= '50';
	 	
	 	// intialize the shadowbox and onfinish initialize the cropper
	 	Shadowbox.init({
	 		modal: true,
			handleOversize: "resize",
	 		onFinish: function(){ initialize_cropper(Shadowbox.getCurrent(),settings);},
			onClose: function(){ closeImgAreaSelect();}
	 	});
	 </script>
	<script>
		$(function() {
			$("#tabs").tabs();
		});
	</script>	
	<div class="contentMain odd">
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
					<div class="inputContainer">
						<?= form_label('Title:', 'title')?>
						<p><?=form_input('title['.$lang_id.']', $fields[$lang_id]['title'], 'class= "inputField"')?></p>
					</div>
					<div class="inputContainer odd">
						<?= form_label(lang('editor_form_descr'), 'sub_title')?>
						<p><?=form_input('sub_title['.$lang_id.']', $fields[$lang_id]['sub_title'], 'class ="inputField"')?></p>
					</div>
					
				</div>
			
			<?endforeach;?>
		
		</div>
	
	</div>
	<div class="contentMain">
		
		<label><?=lang('editor_img_form_preview')?></label>
		<a id="preview-content" href="<?echo $fields['content'];?>"  rel="shadowbox" >
			<img id="image-preview-content" class="contentImgPreview" src="<?= $fields['content'];?>"/>
		</a>



		<div class="inputContainer">
			<?=form_hidden('content_language_independant', 1);?>
			<?=form_hidden('language_dependant', 1);?>
			
		
		
				<?=form_input('content', $fields['content'], 'class ="inputField visuallyhidden" id="content"')?>
				<a href="#" data-target="content" data-preview="image-preview-thumb" class="buttonFile">
				<img id="image-preview-thumb" class="contentImgPreview " src="<?=cdi_thumb_url();?><?=$fields['content']?>"/>
				</a>
		
	
		</div>

	</div>
