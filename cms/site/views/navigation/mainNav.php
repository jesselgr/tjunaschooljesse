<ul> 

	<?if($navItems): 
		foreach($navItems as $navItem):?>
		<li class="root <?if(isset($navItem['subnav']) && $navItem['subnav'] != "")echo' dir';?>">
			<?if($currentPage==$navItem['url'] || $nav['root']['url'] == $navItem['url'] ){ $active = 'class="active"';}else{$active='';}?>
			<?if($navItem['url'] == $this->config->item('default_landing_page')) $navItem['url']='';?>
			
			<a href="<?=site_url(array($lang.'/'.$navItem['url']));?>" <?echo $active;?>><?= $navItem['title'];?></a>
			
			<?if(isset($navItem['subnav']) && $navItem['subnav'] != ""):
				$subNavItems = $navItem['subnav'];?>
				<ul class="navChildren"><!--style="display:  none;" -->
				<?foreach($subNavItems as $subNavItem):?>
					<li class="">
						<a href="<?=site_url(array($lang.'/'.$navItem['url'].'/'.$subNavItem['url']));?>" class="<?= $subNavItem['class'];?>">
							<?= $subNavItem['title'];?>
						</a>
					</li>
				<?endforeach;?>
				</ul>
			<?endif;?>
		<?endforeach;?>
		</li>
	<? endif;?>
	
</ul>