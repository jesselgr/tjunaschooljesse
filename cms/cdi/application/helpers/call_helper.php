<?php
	function check_call_vars($method, $required_fields, $optional_fields = array())
	{

		$CI =& get_instance();
		$acquired_fields 	= array();
		$missing_fields 	= array();

		foreach($required_fields as $field)
		{
			$value = $CI->$method($field);
			if($value != null)
			{
				$acquired_fields[$field] = $value;
			}else{
				$missing_fields[] = $field;
			}
		}
		foreach($optional_fields as $field)
		{
			$value = $CI->$method($field);
			if($value != null)
				$acquired_fields[$field] = $value;

		}
		$check_has_passed = empty($missing_fields);
		return array(
			'passed' 	=> $check_has_passed, 
			'vars' 		=> ($check_has_passed) ? $acquired_fields : $missing_fields
		);
	}