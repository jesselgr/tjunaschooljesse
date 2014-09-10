
<section class="contentMain">
	<p><?= lang('comp_overview_descr');?></p>
	<!-- create button -->
	<?if($this->grouped && $this->permission->get('create_'.$component_group_table)):?>
		<a title="Add <?=lang('comp_'.$component_group_table.'_single')?>" href="<?=$create_url_group?>?dialog=1" class="buttonContent jsDialogLink small"><?=lang('comp_nav_create')?> <?=lang('comp_'.$component_group_table.'_single')?></a>
	<?endif;?>
	<?if( $this->permission->get('create_'.$component)):?>
	<a title="Add <?=lang('comp_'.$component.'_single')?>" href="<?=$create_url?>?dialog=1" class="buttonContent jsDialogLink small"><?=lang('comp_nav_create')?> <?=lang('comp_'.$component.'_single')?></a>
	<?endif;?>
	<!-- / create button -->
</section>

<section class="contentMain odd">
<? if($list):
		$switch='';?>

	
		<ol class="componentGrouped dragList" >
			<?
			foreach($list as $category_id => $category_row):?>
				<?if(!isset($category_row['title'])):?>
				<li comp_id="0" comp_type="<?=$component_group_table?>" class="not-sortable">
					<div class="list-item">
						<span class="page"><i>No category</i></span>
						<a href="#" class="toggleButton"></a>
					</div>
				<?else:?>
				<li class="hasChildren" comp_id="<?=$category_id?>" comp_type="<?=$component_group_table?>" >
					
					<div class="list-item">
						 <div class="pageIcon"></div>
						<span style="width:150px" class="page"><?=character_limiter($category_row['title'],30)?></span>
						<span style="width:100px"><?=$category_row['sub_title']?></span>
						<span><?=count($category_row['children'])?></span>
						<?if($category_delete_permission):?>
						<a href="<?=site_url(array("component/delete", $component_group_table, $category_id ))?>" 	class="pageButton delete confirmSubmit">
							<div class="deletePageIcon"></div> 
						</a>
						<?endif;?>
						<a href="<?=site_url(array("component/edit", $component_group_table, $category_id ,$url_suffix))?>?dialog=1" title="edit <?=$category_row['title']?>" class="pageButton jsDialogLink edit">
							<div class="editPageIcon"></div>
						</a>
						
					</div>
					<?if($category_row['children']):?>
					<a href="#" class="toggleButton"></a>
					<?endif;?>
				<?endif;?>
				<?if($category_row['children']):?>
					<ol class="collapsable" comp_parent_id="<?=$category_id?>" style="display:none" >
						
                        <?foreach($category_row['children'] as $list_item):?>
						
						<li class="dragBgMid ui-nestedSortable-no-nesting" comp_type="<?=$navUrlVal?>" comp_id="<?=$list_item->$urlKey?>" >
							<div class="list-item">
								<div class="listLeftIcon"></div>
								<span style="width:150px" class="page"><?=$list_item->first_name.' '.$list_item->last_name ?></span>
								<span><?=$list_item->position?></span>
								<?if($list_delete_permission):?>
								<a href="<?=site_url(array("component/delete", $navUrlVal, $list_item -> $urlKey))?>" class="pageButton delete confirmSubmit">
									<div class="deletePageIcon"></div> 
								</a>
								<?endif;?>
								<a href="<?=site_url(array("component/edit", $navUrlVal, $list_item -> $urlKey,$url_suffix))?>?dialog=1" class="pageButton jsDialogLink edit" title="edit <?=$list_item -> $titleVal?>">
									<div class="editPageIcon"></div>
								</a>
		
							</div>
						</li>
						
						<?php  endforeach; ?>
						
					 </ol>
					
                       <?endif;?>
				 </li>
		<?	endforeach; ?>
		</ol>
	<?else:?>	
		<p>Geen Resultaten</p>
	<?endif;?>	
</section><!-- contentMain -->
<script>
$('.toggleButton').click(function() {
		 $(this).toggleClass('active');
		$(this).parent().find('.collapsable').slideToggle('fast');
		return false;
	});	
</script>
