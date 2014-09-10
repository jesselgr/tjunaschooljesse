<section class="contentContainer" role="main"> 
	<header class="contentHeader"> 
		<h2><?if(isset($head))echo humanize($head);else{?>no Title<?}?></h2> 
		<h3><?if(isset($subHead))echo humanize($subHead);?></h3> 
	</header> 
	
	<section class="contentSection">	
	
	
	<?if(isset($descr)):?>
		<section class="contentMain"> 
		<p><?= lang($descr);?></p>

		</section>

 	<?endif;?>