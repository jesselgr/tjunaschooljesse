<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class ac{
	
    public $language;
    
    private $CI;
    
    public $side_nav;
    
    public $sites;
    
    public $active_components = array();

    protected $active_key;
    protected $active_sub_key;
    
    public function __construct($params=null)
    {

        $this-> CI = &get_instance();
        $this->_check_login(); 
        
        $this->_set_sites();
        $this->language = $this->CI->config->item('ac_language');
        $this->CI->config->load('main');
        $this->CI->config->load('nav');
        $this->CI->lang->load('comp');
    }
    
    public function set_active_key($key, $sub_key = null)
    {
    	$this->active_key 		= $key;
    	$this->active_sub_key 	= $sub_key;
    }

    public function place_header($data, $title=false, $sub_title=false)
    {
        if($title)      $data['head']       = $title;
        if($sub_title)  $data['subHead']    = $sub_title;
        $this->CI->load->helper('navigation');

        $data['ac_nav'] 	= $this->CI->config->item('ac_nav');
        $data['ac_key'] 	= $this->active_key;
		$data['ac_sub_key'] = $this->active_sub_key;
        $data['is_standalone_popup'] =  $this->CI->input->get('standalone');


        $this->CI->load->view('static/header',$data);
        $this->CI->load->view('static/cms_page_top');
    }

    public function place_overlay_header($data, $title='module', $sub_title=false)
    {
        $this->CI->load->view('static/overlay_header',$data);
    }

    public function place_overlay_footer()
    {
        $this->CI->load->view('static/overlay_footer');
    }
    public function place_footer()
    {
        $this->CI->load->view('static/footer');
    }


    /**
     * place a template from the template directory
     * @param  string  $tpl_file_name       name of template
     * @param  array   $vars                php vars to assign to template
     * @param  boolean $should_return_html  wether to place or get
     */
    public function place_template($tpl_file_name, $vars=array(),$shoud_return=false)
    {
        
       return $this->CI->load->view($tpl_file_name, $vars,$shoud_return);
        
    }


    public function load_view_with_wrapper($view_file_url,$data,$title=null,$sub_title=null){
    	$this->place_header($data, $title, $sub_title);
        $this->CI->load->view($view_file_url);
    	$this->place_footer();
    }
    
    public function load_views_with_wrapper($view_file_urls, $data,$title='module',$sub_title=null)
    {
        $this->place_header($data, $title, $sub_title);
        foreach($view_file_urls as $view_file_urls_url)$this->CI->load->view($url);
        $this->place_footer();
    }

    public function load_html_with_wrapper($content_html)
    {
        $this->place_header($data, $title, $sub_title);
        $this->output->append_output($content_html);
        $this->place_footer();
    }

    public function set_notification($message)
    {
    	$this->CI->session->set_flashdata('ac_cms_message', $message);
    }
    
	private function _set_sites()
	{
		$this->CI->load->model('setting_model','SETT');
		$current_site_id = (int)$this->CI->session->userdata('site_id');
		$this->sites = $this->CI->SETT->get_sites($current_site_id);
	}
	

    private function _check_login()
    {
    	if(!$this->validate_login() && $this->CI->uri->segment(1) != 'login')
    	{
    		redirect('login');
    	}

    }


    public function validate_login()
    {
    	$is_logged_in 	= 	$this->CI->session->userdata('is_logged_in');
    	$hash 			= 	sha1(date('Wm',time()).'TjunaAlbacore'.site_url());
    
    	return (bool)($is_logged_in != null && $is_logged_in == $hash);
    }
    
}