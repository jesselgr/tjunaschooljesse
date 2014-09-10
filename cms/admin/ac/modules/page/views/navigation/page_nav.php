<section class="contentMain">	
	<p><?=lang('page_editor_descr')?></p>	
</section>
<script>

</script>
<section class="contentMain odd">


<?if($parent_page_id && !$page_locked && !$parent_page_id !='root'):?>
<p>
	<strong class="small"></strong>
	<a title="<?=lang('page_new')?> <?=$create_button_text?>" href="<?=site_url(array('page','create', $parent_page_id))?>" class="buttonContent small jsDialogLink"><?=lang('page_new')?> <?=$create_button_text?></a>
</p>	
<?else:?>
<p>
	<strong class="small"><?=lang('page_new')?></strong>
	<a href="<?=site_url(array('page','create'))?>" class="buttonContent small jsDialogLink"><?=lang('page_create_button')?></a>
</p>

<?endif;?>
<a class="order_reset buttonContent small orange right" style="display: none;">Reset Order</a>
</section>
<section class="contentMain odd">
<?=$pageTree?>
</section>
