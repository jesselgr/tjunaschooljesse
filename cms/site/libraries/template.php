<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class template{
	
	
	private $CI;
	
	public $tpl_prefix;// template prefix
	public $tpl_ext;
	private $vars = array();
	protected $tpl_dir;
	protected $tpl_engine_name;
	protected $tpl_engine_instance;
	protected $functions;

	

	public function __construct()
	{

		$this->CI 			= 	&get_instance(); 
		
		$this->CI->load->helper('conf');
		$this->CI->load->config('template');
		$this->tpl_ext 			=	conf('ac_template_extension');
		$this->tpl_engine_name 	= 	conf('ac_template_engine');
		$this->tpl_dir 			= 	conf('ac_template_dir');
		$this->CI->load->model('page/pagemodel','PAGE');
		$this->CI->load->model('page/contentmodel');
		// gentlemen, start your engines!
		$this->_init_tpl_engine($this->tpl_engine_name);

	}
	
	
	// place the header
	public function place_header($data = array(), $notfound = false)
	{
		// page information
		// $data['title']  					= title of page
		// $data['meta']['title']			= meta title
		// $data['meta']['keywords']		= meta keywords
		// $data['meta']['description']		= meta description
		// $data['meta']['thumb']			= meta thumbail  
		
		$navigation_params = array(
				'language_id' 	=> $this->CI->site->language_id,
				'site_id' 		=> $this->CI->site->site_id,
				'max_depth'		=> 1
		);
		
		
		$this->CI->load->helper('minify'); 
		$this->CI->load->helper('template');
		$this->CI->load->library('navigation', $navigation_params);

		
		if(!isset($data['meta']['thumb']))
			$data['meta']['thumb'] = base_url()."assets/img/logo.png";
		
		if($notfound)
			$this->CI->output->set_status_header('404');
		
   
		$data['site'] 		= $this->CI->site->get_site_data();
		$data['domains'] 	= $this->CI->site->available_sites;

		$data['translation']['list']			= $this->CI->site->available_languages;
		$data['translation']['default_code'] 	= conf('default_language');
		$data['translation']['code'] 			= $this->CI->site->lang_code;
		$data['translation']['id'] 				= $this->CI->site->language_id;

		// minify
		$data['minified']['jsUrl'] 		= (isset($data['js'])) 	? 	crunch_files($data['js'],'js') : '';
		$data['minified']['cssUrl'] 	= (isset($data['css'])) ?	crunch_files($data['css'],'css'): '';
		unset($data['js']);
		unset($data['css']);
		 
		// get language_specific labels 		
		$data['labels'] 	= 	$this->CI->site->lang_labels;
		$data['footer_nav'] = 	$this->CI->navigation->get_footer_nav();
		
		// page navigation
		if(conf('auto_nav'))
			$data['page_nav']	=	$this->CI->navigation->main_html['root'];
		
		$this->place('static/header', $data);
	}
	/**
	 * assign a var to template
	 * @param  mixed $assign1 variable name / batch of variables
	 * @param  mixed $assign2 [description]
	 */
	public function assign($assign1, $assign2=false)
	{
		if(is_array($assign1))
		{
			$this->vars = array_merge($assign1, $this->vars);
		}else{
			$this->vars[$assign1] = $assign2;
		}
	}

	/**
	 * places general site footer template
	 */
	public function place_footer()
	{
		$this->place('static/footer');
		$this->place_debug();
	}
	 
	/**
	 * place a template from the template directory
	 * @param  string  $tpl_file_name 		name of template
	 * @param  array   $vars            	php vars to assign to template
	 * @param  boolean $should_return_html 	wether to place or get
	 */
	public function place($tpl_file_name, $vars=array())
	{
		
		$tpl_string = $this->get($tpl_file_name, $vars);
		$this->CI->output->append_output($tpl_string);
		
	}

	
	/**
	 * get a template from the template directory and parse it with the current engine
	 * @param  string $tpl_file_name name of template file
	 * @param  array  $vars          batch of variables you wish to assign to this template. will be added to existing ones
	 * @return string                (html) template filed by given vars
	 */
	public function get($tpl_file_name, $vars=array())
	{
		// declare working variables
		$file_path 		= 	$this->tpl_prefix.$tpl_file_name.$this->tpl_ext;
		$tple_name 		= 	$this->tpl_engine_name;
		$tple_get_func 	= 	$this->functions['get'];	// no puns allowed...


		// check if template exists, if not, abort
		if (!file_exists(FCPATH.$this->tpl_dir.$file_path) ) show_error('the template '.$file_path.' doesn\'t exist.');
		

		// If we have variables to assign, lets assign them
		$vars = array_merge($this->vars, $vars);
        if (!empty($vars))
        {
            foreach ($vars as $key => $val) 
            	$this->CI->$tple_name->assign($key, $val);
        }

		return $this->CI->$tple_name->$tple_get_func($file_path);
	}


	/**
	 * place debug screen
	 */
	public function place_debug()
	{
		if(conf('ac_debug_allowed'))
			$this->place('static/debug');	
	}

	/**
	 * initialize the templating engine, given it is in an accesible codeigniter library
	 * @param  string $engine name of engine
	 */
	private function _init_tpl_engine($engine)
	{
		switch($engine)
		{
			case 'rainTPL':
				$this->functions['get'] 	= 'get';
				$this->functions['place'] 	= 'draw';
				$this->functions['requires_var_assignment'] = true;
				$this->CI->load->library('raintemplate');
			break;

			case 'smarty':
				$this->functions['get'] 	= 'fetch';
				$this->functions['place'] 	= 'parse';
				$this->functions['requires_var_assignment'] = false;
				$this->CI->load->library('smarty');
			break;
		}		
	}
			   
}
/* End of file site lib */