<textarea id="<?=$key?>" name="<?=$key;?>"><?=$value;?></textarea>
<script type="text/javascript">	
$(document).ready(function(){	
		
	var editor = CKEDITOR.instances['<?=$key?>'];
	if (editor) { editor.destroy(true); }
	
	CKEDITOR.replace("<?=$key?>",  {
	 	customConfig : '<?=base_url()?>core/ckeditor/config.js',
	 	
		filebrowserBrowseUrl 		: '<?=base_url()?>filebrowser?popup=1&standalone=1',
		filebrowserImageBrowseUrl	: '<?=base_url()?>filebrowser?popup=1&standalone=1&type=image',
		filebrowserWindowWidth		: '730',
    	filebrowserWindowHeight		: '600'
	});
	
});
</script>
