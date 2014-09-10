	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/js/shadowbox/shadowbox.css">
	
	 <script type="text/javascript">
	 	Shadowbox.init();
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
					<section class="inputContainer">
						<p><?= form_label('Title:', 'title')?></p>
						<p><?=form_input('title['.$lang_id.']', $fields[$lang_id]['title'], 'class= "inputField"')?></p>
					</section>
					
					<section class="inputContainer odd">
						<p><?= form_label(lang('editor_form_file'), 'link')?></p>
						<p><?=form_input('link['.$lang_id.']', $fields[$lang_id]['link'], 'class ="inputField" id="link'.$lang_id.'"')?>
						<?=form_button(array('name'=>'linkbutton', 'class'=>'buttonContent'), lang('editor_img_form_file_button'), 'onclick="openKCFinderFor(\'link'.$lang_id.'\')"');?></p>
					</section>
				</div>
			
			<?endforeach;?>
					
			
		
		</div>
	
	</section>

