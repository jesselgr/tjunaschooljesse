<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pagemodel extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }
   
  	//	get pages per parent (parent null = root) 	/
	
	function get_pages($parent_page_id = null, $menu_only = false, $select = '*',$inTree = true, $order=null, $language_id = 1,$join_template = true){
	
	
		$this->db->select($select);
		$this->db->from('page');
		$this->db->join('page_description description', 'page.page_id = description.page_id');
		
		if($join_template)	$this->db->join('template temp', 'page.template_id = temp.template_id');
		if($parent_page_id)	$this->db->where('parent_page_id', $parent_page_id);
		if($menu_only)		$this->db->where('in_menu', '1');
		if($inTree)			$this->db->where('in_tree', '1');
		if($language_id)	$this->db->where('description.language_id', $language_id);
		
		if($order != null){
			$this->db->order_by($order[0], $order[1]);
		}else{
			$this->db->order_by('nav_prio', 'asc');
		}
		
		$this->db->group_by('description.url_name');
		
		$query = $this->db->get();
	    if($query->num_rows() > 0) return $query->result();
		
	}
	
	
	
	//	get a single page by name	///
	function get_page_by_name($page_name, $conditions=null, $select = '*', $language_id=null, $site_id=null){
		
		$this->db->distinct($select);
		$this->db->select($select);
		
		$this->db->from('page');
		$this->db->join('page_description description','description.page_id = page.page_id');
		$this->db->join('template', 'page.template_id = template.template_id');
		$this->db->limit('1');
		$this->db->where('description.url_name', $this->db->escape_str($page_name));
		$this->db->where('page.site_id', $site_id);
		$this->db->where('publish_state', 1);
		
		if($language_id)$this->db->where('description.language_id', $language_id);
		if($conditions)$this->db->where($conditions);
		
	    $this->db->group_by('description.url_name');
	    
	    $query = $this->db->get();
		
	    if($query->num_rows() == 1) return $query->row();
		
	}
	
	function get_by_uri($uri_array, $language_id, $site_id)
	{
		// all our array segments need to be checked, reverse them so the last is the first to be checked.
		$uri_array 		= 	array_reverse($uri_array);
		$this->db->limit(1);  	
		
		
		foreach ($uri_array as $i => $seg) 
		{
			$h = $i - 1;
			if($i == 0)	// if last item in segment array
			{
				$this->db->select(array(
					'page_0.page_id',
					'page_0.parent_page_id',
					'descr_0.title',
					'descr_0.url_name'
				));
				$this->db->from('page page_'.$i);	
				
			}else{	// any other part of the segment array is a parent
				$this->db->select('page_'.$i.'.page_id as parent_'.$i.'_page_id');
				$this->db->select('descr_'.$i.'.url_name as parent_'.$i.'_url_name');
				$this->db->join('page page_'.$i, 'page_'.$h.'.parent_page_id = page_'.$i.'.page_id');
			}
			
			$this->db->join('page_description descr_'.$i, 	'descr_'.($i).'.page_id 		= page_'.($i).'.page_id');
			
			$this->db->where('descr_'.$i.'.url_name', $seg);
			$this->db->where('descr_'.$i.'.publish_state', true); 
			$this->db->where('descr_'.$i.'.language_id', $language_id);
			$this->db->where('page_'.$i.'.site_id', $site_id);
			
			
		}
		// the last parent (first in array) should be a root item, meaning his parent_page_id is 'root'
		$this->db->where('page_'.$i.'.parent_page_id', 'root');
		$this->db->select('page_'.$i.'.children as has_nav, page_'.$i.'.page_id as root_id, descr_'.$i.'.url_name as root_url, page_'.$i.'.fixed as root_fixed');
		
		$result = $this->db->get()->row_array();
		return $result;
	}

	
	//	get a single page by name	///
	function get_page_by_fixed($page_name, $conditions=null, $select = '*', $language_id=1, $site_id=1){
		
		$this->db->select($select);

		$this->db->from('page');
		$this->db->join('page_description description','description.page_id = page.page_id');
		$this->db->join('template', 'page.template_id = template.template_id');
		$this->db->limit('1');
		$this->db->where('fixed', $this->db->escape_str($page_name));
		$this->db->where('page.site_id', $site_id);
		
		if($language_id)$this->db->where('description.language_id', $language_id);
		if($conditions)$this->db->where($conditions);
		
	    $this->db->group_by('description.url_name');
	    
	    $query = $this->db->get();
		
	  	return $query->row();
		
	}
	
	//	get a fixed page by name	///
	function get_page_by_fixed_name($fixed_name, $conditions=null, $select = '*', $language_id=null, $site_id=null){
		
		$this->db->distinct($select);
		$this->db->select($select);
		
		$this->db->from('page');
		$this->db->join('page_description description','description.page_id = page.page_id');
		$this->db->join('template', 'page.template_id = template.template_id');
		$this->db->limit('1');
		$this->db->where('page.fixed', $this->db->escape_str($fixed_name));
		$this->db->where('page.site_id', $site_id);
		$this->db->where('publish_state', 1);
		
		if($language_id)$this->db->where('description.language_id', $language_id);
		if($conditions)$this->db->where($conditions);
		
	    $this->db->group_by('description.url_name');
	    
	    $query = $this->db->get();
		
	    if($query->num_rows() == 1) return $query->row();
		
	}
	
	
	function get_unpublished($page_name, $site_id){
		
		$this->db->select('lang.code');
		
		$this->db->from('page');
		$this->db->join('page_description description','description.page_id = page.page_id');
		$this->db->join('language lang','lang.language_id = description.language_id');
		
		$this->db->where('fixed', $page_name);
		$this->db->where('page.site_id', $site_id);
		$this->db->where('publish_state', 0);
	    
	    $query = $this->db->get();
		
	    if($query->num_rows() > 0) return $query->result();
		
	}
	
	function get_fixed_pages($site_id, $lang){
		$this->db->select('url_name, parent_page_id, fixed');
		$this->db->from('page');
		$this->db->join('page_description description','description.page_id = page.page_id');
		
		$this->db->where('language_id', $lang);
		$this->db->where('page.site_id', $site_id);
		$this->db->where_not_in('fixed', '');
		$this->db->where_not_in('fixed', '0');
		
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->result();
	}
	
	//	get a single page by id	///
	function get_page_by_id($page_id, $select = '*'){
		$this->db->select($select);
		$this->db->where('page_id', $page_id);
	    $query = $this->db->get('page', 1);
	    
	    if($query->num_rows() == 1) return $query->row();
	}

	
	function get_page_description($page_id, $language_id, $publish = null, $cat=null){
		$this->db->select('*');
		$this->db->from('page_description descr');
		
		$this->db->where('language_id', $language_id);
		if($publish != null)$this->db->where('publish_state', $publish);
		$this->db->where('page_id', $page_id);
		
		$this->db->order_by('page_id', 'asc');
		
		$query = $this->db->get();
		return  $query->row();
		
	}
	
	function get_page_id($name, $site_id, $lang = null){
		
		$this->db->select('page.page_id, publish_state');
		$this->db->from('page');
		$this->db->join('page_description description','description.page_id = page.page_id');
		
		$this->db->where('page.site_id', $site_id);
		$this->db->where('url_name', $name);
		if($lang != null)$this->db->where('language_id', $lang);
		$this->db->where('publish_state', 1);
		
		$query = $this->db->get();
		return $query->row();
		
	}
	
	
	function get_page_urls($page_id, $lang){
		$this->db->select('url_name, publish_state');
		$this->db->from('page_description');
		$this->db->where('page_id', $page_id);
		$this->db->where('language_id', $lang);
		
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		
	}
	
	
	
	function get_page_by_content($content, $select = '*'){
		
		$this->db->select($select);
		$this->db->from('page');
		$this->db->join('content', 'page.id = content.page_id');
		$this->db->where('content.content', $content);
	    $query = $this->db->get();
	    if($query->num_rows() == 1) return $query->row();
		
	}
	function get_page_by_content_id($content_id, $select = '*'){
		
		$this->db->select($select);
		$this->db->from('page');
		$this->db->join('content', 'page.page_id = content.page_id');
		$this->db->where('content_id', $content_id);
		//$this->db->or_where($content_id);
	    $query = $this->db->get();
	   if($query->num_rows() == 1) return $query->row_array();
	}
	
	function get_latest_page($select='*'){
		$this->db->select($select);
		$this->db->from('page');
		$this->db->limit(1);
		$this->db->join('content', 'page.id = content.page_id');
		$this->db->order_by("title", "desc");
		$query = $this->db->get();
		
	   if($query->num_rows() == 1) return $query->row();
	}
	
	
	//	get a single valuefrom a page	by id ///
	function get_page_value($page_id, $value, $sort = 'asc'){
	 	$this->db->select($value);
		$this->db->from('page');
		
		$this->db->where('id', $page_id);
	 	$this->db->order_by($value, $sort);
	 	
		$query = $this->db->get();
		    
	    if($query->num_rows() > 0) return $query->result();
	}
	function get_templates(){
		
	    $query = $this->db->get('template');
	    
	    if($query->num_rows() > 0) return $query->result();
	
	}
	function get_template($template_id, $select = '*'){
		$this->db->select($select);
		$this->db->where('id', $template_id);
	    $query = $this->db->get('template');
	    
	    if($query->num_rows() == 1) return $query->row();
	
	}
	function get_template_by_page($page_id, $select = '*'){
		$this->db->select($select);
		$this->db->from('page');
		$this->db->join('template', 'template.template_id = page.template_id');
		$this->db->where('page.page_id', $page_id);
	    $query = $this->db->get();
	    
	    if($query->num_rows() == 1) return $query->row();
	
	}
	 function count_children($page_id){
	 	if($page_id == 0)$this->db->where('parent_page_id', 0);
		$this->db->from('page');
		$this->db->where('parent_page_id', $page_id);
		$query = $this->db->count_all_results();
		
		return $query;
    }
   
 }