<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class auth{
	
    private $CI;
    
    public $active_components = array();

    
    public function __construct($params=null)
    {

        $this-> CI = &get_instance();
        
    }
    
  
    public function validate_login()
    {
    	$is_logged_in 	= 	$this->CI->session->userdata('is_logged_in');
    	$hash 			= 	sha1(date('Wm',time()).'TjunaAlbacore'.site_url());
    
    	return (bool)($is_logged_in != null && $is_logged_in == $hash);
    }
    
}