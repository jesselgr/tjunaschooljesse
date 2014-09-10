<?php

class filebrowser extends CI_Controller{

	private $file_category_result;
	private $_clist_html  = '';
	private $_clist_dropdown = '';
	public function __construct()
	{
		parent::__construct();
		$this->ac->set_active_key('filebrowser');
	}


	public function index()
	{
		$this->file_category_result	= $this->db->get('file_category')->result();
		
		
		
		
		$data['scripts'][] 	= 	"assets/js/libs/uploadify/jquery.uploadify.min.js";
		$data['scripts'][] 	= 	"assets/js/filebrowser.js";	
		$data['head']		=	lang('ac_panel_media_files');

		$data['CKEditor']['enabled']		=	($this->input->get('CKEditor'))? 1 : 0;
		$data['CKEditor']['target'] 		= 	$this->input->get('CKEditor'); 
		$data['CKEditor']['function'] 		= 	$this->input->get('CKEditorFuncNum'); 

		$data['file_category_list_html'] 	=	$this->_clist_dropdown;
		$this->_recurse_category();

		if($this->input->get('popup'))
		{
			$this->ac->place_header($data);
			$this->_board(true);
			$this->ac->place_footer();
		}		
		elseif($this->input->get('standalone'))
		{	
			$this->ac->place_overlay_header($data);
			$this->_board(true);
			$this->ac->place_overlay_footer();
		}else{
			$this->ac->place_header($data);
			
			$this->_board(false);
			$this->ac->place_footer();
		}
	
	}

	public function insert_category()
	{
		$data = $this->input->post(null,true);
		$this->db->insert('file_category',$data);
		$parent_id = $data['parent_file_category_id'];

		if($parent_id)$this->db->update('file_category',array('has_children'=>'1'),array('file_category_id'=>$parent_id));
	}
	private function _nav()
	{

	}

	private function _board($standalone=false)
	{
		
		$data['file_category_result'] 		= 	$this->file_category_result;
		// $data['file_category_list']		=	$this->_recurse_category();
		$data['file_category_list_html'] 	=	$this->_clist_dropdown;
		$data['file_category_nav_html']		=	$this->_clist_html;

		
		$file_id = $this->input->get('file_id');

		if($type = $this->input->get('type')) 
			$this->db->where('type',$type);

		$file_result 		= 	$this->db
			->get('file')
			->result();

		$data['url_cdi']	=	conf('url_cdi');
		$data['file_id'] 	= 	$file_id;
		$data['type'] 		= 	$type;
		$data['max_upload']	=	ini_get("upload_max_filesize").'B';

		foreach($this->file_category_result as $file_category_row)
			$data['files'][$file_category_row->file_category_id] = array('title'=>$file_category_row->title, 'contents' => array());

		foreach($file_result as $file_row)
			$data['files'][$file_row->file_category_id]['contents'][] = $file_row;
		
		$this->load->view('filebrowser/file_list',$data);
	}

	public function get_for_category_id($category_id)
	{
		$file_result 		= 	$this->db
			->where('file_category_id',$category_id)
			->get('file')
			->result();
		$this->load->view('filebrowser/file_list',$data);	
	}

	private function _recurse_category($parent_id=0, $depth=-1)
	{
		$categories = $this->file_category_result;
		$items		= null;	
		$count 		= 0;
		$depth++;

		
		$this->_clist_html.= '<ul id="nav-cat-'.$parent_id.'">';
 		foreach($categories as &$category)
		{
	
			if($category->parent_file_category_id == $parent_id)
			{
				$this->_clist_html.='<li>';
				$count++;
				//fill item  & recurse
             
				$this->_clist_html.='<a href="#files_'.$category->file_category_id.'">'.$category->title.'</a>';
				$this->_clist_dropdown.= '<option value="'.$category->file_category_id.'">'.$category->title.'</option>';
				//fill
				$items[]	=	$category->title;
				if($category->has_children)
                {
                	$this->_clist_dropdown.= ' <optgroup label="---------">';
	            	$items[]	=	$this->_recurse_category($category->file_category_id, $depth);
	            	$this->_clist_dropdown.= ' </optgroup>';
            	}
				$this->_clist_html.='</li>';
				
			}
		}
		$depth--;
		$this->_clist_html		.= '</ul>';
		
		if($items)return $items;
	}


}