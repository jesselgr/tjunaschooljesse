<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ac nav setting
// ac nav items have the folowing options:
//	title 	: lang key of visible title on the nav item
//	icon  	: css style of the icon to display on the nav item 
//		choices are: .dashboardIcon,contentIcon,settingsIcon,componentIcon,fileIcon,msgIcon,distributorIcon,personIcon
//  tabs  	: array of tabs to place on top of the container when inside the item
//  subnav  : array of children to place under the nav item, as array( url => item, url=>item )


$config['ac_nav'][0]['children'][] = array(
		'url'		=>	'dashboard',
		'title'		=>	'ac_panel_dashboard',
		'icon'		=>	'dashboardIcon',
	  	'permission'=> 	'publisher',
	  	'key'		=>	'dashboard'
	);



$config['ac_nav'][1]['children'][] = array(
	'url'		=>	'page/children/root',
	'title'		=>	'ac_panel_pages',
	'icon'		=>	'contentIcon',
	'permission'=> 	'publisher',
	'key'		=>	'page',
	'sub_key'	=> 	'root'
);




// files
$config['ac_nav'][4]['children'][] = array(
	'url'		=>	'filebrowser',
	'title'		=>	'ac_panel_media_files',
	'icon'		=>	'fileIcon',
  	'permission'=> 	'publisher',
  	'key'		=>	'filebrowser'
);



// settings
$config['ac_nav'][5]['children'][] = array(
	'url'		=>	'settings/general',
	'title'		=>	'ac_panel_settings',
	'icon'		=>	'settingsIcon',
	'permission'=> 'tjuna',
	'key'=> 'settings'
);

$config['ac_nav'][5]['children'][] = array(
	'url'		    =>	'',
	'title'		    =>	'ac_panel_admin',
	'icon'		    =>	'settingsIcon',
	'lang_prefix'   => 'comp_',
	'key'		    => 'component',
	'permission'    => 	'tjuna',
	'subnav'        =>	array(
		'user'				=>	'component/overview/user',
		'user_group' 		=> 	'component/overview/user_group',
		'permission' 		=> 	'component/overview/permission',
		'content_default' 	=> 	'component/overview/content_default',
		'content_type' 		=> 	'component/overview/content_type',
		'template' 			=> 	'component/overview/template',
		'template_section' 	=> 	'component/overview/template_section',
		'site'				=> 	'component/overview/site',
		'language_label'	=> 	'component/overview/language_label',
		'language'			=>	'component/overview/language',
		'setting'			=>	'component/overview/setting'
	)

);
