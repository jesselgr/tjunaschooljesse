<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>AC</title>
	<meta name="description" content="Albacore">
	<meta name="author" content="Tjuna">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link href="http://fonts.googleapis.com/css?family=Tenor+Sans" rel="stylesheet" type="text/css"> -->
	
<!--	<link href="http://fonts.googleapis.com/css?family=Ubuntu:300,400" rel="stylesheet" type="text/css">-->
	<link rel="stylesheet" href="<?= base_url()?>assets/css/setup.css?v=2">
	<link rel="stylesheet" href="<?= base_url()?>assets/css/cms_main.css">
	<link rel="stylesheet" href="<?= base_url()?>assets/css/flags.css">
	
	<link rel="stylesheet" href="<?= base_url()?>assets/js/libs/ui_multiselect/css/ui.multiselect.css"/>
	<link rel="stylesheet" href="<?= base_url()?>assets/js/libs/jquery_ui/css/tjuna_azura/jquery-ui.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?= base_url()?>assets/js/libs/select2/select2.css">
	<script type="text/javascript" src="<?=base_url()?>assets/js/libs/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/shadowbox/shadowbox.js"></script>
	<script type="text/javascript" src="<?=base_url()?>../core/ckeditor/ckeditor.js"></script>
	
	<script type="text/javascript" src="<?=base_url()?>assets/js/libs/modernizr-1.7.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/libs/jquery_ui/js/jquery-ui-1.8.16.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/libs/select2/select2.min.js"></script>
	<?if(isset($css) && is_array($css)):
   	foreach($css as $css_file):?>
			 <link rel="stylesheet" href="<?= base_url()?>assets/css/<?=$css_file?>">
	 	<?endforeach;
 	endif;
 	?>
	
<!--	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
<!--	<script src="<?= base_url()?>assets/js/geocoder.js"></script>-->
	
	
	<script type="text/javascript">
		var base_url 		= 	"<?=base_url()?>",
			site_url 		= 	"<?=site_url()?>",
			current_url 	= 	"<?=current_url()?>",
			page_sort_url	=	'<?=base_url()?>'+'page/change_navprio',
			cdi_url 		=  	"<?=site_url().conf('url_cdi')?>";
</script>
	</script>
	
	 

</head>
<body class="ac <?if($is_standalone_popup) echo " standalone ";?>">	


<? if(!$is_standalone_popup):
	$this->load->view('static/cms_messages');
	$this->load->view('navigation/cms_navigation');
endif;?>
	
	