<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'third_party/raintpl/rain.tpl.class.php');

/**
 * RainTemplate: RainTPL Library for CodeIgniter
 *
 * @author              Alexander Wenzel (alexander.wenzel.berlin@gmail.com)
 * @see                 https://bitbucket.org/alexwenzel/codeigniter-raintemplate
 *
 * @package             CodeIgniter Library
 * 
 * @version             1.0.0
 *
 */
class RainTemplate {
        
        private $_CI;
        private $_CONFIG;
        private $_RAINTPL;
        
        /**
         * Initialize RainTemplate Library
         * 
         * Loads raintemplate.php config file and push config to RainTPL.
         *
         * @return              void
         */
        public function __construct($params)
        {
                // get CodeIgniter instance
                $this->_CI = &get_instance();
                
                // get RainTemplate config file
                $this->_CI->config->load('raintemplate', TRUE);
                
                // load url helper for base_url()
                
                // store config for later use
                $this->_CONFIG                          = $this->_CI->config->item('raintemplate');
                $this->_CONFIG['base_url']      =  $this->_CI->config->base_url();
                
                // push config to RainTPL
                RainTPL::configure('tpl_dir', $this->_CONFIG['tpl_dir']);
                RainTPL::configure('cache_dir', $this->_CONFIG['cache_dir']);
                RainTPL::configure('base_url', $this->_CONFIG['base_url']);
                RainTPL::configure('tpl_ext', $this->_CONFIG['tpl_ext']);
                RainTPL::configure('path_replace', $this->_CONFIG['path_replace']);
                RainTPL::configure('path_replace_list', $this->_CONFIG['path_replace_list']);
                RainTPL::configure('black_list', $this->_CONFIG['black_list']);
                RainTPL::configure('check_template_update', $this->_CONFIG['check_template_update']);
                RainTPL::configure('php_enabled', $this->_CONFIG['php_enabled']);
                

                if($params) foreach($params as $key => $value)  RainTPL::configure($key, $value);
                // create RainTPL instance
                $this->_RAINTPL = new RainTPL();
        }
        
        /**
         * Assign is the method to assign variables to the template
         * 
         * You can either assign $name, $value or
         * pass an associative array.
         *
         * @param               mixed   $param1
         * @param               mixed   $param2
         * 
         * @return              stdClass
         */
        public function assign($param1, $param2 = NULL)
        {
                if (is_array($param1) && is_null($param2)) {
                        $this->_RAINTPL->assign($param1);
                }
                else {
                        $this->_RAINTPL->assign($param1, $param2);
                }
                
                return $this;
        }
        
        /**
         * Draws the selected template
         * 
         * If $cache is set as an integer RainTPL will draw the template from cache.
         * It's possible to cache the same template with different contents, by settings a different $cache_id.
         * 
         * In case of an error it shows HTTP 500.
         *
         * @param               string  $tpl_name
         * @param               mixed   $cache
         * @param               string  $cache_id
         * 
         * @return              void
         */
        public function draw($tpl_name, $cache = FALSE, $cache_id = NULL)
        {
                try {
                        if ($cache && is_int($cache)) {
                                if ($cached = $this->_RAINTPL->cache($tpl_name, $cache, $cache_id)) {
                                        echo $cached;
                                }
                                else {
                                        $this->_RAINTPL->draw($tpl_name, FALSE);
                                }
                        }
                        else {
                                $this->_RAINTPL->draw($tpl_name, FALSE);
                        }
                }
                catch (RainTpl_Exception $E) {
                        show_error($E->getMessage());
                }
        }
        
        /**
         * Checks whether a template exists or not
         *
         * @param               string  $tpl_name
         * 
         * @return              bool
         */
        public function exists($tpl_name)
        {
                $tpl_dir        = $this->_CONFIG['tpl_dir'];
                $tpl_ext        = $this->_CONFIG['tpl_ext'];
                
                $tpl            = $tpl_dir . $tpl_name . '.' . $tpl_ext;
                
                return file_exists($tpl);               
        }
        
        /**
         * Returns a string with designed template.
         * 
         * In case of an error it shows HTTP 500.
         *
         * @param               string  $tpl_name
         * 
         * @return              string
         */
        public function get($tpl_name)
        {
                try {
                        return $this->_RAINTPL->draw($tpl_name, TRUE);
                }
                catch (RainTpl_Exception $E) {
                        show_error($E->getMessage());
                }
        }
}