	<script>
		$(function() {
			$("#tabs").tabs();
		});
	</script>	

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
				<div class="inputContainer small ">
					<?= form_label('Titel:', 'title')?>
					<p><?=form_input('title['.$lang_id.']', $fields[$lang_id]['title'], 'class= "inputField"')?></p>
				</div>
				<div class="inputContainer small odd">
					<?= form_label(lang('form_page_sub_title'), 'sub_title')?>
					<p><?=form_input('sub_title['.$lang_id.']', $fields[$lang_id]['sub_title'], 'class ="inputField"')?></p>
				</div>
				
				<div class = "inputContainer small ">
					<?= form_label(lang('editor_text_form_content'), 'content')?>
					<?$data['key'] = 'content['.$lang_id.']'; $data['value'] = $fields[$lang_id]['content'];?>
					<?$this->load->view('forms/content/types/ckeditor', $data);?>
				</div>
			</div>
		
		<?endforeach;?>
	
	</div>
	
	

