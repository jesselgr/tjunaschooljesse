<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* @name CI Smarty
* @copyright Dwayne Charrington, 2011.
* @author Dwayne Charrington and other Github contributors
* @license (DWYWALAYAM) 
*           Do What You Want As Long As You Attribute Me Licence
* @version 1.2
* @link http://ilikekillnerds.com
*/

require_once APPPATH."../../core/Smarty/Smarty.class.php";

class CI_Smarty extends Smarty {

    public function __construct()
    {
        parent::__construct();

        // Store the Codeigniter super global instance... whatever
        $CI = &get_instance();


        $this->template_dir      = SITEPATH.config_item('ac_template_dir');
        $this->compile_dir       = config_item('smarty_compile_directory');
        $this->cache_dir         = config_item('smarty_cache_directory');
        $this->config_dir        = config_item('smarty_config_directory');
        $this->template_ext      = config_item('smarty_template_ext');
        
        $this->cache_lifetime    = config_item('smarty_cache_lifetime');
        
        // If caching is enabled, then disable force compile and enable cache
        if (config_item('smarty_cache_status') === TRUE)
        {
            $this->caching       = 1;
        }
        else
        {
            $this->disable_caching();
        }
        
        $this->error_reporting   = config_item('smarty_template_error_reporting');

        $this->exception_handler = null;

        // Add all helpers to plugins_dir
        $helpers = glob(APPPATH . 'helpers/', GLOB_ONLYDIR | GLOB_MARK);

        foreach ($helpers as $helper)
        {
            $this->plugins_dir[] = $helper;
        }
        
        // Should let us access Codeigniter stuff in views
        $this->assign("this", $CI);
    }
    
    /**
    * Disable Caching
    * Allows you to disable caching on a page by page basis
    * @example $this->smarty->disable_caching(); then do your parse call
    * 
    */
    public function disable_caching()
    {
        $this->caching       = 0; 
    }

}