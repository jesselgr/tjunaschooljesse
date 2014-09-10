<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**
 * a_lost_items
 *
 * Lets you determine whether an array index is set and whether it has a value.
 * If the element is empty it returns FALSE (or whatever you specify as the default value.)
 *
 * @access	public
 * @param	mixed object or array
 * @param	string
 * @param	string
 * @return	string	
 */

if(!function_exists('a_list_items')){
	function a_list_items($items, $itemUrl,$urlVarName, $titleVarName, $class=null){
		if($class){
			$class ='class="'.$class.'">';
		}
		
	   foreach($items as $item){
	   	
	     	$url=$itemUrl.'/'.$item->$urlVarName;
	       
	        $list[]='<li'.$class.'><a href='.$url.'>'.$item->$titleVarName.'</a></li>';
	        	
	    }
	    return $list;
	}   

}

// create list suitable for ci form_dropdown helper
if(!function_exists('select_list_items')){
	function select_list_items($items, $idVal=null, $listVal, $default=null){
	
		if($default){
			$return = $default;
		}
		
		if($idVal){
			foreach($items as $item){
				$return[$item->$idVal]=$item->$listVal;
			}
		}else{
			foreach($items as $item){
				$return[]=$item->$listVal;
			}
		}
		
		return $return;
	}   
}

if(!function_exists('list_items')){
	function list_items($items, array $itemVars){
		
	   foreach($items as $item){
	   		var_dump($items);
		   	foreach($itemVars as $var){
		   		
		        $list[$var]=$item[$var];
		   	}
	    }
	    return $list;
	}   
}

function flick_switch($switch){
	if(!$switch){
		$switch='odd';
	}else{
		$switch='';
	}
	return $switch;
}
