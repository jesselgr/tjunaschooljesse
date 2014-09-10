<div class="contentMain">
<div>
	<p><a href="#" class="buttonContent toggleUploadForm">+</a></p>
</div>
<div>
<?=$upload_form_html?>
</div>

<div class="clearfix filebrowser">

	<div id="filebrowser" >
	
	<ul>
	<?foreach($file_category_result as $file_cat_row):?>
		<li><a href="#files_<?=$file_cat_row->file_category_id?>"><?=$file_cat_row->title?></a></li>
	<?endforeach;?>
	</ul>


	<?foreach($file_category_result as $file_cat_row):?>
	<div id="files_<?=$file_cat_row->file_category_id?>" class=" filesList">
<!--		<h3><?=$files[$file_cat_row->file_category_id]['title']?></h3>-->
		<ul class="clearfix">
		<?if(isset($files[$file_cat_row->file_category_id])):?>
		<?foreach($files[$file_cat_row->file_category_id]['contents'] as $file):?>
		
			<li class="file" id="file_<?=$file->file_id?>" data-id="<?=$file->file_id?>">
				<img src="<?=site_url('filebrowser/graphic/getImage/'.$file->file_id)?>"/>
				<a href="#" class="jsDeleteFile file_delete">&#10006;</a>
				<span class="jsRenameFile fileLabel"><?=$file->title?></span>
			</li>
		<?endforeach;?>
		<?endif;?>
		</ul>
	</div>
	<?endforeach;?>
	</div>
</div>
</div>
