<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	
	/*******************************************
	*     Content
	********************************************/


class Page_content{
	
		
	private $CI;

	public $access;
	public $parent;

	public $pageNames;
	public $cont_type_tpl_path;

	private $contentSelect 	= array(
		'description.title',
		'description.sub_title',
		'description.content',
		'content_type.title as typeTitle',
		'content.template_section_id',
		'template_section.title section'
	);
	
	public function __construct($params=null)
	{

		$this-> CI = &get_instance(); 
		$this->cont_type_tpl_path = 'content_type/';
	}
	
		
				
	/**
	 * [format_content description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function format_content($content)
	{
		$viewData = null;
		if($content){
			foreach($content as $row){
				$viewData[$row->typeTitle][] = get_object_vars($row);
			
			}
		}
		
		return $viewData;
	}
	
	/**
	 * [format_sections_html description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function format_sections_html($content){

		foreach($content as $section => &$section_content)
		{
			foreach($section_content as $content_type =>  &$content_type_rows)
			{
				// dump($content_type_rows);
				if($content_type_rows && is_array($content_type_rows)) 
					foreach($content_type_rows as $content_type_row)
						$section_content['html'] = $this->get_content_type_html($content_type_row); 
			}
		}
		return $content;
	}
		
	/**
	 * [get_content_html description]
	 * @param  [type] $content_type_rows [description]
	 * @return [type]                    [description]
	 */
	public function get_content_type_html($item)
	{

		$content_type 	= 	$item['typeTitle'];
		$file_path 		= 	'output_'.$content_type;
		$return_html	=	$this->CI->template->get('content_type/'.$file_path, $item, true);
		
		return $return_html;
	}


	/**
	 * [get_page_and_content_for_page_fixed description]
	 * @param  [type] $fixed [description]
	 * @return [type]        [description]
	 */
	public function get_page_and_content_for_page_fixed($fixed)
	{
		$result = array('page','content');
		$this->CI->load->model('pagemodel', 'PAGE');

		if($page_row = $this->CI->PAGE->get_page_by_fixed($fixed, null, '*',$this->CI->site->language_id, $this->site_id))
		{
			$result['page']     =   $page_row;
			$result['content']  =   $this->get_content($page_row);
		}
		return $result;
	}


	/**
	 * get
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
	public function get_content_for_page_url($url)
	{
		$this->CI->load->model('pagemodel', 'PAGE');

		if($page_row = $this->CI->PAGE->get_page_by_name($url, null, '*',$this->CI->site->language_id, $this->site_id))
		{
			return $this->get_content($page_row);
		}
	} 
	/**
	 * [get_content_for_page_row description]
	 * @param  [type] $page [description]
	 * @return [type]       [description]
	 */
	public function get_content_for_page_row($page)
	{
		$this->CI->load->model('contentmodel', 'CONT');

		$page_content_sections = array();

		// Get content
		if($content_result = $this->CI->CONT->get_content_by_page_id($page->page_id, $this->CI->site->language_id, $this->contentSelect))
		foreach($content_result as $content_row) $page_content_sections[$content_row['section']][$content_row['typeTitle']][] = $content_row;

		return $page_content_sections;
	}


}


/* End of file content lib */