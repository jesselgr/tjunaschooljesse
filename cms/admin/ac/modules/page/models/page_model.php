<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class page_model extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
        $this->site_id = $this->session->userdata('site_id');
        
    }
   
  	//	get pages per parent (parent null = root) 	/
	
	function get_pages($parent_page_id = null, $menu_only = false, $select = '*',$inTree = true, $order=null, $language_id = '1', $site_id)
	{

		$this->db->select($select);
		$this->db->from('page');
		$this->db->join('page_description description', 'page.page_id = description.page_id');
		
		if($parent_page_id != null) $this->db->where('parent_page_id', $parent_page_id);
		if($menu_only == true)		$this->db->where('in_menu', '1');
		if($inTree == true)			$this->db->where('in_tree', '1');
		if($this->site_id)			$this->db->where('page.site_id', $this->site_id);
		
		$this->db->where('description.language_id', $language_id);
		$this->db->group_by('description.url_name');
		$this->db->order_by( ($order)? $order[0].' '.$order[1] : 'nav_prio asc');
		
		$query = $this->db->get();
	    if($query->num_rows() > 0) return $query->result();
		
	}
	
	//	get a single page by id	///
	function get_page_by_id($page_id, $select = '*', $lang=null)
	{
		$this->db->select($select);
		$this->db->where('page_id', $page_id);
		if($lang) $this->db->where('language_id', $lang);
	    $query = $this->db->get('page', 1);
	    
	    if($query->num_rows() == 1) return $query->row();
	}
	
	function get_page_descr_by_id($page_id, $select = '*', $lang=null)
	{
		$this->db->select($select);
		$this->db->where('page_id', $page_id);
		if($lang) $this->db->where('language_id', $lang);
	    $query = $this->db->get('page_description', 1);
	    
	    if($query->num_rows() == 1) return $query->row();
	}	
	
	
	//	get a single page by name	///
	function get_page_with_id($id, $conditions=null, $select = '*', $language_id=null, $site_id=null)
	{

		$this->db->distinct($select);
		$this->db->select($select);
		
		$this->db->from('page');
		$this->db->join('page_description description','description.page_id = page.page_id');
		$this->db->limit('1');
		$this->db->where('page.page_id', $id);
		if($site_id)$this->db->where('page.site_id', $site_id);
		
		if($language_id)$this->db->where('description.language_id', $language_id);
		if($conditions)$this->db->where($conditions);
		
	    $this->db->group_by('description.url_name');
	    
	    $query = $this->db->get();

		
	    if($query->num_rows() == 1) return $query->row();
		
	}
		//	get a single page by name	///
		function get_full($id, $conditions=null, $select = '*', $language_id=null, $site_id=null)
		{
	
			$this->db->distinct($select);
			$this->db->select($select);
			
			$this->db->from('page');
			$this->db->join('page_description description','description.page_id = page.page_id');
			$this->db->join('template', 'page.template_id = template.template_id');
			$this->db->limit('1');
			$this->db->where('page.page_id', $id);
			if($site_id)$this->db->where('page.site_id', $site_id);
			
			if($language_id)$this->db->where('description.language_id', $language_id);
			if($conditions)$this->db->where($conditions);
			
		    $this->db->group_by('description.url_name');
		    
		    $query = $this->db->get();
	
			
		    if($query->num_rows() == 1) return $query->row();
			
		}
	//	get a single page by name	///
		function get_page_by_fixed($fixed_name, $conditions=null, $select = '*', $language_id=null, $site_id=null)
		{
		
			$this->db->distinct($select);
			$this->db->select($select);
			
			$this->db->from('page');
			$this->db->join('page_description description','description.page_id = page.page_id');
			$this->db->limit('1');
			$this->db->where('page.fixed', $fixed_name);
			if($site_id)$this->db->where('page.site_id', $site_id);
			
			if($language_id)$this->db->where('description.language_id', $language_id);
			if($conditions)$this->db->where($conditions);
			
		    $this->db->group_by('description.url_name');
		    
		    $query = $this->db->get();
	
			
		    if($query->num_rows() == 1) return $query->row();
			
		}
		
	
	
	function check_page_name_exists($name, $parent_id, $exclude_page_id=null)
	{
		$site_id = $this->session->userdata('site_id');
		
		$this->db->select('description.url_name');
		$this->db->from('page');
		$this->db->join('page_description description','description.page_id = page.page_id');
		
		$this->db->where('description.url_name', $this->db->escape_str($name));
		$this->db->where('page.site_id', $site_id);
		$this->db->where('parent_page_id', $parent_id);
		if($exclude_page_id){
			$this->db->where('page.page_id !=', $exclude_page_id);
		}
		
		$query = $this->db->get();
		
		$data = $query->result();
		
		if(!empty($data)){
			return $data;
		}
	}
	
	function get_page_description($page_id)
	{
		$this->db->select('*');
		$this->db->from('page_description');
		$this->db->where('page_id', $page_id);
		
		$this->db->order_by('page_id', 'asc');
		$query = $this->db->get();
		return  $query->result();
		
	}
	
	function get_page_by_content($content, $select = '*')
	{
		
		$this->db->select($select);
		$this->db->from('page');
		$this->db->join('content', 'page.id = content.page_id');
		$this->db->where('content.content', $content);
	    $query = $this->db->get();
	    if($query->num_rows() == 1) return $query->row();
		
	}
	
	function get_latest_page($select='*')
	{
		$this->db->select($select);
		$this->db->from('page');
		$this->db->limit(1);
		$this->db->join('content', 'page.id = content.page_id');
		$this->db->order_by("title", "desc");
		$query = $this->db->get();
		
	   if($query->num_rows() == 1) return $query->row();
	}
	
	
	//	get a single valuefrom a page	by id ///
	function get_page_value($page_id, $value, $sort = 'asc')
	{
	 	$this->db->select($value);
		$this->db->from('page');
		
		$this->db->where('id', $page_id);
	 	$this->db->order_by($value, $sort);
	 	
		$query = $this->db->get();
		    
	    if($query->num_rows() > 0) return $query->result();
	}
	function get_templates($code = NULL)
	{
		
		$this->db->order_by('title', 'asc');
	    $query = $this->db->get('template');
	    
	    if($query->num_rows() > 0) return $query->result();
	}
	
	function get_template($template_id, $select = '*')
	{
		$this->db->select($select);
		$this->db->where('id', $template_id);
	    $query = $this->db->get('template');
	    
	    if($query->num_rows() == 1) return $query->row();
	
	}
	function get_template_by_page($page_id, $select = '*')
	{
		$this->db->select($select);
		$this->db->from('page');
		$this->db->join('template', 'template.template_id = page.template_id');
		$this->db->where('page_id', $page_id);
	    $query = $this->db->get();
	    
	    if($query->num_rows() == 1) return $query->row();
	
	}
	
	 function count_children($page_id)
	 {
	 	if($page_id == 0)$this->db->where('parent_page_id', 0);
		$this->db->from('page');
		$this->db->where('parent_page_id', $page_id);
		$query = $this->db->count_all_results();
		
		return $query;
    }
    
    function get_collumns(){
    	return $this->db->list_fields('page');
    }
    function get_description_collumns()
    {
    	return $this->db->list_fields('page_description');
    }
    function update_page($page_id, $values){
    	$this->db->update('page', $values, array('page_id' => $page_id, 'site_id' => $this->site_id));
    	
    }
    
    function update_page_description($page_id,  $values)
    {
    	$this->db->delete('page_description', array('page_id' => $page_id)); 
    	$this->db->insert_batch('page_description', $values);    	
    }
    
    function insert_page($page_properties){
    	$this->db->insert('page', $page_properties); 
    	return $this->db->insert_id();
    }
//    
    function insert_page_description($pageAttr){
    	
    	$this->db->insert('page_description', $pageAttr); 
    }
    
    function delete($table,$id,$conditionvar = 'page_id'){
    	$this->db->delete($table, array($conditionvar => $id)); 
    }
    function delete_page_description($id,$conditionvar = 'page_id'){
    	$this->db->delete('page_description', array($conditionvar => $id)); 
    }
    function update_page_batch($data){
    	$this->db->update_batch('page', $data, 'page_id'); 		
    }
    
    function get_languages(){
    	$query = $this->db->get('language');
    	return $query->result();
    }
    
 }