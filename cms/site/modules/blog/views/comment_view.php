<h1>{$heading}</h1>

<div id="comments">
<?php if($query->num_rows() > 0): ?>

 	<?php foreach($query->result() as $row):?>
 	<div class="commentblock" id="<?php echo $row->id; ?>">
 	<h2><?php echo $row->author; ?></h2>

  		<p><?php echo $row->body; ?></p>
  		
  		<p>Geschreven door: <?php echo $row->user; ?></p>
  		<?php if($row->user == $this->session->userdata('username')): ?>
  			<button class="edit" id="<?php echo $row->id; ?>">Aanpassen</button>
  			<button class="delete" id="<?php echo $row->id; ?>">Verwijder</button>
  			<br /><br />
  		<?php endif;?>	
  		<hr>
  	</div>
  	
	<?php endforeach;?>
 
<?php endif;?>
</div>

<h2>Reacties toevoegen</h2>
<?php echo form_open('blog/comment_insert','id="formpie"');?> 
<?php echo form_hidden('entry_id', $this->uri->segment(3));?> 
<p><input type="text" name="author" placeholder="Titel"/></p>
<p><textarea name="body" rows="10"></textarea></p>
<p><input type="submit" value="Voeg reactie toe"/></p>
<?php echo form_hidden('user', $this->session->userdata('username'));?>
<p><?php echo anchor('blog', 'Ga terug naar blog');?></p>

</form>
