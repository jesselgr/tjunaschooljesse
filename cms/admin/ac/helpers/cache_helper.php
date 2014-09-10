<?php 

function write_to_cache($key, $value, $t)
{
	$ci = &get_instance();
	$ci->load->driver('cache', array('adapter' => 'file'));
	
	return $ci->cache->save($key, $value, $t);	

}

function get_from_cache($key)
{
	$ci = &get_instance();
	$ci->load->driver('cache', array('adapter' => 'file'));
	
	return $ci->cache->get($key);
}

function delete_from_cache($key)
{
	$ci = &get_instance();
	$ci->load->driver('cache', array('adapter' => 'file'));

	return $ci->cache->delete($key);
}