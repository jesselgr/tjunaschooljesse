<ul>
	<? if(isset($subNavItems) && $subNavItems != ""){
		$switch='odd';
		if(!isset($urlKey)){$urlKey = 'name';}
		if(!isset($titleKey)){$titleKey = 'title';}
		foreach($subNavItems as $subNavItem){ 
			if(is_object($subNavItem))$subNavItem = get_object_vars($subNavItem);  ?>
			<li class="subNavListItem <?php echo $switch; ?>">
				<a href="<?=$base.$navUrlController."/".$subNavItem[$urlKey];?>" 
				<? if(array_key_exists('class', $subNavItem)){?>class="<?= $subNavItem['class'];?>"<?}?>>
					<?= $subNavItem[$titleKey]; ?>
				</a>
			</li>
			<?php 
			if($switch==''){$switch='odd';}else{$switch='';}
		 } 
	} ?>
</ul>