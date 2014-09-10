
<ol id="<?=$pageID?>" class="dragList">
	<? if(isset($navItems) && $navItems):
	
		foreach($navItems as $listedPage):
		if(is_object($listedPage))$listedPage = get_object_vars($listedPage);?>
			
			<li name="<?=$listedPage['nav_prio']?>" id="<?=$listedPage['id']?>" class="dragBgMid">
			 <div>
			  <div class="dragBgLeft"></div>
			  <div class="pageIcon"></div>
			  <p class="page"><?=$listedPage['title']?></p>
			  <a  href="<?=site_url(array('page','delete_page',$listedPage['id']))?>" class="deletePageIcon" 
			  onclick='return confirmSubmit("<?=lang("content_confirm_delete_text");?>")'></a>
			  <a  href="<?=site_url(array('content', $listedPage['url_name']))?>" class="editPageIcon"></a>
			  <div class="dragBgRight"></div>
			 </div>
			</li>
		 <?endforeach;
	 endif; ?>
</ol>
