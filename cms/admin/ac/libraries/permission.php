<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

////////////////////////////
//	library permission    //
////////////////////////////

class Permission{

private $user_group_id;
// our instance is stored in a private var
private $CI;

protected $permissions= array();

	public function __construct($params=null)
	{
		
		$this-> CI = &get_instance();
		$this->user_group_id = $this->CI->session->userdata('user_group_id');
	}
 	
/* 	function get
 	//
 	//	checks permissions in db and returns
 	//	@param $action - where user is trying to go
 	//	@param $group_id - user to check
 	/
 	*/
 	public function get($action, $user_group_id=null){
		
 		if(!$user_group_id) $user_group_id =  $this->user_group_id;

 		if(!$this->permissions || ($user_group_id &&  $user_group_id != $this->user_group_id))
 		{
 			$this->permissions 	= $this->_get_permissions($user_group_id);
 		}

 		return in_array($action, $this->permissions);
 	}
 
 	
 	private function _get_permissions($user_group_id)
 	{
 		$this->CI->load->model('user_model','RULE');
 		$this->CI->load->driver('cache', array('adapter' => 'file'));
 		$result = array();
		$cache_key 	= 'permission/ug_'.$user_group_id;
 		// if(!$result = $this->CI->cache->get($cache_key))
 		// {
 			$permission_result = $this->CI->RULE->get_permissions($user_group_id,'key');
 			
 			if($permission_result)
	 		{
	 			foreach($permission_result as $perm_row){
	 				$result[] = $perm_row->key;
	 			}
	 
	 			$this->CI->cache->save($cache_key, $result, 80000);
	 		}
 		// }
 		
 		
 		return $result;
 	}
 	
 	
}


/* End of file permission library */