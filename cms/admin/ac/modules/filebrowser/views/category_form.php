<div id="category-form" title="Create new category" style="display:none">
	<form>
		<fieldset>
			<label for="category_name">Name</label>
			<input type="text" name="title" id="category_name" class="text ui-widget-content ui-corner-all" />
			<label for="parent_category_id">under:</label>
			<select name="parent_category_id" id="parent_category_id">
			<?=$file_category_list_html?>
			</select>
		</fieldset>		
	</form>
</div>