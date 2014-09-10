<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{


	public function __construct(){
       parent::__construct();	
        // Your own constructor code
    	$this->lang->load('dashboard');
    	
    }	
    

	// 				dashboard admin 	 			///
	///////////////////////////////////////////////////
			
	public function index()
	{
		$this->ac->set_active_key('dashboard');	
		$this->load->helper('language');
		
		$data['head']				=	lang('dashboard_head'); 
		$data['subHead']			=	lang('dashboard_subhead');
		$data['descr']				=	'admin_dashboard_descr';
		
		$data['pageDescription']	=	$this->lang->line('descr_admin');
		$data['shortcuts']			=	$this->config->item('cms_dashboard_shortcuts');
		
		
		
		$this->ac->load_view_with_wrapper('dashboard',$data);
		
	}
	
}