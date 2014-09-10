<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class navigation {

	public 	$nav;
	public 	$subnav;
	public  $dropdown;
	public  $language;
	public	$site_id;
	
	private $page_select = array('page.page_id', 'title', 'sub_title', 'description.url_name', 'nav_prio','parent_page_id', 'publish_state', 'fixed','children');
	private $CI;
	private $depth;
	private $max_depth = 5;
	private $menu_pages_only;
	private $in_tree;
	private	$pages;
	private $fixed_id;
	
	
	/*****************************************************************************
	 * 	Navigation library allows us to dynamically create navigations with ease *
	 *****************************************************************************
	 * 	  This data is optimized and directly usable in the ac navigation view  *
	 *****************************************************************************
	 * @see		get_main_nav
	 * @param	$children 		bool
	 * @param	$dropdown 		bool
	 * @param	$depth			int
	 * @param	$menu_pages_only 	bool
	 * 
	*/
	
	public function __construct($params=null)
    {
		$this-> CI = &get_instance();
		$this-> CI -> load->helper('config');
		$this-> CI -> load->helper('language');
		
		$this -> fixed_id 	= 	$this->CI->session->userdata('fixed_id');
		$this -> language 	= 	(isset($params['lang'])) 	?  	$params['lang']: conf('site_language');
		$this -> site_id	= 	(isset($params['site_id'])) ? 	$params['site_id'] : 1;
		
		$this-> CI->load->model('page_model', 'PAGE');
    }
    
	public function generate_all_navigations()
	{	
		if(conf('cache_page_nav'))
		{
			$depth 		=  	conf('navigation_depth');
			$view_path 	= 	conf('navigation_gen_dir');
			
			$this->generate_page_tree('root', true, $depth, true, $view_path);
		}
	}
		
	

	/************************************************************************
	 * This function retrieves a navigation based on a given parent page id *
	 ************************************************************************
	 * @see		get_nav
	 * @param	$parent_id 			int
	 * @param	$menu_pages_only 	bool
	 * @param	$in_tree			bool
	*/
	
	public function get_nav($parent_id, $menu_pages_only = true, $in_tree=true)
	{
		$this->menu_pages_only 	= 	$menu_pages_only;
		$this->in_tree		 	=	$in_tree;
	
		$wholeSubNav 		= 	false;
		$subNavItems		= 	null;
		$uriSegment			=	$this->CI-> uri->segment(2);
		
		
		//	get all children and their children   //
		$subNavItems = $this->get_page_hierarchy($parent_id);
		$this -> subnav = $subNavItems;
		return $subNavItems;
	}

	
	
	
	/************************************
	 * General page retrieval function  *
	 ************************************
	 * @see		get_pages
	 * @param	$parent_id 		int
	 * @param	$menu_pages_only 	boolean
	 * @param	$in_tree 		boolean
	*/	

	function get_pages($parent_id,$menu_pages_only,$in_tree)
	{
	
		$subQuery = $this-> CI-> PAGE ->get_pages( $parent_id, $menu_pages_only, $this->page_select, $in_tree, null, $this->language, $this->site_id);
		
		return $subQuery;
	}
	
	/******************************
	 * Returns tree of all pages  *
	 ******************************
	 * @see		get_page_hierarchy
	 * @param	$parent_id int
	*/
	
	public function get_pages_hierarchy($menu_pages_only = true)
	{
		$this->menu_pages_only = $menu_pages_only;
		return $this->_calculate_hierarchy();
	}
	
	/*******************************************
	 * Returns tree of pages under given page  *
	 *******************************************
	 * @see		get_page_hierarchy
	 * @param	$parent_id int
	*/
	
	public function get_page_hierarchy($parent)
	{
		return $this->_calculate_hierarchy($parent);
	}
	
	/*******************************************
	 * Returns tree of pages under given page  *
	 *******************************************
	 * @see		_calculate_hierarchy
	 * @param	$parent_id int
	*/
	
	private function _calculate_hierarchy($parent_id='root')
	{
		$subItems		= 	null;
		$this->pages	=	$this->get_pages(null, $this->menu_pages_only, $this->in_tree);
		// check all pages for parents
	
		$subItems = $this->_get_children($parent_id, $this->depth);
	
		return $subItems;
		
	}
	/********************************************************
	 * function to recurively get children of a given page  *
	 ********************************************************
	 * @see		_calculate_hierarchy
	 * @param	$parent_id 	int
	 * @param	$depth 		int
	*/

	private function _get_children($parent_id, $depth)
	{
		// load children for given parent id
		$items	= null;	
		$depth++;
		if($this->pages)
		{
			foreach($this->pages as $page)
			{
				if($page->parent_page_id == $parent_id)
				{
					//fill item  & recurse
					$item 				=	$this->_fill_item($page,$depth);
					
					if($page->children)
					{
						$children			=	$this->_get_children($page->page_id,$depth);
						if($children)$item['children']	= $children;
					}
					//fill
					$items[]			=	$item;
				}
			}	
			if($items)return $items;
		}
	}
	
	/**************************
	 * fill (hierarchy) item  *
	 **************************
	 * @see		_fill_item
	 * @param	$row 	object
	 * @param	$i 		int
	*/

	private function _fill_item($row, $i=1)
	{
		$item		= 	array(
			'id'		=>		$row->page_id,		   	//db id
			'title' 	=> 		$row->title, 	   		//normal text, editable by admin
			'subtitle' 	=> 		$row->sub_title, 		//normal text, editable by admin
			'name' 		=> 		$row->url_name,  		//system name, always stays the same
			'navpos'	=> 		$i.$row->nav_prio,  	//position in navigation, add index in front for grouping
			'class' 	=> 		"subNav".$i,        	//css class per subnav rule
			'publish'	=>		$row->publish_state,	//publish state
			'fixed'		=>		$row->fixed 
			
		);
		
		return $item;
	}
		

	
			
	public function generate_page_tree($start_page_id ='root',$menu_only, $max_depth, $should_write_view_file, $view_path=null, $in_tree=false)
	{
		$this->max_depth 		=	$max_depth;
		$this->in_tree 			= 	$in_tree;
		$this->menu_pages_only 	= 	$menu_only;
		$this->CI->load->helper('file');
		
	
		
		// we get our (usually massive) page tree
		$pageTree=$this->_calculate_hierarchy($start_page_id);
		
		// we get some of our html templates
		$li_template = $this->CI->load->view('partials/adminPageNav/adminPageNavLi','',true);
		
		// we set our changeable keys
		$keys['{navpos}'] 		= 	'navpos'; 
		$keys['{id}'] 			= 	'id';
		$keys['{title}'] 		= 	'title';
		$keys['{edit_url}'] 	= 	'id';
		$keys['{content_url}'] 	= 	'id';
		$keys['{delete_url}'] 	= 	'id';
		
		// permission check gate //
		///////////////////////////
//		if($this->CI->permission->get('modify'))
//		{
//			$prefix['{edit_url}'] 	= 	site_url('page/modify/');
//			$prefix['{delete_url}'] = 	site_url('page/delete_page/');
//			$prefix['{content_url}'] 	= 	site_url('page/content/overview/');
//		}else{
			$prefix['{edit_url}'] 	= 	site_url('page/modify/').'/';
			$prefix['{delete_url}'] = 	site_url('page/delete_page/').'/';
			$prefix['{content_url}'] 	= 	site_url('page/content/overview/').'/';
//		}
		///////////////////////////
		//					 	 //
		
		
		$page_nav_html='';
		
		// we fill the tree using our _fill_page_tree_item function
		if($pageTree)
		{
			foreach($pageTree as $listedPage)
			{
				// prepare the prefixes for the values	
				$page_nav_html= $this->_fill_page_tree_item($page_nav_html, $listedPage ,$li_template,$keys,$prefix);	
			}
		}
		// everything has an end, so does our html
		$page_nav_html = '<ol id="'.$start_page_id.'" class="dragList">'.$page_nav_html.'</ol>';
		// simple text replacement	
		$text['{edit_text}'] 	= 	lang('page_nav_edit_link_title');
		$text['{delete_text}'] 	= 	lang('page_nav_delete_link_title');
		
		$page_nav_html = str_replace(array_keys($text),array_values($text), $page_nav_html);
		
		if($should_write_view_file === true)
		{
			// don't be fooled, this actually writes the file.. if we have the rights to write that is
			if(!write_file($view_path, utf8_encode($page_nav_html))) $this->CI->session->set_flashdata('ac_cms_error_message', lang('error_page_tree_write'));
			
		}else{
			return $page_nav_html;
		}
	}
		
		
	/****************************************************************
	 * Recursive function to fill a html navigation item template   *
	 ****************************************************************
	 * @see		_fill_page_tree_item
	 * @param	$html 		string
	 * @param	$page 		array
	 * @param	$li_template string
	 * @param	$keys 		array
	 * @param	$prefix 	array
	 *
	*/
	
	private function _fill_page_tree_item($html, $page, $li_template, $keys, $prefix)
	{
		
		// our html template for the menu item
		$li=$li_template;
		
		// we put the values we want to replace in arrays
		foreach($keys as $key =>$value)
		{
			$value 			= (isset($prefix[$key]))? $prefix[$key].$page[$value] : $page[$value];
			$values[$key] 	= $value;
		}
	
		$values['{toggle}']			=	'';
		$values['{display_none}'] 	= 	'';
		$values['{delete_display_none}'] = ($page['fixed'])? 'style="display:none"': '';
		$values['{cssClasses}']		=	'';
		
		
		if(isset($page['children']))
		{
			$values['{cssClasses}']		=	'hasChildren';
		}
		if((isset($page['children'])) || $this->fixed_id != NULL ) 
		{
			$values['{display_none}'] 	= 	'hiddenInput';

		}
		
		//publish state class presented to the frontend
		$values['{publish}'] = ($page['publish'] == 1) ? 'published' : 'unpublished';
		
		// we replace the keys with their values in the template
		$li= str_replace(array_keys($values), array_values($values), $li);
		$children_template = "";
		// if our current page has children, we'll put them inside our template using this template
		if(isset($page['children']))
		{
			// every child is an item, so we use our template to fill them with recursion
			foreach($page['children'] as $child)	
				$children_template.= $this->_fill_page_tree_item('', $child, $li_template,$keys,$prefix);
		}

		$li= str_replace('{children}',$children_template, $li);
//		$li= str_replace('{children}','', $li);
		$html.=$li;
			
		return $html;
	}	
}

/* End of file navigation.php */