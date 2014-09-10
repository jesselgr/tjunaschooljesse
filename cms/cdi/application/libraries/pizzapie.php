<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class pizzapie{

	// counters for salt
	private $counters = array(
	'dog' 	=> 	'cat',
	'pizza' => 	'pie',
	'man'	=> 	'woman',
	'mac'	=> 	'pc',
	'bmp'	=> 	'jpg'
	);

	/***********************************************************************************
	 * 				PizzaPie Library encrypts passwords with a double salt 	  		   *
	 *---------------------------------------------------------------------------------*
	 * First salt is a regular string, second salt is given and a counter is generated *
	 ***********************************************************************************
	 *
	 * @see		encrypt
	 * @param	$pepper 	string
	 * @param	$salt 		string
	 * @param	$sugar		string
	*/
	
	public function encrypt($string, $salt, $pepper){
		// get a counter for our salt
	  	if(in_array($salt, array_keys($this->counters))) {
	  		$salt = $this->counters[$salt];
		}else{
			return;
		}
		// mix up our shizzle like a frizzle, mix it up make it drizzle
	  	$string=md5($salt) . sha1($string) . md5($pepper);
	  	$string=md5($string);

	  	return $string;
	}
	
	
	/********************************************************
	 * 	  		Generate a double salted string				*
	 *------------------------------------------------------*
	 *	  The first salt is given, the third is generated	*
	 ********************************************************
	 *
	 * @see		generate
	 * @param	$string 	string
	 * @param	$pepper		string 
	*/
		
	public function generate($string, $pepper){
		// pick random salt for our encryption
		$salt 		= 	array_rand($this->counters,1);
		$string 	=	$this->encrypt($string, $salt, $pepper);
		
		return array('salt'=> $salt, 'password' => $string);
	}

}// end of class pizzapie