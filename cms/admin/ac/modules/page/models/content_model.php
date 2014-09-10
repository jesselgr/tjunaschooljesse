<?php // admin content model

class content_model extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }
   function insert($data){
   		$this->db->insert('content', $data);
   		return $this->db->insert_id();
   } 
   function insert_description($data){
   		$this->db->insert('content_description', $data);
   		return $this->db->insert_id();
   }
   function insert_descriptions($data){
   		$this->db->insert_batch('content_description', $data);
   }
    
		//get all contents per page ///
	   function get_content_by_page_id($page_id, $lang = null, $select = '*'){
		
			$this->db->select($select);
			$this->db->from('content');
			$this->db->join('content_description', 'content.content_id = content_description.content_id','left');
		
			$this->db->join('content_type', 'content_type.content_type_id = content.content_type_id');
			if($lang)$this->db->where('content_description.language_id', $lang);
			
			$this->db->where('page_id', $page_id);
			
			$this->db->order_by("content.sort_order", "ASC");
		
			$this->db->group_by('content.content_id');
	
	   		$query = $this->db->get();
	
	   	    if($query->num_rows() > 0) return $query->result();
	    }
	
		
    
 	// get single content per page and location //
      function get_content( $content_id,  $select = '*'){
   		$this->db->select($select);
   		$this->db->from('content');
   		$this->db->join('content_type', 'content.content_type_id = content_type.content_type_id');
		$this->db->where('content.content_id', $content_id);
 
   	    $query = $this->db->get();
   	    
		return $query->row_array();
    }
    function get_content_descr($content_id,  $select='*'){
    	$this->db->select($select);
    	$this->db->where('content_id',$content_id);
       	$query = $this->db->get('content_description');
    	
    	return $query -> result_array();
    }
    
    function get_single_content_descr($select='*', $condition=null){
    	$this->db->select($select);
    	$this->db->where($condition);
       	$query = $this->db->get('content_description');
    	
    	return $query ->row();
    }
    
   
	function get_content_types($select='*', $section_id=null){
		$this->db->select($select);
   		$this->db->from('content_type');
   		$this->db->join('template_section_to_content_type sectcont', 'content_type.content_type_id =sectcont.content_type_id');
   		if($section_id)
   			$this->db->where('template_section_id', $section_id);
   		$this->db->order_by("sort", "ASC");
		$query = $this->db->get();
		
		
   	    if($query->num_rows() > 0) return $query->result();
	}
	function get_content_type($content_type_id, $select='*')
	{
			$this->db->select($select);
			$this->db->from('content_type');
			$this->db->where('content_type_id',$content_type_id);
			$this->db->order_by("sort", "ASC");
			$query = $this->db->get();
			
		    if($query->num_rows() > 0) return $query->row();
	}
	
	function count_for_page_and_section($page_id, $template_section_id)
	{
		return $this->db
			->where('page_id', $page_id)
			->where('template_section_id',$template_section_id)
			->from('content')
			->count_all_results();
	}
	
	function get_content_sections($template_id,$select='*'){
	
		$this->db->select($select);
   		$this->db->from('template_section section');
   		$this->db->join('template_to_template_section tts', 'section.template_section_id = tts.template_section_id');
   		$this->db->where('tts.template_id', $template_id);
   		
   		$this->db->order_by("section.sort_order", "ASC");
		$query = $this->db->get();

   	    if($query->num_rows() > 0) return $query->result();
	}
	function get_last_edit_date($select){
		$this->db->select($select);
		$this->db->from('content');
		$this->db->where('content !=', '');
		$this->db->order_by("last_edit_date", "desc");
		$this->db->limit(1);
		
		$query = $this->db->get();
		
	    if($query->num_rows() == 1) return $query->row();
		
	}
	function get_content_types_per_template($template_id, $select='*'){
		
		$this->db->select($select);
   		$this->db->from('content_default');
   		$this->db->where('template_id', $template_id);
		$query = $this->db->get();
		
   	    if($query->num_rows() > 0) return $query->result();
	}
	
	function delete_by_page_id($page_id){
		$this->db->where('page_id',$page_id);
		$this->db->join('content_description description', 'content.content_id = description.content_id');
		$this->db->delete('content');
	}
	
	function delete($content_id){
		
		$this->db->where('content_id',$content_id);
		$this->db->delete('content');
	}
	
	function delete_content_descr($content_id){
		$this->db->where('content_id',$content_id);
		$this->db->delete('content_description');
	}
	function get_content_by_filter($select = '*', $condition = null){ 
			$this->db->select($select);
			$this->db->from('content_description');
			if($condition)$this->db->where($condition);
			$this->db->join('content', 'content.content_id = content_description.content_id', 'left');
		    
		    $query = $this->db->get();
		    
	    if($query->num_rows() >= 1) return $query->result_array();
	}
	
	
	function update_content_description($content_id, $data, $lang_id){
		$this->db->where('content_id', $content_id);
		$this->db->where('language_id', $lang_id);
		$this->db->update('content_description', $data);
	}
	function update_content_order($content_id, $data){
		$this->db->where('content_id', $content_id);
		$this->db->update('content', $data);
	}
 }