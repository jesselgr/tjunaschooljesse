<h1>{$heading}</h1>
<div id="subtitle">
  {foreach from=$result2 item=row}
    <h2>{$row.title}</h2>
    <h3>{$row.body}<h3>
    <hr>
  {/foreach}
</div>
<div id="comments">
{if $has_items}

 	{foreach from=$result item=row}
 	<div class="commentblock" id="{$row.comment_id}">
 	<h3>{$row.title}</h3>

  		<p>{$row.body}</p>
  		
  		<p>Geschreven door: {$row.user}</p>
  		{if $row.user == $this->session->userdata('username')}
  			<button class="edit" id="{$row.comment_id}">Aanpassen</button>
  			<button class="delete" id="{$row.comment_id}">Verwijder</button>
  			<br /><br />
  		{/if}	
  		<hr>
  	</div>
  	
	{/foreach}
 
{/if}
</div>

<h2>Reacties toevoegen</h2>
{form_open('blog/comment_insert','id="formpie"')}
{form_hidden('entry_id', $this->uri->segment(3))}
<p><input type="text" name="title" placeholder="Titel"/></p>
<p><textarea name="body" rows="10"></textarea></p>
<p><input type="submit" value="Voeg reactie toe"/></p>
{form_hidden('user', $this->session->userdata('username'))}
<p>{anchor('blog', 'Ga terug naar blog')}</p>

</form>
