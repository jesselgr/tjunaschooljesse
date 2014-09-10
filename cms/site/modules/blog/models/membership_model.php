<?php

class Membership_model extends CI_Model{
/**
 * get username and password
 * get databasetabel membership
 * @return [query, boolean]
 */
	function validate(){

		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', sha1($this->input->post('password')));
		$query = $this->db->get('membership');


		if($query->num_rows() == 1){
			return true;
		}
		
	}
	/**
	 * create member 
	 * insert into database tabel membership
	 * @return [boolean]
	 */
	function create_member() {
		$post = $this->input->post();
		$post['password'] = sha1($post['password']);

		$new_member_insert_data = array(
			'first_name' 		=> $post['first_name'],
			'last_name' 		=> $post['last_name'],
			'email_address' 	=> $post['email_address'],
			'username' 			=> $post['username'],
			'password' 			=> $post['password']
		);

		$insert = $this->db->insert('membership', $new_member_insert_data);
		return $insert;
	}
}