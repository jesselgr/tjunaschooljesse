
<div class="contentMain">
	<div>
		<p><a href="#" class="buttonContent toggleUploadForm">Upload file(s)</a></p>
	</div>
	<div >

		<form  id="uploadForm" class="uploadForm clearfix" style="display:none">
			<p><label for="file_category_id">Upload into:</label></p>
			<p class="floatLeft">
				
				<select name="file_category_id">
				<?=$file_category_list_html?>
				</select>
			</p>
			<p class="floatLeft">
				<button id="addFile" class="buttonContent "></button>
			</p>
		</form>
	</div>
</div>
