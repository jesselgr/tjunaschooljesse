<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

///////////////////////////////////////////
///		general settings albacore 		///
///////////////////////////////////////////

$config['default_landing_page']	=	"home";

/////////////////////
// front-end views //
/////////////////////

//  smarty templates on/off, make sure the cache folder has write-rights if you turn it on

$config['site_smarty']							= 		true;
$config['site_smarty_template_extension'] 		= 		'.tpl';

// debug button that dumps front-end vars

$config['debug_button'] 						= 		true;

/* content regular formatting
/	true gives something like: content[text][left][0]
/	false gives raw db output
*/
$config['content_formatting']				=	true;

// content html formatting, content will have it's html syntax added as a 'html' value
$config['content_html_formatting'] 			= 		true;

// the html formatting of content is the only thing passed to the front end, sacrificing data for loading time
$config['content_html_formatting_only'] 	= 		false;


////////////////
// navigation //
////////////////


//auto load nav in front end controller (if false, you must load it manually in the view)

$config['auto_nav'] 	= 	true;

// main navigation settings (only applicable if custom cache is on, standard depth is 1 (not changable yet)

$config['site_navigation_has_children'] 	= 	true;
$config['site_navigation_is_dropdown']  	= 	false;
$config['site_navigation_gen_dir']		 	= 	'ac/views/generated/mainNav.php';

// The system can generate html navigations based on page changes. define here wether you want this or not. (note: You MUST give Modifying rights to the ac/views/generated folder before settings this to true.

$config['site_navigation_cache'] 	= 	false;

////////////////
// front-end  //
////////////////
//  contact	  //
////////////////

// debug button that dumps front-end vars
$config['contact_form_receiving_mail'] 	= 	'erik@tjuna.com';

$config['default_language_id']		=	2;
$config['default_language_code']	='nl';

$config['fallback_language_id']		=	1;
$config['fallback_language_code']	='en';

