<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class component_group_model extends CI_Model {
	
	
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }
    
    function get_grouped_for_table($table, $gr_table, $select = '*', $where=null, $order=null)
	{
        // declarations
        $groups = array();
        $gr_table_prim = $gr_table.'_id';
        

    	$this->db->select($select);
        $this->db->select($gr_table.'.'.$gr_table_prim.' as category_id');
    	if($order)$this->db->order_by($order);
    	if($where)$this->db->where($where);
        $this->db->join($gr_table,$gr_table.'.'.$gr_table.'_id = '.$table.'.'.$gr_table.'_id');
        
    	$query 	= $this->db->get($table);
    	$result = $query->result();

        // do category separately
        if($this->db->table_exists($gr_table))
        {
           
            if($where)$this->db->where($where);
            $category_result = $this->db
                ->select('name as category, '.$gr_table.'.'.$gr_table_prim.' as category_id')
                ->order_by($order)
                ->get($gr_table)
                ->result();

            foreach($category_result as &$category_row)
            {
                $row_id = $category_row->category_id;
                $groups[$row_id]['title']       =   $category_row->category;
                $groups[$row_id]['sub_title']   =   $category_row->country;
                $groups[$row_id]['children']    =   array();

            }
        }
        // place results inside categories
    	foreach($result as $row)
    	{
            $row_id = ($row->category_id) ? $row->category_id : 0;
            $groups[$row_id]['children'][] 	= $row;
    	}

    	return $groups;
    }
   
  }