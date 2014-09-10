<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class languagemodel extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }
   

	
	function get_languages($default, $select='*', $where=null)
	{
		if($where)$this->db->where($where);
		
		$query = $this->db
			->select($select)
			->from('language')
			->where('status = 1 ORDER BY code="'.$default.'" DESC, sort_order asc',null, false)
			->get();
		
		if($query->num_rows() > 0) return $query->result();
	}
	
	function get_language($code, $select='*'){
		$this->db->select($select);
		$this->db->from('language');
		$this->db->where('language_id', $code);
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
	
	function get_language_labels($id){
		$this->db->select('*');
		$this->db->from('language_label');
		$this->db->where('language_id', $id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) return $query->row_array();
	}
	
	function get_language_count($select='*', $where=null){
		$this->db->select($select);
		$this->db->from('language');
		if($where)$this->db->where($where);
		
		return $this->db->get()->num_rows();
	}
		
}