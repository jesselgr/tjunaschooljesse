<?php
class api {

	
	public $params;
	public $user_settings;
	public $output ='';
	public $token;
	

	/**
	 * API constructor
	 * 
	 * The API can be called from the API url or directly from PHP by adding
	 * the trusted security token as a parameter.
	 * 
	 * USAGE: /?cmd=COMMAND&params=PARAMS&tst=token
	 *
	 * @param api_key string
	 */
	 
	function __construct()
	{
		error_reporting(0);		// shut yo mouth
		
		$this-> CI 		= 	&get_instance();
				
	}	
	

	
	/* end of file api.php */
}
