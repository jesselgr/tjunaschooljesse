
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
	<p>Log nou maar gewoon in</p>
{else}
	<p>Username: {$this->session->userdata('username')}</p>
{/if}

<div id="post">
	{foreach from=$result item=row}
		<div class="postmessage" id="{$row.topic_id}">
 			<h3>{anchor('blog/comments/'|cat:$row.topic_id, $row.title)} Geschreven door: {$row.user}</h3>
 			<hr>
 		</div>
	{/foreach}  

</div>
{if $this->session->userdata('username') != NULL}
	<h2>Topic toevoegen</h2>
	{form_open('blog/entry_insert','id="postform"')} 
	{form_hidden('topic_entry', $this->uri->segment(4))} 
	<p><input type="text" name="title" placeholder="Titel"/></p>
	<h3>Geef hier een uitleg waar het topic over gaat</h3>
	<p><textarea name="body" rows="10" placeholder="Uitleg"></textarea></p>
	{form_hidden('user', $this->session->userdata('username'))} 
	<p><input type="submit" value="Voeg bericht toe"/></p>
	<a href="blog/logout">Log out</a>
{/if}