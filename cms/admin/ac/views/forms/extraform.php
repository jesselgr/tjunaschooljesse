<section class="contentSection">

	<?=form_open($formAction)?>
	
	<?foreach ($object as $key => $item):?>	
		
		<?if(($key%2)) $odd=' odd';
		else $odd = '';?>
		<section class=	"contentMain<?=$odd?>">
		
			<div class="tabs" class="ambLangTab">
				<?if(count($languages) > 1):?>
				<script>
					$(function() {
						$(".tabs").tabs();
					});
				</script>	
				<ul>
					<?foreach($languages as $i => $language):?>
						<li>
							<a class="ambLangTab" href="#tabs-<?=($language->code)?>" title="<?=$language->name?>">
								<span class="flag flag-<?=$language->code?>">&nbsp;</span>
							</a>
						</li> 
					<?endforeach;?>
				</ul>
				
				<?endif;?>
				<?foreach($languages as $i => $language):?>
					
					<?if(!isset($item[$i])) $item[$i] = array('title' => '', 'link' => '');?>
					
					<div id="tabs-<?=($language->code)?>">
					
					
						<section class=" ">
							<p><?= form_label('Title:', 'title')?></p>
							<p><?=form_input(array('name'=>'title-'.$key.'-'.$i,'class'=> 'inputField'),$item[$i]['title'])?></p>
						</section>
						
						<section class="odd">
							<p><?= form_label('Link:', 'link')?></p>
							<p><?=form_input(array('name'=>'link-'.$key.'-'.$i,'class'=> 'inputField'),$item[$i]['link'])?></p>
						</section>
					
					</div>
				
				<?endforeach;?>
			
			</div>
		</section>
		
	<?endforeach;?>	
	
</section>
		<section class="contentMain odd">
			<p><?=form_submit(array('class' => 'buttonContent','value'=>lang('form_page_edit_submit')))?>
			
			<a class="buttonContent grey" href="<?=current_url()?>" onclick="return confirmSubmit('<?=lang('form_cancel_confirm');?>')">
				<?=lang('form_cancel');?>
			</a></p>
		</section>