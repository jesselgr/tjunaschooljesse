<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title></title>
	<meta name="description" content="">
	<meta name="author" content="Tjuna">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href='http://fonts.googleapis.com/css?family=Voces' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="<?php echo base_url()?>assets/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo base_url()?>assets/apple-touch-icon.png">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/setup.css?v=2">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/cms_main.css?v=2">

	<script src="<?php echo base_url()?>assets/js/libs/modernizr-1.7.min.js"></script>

 </head>
<body>
		<header class="login">
			<h1 class="ir logo">Tjuna Albacore ac</h1>
		</header>

		<div class="loginSectionContainer">


			<section class="loginSection">




				<?=form_open('login')?>

					<div class="formInput">
					    <?=form_label(lang('login_form_username'), 'user_name')?>
					    <?=form_input('user_name', set_value('user_name'), 'class="inputField medium"')?>
				    </div>
					<div class="formInput">
				    	<?=form_label(lang('login_form_password'), 'user_pass')?>
				   	 	<?=form_password('user_secr', null, 'class="inputField medium"')?>
				   	 	<?=form_password('user_pass', null, 'class="inputField medium visuallyhidden"')?>
				    </div>

			       	<?=form_submit(array('name' =>'login-submit', 'class' => 'buttonContent'), 'Login')?>

				<?=form_close();?>

				</section><!-- loginSection -->

			</div><!-- loginSectionContainer -->
			<?if(validation_errors()):?>
			 <div class="formErrorMessage"><?php  echo validation_errors(); ?></div>
			<? endif;?>
			<?php if(!empty($error)) : ?>
			<div class="formErrorMessage"><?php echo lang($error)?></div>
			<?php endif; ?>

		<!--[if lt IE 7 ]>
		<script src="js/libs/dd_belatedpng.js"></script>
		<script> DD_belatedPNG.fix('img, .png_bg');</script>
		<![endif]--> </body>
	</body>
</html>