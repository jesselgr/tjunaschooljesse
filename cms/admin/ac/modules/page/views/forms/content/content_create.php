

<div class="contentCreateSelect">
	<?=form_open('page/content/create_content', array('class' =>  'modtools')); ?>
<!--		<label for="title">Titel:</label><?=form_input('title',null, 'class="inputField"')?>	-->
		<?=form_hidden('pageID', $pageID);?>
		<?=form_hidden('pageName', $pageName);?>
		<?=form_hidden('section_id', $section_id);?>
		<?=form_dropdown('type',$contentTypes, null,  'id="contentCreateSwitch"')?>
		<input type="submit" value=" <?=lang('content_add')?>" class="buttonContent small"/>
	<?=form_close();?>
</div>

