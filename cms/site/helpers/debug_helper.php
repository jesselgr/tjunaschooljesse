<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('dump')){
	/**
	 * debug dump, prints all arguments given to this function
	 * @return string
	 */
	function dump(){
		$called_at = debug_backtrace();
        echo '<strong>' . substr(str_replace(SELF, '', $called_at[0]['file']), 1) . '</strong>';
        echo ' (line <strong>' . $called_at[0]['line'] . '</strong>)';
		echo'<pre>';
		foreach(func_get_args() as $dump_item)
     		var_dump($dump_item);
		echo'</pre>';
	}

}

if(!function_exists('rdump')){
	/**
	 * debug dump, returns the first given argument
	 * @param  string $dump
	 * @return string
	 */
	function rdump($dump) {
		$called_at = debug_backtrace();
		ob_start();
        echo '<strong>' . substr(str_replace(SELF, '', $called_at[0]['file']), 1) . '</strong>';
        echo ' (line <strong>' . $called_at[0]['line'] . '</strong>)';
		echo'<pre>';
     	var_dump($dump);
		echo'</pre>';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}   
}

if(!function_exists('cheerio')){
	/**
	 * cheerio!
	 */
	function cheerio()
	{
		if ( func_get_args() ) dump(func_get_args());
		die('cheerio!');
	}
}

