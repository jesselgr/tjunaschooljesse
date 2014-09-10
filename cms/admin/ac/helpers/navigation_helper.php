<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function nav_item_is_active($item, $active_key, $active_sub_key)
{
	return (
		(
			$item['key'] == $active_key
			&& empty($item['subnav'])
		 	&& empty($item['sub_key'])
		 ) 
		|| 
		(
			!empty($item['sub_key'])
			&& $active_sub_key == $item['sub_key']
		)
		||
			!empty($item['subnav'] )
			&& in_array($active_sub_key, array_keys($item['subnav']))

	);
}