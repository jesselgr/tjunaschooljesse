<section class="contentMain odd">


	<div class="dashboard">
		<ul class="shortcuts">
		
		<?if($shortcuts):?>
		<?foreach($shortcuts as $shortcut):?>
		<li>
			<a class="<?=$shortcut['class']?>" href="<?=$shortcut['link']?>">
				<span><?=lang($shortcut['lang_key'])?></span>
			</a>
		</li>
		<?endforeach;?>
		<?endif;?>
		</ul>
	</div>
</section>