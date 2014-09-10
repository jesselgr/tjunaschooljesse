<html>
<head>
<title>404 Page Not Found</title>
<style type="text/css">


body {

margin:				40px;
font-family:		Verdana, Sans-serif;
font-size:			12px;
color:				#000;
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
</body>
</html>