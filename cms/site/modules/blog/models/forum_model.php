<?php 

class Forum_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

    function get_category() {
    	$query = $this->db->get('categories');
        return $query;
    }

    function get_topics() {

    	$this->db->where('topic_entry', $this->uri->segment(4));
        $query = $this->db->get('entries');
        return $query;
    }
}