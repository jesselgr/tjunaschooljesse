<?if(isset($key)):?>
<textarea id="<?=$key?>" name="<?=$key;?>"><?=$value;?></textarea>

<script type="text/javascript">	
$(document).ready(function(){	
	CKEDITOR.replace("<?=$key?>",  {
	 	customConfig : '<?=base_url()?>../core/ckeditor/config.js',
	});
});
</script>
<?endif;?>