<textarea  id="<?=$key?>" name=" <?=$key;?>"> <?=$value;?></textarea>
<script type="text/javascript">	CKEDITOR.replace( "<?=$key?>",  {
 	customConfig : '<?=base_url()?>assets/js/libs/ckeditor/config.js',
 	
	filebrowserBrowseUrl : '<?=base_url()?>core/kcfinder/browse.php',
    filebrowserImageBrowseUrl : '<?=base_url()?>core/kcfinder/browse.php',
    filebrowserFlashBrowseUrl : '<?=base_url()?>core/kcfinder/browse.php',
});</script>
