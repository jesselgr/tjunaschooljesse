<section class="sidebarContainer"> 
		
	<header class="sidebarHeader"> 
		<section class="sidebarInfo"> 
			<div class="siteInfo clearfix">
				<h3 title="<?php echo $this->session->userdata('username'); ?>">
					<?php echo $this->session->userdata('username')?>
				</h3>
				<h3>
					<span class="siteName">
						<?if($this->permission->get('all_sites') && count($this->ac->sites) >1 ):?>
							<span>&#11015;</span>
							<ul class="site_switch">
								<?foreach($this->ac->sites as $site_row):?>
									<li><a href="<?php echo site_url('settings/switch_site').'/'.$site_row->site_id?>"><?php echo $site_row->name?></a></li>
								<?endforeach;?>
							</ul>
						<?endif;?> 
						<h5><?php echo $this->ac->sites[0]->name?></h5>
					</span>
				</h3>
				<small> 
					<div class="info">						
						<?$website = $this->ac->sites[0]->url;?>
						<ul>
							<li><a title="<?php echo lang('ac_panel_link_visit_website')?>" href="<?php echo $website ?>" target="_blank"><?php echo lang('ac_panel_link_visit_website')?></a></li>
							<li><a title="<?php echo lang('settings_password_subhead')?>" class="jsDialogLink" href="<?php echo base_url().'settings/password' ?>?dialog=1"><?php echo lang('settings_password_subhead')?></a></li>
							<li><a href="<?php echo base_url()?>login/logout" onclick='return confirmSubmit("<?php echo lang('ac_panel_link_log_out_confirm')?>")'><?php echo lang('ac_panel_link_log_out')?></a></li> 
						</ul>
					</div>
				</small>
			</div>
		</section>
	</header> 

	<nav id="sidebar" class="sidebarNav"> 
		<ul id="accordion">
		<?foreach($ac_nav as $i=> $group):?>
		
			<?if($i != 0):?><li class="noLink">&nbsp;</li><?endif;?>
		<?foreach($group['children'] as $item):?>
		
		
				
			<?if(isset($item['permission']) &&  $this->permission->get($item['permission'])):?>
			<?php $is_active = ((bool)nav_item_is_active($item, $ac_key, $ac_sub_key))?>
				<?$has_subnav = (isset($item['subnav']) && is_array($item['subnav']));?>
				<li class=" <?php echo ($has_subnav) ? ' submenu ':' nosubmenu '?> <?if($is_active) echo ' current '?>">
					<a href="<?php echo site_url($item['url'])?>"> 
						<div> 
							<span class="navTitle"><?php echo lang($item['title'])?></span> 
							<span class="navIcon <?php echo $item['icon']?>"></span> 
						</div> 
					</a> 
					<?if($has_subnav):?>
					<ul <?if(!$is_active):?>style="display:none"<?endif;?>>
						<?foreach($item['subnav'] as  $key => $url):?>
							<li ><a  class="<?php echo ($ac_sub_key == $key) ?'active': null;?>" href="<?php echo site_url($url)?>"><?php echo lang($item['lang_prefix'].$key)?></a></li>
						<?endforeach;?>
					</ul>
					<?endif;?>
				</li> 
				
			<?endif;?>
			<?endforeach;?>
		<?endforeach;?>
		</ul><!-- accordion --> 
	</nav><!-- sidebarNav --> 
</section><!-- sidebar --> 


