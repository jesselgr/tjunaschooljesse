<form  id="uploadForm" class="uploadForm">
	<p>
		Upload into:
		<?=form_dropdown('file_category_id', $file_category_list)?>
	</p>
	<p>
		<input type="text" name="title"/>
	</p>
	<p>
		<button id="addFile" class="buttonContent"></button>
	</p>
</form>
<script>
var site_url = "<?=site_url()?>";

</script>