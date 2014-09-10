<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_test extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index() {
		
		$this->load->library('table');
		$this->load->helper('form');
		$this->load->helper('html');

		$html = form_open_multipart(base_url().'cdi/api_test');
		$table[]= array( 'api call');
		$table[]= array( 
			form_label('environment','environment'),
			form_dropdown('environment', array(
				'gstar.dev.tjuna.com/cdi'=>'DEV',
				'gstar-academy.dev.tjuna.com/cdi/' => 'STAGE',
				'localhost/gstar-academy/cdi'=>'LOCAL')
				,set_value('environment')
			)
		);
		$table[]= array(
			form_label('type','type'),
			form_dropdown('type', array('get'=>'get','put'=>'put','post'=>'post'),set_value('type'))
		);

		$table[]= array(
			form_label('controller','controller'),
			form_dropdown('controller',
				array(
				'page'=>'page',
				'content/slide'		=>	'content/slide',
				'content/subject'	=>	'content/subject',
				'content/test'		=>	'content/test',
				'user/login' 		=> 	'user/login',
				'user/profile'		=>	'user/profile',
				'user/password'		=>	'user/password',
				'content/label'		=>	'content/label',
				'file'				=>	'file'
				)
			,set_value('controller')
			)
		);
		$table[]= array(
			form_label('method','method'),
			form_input('method',set_value('method'))
		);
		$table[]= array(
			form_label('param','param'),
			form_input('param0name',set_value('param0name'))
		);
		$table[]= array(
			form_label('value','value'),
			form_input('param0value',set_value('param0value'))
		);
		$table[]= array(
			form_label('param','param'),
			form_input('param1name',set_value('param1name'))
		);
		$table[]= array(
			form_label('value','value'),
			form_input('param1value',set_value('param1value'))
		);
		$table[]= array(
			form_label('file','file'),
			'<input type="file" name="image"/>'
		);
		
		$html .= $this->table->generate($table);
		$html.= form_submit('name', 'check it!');
		$html.= form_close();

		$this->load->library('rest', array(
			    'server' => 'http://'.$this->input->post('environment'),
			    'http_user' => 'apitest',
			    'http_pass' => 'apitest',
			    'http_auth' => 'basic'
			));

		if($this->input->post())
		{
			

			$params = array(
				$this->input->post('param0name') => $this->input->post('param0value'),
				$this->input->post('param1name') => $this->input->post('param1value')
			);
			$this->rest->api_key('mK7W36PvF4iMfheL2yJrVHzdocXBg9au');
			$type = $this->input->post('type');
			$result = $this->rest->$type($this->input->post('controller').'/'.$this->input->post('method'), $params);

		}else{
			$result = " - raw result will show here! - ";
		}
			echo '<html><body style="width:100%; height:100%">';
			echo '<div style="height:100%; width: 25%; float:left; overflow:scroll">'.$html.'</div>';
			echo '<div style="height:100%; width: 25%; float:left; overflow:scroll">';
			echo '<pre>';
			print_r($result);
			echo '</pre>';
			echo '</div>';
			echo '<div style="height:100%; width: 50%; float:left; overflow:scroll">';
			$this->rest->debug();
			echo '</div>';
			echo '</body></html>';
			
		
		
		
		


	}

	public function profile()
	{
		$this->load->library('page/template');
		$this->template->place('profile_form');
	}

	


	function curl_upload(){


	    $url = 'http://gstar.dev.tjuna.com/cdi/user/profile/image';
	    $file = '/APPLICATIONS/MAMP/htdocs/gstar-academy/assets/img/backgroundImages/hotSpotScrollBg.jpg';
	    $ch = curl_init($url);

	    curl_setopt($ch,CURLOPT_HTTPHEADER,array('call_token: mK7W36PvF4iMfheL2yJrVHzdocXBg9au'));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_POST, true);
	    $post = array(
	        "userfile" => "@$file;type=image/jpeg"
	    );
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
	    $response = curl_exec($ch);
	    var_dump( $response);

	    curl_close($ch);
}

}