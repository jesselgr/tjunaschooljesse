<?php

function pick_language() {

    require_once(APPPATH.'config/language.php');


    // define uri (somewhat like route does)
	$uri = $_SERVER['REQUEST_URI'];
	if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
	{
		$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
	}
	elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
	{
		$uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
	}
  	$uri = explode('/',str_replace(array('//', '../'), '/', trim($uri, '/')));
   	$lang_candidate = $uri[0];
   	
   	// determine if the first bit of url is a lang code
  	if($lang_candidate && strlen($lang_candidate) == 2)
  	{
  		define('CURRENT_LANGUAGE',$lang_candidate);
  		define('URL_SUFFIX',$lang_candidate.'/');
  	}else{
	  	define('CURRENT_LANGUAGE', $config['default_language']);
  		define('URL_SUFFIX', null);
  	}
}