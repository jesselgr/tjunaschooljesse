<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class navigationmodel extends CI_Model {
	
	private $parents;
	
    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
        $this->parents = $this->uri->segment_array();
        $this->parents = array_reverse($this->parents);
    }
   
	
	//	get page breadcrumbs
	public function get_page_breadcrumbs(){
		$parent_nav = array();
		if($this->parents){
			
			foreach($this->parents as $j=> $parent){
				$i = ($j-1);
				if($j == 0){
					$this->db->from('page page_0');
				}else{
					$this->db->join('page page_'.$j, 'page_'.$i.'.parent_page_id = page_'.$j.'.page_id');
				}
				$this->db
				->select('page_description_'.$j.'.url_name url_title_'.$j.', page_description_'.$j.'.title title_'.$j.', page_description_'.$j.'.page_id id_'.$j.', page_'.$j.'.children children_'.$j)
				->join('page_description page_description_'.$j, 'page_'.$j.'.page_id = page_description_'.$j.'.page_id')
				->where('page_description_'.$j.'.url_name', $parent)
				->group_by('url_title_'.$j);
			}
			$parent_result = $this->db->get('page')->row_array();
			
			foreach($parent_result as $key => $value){
				$index = substr($key, -1);
				$real_key = substr($key, 0, -2);
				$parent_nav[$index][$real_key] = $value;
			}
			unset($parent_result);
			foreach ($parent_nav as $key => $value) {
				if(!$value['children']) unset($parent_nav[$key]);
			}
			$nav['crumbs']	= array_reverse($parent_nav);
			if(count($parent_nav) == 0) return false;
			$nav['navID'] 	= $nav['crumbs'][count($parent_nav)-1]['id'];
			unset($parent_nav);
		}
		return $nav ;
	
	}
}