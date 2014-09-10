<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class language_model extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }
   

	
	function get_languages($select='*', $where=null){
		$this->db->select($select);
		$this->db->distinct('code');
		$this->db->from('language');
		$this->db->where('status', 1);
		if($where)$this->db->where($where);
		$this->db->order_by('sort_order', 'asc');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) return $query->result();
	}
	
	function get_language_by_code($code, $select='*'){
		$this->db->select($select);
		$this->db->from('language');
		$this->db->where('code', $code);
		$this->db->order_by('sort_order', 'asc');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) return $query->result();
	}
	
	function get_languages_for_content($page_id){
		$this->db->select('*');
		$this->db->from('content');
		$this->db->join('content_description description', 'content.content_id = description.content_id');
		$this->db->where('page_id', $page_id);
		$this->db->join('language ','language.language_id = description.language_id');
		
		$this->db->group_by('language.language_id');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) return $query->result();
	}
		
}