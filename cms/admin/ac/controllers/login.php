<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller{

	private $_errors = 0;
	public function __construct()
	{
	   parent::__construct();
	   $this->lang->load('login', $this->config->item('language'));
	}

	public function index()
	{
		if($this->ac->validate_login())redirect($this->config->item('ac_after_login_landing_page'));
		//login
		$this->load->library('form_validation');

		$config = array(
			array(
				'field'   => 'user_name',
				'label'   => lang('login_form_username'),
				'rules'   => 'required|xss_clean'
			),
			array(
				'field'   => 'user_secr',
				'label'   => lang('login_form_password'),
				'rules'   => 'required|xss_clean'
			),
		);

		$data = array();

		$this->form_validation->set_rules($config);

		// Form validation werkt niet om nog onbekende reden
		if (!($this->form_validation->run() == FALSE || $this->input->post('user_pass')))
			$data['error'] = $this->_validate();

		$this->load->view('login',$data);
	}

	/* 		functie kijkt in de database of de gegeven gebruiker (post) in de DB staat
	 * 		zo ja: ga door naar admin paneel
	 * 		zo nee: terug naar het aanmeldformulier
	 */

	private function _validate()
	{
		$this->load->model('user_model', 'USER');
		$this->load->helper('password');

		$user_name 	= 	mysql_real_escape_string($this->input->post('user_name'));
		$error = false;
		$user_row = $this->USER->get_for_login($user_name);
		if (!$user_row)
			return 'login_error_failed';
	

		// check for inconsisenties in the given user's data
		if(!password_verify(htmlspecialchars($this->input->post('user_secr')), $user_row->password))
			return 'login_error_failed';

		if($user_row->status != 1)
			return 'login_error_inactive';

		if($user_row->ac_cms_access != '1')
			return 'login_error_failed';

		// since we have seperated the user groups, load this after we know we have the right user.
		// get the site information (id) based on the user information
		$site_id = $user_row->site_id;
		if($site_id == 999) 
			$site_id = 1;

		// set userdata after login with the user and site info
		$userdata = array(
			'username' 		=> 	$user_name,
			'is_logged_in' 	=> 	sha1(date('Wm',time()).'TjunaAlbacore'.site_url()),
			'user_group_id'	=> 	$user_row -> user_group_id,
			'user_id'		=> 	$user_row -> user_id,
			'site_id'		=> 	$site_id
		);

		// if($this->session->all_userdata())	$this->session->sess_destroy();
		//set the user data
		$this->session->set_userdata($userdata);
		// get our landing page and go there

		redirect($this->config->item('ac_after_login_landing_page'));
		
		
	}

	public function logout()
	{
		$this->session->sess_destroy();
		if(session_id()){
			session_destroy();
		}
		redirect('login');
	}



}