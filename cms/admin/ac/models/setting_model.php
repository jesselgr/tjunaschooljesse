<?php
class setting_model extends CI_Model {
	
	
	     
    function get_all($group = NULL, $site_id)
    {
		$result    = array();
		$cache_key 	= 'settings/site_'.$group.'_'.$site_id;                                                   
		if (!$result = get_from_cache($cache_key))
		{
		  	if($group != NULL)	$this->db->where('group', $group);
		  
		  
		  	$this->db
			  	->where('site_id', $site_id)
			  	->order_by('setting_id','asc');
		  	
		  	$raw_result = $this->db->get('setting')->result();
		  	
		  	foreach($raw_result as $setting_row)
		  		$result[$setting_row->key] = $setting_row->value;
		  	
			write_to_cache($cache_key, $result, 3000);
			
			return $result;
		}
		
	}
	   
	function get_array($group = NULL, $site_id)
	{
		if($group != NULL) $this->db->where('group', $group);
		$this->db
			->select('setting.*, input_type.file_name as input_type',false)
			->join('input_type','input_type.input_type_id = setting.input_type_id')
			->where('site_id', $site_id)			
			->order_by('setting_id','asc');
		$query = $this->db->get('setting');


	    if($query->num_rows() > 0) return $query->result_array();
		
	}
	
	function get_settings_serialized($site_id)
	{	
		$this->db->where('site_id', $site_id);
		$this->db->where('serialized', true);
		$query = $this->db->get('setting');
		
	    if($query->num_rows() > 0) return $query->result();	
	}
	
	function get_front_settings(){
		$this->db->where('group','front');
		$query = $this->db->get('setting');
		
	    if($query->num_rows() > 0) return $query->result();
		
	}
	
	function set_setting($key, $setting, $site_id = 1)
	{
		$this->db
		->where('site_id', $site_id)
		->where('key',$key)
		->update('setting', array('value' => $setting));
	}
	
	function set_batch($batch, $site_id=1)
	{
		$this->db
			->where('site_id', $site_id)
			->where('key',$key)
			->update_batch('setting',$batch);
		
	}
	
	function get_setting_content($group = NULL, $site_id)
	{
		
		if($group != NULL)	$this->db->where('group', $group);
		
		$this->db
			->select('setcont.title, setcont.link, setting.setting_id, setting.value, setcont.setting_content_id, setcont.language_id, lang.name, lang.code')
			->where('site_id', $site_id)
			->join('setting_content setcont', 'setting.setting_id = setcont.setting_id')
			->join('language lang', 'setcont.language_id = lang.language_id');
		
		$query = $this->db->get('setting');
		
	    if($query->num_rows() > 0) return $query->result();   
	}
	
		
	function set_setting_content($setting)
	{
		
		$where = array(
			'setting_id' => $setting['setting_id'],
			'language_id'=>	$setting['language_id'],
		);
		$query = $this->db->get_where('setting_content', $where);
		
		
		if($query->num_rows() > 0)
		{
			$this->db->where($where);
			$this->db->update('setting_content', $setting);
		}
		else {
			$this->db->insert('setting_content', $setting);
		}
	}
	
	function get_site($site_id=1, $select='*')
	{
		$this->db->select($select);
		$this->db->where('site_id', $site_id);
		$query = $this->db->get('site');
		
		if($query->num_rows() == 1) return $query->row();
	}
	
	function get_sites($current_site_id)
	{
		$result = $this->db
			->order_by('site_id = '.$current_site_id.' desc')
			->get('site')
			->result();
	
		return $result;
	}
}