<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class component_model extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }
   
  	//	get pages per parent (parent null = root) 	//
        
    function get_tables($table, $select = '*', $where=null, $order=null, $start=null, $limit=null)
    {
    	$this->db->select($select);
    	
    	
    	if($order)$this->db->order_by($order[0], $order[1]);
		if($where)$this->db->where($where);
		
		if($start || $limit){
			$this->db->limit($limit, $start);
		}
		
		$query = $this->db->get($table);
	    return $query->result();
		
	}
	function count_all($table, $conditions)
	{
		
		if($conditions)$this->db->where($conditions);
		return $this->db->count_all_results($table);
	}
	
	//	get a single page by id	///
	function get_table($table,$id=null, $select = '*')
	{
		$this->db->select($select);
		if($id)$this->db->where($table.'_id', $id);
		$this->db->limit(1);
	    $query = $this->db->get($table, 1);
	    
	    if($query->num_rows() == 1) return $query->row();
	    
	}
	
	function update_table($table, $id, $values){
		$this->db->update($table, $values, array($table.'_id' => $id));
	
	}
	
	
	function insert_table($table,$values){
		$this->db->insert($table, $values);
		return $this->db->insert_id();
	}
	
		
	function insert_relation($table, $data){
		$this->db->insert_batch($table, $data);
	}
	
	function delete_relation($table,$id_collumn, $id){
		$this->db->delete($table, array($id_collumn => $id)); 
	}
	
	function delete($table,$id){
		$this->db->delete($table, array($table.'_id' => $id)); 
	}
	
	function check_collumns($table){
		$fields = $this->db->list_fields($table);
		
		return $fields;
	}
	
	function get_list($table){
		$query = $this->db->get($table);
		 if($query->num_rows() > 0) return $query->result();
	}
	
	function get_related_tables($relation_table, $table, $id=null, $select='*', $order=null, $where=null){
		$this->db->select($select);
		
		if($order)$this->db->order_by($order[0], $order[1]);
		if($where)$this->db->where($where);
		if($id)$this->db->where($table.'_id', $id);
		$this->db->from($relation_table);
	
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->result();
		
	}
	function get_active_template_sections($template_id, $select='*'){
		$this->db->select($select);
   		$this->db->from('template_to_template_section');
   		$this->db->where('template_to_template_section.template_id', $template_id);
		$query = $this->db->get();
		
		$data['sections'] = $query->result_array();
		$data['total_sections'] = $query->num_rows();
	
		return $data;
	}
}