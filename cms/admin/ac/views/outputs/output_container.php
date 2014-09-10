<section class="contentMain <?=$switch?>">
	
	<span class="list_item_title"><?=$label?>: </span> &nbsp;
	<?if(isset($HTML)): 
		echo $HTML;
	elseif($value):
		$this->load->view('outputs/'.$output_type);
	else:?>
	N.A.
	<?endif;?>
</section><!-- end contentMain <?=$switch?> -->