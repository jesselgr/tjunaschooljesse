<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['ac_template_dir'] 			= 'templates/';
$config['ac_template_extension'] 	= '.tpl';

// choice generally between rainTPL and smarty
$config['ac_template_engine'] = 'smarty';
// debug button that dumps front-end vars

$config['ac_debug_allowed'] 	= 	true;

/* content regular formatting
/	true gives something like: content[text][left][0]
/	false gives raw db output
*/
$config['content_formatting']		=	true;
$config['content_html_formatting'] 	= 	true;	// content html formatting, content will have it's html syntax added as a 'html' value
$config['content_html_formatting_only'] = 	false; // the html formatting of content is the only thing passed to the front end, sacrificing data for loading time


// Is the directory where RainTPL compile the templates
$config['rtpl_cache_dir']= APPPATH . 'cache/';


// Is the templates extension
$config['rtpl_tpl_ext'] = 'html';


// RainTPL when compile a template, replaces all relative paths with the correct server path.
$config['rtpl_path_replace'] = TRUE;


// Is possible to configure what elements to parse.
// You can set only the following elements, <a>, <img>, <link> and <script>.
$config['rtpl_path_replace_list'] = array('a', 'img', 'link', 'script');


// It define what functions and variables cannot be used into the template.
$config['rtpl_black_list'] = array();


// Set it false only if your cache directory has not write permission,
// else is strongly advised to re-compile the template for each change.
$config['rtpl_check_template_update'] = TRUE;


// Set true if you want to enable the use of PHP codes in your templates.
// Its strongly recommend to keep this configuration disabled.
$config['rtpl_php_enabled']  = FALSE;