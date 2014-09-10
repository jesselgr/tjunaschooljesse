<?php

class contentmodel extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }
    
	//get all contents per page ///
   function get_content_by_page_id($page_id, $language_id, $select = '*'){
		$this->db->select($select);
		$this->db->from('content');
		$this->db->join('content_description description', 'content.content_id = description.content_id');
		$this->db->join('content_type', 'content.content_type_id = content_type.content_type_id');
		$this->db->join('template_section', 'template_section.template_section_id = content.template_section_id ');
		
		$this->db->where('language_id', $language_id);
		$this->db->order_by("content.sort_order", "ASC");
		
		$this->db->where('content.page_id', $page_id);
		$this->db->group_by('content.content_id');
   		$query = $this->db->get();
   	    if($query->num_rows() > 0) return $query->result_array();
    }
		
    
 	// get single content per page and location //
   function get_section_content($page_id, $section, $lang=null, $select = '*'){
   		$this->db->select($select);
   		$this->db->from('content');
   		
		if($lang)$this->db->where('lang', $lang);
		$this->db->where('page_id', $page_id);
		$this->db->where('section',$section);
 
   	    $query = $this->db->get();
   	    
        if($query->num_rows() == 1) return $query->row();
    }
    
    
    
    function get_content( $content_id, $select = '*'){
   		$this->db->select($select);
   		$this->db->from('content');
   		
		$this->db->where('id',$content_id);
 
   	    $query = $this->db->get();
   	    
        if($query->num_rows() == 1) return $query->row();
    }
    
    function get_content_by_filter($select = '*', $condition = null){ 
  		$this->db->select($select);
  		$this->db->from('content_description');
		if($condition)$this->db->where($condition);
		$this->db->join('content', 'content.content_id = content_description.content_id', 'left');
  	    
  	    $query = $this->db->get();
  	    
       if($query->num_rows() >= 1) return $query->result();
   }

	
	function get_content_sections($template_id,$select='*'){
	
		$this->db->select($select);
   		$this->db->from('template_to_template_section');
   		$this->db->where('template_id', $template_id);
   		$this->db->join('template_section', 'template_section.template_section_id = template_to_template_section.template_section_id', 'left');
		$query = $this->db->get();
   	    if($query->num_rows() > 0) return $query->result();
	}
		
	
	function get_unnassigned_sections($select='*'){
		$this->db->select($select);
		$this->db->from('template_section');
		$this->db->where('template_section_id', 0);
		$query = $this->db->get();
	   if($query->num_rows() > 0) return $query->row();
	
	}
	
 }