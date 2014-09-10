<h1>Create Account</h1>
<fieldset>
	<legend>Personal Information</legend>

	{form_open('blog/login/create_member')}
	{form_input('first_name', set_value('first_name', 'First name'))}
	{form_input('last_name', set_value('last_name', 'Last name'))}
	{form_input('email_address', set_value('email_address', 'Email Address'))}

</fieldset>

<fieldset>
	<legend>Login Info</legend>
	
	{form_input('username', set_value('username', 'Username'))}
	{form_input('password', set_value('password', 'Password'))}
	{form_input('password2', set_value('password2', 'Password Confirm'))}
	{form_submit('submit', 'Create Account')}
	

	{validation_errors('<p class="error">')}
</fieldset>