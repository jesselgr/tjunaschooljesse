<?php
class file extends CI_Controller{
	
	
	
	public function __construct()
    {
       parent::__construct();	
        // Your own constructor code
    

    }	
    
	
	
	//////////////////////////////////////////////////
	// 			file Browser en upload  	  		//
	//////////////////////////////////////////////////
		
	public function index(){
		$this->load->helper('language');
		$headerData['navItems']	= 	'';
		
		$data['head']			=	'Bestanden'; 
		$data['subHead']		=	'Afbeeldingen en andere media';
		$data['descr'] 			= 	'file_upload_descr';
		
		$this-> load->view('adminHeader', $headerData);
		$this-> load->view('adminPage',$data);
		$this-> load->view('fileBrowser');

		$this-> load->view('adminFooter');	
	}
	
}