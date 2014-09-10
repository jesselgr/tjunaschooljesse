<?php

class Site extends CI_Controller {
	/**
	 * call function
	 */
	function __construct() {
		parent::__construct();
		$this->is_logged_in();
	}
	/**
	 * get userdata
	 * @return boolean
	 */
	function is_logged_in() {
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'You dont have permission to acces this page. <a href="../login">Login</a>';
			die();
		}
	}
}
?>