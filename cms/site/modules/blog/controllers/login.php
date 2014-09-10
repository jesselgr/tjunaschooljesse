<?php

class Login extends CI_Controller {
	/**
	 * get header content footer css
	 * @return [view]
	 */
	function index() {
		$data['main_content'] = 'login_form';
		$data['css'][] = 'style2';

		$this->template->place_header($data);
  		$this->load->view('login_form', $data);
  		$this->template->place_footer($data);
		
	}
	/**
	 * load model
	 * get query
	 * set userdata
	 * @return [redirect]
	 */
	function validate_credentials() {
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();
		$success = false;

		if($query)
		{
			$data = array(
				'username' => $this->input->post('username'),
				'is_logged_in' => true
				);
			$this->session->set_userdata($data);
			$success = true;
			// redirect('blog', $data);
		}
		else
		{
			//doe iets voor ajax
		}

		echo json_encode(array('success'=>$success));
	}
	/**
	 * get header content footer
	 * @return [view]
	 */
	function signup() {
		$data['main_content'] = 'signup_form';
		$this->template->place_header($data);
		$this->template->place('blog/signup_form',$data);
  		//$this->load->view('signup_form', $data);
  		$this->template->place_footer($data);
	}
	/**
	 * load library for validations
	 * validate input
	 * @return [view]
	 */
	function create_member()
	{
		$this->load->library('form_validation');
		//error message
		$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
	
		if($this->form_validation->run() == FALSE)
		{
			$this->signup();
		}
		else
		{
			$this->load->model('membership_model');
			if($query = $this->membership_model->create_member())
			{
				$data['main_content'] = 'signup_succesful';
				$this->template->place_header($data);
  				//$this->load->view('signup_succesful', $data);
  				$this->template->place('blog/signup_succesful',$data);
  				$this->template->place_footer($data);
			}
			else
			{
				$this->load->view('signup_form');
			}
		}
	}


}