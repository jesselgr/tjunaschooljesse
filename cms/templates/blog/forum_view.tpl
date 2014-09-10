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
	<p>Log nou maar gewoon in!</p>
{else}
	<p>Username: {$this->session->userdata('username')}</p>
{/if}
<h2>Categorieën</h2>

{foreach from=$result item=row}
			
 	<h2>{anchor('blog/forum/category/'|cat:$row.category_id, $row.title)}</h2>
 		
{/foreach}  

