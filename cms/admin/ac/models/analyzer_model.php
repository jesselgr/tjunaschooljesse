<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class analyzer_model extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }
   
  	//	get pages per parent (parent null = root) 	//
        
		
	function get_collumns($table){
		$fields = $this->db->list_fields($table);
//		var_dump($fields);
		return $fields;
	}

	function get_fields($table) 
	{
		$this->db->select('COLUMN_NAME as name, IS_NULLABLE as is_null, DATA_TYPE as type, COLUMN_TYPE as data_type, CHARACTER_MAXIMUM_LENGTH as max_length, COLUMN_DEFAULT as default_value, COLUMN_KEY as is_key, COLUMN_COMMENT as comment');
		$this->db->from('INFORMATION_SCHEMA.COLUMNS');
		$this->db->where('TABLE_NAME', $table);
		$this->db->where('TABLE_SCHEMA', $this->db->escape($this->db->database),false);
		$this->db->order_by('ORDINAL_POSITION asc');
		$query= $this->db->get();
		 if($query->num_rows() > 0) return $query->result_array();
		
	}
	
	function get_relation_tables_scheme($table){
		$this->db->select('TABLE_NAME as name');
		$this->db->from('INFORMATION_SCHEMA.COLUMNS');
//		$this->db->where('COLUMN_NAME', $this->db->escape($table.'_id'), false);
		$this->db->like('TABLE_NAME', $table.'_to_', 'after', false);
		$this->db->where('TABLE_NAME !=', $table);
		$this->db->where('TABLE_SCHEMA', $this->db->escape($this->db->database),false);
		$this->db->group_by('TABLE_NAME');
		$query= $this->db->get();

		 if($query->num_rows() > 0) return $query->result();
	}
	
	function get_table_scheme($table_name){
		$this->db->select('TABLE_NAME as name');
		$this->db->from('INFORMATION_SCHEMA.COLUMNS');
		$this->db->where('TABLE_NAME', $table_name);
		$this->db->where('TABLE_SCHEMA', $this->db->escape($this->db->database),false);
		$query= $this->db->get();
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
	
	function get_tables($table, $select = '*', $where=null, $order=null, $start=null, $limit=null){
		$this->db->select($select);
		
		if($order)$this->db->order_by($order[0], $order[1]);
		if($where)$this->db->where($where);
		
		if($start || $limit){
			$this->db->limit($limit, $start);
		}
		
		$query = $this->db->get($table);
	    return $query->result();
		
	}
	
	function check_if_table_exists($table_name)
	{
		$this->db->select('TABLE_NAME as name');
		$this->db->from('INFORMATION_SCHEMA.TABLES');
		$this->db->where('TABLE_NAME', $table_name);
		$this->db->where('TABLE_SCHEMA', $this->db->escape($this->db->database),false);
		$query= $this->db->get();
		 return($query->num_rows() > 0);
	}
}