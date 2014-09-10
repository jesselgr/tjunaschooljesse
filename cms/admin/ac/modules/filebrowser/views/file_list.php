




<div  id="fileBrowserContainer" >
	<?if($file_id):?>
	<ul class="fileBrowserNav">
		<li><a href="#filePreview">Preview</a></li>
		<li><a href="#fileBrowserPicker">Pick a file</a></li>
	</ul>

	

	<div id="filePreview" class="fileBrowserPreview">
		<img src="<?=site_url($url_cdi.'graphic/getImage/'.$file_id)?>/1"/>
	</div>
	<?endif;?>
	<div id="fileBrowserPicker" class="contentMain ">
		
		<section id="filebrowser"  class="clearfix filebrowser">
			

			<div class="floatLeft categoryContainer">
				<div class="cat_nav">
					<?=$file_category_nav_html?>
				</div>
				<?if($this->permission->get('create_category')):?>
				<p><a  class="buttonContent small createCategory" href="#">Add category</a></p>
				<?endif;?>
			</div>
			<div class="floatRight fileContainer">
				<?foreach($file_category_result as $i => $file_cat_row):?>
				<div id="files_<?=$file_cat_row->file_category_id?>" <?if($i != 0):?>style="display:none"<?endif;?> class=" filesList">
				<h3 class="categoryTitle"><?=$files[$file_cat_row->file_category_id]['title']?></h3>
					<ul class="clearfix">
					<?if(isset($files[$file_cat_row->file_category_id])):?>
					<?foreach($files[$file_cat_row->file_category_id]['contents'] as $file):?>
					
						<li class="file" id="file_<?=$file->file_id?>" data-id="<?=$file->file_id?>" data-filename="<?=$file->sha1.'.'.$file->extension?>">
							<img src="<?=site_url($url_cdi.'graphic/getImage/'.$file->file_id)?>"/>
							<a href="#" class="jsDeleteFile file_delete">&#10006;</a>
							<span class="jsRenameFile fileLabel "><?=$file->title?></span>
						</li>
					<?endforeach;?>
					<?endif;?>
					</ul>
				</div>
				<?endforeach;?>
			</div>
		</section>
		<?if($this->permission->get('create_category')):?>
		<section class="">
			<?$this->load->view('filebrowser/upload_form');?>
		</section>
		<?endif;?>
	</div>

</div>
<?$this->load->view('filebrowser/category_form');?>

<script>

	<?if($file_id):?>
		$('#fileBrowserContainer').tabs(function()
		{
			window.location.hash = '#filePreview';
		});
	<?endif;?>

var parentTarget = '<?=$this->input->get('target')?>';

var site_url 	= "<?=site_url()?>";
var cdi_url 	= site_url + "<?=$url_cdi?>";
var filter_type = "<?=$type?>";
var upload_max 	= "<?=$max_upload?>";

var ckeditor = {
	enabled : <?=$CKEditor['enabled']?>,
	target  : "<?=$CKEditor['target']?>",
	functionNr: "<?=$CKEditor['function']?>"
}
</script>