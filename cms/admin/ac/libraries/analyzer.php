<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class analyzer{
	
	private $CI;
	
	
	public $table;
	public $collumns;
	public $fields;
  	public $related_tables;
  	public $validation_rules;
  	
	public function __construct($params=null)
	{
	
		$this-> CI =  &get_instance();
		$this-> CI -> load->model('analyzer_model', 'SCAN');
		$this-> CI -> load->helper('language');
		$this-> CI -> load->helper('inflector');
		$this-> CI -> config->load('analyzer');
	
		if($params)$this->initialize($params);
		
	}

	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))	$this->$key = $val;
			if ($key == 'table')	$this->cache($val);
		}
		
	}
   
	/***
	*
	*	get_collumns
	*	get database collumns for given table
	*	@param $table // optional of given to class
	*
	***/  
  
	public function get_collumns($table=null)
	{
		if(!$table && $this->table)	$table = $this->table;

		$this->collumns	= $this->CI->SCAN->get_collumns($table);

		
		return $this->collumns;
	}
	
	/***
	*
	*	@see get_fields
	*	get form fields for given table
	*	@param $table // optional of given to class
	*
	***/  
	public function get_fields($table=null) 
	{
		if(!$table && $this->table) $table = $this->table;
		$this->fields 			= 	$this->CI->SCAN->get_fields($table);
	
		return $this->fields;
	}
	
	/***
	*
	*	@see get_fields_settings
	*	get form fields with additional info for given table
	*	@param $table // optional of given to class
	*	***/  
	
	public function get_fields_settings($table)
	{
		if(!$table && $this->table) $table = $this->table;
		$this->table= $table;
		$fields = array();
		foreach($this->fields as &$field)
		{
			if(!$field_title = $this->CI->lang->line($field['name'])) $field_title = humanize(str_replace('_id', '', $field['name']));
			
			$field['title']	= 	$field_title;

			$fields[$field['name']] 				= 	$this->_get_input_by_field($field);
			$fields[$field['name']]['rules'] 		= 	$this->_get_input_validation_by_field($field);
			$fields[$field['name']]['title']		=	$field_title;
			
			$this->validation_rules[$table] = $fields[$field['name']]['rules'];
		}
		
		return  $fields;
	}
	
	
	/***
	*
	*	@see get_title_collumn
	*	get title collumn for given table
	*	@param $table // optional of given to class
	*
	***/  
	
	public function get_title_collumn($table)
	{
//		$this->CI->SCAN->check_multilanguage($table);
		$possibleTitles = $this->CI->config->item('scan_title_candidates');
		
		// if we already know the table row..
		$row =  (!$table || $table == $this->table) ? $this->collumns : $this->CI->SCAN->get_collumns($table);
		
		return ($row) ? current(array_intersect($row, $possibleTitles)) : null;
	}
	
	
	
	/***
	*
	*	@see get_subtitle_collumn
	*	get sub title collumn for given table
	*	@param $table // optional of given to class
	*
	***/  
	
	public function get_subtitle_collumn($table)
	{
		$possibleTitles = $this->CI->config->item('scan_subtitle_candidates');
		
		// if we already know the table row..
		$row = ($table == $this->table) ? $this->collumns : $row = $this->CI->SCAN->get_collumns($table);
	
		return ($row) ? current(array_intersect($row, $possibleTitles)) : null;
	}


	/***
	*
	*	@see _get_input_validation_by_field
	*	get validation for given field
	*	@param $field
	*
	***/  

	private function _get_input_validation_by_field($field)
	{
		$validation = array();
		$validation['rules'] = '';
		$validation['field'] = $field['name'];
		$validation['label'] = $field['title'];
		$rules = array();
		
		$email_rule 	= 	($field['name'] == 'email' || $field['comment'] == 'email');
		$length_rule 	= 	($field['max_length']);
		$empty_rule		=	($field['is_null'] == 'NO');
		$number_rule	=	(strstr($field['type'], 'int'));
		
		if($empty_rule)		$rules[] = 'required';
		if($length_rule)	$rules[] = 'max_length['.$field['max_length'].']';
		if($email_rule) 	$rules[] = 'valid_email';
		if($number_rule)	$rules[] = 'is_numeric';
		
		$validation['rules'] = $rules;
		return $validation;
	}
	
	
	/***
	*
	*	@see _get_input_by_field
	*	get input field data for given field
	*	@param $field
	*
	***/  
	
	private function _get_input_by_field($field)
	{
		$field['hide_label'] = false;
		$field['input_type'] = false;

		$table 		= $this->table;
		$types['hidden'] 		= array($table.'_id', 'salt','date_create','date_modified');
		$types['file']			= array('image','img','attachment', 'logo', 'image_url' , 'attachment_url');

		// set key..
		if(!$field['input_type']) $key = $field['name'];
	
		// check names for known signatures
		if(in_array($key,$types['hidden']) || $field['comment'] == 'hidden')
		{
			$field['input_type'] = "hidden";
			$field['hide_label'] = true;
		}
		elseif (in_array($key,$types['file'])  || $field['comment'] == 'file')
		{
			$field['input_type'] = "file";
		}
		elseif(substr($key, -3) == '_id' || strstr($field['comment'],'fk ->'))
		{
			$table = substr($key, 0, strpos($key,'_id'));
			if($this->CI->SCAN->check_if_table_exists($table))
			{
				$field['input_type'] 			= 	"select";
				$field['table'] 				=	$table;
				$field['table_title_collumn'] 	= 	$this->get_title_collumn($table);
			}
		}
		elseif ($field['type'] == 'enum') {
			$field['input_type'] 			= 	"select";
			$field['options'] = explode(',',str_replace("'", '', substr($field['data_type'], 5, -1)));
		}
		elseif ($field['type'] == 'tinyint' && substr($field['data_type'], 8, -1) == 1 ) {
			$field['input_type'] = 'boolean';
		}
		
		
		if ( $field['input_type'] ) return $field;
		
		//check out our data-types
		switch($field['type'])
		{
			// regular text
			default:
				$field['input_type'] = "text";
				break;
				
			// numbers
			case 'tinyint':
			case 'int':
			case 'bigint':
				$field['input_type'] = "number";
				break;
			
			// text area	
			case 'text':
			case 'longtext':
				$field['input_type'] = "text_area";
				break;
			
			case 'date':
			case 'datetime':
			case 'timestamp':
				$field['input_type'] = "date";
				break;
		}
		
		return $field;
	}
	
	
	// search the database information scheme for relation (table1_to_table2) tables
	public function get_related_tables($table)
	{
		$related_tables=null;
		
		if($relation_tables_result = $this->CI->SCAN->get_relation_tables_scheme($table))
		{

		
			foreach($relation_tables_result as $relation_table_row)
			{
				// we search our relation table for the second table, referred to as 'related table'
				$relation_table_name 	= 	$relation_table_row->name;
							
	
				if($relation_table_name != $table)
				{
					$related_table_name 	= 	substr($relation_table_name, (strpos($relation_table_name,'_to_')+strlen('_to_')), strlen($relation_table_name));
					if($this->CI->SCAN->get_table_scheme($related_table_name)) $related_tables[] =	$related_table_name;
				}
			}
		}

		return array('relation' => $relation_tables_result, 'related' => $related_tables);
	}
	
	/*
		Function to find tables related to this table and list them for a multiselect form item
	*/
	
	public function get_related_table_lists($table, $related_tables,$table_id=false){

		$lists 			= 	array();
		// relation is our pointing table referring to the related ex: 
		// table: template relation:(template_section_to_template, related: template_section)
		
		
		if($related_tables['relation'] || $related_tables['related'])
		{
			
			foreach($related_tables['related'] as $i => $related_table_name)
			{
				$relation_table_name = $related_tables['relation'][$i]->name;
	
	
				// define what we want to know about the related table
				$list_title_val = $this->get_title_collumn($related_table_name);
				$select 		= array($list_title_val, $related_table_name.'.'.$related_table_name.'_id');	// example: category.title, category.category_id
				
				
				// get the resulting data and fill our returning array with the values
				$table_result 							= $this->CI->SCAN->get_tables($related_table_name, $select);
				$lists[$related_table_name]['list'] 	= ($table_result) ? select_list_items($table_result, $related_table_name.'_id', $list_title_val) : array(''=>'');
				
				
				$related_table_result = ($table_id) ? $this->CI->SCAN->get_related_tables( $relation_table_name, $table, $table_id) : null;
				$lists[$related_table_name]['values']  	= ($related_table_result) ? select_list_items($related_table_result, null, $related_table_name.'_id'): array(''=>'');
			
			}
		}
		
		return $lists;
	}
	
	/*
		function to find the title value in a table
	
	*/
	
	private function cache($current_table){
		// tabledata of the previous request
		$saved_table				=	$this -> CI ->session -> flashdata('comp_table');
		$saved_table_title_column 	=	$this -> CI ->session -> flashdata('comp_table_title_collumn');
		$saved_table_related		=	$this -> CI ->session -> flashdata('comp_table_related');
		$saved_display_html_body	=	$this -> CI ->session -> flashdata('comp_no_html_body');
		
		// check data we have on this table
		if($current_table == $saved_table){
			$this -> CI ->session -> keep_flashdata('comp_table');
			$this -> CI ->session -> keep_flashdata('comp_table_related');
			$this -> CI ->session -> keep_flashdata('comp_table_title_collumn');
			$this -> CI ->session -> keep_flashdata('comp_no_html_body');
			
			$this -> CI ->title_collumn 	= $saved_table_title_column;
			$this -> CI ->related_tables = unserialize($saved_table_related);
			$this -> CI ->hide_html_body = $saved_display_html_body;
			
		}else{
			$this ->title_collumn 	= 	$this->get_title_collumn($current_table);
			$this ->related_tables 	= 	$this->get_related_tables($current_table);

//			$this -> CI ->session -> set_flashdata('comp_table', $current_table);
//			$this ->CI -> session -> set_flashdata('comp_table_related', serialize($this->related_tables));
//			$this ->CI -> session -> set_flashdata('comp_table_title_collumn', $this->title_collumn);
//			$this ->CI -> session -> set_flashdata('comp_no_html_body', $this -> hide_html_body);
		}
	}

	public function get_relation_list($component, $component_id=null, $switch='even'){
		$html = '';

		// create a multiselect for every related table
		if($this -> related_tables && $related_table_lists = $this->get_related_table_lists($component,$this -> related_tables, $component_id))
		{
			
			foreach($related_table_lists as $key => $related_table_list){
				
				$data['key']		=	$key; 
				if(!$data['label'] 	= 	lang($key)){
					$data['label'] 	= 	$key;
				}
				$data['switch'] 	= 	$switch;
				$data['list'] 		= 	$related_table_list['list'];
				$data['values'] 	= 	$related_table_list['values'];
				$data['input_type']	=	'input_multi_select';
				
				$html.= $this->CI->load->view('inputs/form_input_container', $data, true);
				
				if($switch=='even'){$switch='odd';}else{$switch='even';}
			}
		}
		
		return array('html' =>$html, 'switch' => $switch);
	}
	

}// end of class pizzapie