<html>
<head>
<title>Database Error</title>
<style type="text/css">

body {

margin:				40px;
font-family:		Verdana, Sans-serif;
font-size:			12px;
color:				#000;
background:  		url("<?=base_url()?>assets/img/contentcontainer_bg.png") repeat-x;
}

#content  {
border:				#999 1px solid;
border-radius: 		5px;
background-color:	#fff;
padding:			20px 20px 12px 20px;
box-shadow: 0px 3px 5px #ddd;
}

h1 {
font-family: 		monospace, courier new;
font-weight:		bold;
font-size:			18px;
color:				#009999;
margin:				0 0 4px 0;
}

#footnote{
	font-size: 10px;
	color: #888;
	padding-left: 5px;
}
</style>
</head>
<body>
	<div id="content">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
		
	</div>
	<p id="footnote">This message is intent for notifying developers of minor errors. These errors often occur in incompleted sections of the system. If you are not a developer, please ignore this message. If this error persists, please contact your <a target="blank" href="http://www.tjuna.com">ac administrator</a></p>
</body>
</html>