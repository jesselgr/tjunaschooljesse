<?php

class Settings extends CI_Controller{
	
	public $language , $pageAttributes;
	private $child , $site_id;
	private $_form_data = array();

	public function __construct()
    {
		parent::__construct();	
		$this->ac->set_active_key('settings');

		$this->load->helper('language');
		$this->lang->load('form');
		$this->site_id = $this->session->userdata('site_id');
    }	
	
	public function switch_site($site_id)
	{
		if(!$this->permission->get('all_sites')) redirect($this->input->server('HTTP_REFERER'));
		$this->session->set_userdata('site_id', $site_id);
		redirect($this->input->server('HTTP_REFERER'));
	}
	public function general(){
		
		if(!$this->permission->get('update_setting')) show_error('Sorry, You do not have the correct permissions to access site settings');
		
		$status = ($_POST) ? $this->_update_settings() : false;

		$this->load->model('setting_model', 'SETT');
		///////////////////////////////////////////////////
		// 			Set data for loopform				///
		///////////////////////////////////////////////////
		
		$data['ac_cms_message']	=	$status;
		$data['head']			=	lang('settings_head'); 
		$data['subHead']		=	lang('settings_general_subhead');
		$data['descr']			=	'settings_descr';
		$data['object']		= 	$this->SETT->get_array(NULL, $this->site_id);

		$data['formTitle']	=	lang('settings_general_form_title');
		$data['formAction']	=	current_url();
		
		///////////////////////////////////////////////////
		// 			LOAD ALL THE VIEWS!1! 				///
		///////////////////////////////////////////////////
		
		if($this->input->is_ajax_request() || $this->input->get('dialog'))
		{

			$this->ac->place_overlay_header($data);
			$this->ac->place_template('forms/loopform');
			$this->ac->place_overlay_footer();
		}else{
			$this->ac->place_header($data);
			$this->ac->place_template('forms/loopform');
			$this->ac->place_footer();
		}
		
	}
		
	public function password()
	{
		if( ! $this->permission->get('update_user_self') )
		{
			show_error('Sorry, You do not have the correct permissions to change your password');
		}

		$in_dialog = $this->input->is_ajax_request() || $this->input->get('dialog');

		if( $this->_validate_input() )
		{
			$this->_form_data['pass_old'] = set_value('oldPassword');
			$this->_form_data['pass_new'] = set_value('newPassword');
			
			$result = $this->_update_password( $in_dialog );

			if( $in_dialog )
			{
				$this->output->set_status_header( $result['code'] );
				$this->output->set_output( $result['message'] );

				return;
			}
			else
			{
				$message_status = ($result['code'] == 201) ? 'ac_cms_message': 'ac_cms_error_message';

				$this->session->set_flashdata( $message_status , $result['message'] );
				redirect('settings/password');
			}
		}

		$data['in_dialog']		=	$in_dialog;
		$data['head']			=	lang('settings_head'); 
		$data['subHead']		=	lang('settings_password_subhead');
		$data['descr']			=	'settings_pwd_descr';
		
		$data['options'] 	= 	array('settings/password' => lang('settings_password_subhead'));

		if($in_dialog)
		{
			$this->ac->place_overlay_header($data);
			$this->ac->place_template('forms/pwdform');
			$this->ac->place_overlay_footer();
		}else{
			$this->ac->place_header($data);
			$this->ac->place_template('forms/pwdform');
			$this->ac->place_footer();
		}
		//$this->session->set_userdata('username', 'tjuna');
	}
	
	//////////////////////////////////////////////////////
	// 			verander het wachtwoord				   ///
	//////////////////////////////////////////////////////
	
	private function _update_password( $in_dialog = FALSE )
	{
		$this->load->model('user_model','USER');
		$this->load->helper('password');

		$userName 	= $this->session->userdata('username');
		$userRow 	= $this->USER->get_for_login( $userName );
		$passOld 	= $this->_form_data['pass_old'];

		if( password_verify( htmlspecialchars( $passOld ) , $userRow->password ) )
		{
			$passNew = password_hash( $this->_form_data['pass_new'] , PASSWORD_DEFAULT );
			
			$this->USER->update_pw( $userName , array('password' => $passNew ) );
			
			return array(
				'code' => 201,
				'message' => $this->lang->line('success_settings_password')
			);
		}
		else
		{
			return array(
				'code' => 400,
				'message' => $this->lang->line('error_settings_password')
			);
		}
	}
	
	///////////////////////////////////////////////////
	// 			Setup form validation				///
	///////////////////////////////////////////////////
	private function _validate_input()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('oldPassword', 	lang('form_pwd_old_password') , 'required|xss_clean');
		$this->form_validation->set_rules('newPassword', 	lang('form_pwd_new_password'), 'required|xss_clean');
		$this->form_validation->set_rules('verNewPassword', lang('form_pwd_new_password_confirm'), 'required|matches[newPassword]|xss_clean');

		return (bool) $this->form_validation->run();
	}
	
	
	private function _update_settings()
	{
		$this->load->model('settingsmodel', 'SETT');
		$settings = $this->input->post();
		
		
		foreach($settings as $row => $value){

			$this->SETT->set_setting($row, $value, $this->session->userdata('site_id'));
		}
		
		return $this->lang->line('succes_settings_saved');
	}

}