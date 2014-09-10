<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
// require APPPATH.'/libraries/REST_Controller.php';

class Status extends CI_Controller
{

    
    function summary()
    {
        if(ENVIRONMENT != 'development') show_404();

        $this->load->library('table'); 
        $this->load->helper('html');  

        $last_five_calls = $this->db
            ->select('uri, method, params, CONCAT(ROUND(((UNIX_TIMESTAMP() - time))/ 60), " minuten"),ip_address',false)
            ->order_by('cdi_log_id desc')
            ->get('cdi_log',5)
            ->result_array();

        $html = '<section style="background:#f2f2f2; box-shadow: 0 2px 5px rgba(0,0,0,0.2); width:90%; overflow:scroll; display:table; margin: 20px auto; padding:10px; font-family: helvetica">';
        $html.= heading('API status', 2);
        $html.= $this->table->generate(array(
            array('status: ','in development'),
            array('version:', $this->config->item('cdi_version')),
            array('contact: ','erik@tjuna.com')
		));
     

        $html.= heading('Last 5 calls', 2);
        $table_vars = array(array('uri', 'method', 'params','time ago','ip_address')) + $last_five_calls;
        $html .= $this->table->generate($table_vars); 
        $html.= '</section>';
        $this->output->set_output($html);
      
    }
}