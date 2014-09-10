<?php

class Logout extends CI_Controller {

	/**
 	* get placeholders and content
 	* destroy session
 	* @return [view]
 	*/
	public function index()
	{
		$data['main_content'] = 'logout';
		$this->template->place_header($data);
  		//$this->load->view('logout', $data);
  		$this->template->place('blog/logout',$data);
  		$this->template->place_footer($data);
  		
		$this->session->sess_destroy(); // codeigniter session end
	}

}