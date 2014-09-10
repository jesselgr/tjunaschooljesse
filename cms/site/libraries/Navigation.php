<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class navigation {

	public 	$main = '';
	public 	$subnav;

	public  $language_id;
	public	$language_code;
	public 	$site; 		// object
	private $CI;
	private $depth;
	public 	$max_depth = 2;
	
	private $home_url = 'home';
	private $pageTree;
	private $uri_array = array();

	private	$pages;
	private $html;
//	private $db;
	
	private $li_template;
	
	private $page_query_select = array('page.page_id', 'page.template_id','description.title', 'sub_title', 'description.url_name', 'nav_prio','parent_page_id', 'publish_state','in_footer','children');
	
	public $children = true;
	public $dropdown = true;
	
	public $in_menu = true;
	public $in_tree = true;
	
	public $html_key 	= 'root';
	public $main_html	= array();
	
	/*****************************************************************************
	 * 	Navigation library allows us to dynamically create navigations with ease *
	 *****************************************************************************
	 * 	  This data is optimized and directly usable in the cms navigation view  *
	 *****************************************************************************
	 * @see		set_main_nav
	 * @param	$children 		bool
	 * @param	$dropdown 		bool
	 * @param	$depth			int
	 * @param	$in_menu 		bool
	 * 
	 *
	 *	2 public functions:
	 *	
	 *	- set_main_nav:	gets all root pages
	 *	- get_nav:		needs page_id to get childeren
	*/
	
	
	public function __construct($params=array())
    {
    		
		$this-> CI = &get_instance();
		// get our models
		$this->CI->load->model('pagemodel', 'PAGE');
		
		$this->CI->load->model('settingsmodel', 'SETT');
		
		$this->uri_array = $this->CI->site->uri_segment_array;
		
		$this->initialize($params);
		$this->pages=$this->get_pages();
		
		$this->set_main_nav();
		
    }
    
    public function initialize($params)
    {
    	foreach($params as $param => $value)
    	{
    		$this->$param = $value;
    	}
    	$this->site_id 			=  	(isset($params['site_id'])) 		?  	$params['site_id'] 		:	$this->CI->site->site_id;
    	$this->language_id		= 	(isset($params['language_id'])) 	?  	$params['language_id'] 	: 	$this->CI->site->language_id;
    	$this->language_code 	= 	(isset($params['language_code']))	? 	$params['language_code']: 	$this->CI->site->lang_code;
    }
		
	
	/*************************************************************************
	 * 		This function retrieves a navigation of all published pages 	 *
	 *************************************************************************
	 * This data is optimized and directly usable in the cms navigation view *
	 *************************************************************************
	 * @see		set_main_nav
	 * @param	$children 		bool
	 * @param	$dropdown 		bool
	 * @param	$depth			int
	 * @param	$in_menu 		bool
	 * 
	*/
	
	public function set_main_nav()
	{
		
		$this->in_menu = true;
		$this->main_html[$this->html_key] = array(
			'html' 		=> '',
			'page_tree' => ''
		);
		$depth 		= 	($this->CI->config->item('site_navigation_has_children')) ? 2 : 1;
		$main_nav 	=	$this->get_nav('root',true, $depth);
			
		$this-> main = $main_nav;		
	}

	public function get_footer_nav()
	{
		$footer_nav = array();
		$footer_nav_result = $this->CI->db
			->where('in_footer','1')
			->where('language_id', $this->language_id)
			->select('title, url_name')
			->join('page_description','page_description.page_id = page.page_id')
			->get('page')
			->result_array();
	
		
		return $footer_nav_result;
	}

	/************************************************************************
	 * This function retrieves a navigation based on a given parent page id *
	 ************************************************************************
	 * @see		get_nav
	 * @param	$parent_id 	int
	*/
	
	public function get_nav($parent_id='root', $in_menu = null, $max_depth=null)
	{
		$this->html_key = $parent_id;
		$this->main_html[$parent_id]['html'] = '';
//		$this->in_menu 	= $in_menu;
		if($max_depth) $this->max_depth = $max_depth;
		
		//	get all children and their children   //
		$sub_nav_items = $this->_get_children($parent_id, 0);
			
		return $sub_nav_items;
	}
	
	public function get_nav_by_url($url, $in_menu = null, $max_depth=null, $base_segments = '')
	{
		$this->in_menu 	= $in_menu;
		if($max_depth) $this->max_depth = $max_depth;
		
		$parent_id = $this->CI->db->select('page_id')->get_where('page_description',array('url_name' => $url));
		$parent_id = $parent_id->row()->page_id;
		//	get all children and their children   //
		
		$sub_nav_items = $this->_get_children($parent_id, 0, $base_segments.'/'.$url);
		return $sub_nav_items;
	}
	
	
	public function get_nav_html($url, $new = false, $base_segments = '')
	{
		if(($return = $this->html[$url]) && !$new)
		{
			return $return;
		}else {
			$this->html_key = $url;
			$this->main_html[$url] = array(
				'html' 		=> '',
				'page_tree' => ''
			);
			$this->pageTree = array();
			if(is_numeric($url)) 
			{ 
				$this->get_nav($url,null,null);
			}else{
			 	$this->get_nav_by_url($url,null,null, $base_segments);
			}
			$this->main_html[$url]['page_tree'] = $this->pageTree;
			return $this->main_html[$url];
		}
	}	
	
	/************************************
	 * General page retrieval function  *
	 ************************************
	 * @see		get_pages
	 * @param	$parent_id 		int
	 * @param	$in_menu 	boolean
	 * @param	$in_tree 		boolean
	*/	

	private function get_pages($parent_id=null, $order = NULL)
	{	
		$this -> CI -> db -> select($this->page_query_select);
		$this -> CI -> db -> from('page');
		$this -> CI -> db -> join('page_description description','page.page_id = description.page_id');
		
		if($this->in_menu != null)$this -> CI -> db -> where('in_menu', $this -> in_menu);
		if($parent_id)$this -> CI -> db -> where('parent_page_id', 	$parent_id);
	
		$this -> CI -> db -> where('language_id', 	$this->language_id);
		$this -> CI -> db -> where('site_id', 		$this->site_id);

		$this -> CI -> db -> where('publish_state', 	1);
		
		$order = ($order)? $order : 'nav_prio asc';
		$this -> CI -> db -> order_by($order);
		
		$page_query = $this -> CI -> db -> get();
		
		return $page_query->result_array();
		
	}	

	/********************************************************
	 * function to recurively get children of a given page  *
	 ********************************************************
	 * @see		get_tree
	 * @param	$parent_id 	int
	 * @param	$depth 		int
	*/

	private function _get_children($parent_id, $depth, $parent_url='', $parent_active = false)
	{	
		// load children for given parent id
		$items	= null;	
		$depth++;
		$count = 0;
		$parent_url = (empty($parent_url))? $parent_url:$parent_url.'/';
	
 		foreach($this->pages as &$page)
		{
			if($page['parent_page_id'] == $parent_id)
			{
				$a_class 		= '';
				$li_class 		= ($depth == 1)? 'class="root"':'';
				
				$a_class 		= '';
				$toggleclass 	= '';
	
			
				
				if($page['url_name'] == $this->home_url)
				{
					$a_class 	= 	(count($this->CI->site->uri_segment_array) == 0)?'active' : '';
					$url 	=  	'';
				}else{
					$a_class 	= 	(in_array($page['url_name'], $this->CI->uri->segment_array()))?'active' : '';
					$url 	=  	$parent_url.$page['url_name'];
				}
				
//				$this->main_html[$this->html_key]['html'].= ($count == 0)? '<ul '.$ulclass.$block.'>':'';
				$this->main_html[$this->html_key]['html'].= ($count == 0)? '<ul>':'';
				$count++;
				//fill item  & recurse
				$item 	=	$page;
				$this->main_html[$this->html_key]['html'].='<li '.$li_class.'>';
				$this->main_html[$this->html_key]['html'].='<a class="'.$a_class.'" href="'.site_url().$url.'">'.$item['title'].'</a>';
		
				if($depth < $this->max_depth && $page['children'])
				{

					$children	=	$this->_get_children($page['page_id'],$depth, $parent_url.$url, $parent_active);
					if($children){
						$item['children']	= $children;
					}else{
						$this->main_html[$this->html_key]['html'] = substr($this->main_html[$this->html_key]['html'], 0, -33);
					}
				}
				//fill
				$items[]	=	$item;
				$this->main_html[$this->html_key]['html'].='</li>';
				
			}
		}
		$depth--;
		$this->main_html[$this->html_key]['html'].= ($count >= 1)? '</ul>':'';
		if($items)return $items;
	
	}
}

/* End of file navigation.php */
