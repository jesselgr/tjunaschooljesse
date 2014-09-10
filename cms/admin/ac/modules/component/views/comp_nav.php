
<section class="contentMain">
	<p><?= lang('comp_overview_descr');?></p>
	<a class="buttonContent small jsDialogLink" title="<?=lang('comp_nav_create') . ' '. $comp_title?>" href="<?=site_url('component/create/'.$navUrlVal)?>?dialog=1"><?=lang('comp_nav_create')?></a>
</section>

<section class="contentMain odd">
<? if($list):
		$switch='';?>

	
		<table class="contentMain tableList">
			<?
			foreach($list as $list_item):
				$view_url	= site_url(array('listing','view', $navUrlVal, $list_item -> $urlKey));
				$edit_url 	= site_url(array('component', "edit", $navUrlVal, $list_item -> $urlKey,$navSuffix)).'?dialog=1';
				$delete_url = site_url(array('component', "delete", $navUrlVal, $list_item -> $urlKey));
				?>
				
				<tr class="<?php echo $switch; ?>">
					<td><?= humanize($list_item -> $titleVal); ?></td>
					<td><? if($subtitleVal) echo $list_item -> $subtitleVal; ?></td>
					<td class="alignRight">
						<!--<a class="buttonContent small"	href="<?=$view_url?>"><?=lang('list_view')?></a>-->
						<a class="buttonContent small jsDialogLink" title="<?=lang('comp_nav_edit')?> <?=$comp_title?>: <?= humanize($list_item -> $titleVal); ?>"	href="<?=$edit_url?>"><?=lang('list_edit')?></a>
						<?php if($this->permission->get('tjuna')):?>
						<a class="buttonContent red small confirmSubmit"  href='<?=$delete_url?>'><?=lang('list_delete')?></a>
						<?php endif;?>
					</td>
				</tr>
				<?php 
				if($switch==''){$switch='odd';}else{$switch='';}
			 endforeach; ?>
		</table>
	<?else:?>	
		<p>Geen Resultaten</p>
	<?endif;?>	
</section><!-- contentMain -->

<section class="contentMain">
<div class="pagination">
	<p><?=$pagination['start'].' '.lang('pagination_of').' '.$pagination['end'].' '.lang('pagination_of_total').' '.$pagination['total']?></p>
	<br/>
	<?=$this->pagination->create_links();?>
</div>
</section>