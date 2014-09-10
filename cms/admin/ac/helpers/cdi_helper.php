<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function cdi_url()
{
	$CI =& get_instance();
	return site_url().$CI->config->item('url_cdi');

}


function cdi_thumb_url()
{
	$CI =& get_instance();
	return site_url().$CI->config->item('url_cdi').'/graphic/getImage/';

}


function form_file_button($key,$value,$type=null,$preset=false)
{
	$url_suffix = ($preset)?'?preset='.$preset : null;
	$thumb_url = cdi_thumb_url().$value. $url_suffix;
	$html = '';
	$html.="<div class=\"buttonFileBox\"> \n";
	$html.="<a href=\"#\" data-target=\"input_".$key."\" data-label=\"\" data-type=\"".$type."\" data-preset=\"".$preset."\" data-preview=\"buttonFile-thumb-".$key."\" class=\"buttonFile\">\n";
	$html.="<img id=\"buttonFile-thumb-".$key."\" class=\"contentImgPreview\" src=\"".$thumb_url . "\"/>\n";
	$html.="</a>\n";
	$html.="<label id=\"buttonFile-label".$key."\" class=\"buttonFileLabel\"></label>\n";
	$html.=form_input(array('id'=> 'input_'.$key, 'name'=>$key,'class'=> 'inputField visuallyhidden'),$value);
	$html.="</div>";


	return $html;
}