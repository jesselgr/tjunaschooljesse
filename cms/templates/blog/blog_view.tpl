
<h1>{$heading}</h1>
<div id='login_form'>
		<a href="#" class="close">Close</a>

	<h1>Login</h1>
	{form_open('blog/login/validate_credentials', 'id="logform"')}
	{form_input('username', null, 'placeholder="username"')}
	{form_password('password', 'Password')}
	{form_submit('submit', 'login')}
	{form_hidden('validator', $this->session->userdata('is_logged_in'))}
	{anchor('blog/login/signup', 'Create Account')}
</form>
</div>
<a href="#" class="window">Loginwindow</a>
{if $this->session->userdata('is_logged_in') == NULL}
	<p>Login om berichten en reacties te kunnen toevoegen</p>
{else}
	<p>Username: {$this->session->userdata('username')}</p>
{/if}

<div id="post">
	{foreach from=$result item=row}
		<div class="postmessage" id="{$row.id}">
 			<h2>{$row.title}</h2>
 			<p>{$row.body}</p>
 			<p>Geschreven door: {$row.user}</p>
			{if $this->session->userdata('username') != NULL}

 				<p>{anchor('blog/comments/'|cat:$row.id, 'Reacties')}</p>

			{/if}
 			<hr>
 		</div>
	{/foreach}  

</div>
{if $this->session->userdata('username') != NULL}
	<h2>Berichten toevoegen</h2>
	{form_open('blog/entry_insert','id="postform"')} 
	<p><input type="text" name="title" placeholder="Titel"/></p>
	<p><textarea name="body" rows="10" ></textarea></p>
	{form_hidden('user', $this->session->userdata('username'))} 
	<p><input type="submit" value="Voeg bericht toe"/></p>
	<a href="blog/logout">Log out</a>
{/if}