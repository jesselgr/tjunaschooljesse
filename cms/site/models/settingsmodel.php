<?php
class settingsmodel extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }
   
        
    function get_settings($role)
    {
    	$this->db->where('editablebyrole',$role);
		$query = $this->db->get('setting');
		
	    if($query->num_rows() > 0) return $query->result();
		
	}
	function get_front_settings($site_id = null){
		$this->db->where('group','front');
		if($site_id != null) $this->db->where('site_id', $site_id);
		$this->db->where('serialized', 0);
		
		$query = $this->db->get('setting');
		
	    if($query->num_rows() > 0) return $query->result();
		
	}
	
	function set_setting($key, $setting){
		$this->db->where('varname',$key);
		$this->db->update('setting', array('value' => $setting));
	
	}
	
	 function get_site_id_by_url($site_url=null)
    {
		if($site_url) $this->db->where('url',$site_url);
    	
    	$query = $this->db
    	->from('site')
    	->get();

       return $query->row();
	
	}
	
	 function get_sites($site_url=null)
{
	
		$query = $this->db
		->select('site_id,name, url, ssl')
		->from('site')
		->where('status = 1 ORDER BY url="'.$site_url.'" DESC',null, false)
		->get();
		
		return $query->result();
		
	}
}