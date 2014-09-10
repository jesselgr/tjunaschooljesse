<?php
class user_model extends CI_Model {
	/*
	
	`id` 		int(10) 		NOT NULL 	AUTO_INCREMENT,
    `name` 		varchar(255) 	NOT NULL,
	`role` 		varchar(255) 	NOT NULL,
    `password` varchar(255) 	NOT NULL,
	
	*/
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function validate( $username, $password)
		{
			$query = $this->db->get_where('user',array('username' => $username, 'password' => $password));
			
			if($query->num_rows == 1)return true;
		}
		   //get single user
	 function get_for_login($username, $password=null)
	 {
	 		$conditions = array('username' => $username);
	 		if($password)$conditions['password'] = $password;
	 	
	 	    $query = $this->db
	 	    	->join('user_group','user_group.user_group_id = user.user_group_id')
	 	    	->get_where('user', $conditions);
	 	    
	      if($query->num_rows() == 1) return $query->row();
	  }

	 function update_pw($userName, $values){
		
			$this->db->update('user', $values, array('username' => $userName));
		}
	
	function get_permissions($user_group_id, $select="*"){
		$query = $this->db
			->select($select)
			->where('user_group_id', $user_group_id)
			->from('user_group_to_permission utp')
			->join('permission', 'utp.permission_id = permission.permission_id')
			->get();
		
		if($query->num_rows() > 0) return $query->result();
		
	}
		
	function get_user_group($user_group_id,$select='*',$conditions=null){
		$this->db->select($select);
		$this->db->from('user_group');
		if($conditions){
			$this->db->where($conditions);
		}
		
		$this->db->where('user_group_id', $user_group_id);
			
		$query = $this->db->get();
		    
		 if($query->num_rows() == 1) return $query->row();
	}
	
	function get_user_groups($select='*',$conditions=null){
		$this->db->select($select);
		$this->db->from('user_group');
		if($conditions){
			$this->db->where($conditions);
		}
			
		$query = $this->db->get();
		    
		 if($query->num_rows() > 0) return $query->result();
	}
	
	function get_user_group_by_user($user_id,$select='*',$conditions=null){

		$this->permission->get('ban_user');

		$this->db->select($select);
		$this->db->from('user_group');
		$this->db->join('user','user.user_group_id = user_group.user_group_id');
		if($conditions){
			$this->db->where($conditions);
		}
		$this->db->where('user_id', $user_id);	
		$query = $this->db->get();
		    
	  	if($query->num_rows() == 1) return $query->row();
	}
	
	
	
	
}