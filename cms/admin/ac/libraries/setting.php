<?php
 class setting {
	private $data = array();
	
	public function __construct($params=null)
	{
		
		$this-> CI = &get_instance();
	    $this-> CI->load->model('setting_model', 'SETT');
	        
	    $this->_load();
	}
	
	// getter
  	public function get($key) 
  	{
    	return (isset($this->data[$key]) ? $this->data[$key] : null);
  	}	
	
	// setter
	public function set($key, $value, $save = true) 
	{
    	$this->data[$key] = $value;
    	if($save)$this->SETT->set_setting($key, $value);
  	}

	// just checker
	public function has($key) 
	{
    	return isset($this->data[$key]);
  	}

	// on first load, get 'em
  	private function _load() 
  	{
  		$site_id 	= $this->CI->session->userdata('site_id');
  		if(!$site_id) $site_id =  1;
  		
  		if($this->data = $this->CI->SETT->get_all('back', $site_id))
  		{

			// set to config file
		  	foreach($this->data  as $key => $value)
		  	{
		  		$this->CI->config->set_item('sett_'.$key, $value);
		  	}
	  	}
  	}
  	
    	
}
?>