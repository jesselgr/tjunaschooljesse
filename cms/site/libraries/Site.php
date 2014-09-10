<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class site{
	
	
	private $CI;
	
	private $pageID;
	

	public $site_id;
	public $available_sites;
	public $page_row;
	
	
	public $uri_segment_array;
	public $available_languages;
	public $language_id;
	public $lang_code;
	public $lang_locale;
	public $lang_labels;
	
	private $contentSelect 	= array(
		'description.title',
		'description.sub_title',
		'description.content',
		'content_type.title as typeTitle',
		'content.template_section_id',
		'template_section.title section'
	);
	private $lang_select 	= array(
		'language_id', 
		'code',
		'name',
		'locale'
	);	


	public function __construct()
	{
		$this->CI 			= 	&get_instance(); 
		
		$this->CI->load->model('languagemodel', 'LANG');
		$this->CI->load->model('settingsmodel', 'SETT');
		$this->CI->load->helper('conf');
		
		$this->uri_segment_array	=	$this->CI->uri->segment_array();
		
		$this->_handle_language();
		$this->_handle_site();   
	}
	
  

	
	public function get_site_data()
	{
		$this->CI->load->model('settingsmodel', 'SETT');
		$site_data = array();	
		//get site settings
		$settingsResult	= 	$this->CI->SETT->get_front_settings($this->site_id);
		if($settingsResult)
			foreach($settingsResult as $settingRow)
				$site_data[$settingRow->key]	=	$settingRow->value;	
		
		return $site_data;
	}
	

	
	private function _handle_language()
	{
		$available 			= false;
		$this->lang_code 	= CURRENT_LANGUAGE;

		if(URL_SUFFIX != null)	// if uri contains lang code, clean it
			array_shift($this->uri_segment_array);
			
		// get list of available languages, the current one sorted as first
		$this->available_languages = $this->CI->LANG->get_languages($this->lang_code, $this->lang_select);
		
		foreach ($this->available_languages as $key => $value) {
			if($value->code === $this->lang_code)
				$available = true;
		}
	
		if($available)
		{
			$this->language_id 	= 	$this->available_languages[0]->language_id;
			$this->lang_locale 	=  	$this->available_languages[0]->locale;
		}else{
			show_error('Language not found.',404);
		}
		
		$this->lang_labels 	= 	$this->CI->LANG->get_language_labels($this->language_id);
		setlocale(LC_TIME, $this->lang_locale);
	}
	
	private function _handle_site()
	{
		//Get site id
		if($this->available_sites = $this->CI->SETT->get_sites(base_url()))
		{
			$this->site_id 	= $this->available_sites[0]->site_id;
		}else{
			show_error('No matching website found.',404);
		}
	}
			   
}
/* End of file site lib */