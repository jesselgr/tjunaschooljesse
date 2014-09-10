<?php
                                               
////////////////////////////////////////////////////////////////////////////////////
// 							Page controller	by Tjuna		  					 ///
////////////////////////////////////////////////////////////////////////////////////

class Page extends CI_Controller{

	private $pageSelect= array(
		'page.page_id', 
		'description.url_name', 
		'page.thumb',
		'page.mobile_thumb',
		'publish_state',
		'description.title', 
		'page.parent_page_id', 
		'description.sub_title', 
		'description.meta_description', 
		'page.fixed',
		'page.parent_page_id', 
		'page.template_id as template_id',
		'template.view_file_name as template'
	);	// array
	

	
	public $segments;
	public $page_row; 	// object
	public $seg_array;
	public $language_id;
	public $page_url;
	
	public function __construct()
    {
    	parent::__construct();	
		
		// get our models
        $this->load->model('pagemodel', 'PAGE');
        $this->load->model('languagemodel', 'LANG');
        $this->language_id = $this->site->language_id;
    }	      	
		
	public function _remap()
	{	
		$request_data = $this->_handle_page_request();
		// Get url data and do stuff with language	
		
		$this->request = $request_data;
		if($request_data) 
		{
			$this->page_row = $this->PAGE->get_page_by_name($request_data['url_name'],null, $this->pageSelect, $this->language_id, $this->site->site_id);
			$this->_load_page($request_data['url_name']);		
		} else {
			$this->page_row = $this->PAGE->get_page_by_fixed('404',null, $this->pageSelect, $this->language_id, $this->site->site_id);
			$this->_load_page('404');
		}
		
	}
	
	
	private function _handle_page_request()
	{
		$seg_array = $this->site->uri_segment_array;
		if(count($seg_array) < 1) $seg_array[0]= $this->config->item('default_landing_page');
		return $this->PAGE->get_by_uri($seg_array, $this->site->language_id, $this->site->site_id);
	}
	
	////////////////////////////////////////
	//		 inladen gegevens pagina	  //
	////////////////////////////////////////
	
	private function _load_page($called_page)
	{
		$this->load->library('template');
		$this->load->library('page_content');
		$data = $this->_get_exceptions();
		$data['page']			=	get_object_vars($this->page_row);
		$data['content'] 		=  	$this->page_content->get_content_for_page_row($this->page_row);
		if($this->config->item('content_html_formatting'))
		{
			$this->load->library('page_content');
			$data['content'] = $this->page_content->format_sections_html($data['content']);
		}
		
		$data['title']			=	$data['page']['title'];

		
		// load our views as smarty templates
		$this->template->place_header($data);
		$this->template->place('page/' . $this->page_row->template);
		$this->template->place_footer();

	}
	
	// allow exceptions for specific pages
	private function _get_exceptions()
	{
		$data = array();

	
		if($this->page_row->url_name == '404')
			$this->output->set_status_header('404');

		return $data;
	}
}
