<?=form_open('settings/password')?>
	<!-- OLD PASSWORD -->	
	<section class="contentMain odd">
		<label for="oldPassword"><?=lang('form_pwd_old_password');?></label>
		<p>
			<input type="password" name="oldPassword" id="oldPassword" class="inputField" >
			<?=form_error('oldPassword', '<div class="formInputErrorMessage">','</div>')?>
		</p>
	</section> 
	<!-- NEW PASSWORD -->
	<section class="contentMain ">
		<label for="newPassword"><?=lang('form_pwd_new_password');?></label>
		<p>
			<input type="password" name="newPassword" id="newPassword" class="inputField" >
			<?=form_error('newPassword', '<div class="formInputErrorMessage">','</div>')?>
		</p>
	</section>
	<!-- NEW PASSWORD CONFIRM -->
	<section class="contentMain odd">
		<label for="verNewPassword"><?=lang('form_pwd_new_password_confirm');?></label>
		<p>
			<input type="password" name="verNewPassword" id="verNewPassword" class="inputField" >
			<?=form_error('verNewPassword', '<div class="formInputErrorMessage">','</div>')?>
		</p>
	</section>

	<?if(!$in_dialog):?> 
	<section class="contentMain"> 
		<p>
			<?=form_submit(array('class' => 'buttonContent','value'=>lang('form_pwd_submit')))?>
			<a class="buttonContent grey" href="<?=site_url(array('dashboard'))?>" onclick="return confirmSubmit('<?=lang('form_cancel_confirm');?>')">
				<?=lang('form_cancel');?>
			</a>
		</p>
	</section>
	<?endif;?>

</form>