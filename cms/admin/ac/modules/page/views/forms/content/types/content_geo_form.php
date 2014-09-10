

<style>
	.jquery-auto-geocoder-map{
		width: 500px;
		height: 500px;
	}
</style>
	


	<?=form_hidden('page', $hidden['page']);?>				
	<?=form_hidden('type', 'img');?>
	<?=form_hidden('section', 'section_here');?>	
	<?=form_hidden('page_id', $hidden['page_id']);?>	
	<?=form_hidden('content_id', $hidden['content_id']);?>

	<section class="contentMain">
		<p><?= lang('editor_geo_descr');?></p>
	</section>
	
	<section class="contentMain inputContainer">	
		<p><?=form_label('Address:', 'title');?></p>
		<p><?=form_input(array('id' => 'address', 'name' => 'title', 'class' => 'inputField', 'value' => $fields['title']))?></p>
	</section>
	
	<section class="contentMain inputContainer">
		<p><?=form_label(lang('editor_geo_form_content'),'address_gps')?></p>
		<input type='text' name='content' id='content' value="<?=$fields['content']?>" class="inputField" readonly>
	</section>

				
	<script>
		$(function() {
		  $('#address').autoGeocoder();
		});
	</script>


	
	
	
	

