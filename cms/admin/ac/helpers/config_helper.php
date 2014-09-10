<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('conf'))
{
	function conf($key, $value = null)
	{
		$CI =& get_instance();
		$item = $CI->config->item($key);
		return $item;
	}
}
