<?=form_hidden('language_dependant', false);?>

	<section class="contentMain ">
		<p><?= form_label('Titel:', 'title')?></p>
		<p><?=form_input('title', $fields['title'], 'class= "inputField"')?></p>
	</section>
	
	<section class = "contentMain ">
		<p><?= form_label(lang('editor_text_form_content'), 'content')?></p>
		<p><?= form_textarea('content', $fields['content'], 'class="inputField"')?></p>
	</section>

