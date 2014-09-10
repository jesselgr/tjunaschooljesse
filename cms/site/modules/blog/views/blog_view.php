
<h1><?php echo $heading?></h1>
<div id='login_form'>
		<a href="#" class="close">Close</a>

	<h1>Login</h1>
	<?php 
	echo form_open('blog/login/validate_credentials', 'id="logform"');
	echo form_input('username', null, 'placeholder="username"');
	echo form_password('password', 'Password');
	echo form_submit('submit', 'login');
	echo form_hidden('validator', $this->session->userdata('is_logged_in'));
	echo anchor('blog/login/signup', 'Create Account');
	?>
</form>
</div>
<a href="#" class="window">Loginwindow</a>

<?php if ($this->session->userdata('is_logged_in') == NULL):?>
	
	<p>Login om berichten en reacties te kunnen toevoegen</p>
	
<?php else:?>

<p>Username:<?php print_r($this->session->userdata('username'));?></p>

<?php endif;?>
<div id="post">
	<?php foreach($query->result() as $row):?>
		<div class="postmessage" id="<?php echo $row->id; ?>">
 			<h2><?php echo $row->title; ?></h2>
 			<p><?php echo $row->body; ?></p>
 			<p>Geschreven door: <?php echo $row->user; ?></p>
 		
			<?php if ($this->session->userdata('username') != NULL):?>

 				<p><?php echo anchor('blog/comments/'.$row->id, 'Reacties');?></p>

			<?php endif;?>
 			<hr>
 		</div>
	<?php endforeach;?>  

</div>
<?php if ($this->session->userdata('username') != NULL):?>
	<h2>Berichten toevoegen</h2>
	<?php echo form_open('blog/entry_insert','id="postform"');?> 
	<p><input type="text" name="title" placeholder="Titel"/></p>
	<p><textarea name="body" rows="10" ></textarea></p>
	<?php echo form_hidden('user', $this->session->userdata('username'));?> 
	<p><input type="submit" value="Voeg bericht toe"/></p>
	<a href="blog/logout">Log out</a>
<?php endif;?>
