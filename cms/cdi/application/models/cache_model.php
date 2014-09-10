<?php
class cache_model extends CI_Model {
	
	
	private $cache_dir;
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
        $this->load->helper('file');
        
        $this->cache_dir='../assets/custom/cache/';
        if(!is_writable(FCPATH.$this->cache_dir)) log_message('error', 'cache dir not writable!');
    }
   
        
    function set($cache_sum, $bin, $ext=false)
    {
    	if(is_file($this->cache_dir.$cache_sum.$ext) === true) unlink($this->cache_dir.$cache_sum.$ext);
    	return write_file($this->cache_dir.$cache_sum.$ext, $bin);
    }
    	
    	
    function get($cache_sum)
    {
    	return (is_file($this->cache_dir.$cache_sum)) ? read_file($this->cache_dir.$cache_sum) : false;
    }
}