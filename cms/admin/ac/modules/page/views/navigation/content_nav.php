<div class="contentMain odd clearfix">
	<div class="templateDescription floatLeft">
		<?=$template_description?>
	</div>
	
	<div class="contentButtonContainer">
		<?if($permissions['page_delete']):?>
		
					<a class="buttonContent huge narrow floatRight red delete" {delete_display_none} title="<?=lang('page_delete_button_full')?>" href="<?=site_url('page/delete/'.$pageID)?>" onclick='return confirmSubmit("<?=lang("content_confirm_delete_text");?>")'>
					<?=lang('page_delete_button')?>
					</a>
		
				<?endif;?>
		<a class="buttonContent huge floatRight jsDialogLink hasSmallIcon" title="<?=lang('nav_page_settings_for').$subHead?>" href="<?=site_url('page/modify/'.$pageID)?>"><?=lang('nav_page_settings')?></a>
		
	</div>
	<a class="order_reset buttonContent  orange " style="display: none;">Reset order</a>
</div>

<div id="contentNav" >
	
	
	<? $switch='';	
	foreach($sections as $sectionRow):
	$section_id = $sectionRow->template_section_id;
	?>
	
	<section  class="contentMain clearfix <?php echo $switch; ?> ">
		<div class="sectionDescriptionContainer">
		<?if(isset($sectionRow->description)) echo $sectionRow->description;?>
		</div>
		<div class="contentListContainer">
			<h3><?=(lang('content_section_'.$sectionRow->title))? lang('content_section_'.$sectionRow->title) :humanize($sectionRow->title);?></h3>	
			<ul id="<?=$section_id?>" class=" contentList">	
				<? $edit_url 	= site_url(array('page','content','form', $pageID)).'/';?>
				<? $delete_url 	= site_url(array('page','content','delete_content')).'/';?>
<!--				<? $perm_create = $this->permission->get('create_content');?>-->
				<?if(isset($content[$section_id])):?>	
				<?foreach($content[$section_id] as $contentRow):?>
				
					
					<li id="<?=$contentRow->content_id?>" class="<?=$contentRow->typeTitle?> contentItem <?if($contentRow->restricted && !$modify):?>drag-disabled<?endif;?>">

						<?php $tabname='sectiontitle';?>
						<div class="listIcon contentIcon"></div>

						<span class="title contentTitle">
							<?php if($contentRow->title) echo character_limiter($contentRow->title, 40);?>
							
						</span>
						<span class="title typeTitle">
							<?php if($contentRow->typeTitle) echo lang('content_type_title_'.$contentRow->typeTitle);?>
						</span>

						<div class="floatRight">
							<!-- <a class="listButton" href="<?=site_url('../preview/slide/'.$contentRow->content_id)?>" target="_blank">Preview</a> -->
							<?if($permissions['update'] ):?>
								<a title="<?=lang('content_edit_button')?> <?php if($contentRow -> title) echo $contentRow->title;?>" class="listButton  contentEdit jsDialogLink" href="<?=$edit_url.$contentRow -> content_id?>">
									<?=lang('content_edit_button')?>
								</a>

							<?endif;?>
							<?if($permissions['create']   && !$contentRow->restricted):?>
							<a  class="listButton red small" title="<?=lang('content_delete_button')?>" href="<?=$delete_url.$contentRow->content_id?>" onclick='return confirmSubmit("<?=lang('list_delete_confirm')?>")'>
								&#9747;
							</a>
							<?endif;?>
						</div>

					</li>

				 
				<?endforeach;unset($content[$section_id]);?>
				<?else:?>
				<span class="no_content_text"><?=lang('content_no_content')?></span>
				<?endif?>
				</ul> 
				<?if($permissions['create'] && $section_id):?>
				<div class="contentAddCont">
					<div class="contentCreateSelect clearfix">
						<?=form_open('page/content/create_content', array('class' =>  'modtools')); ?>
					<!--		<label for="title">Titel:</label><?=form_input('title',null, 'class="inputField"')?>	-->
							<?=form_hidden('pageID', $pageID);?>
							<?=form_hidden('pageName', $pageName);?>
							<?=form_hidden('section_id', $sectionRow->template_section_id);?>
							<?=form_dropdown('type',$contentTypes[$sectionRow->template_section_id], null,  'id="contentCreateSwitch", style="width:150px"')?>
							<input type="submit" value=" <?=lang('content_add')?>" class="buttonContent small floatRight"/>
						<?=form_close();?>
					</div>
				</div>
				<a data-switch="0" href="<?=site_url(array('page/content/create', $pageID, $section_id))?>" class="addContent  hoverLight collapsed"><span>+</span></a>
				<?endif;?>
			</div>
		</section>
		<?if($switch==''){$switch='odd';}else{$switch='';}?>
	<?endforeach;?>
	</div>
	
</section>
</div>