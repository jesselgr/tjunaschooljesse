<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

///////////////////////////////////////////
///		general settings albacore 		///
///////////////////////////////////////////



//////////////////////
//   	back end  	//
//////////////////////
// general settings //
//////////////////////

//language settings for backend

$config['ac_language'] 								= 	'2';
$config['site_language'] 							= 	'2';

// dashboard shortcuts

$config['ac_dashboard_shortcuts'][1]['lang_key']	=	'dashboard_shortcut_page_create';
$config['ac_dashboard_shortcuts'][1]['link']		=	'page/create';
$config['ac_dashboard_shortcuts'][1]['class']		=	'shortcut page';

// the landing page ater loggin in to the ac

$config['ac_after_login_landing_page']				= 	'dashboard';

// The system can generate html navigations based on page changes. define here wether you want this or not. (note: You MUST give writing rights to the ac/views/generated folder before settings this to true.

$config['cache_page_nav'] 							= 	false;

// main navigation settings (only applicable if custom cache is on)

$config['navigation_gen_dir']						= 	'ac/views/generated/adminPageNav.php';

// in case a page (url) is created that already exists, add this to the end of the url

$config['duplicate_page_add'] 						= 	'-';

//relative paths (starting at the index.php folder) to resources
$config['path_ckeditor']							=	"core/ckeditor/";

$config['url_cdi']									=	'../cdi/';
