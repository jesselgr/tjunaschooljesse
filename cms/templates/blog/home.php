<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>

<div id="container">
	<p>My view has been loaded</p>
	
	
	<?php foreach($rows as $r) {
	echo '<h1>' . $r->title . '</h1>';
	echo '<div>' . $r->contents . '</div>';
	}
	?>

</div>

</body>
</html>