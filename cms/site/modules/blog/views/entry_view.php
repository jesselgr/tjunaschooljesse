<html>
<head>
<title><?php echo $title?></title>
</head>

<body>

<h1><?php echo $heading?></h1>

<?php echo form_open('blog/entry_insert');?> 
	<p><input type="text" name="title" placeholder="Titel"/></p>
	<p><textarea name="body" rows="10" ></textarea></p>
<?php echo form_hidden('user', $this->session->userdata('username'));?> 
	<p><input type="submit" value="Voeg bericht toe"/></p>
	<p><?php echo anchor('blog', 'Terug naar Blog');?></p>
</form>
 
</body>