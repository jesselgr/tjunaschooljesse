<?php
class component extends CI_Controller{

	private $title_collumn;
	private $subtitle_collumn;

	private $related_tables;
	private $filter_key;
	private $filter_value;

	private $hide_html_body = false;

	private $table;
	private $collumns;
	private $fields;
	private $id_collumn;

	private $form;

	public function __construct()
    {
    	parent::__construct();



		$current_table 	= $this->uri->segment(3);

       	$this->load->helper('list');
       	$this->load->helper('language');
       	$this->lang->load('comp');

		$this->load->helper('inflector');
		$this->load->library('analyzer', array('table' => $current_table));
		$this->load->model('component_model', 'COMP');

		$this->hide_html_body = ($this->input->get('dialog') == 1);


		// table of what were viewing now

		$this->table 		= $current_table;
		$this->collumns 	= $this->analyzer->get_collumns($current_table);
		$this->fields		= $this->analyzer->get_fields($current_table);
		$this->id_collumn  	= $current_table.'_id';

		$this ->title_collumn 		= 	$this->analyzer->get_title_collumn($current_table);
		$this ->subtitle_collumn 	= 	$this->analyzer->get_subtitle_collumn($current_table);
		$this ->related_tables 		= 	$this->analyzer->get_related_tables($current_table);

		$this->form = 'comp_form';
		$this->ac->set_active_key('component',$current_table);
//		$this->analyzer->cache();
    }


	//////////////////////////////////////////////////////////////////
	// 			maak gegevens voor een  nieuwe pagina form	  		//
	//////////////////////////////////////////////////////////////////

	public function overview($component, $pagination=0, $filter_key=null,$filter_value=null){
		$this->load->library('pagination');
		$this->lang->load('list');
		$this->lang->load('pagination');
		$this->load->helper('inflector');
		if(!$this->permission->get('read_'.$component) && ! $this->permission->get('tjuna'))
			show_error('sorry, you do not have permissions to view a '.$component.' <a href="'.$this->input->server("HTTP_REFERER").'">Go back</a>');

		if(!$comp_title	= lang('comp_'.$component)) $comp_title = humanize($component);

		// walk through filters
		$conditions = 	null;

		if($filter_key && $filter_value){

			$conditions = array($filter_key.'_id' => $filter_value);
			$this->filter_key 	= $filter_key;
			$this->filter_value = $filter_value;
		}else{
			$filter_key 	= $this->filter_key;
			$filter_value 	= $this->filter_value;
		}
		if($filter_key && $filter_value){
			$data['navSuffix']			=	$filter_key.'/'.$filter_value;
		}

		// pagination data
		$limit			=	10;
		$uri_segment	=	(4);
		$start 			= 	$pagination;
		$total_count 	= 	$this->COMP->count_all($component, $conditions);

		$config['anchor_class'] = 	'class="pagination-link" ';
		$config['base_url'] 	= 	site_url(array('component','overview', $component));
		$config['total_rows'] 	= 	$total_count;
		$config['per_page'] 	= 	$limit;
		$config['use_page_numbers']		=	TRUE;
		$config['uri_segment']  =	$uri_segment;

		if($this->input->get()){
			$config['suffix']	= 	implode('/',$conditions).'?'.http_build_query($this->input->get(), '', "&");
		}

		$this->pagination->initialize($config);


		$subtitle_collumn 	= $this->subtitle_collumn;
		// get results
		$component_result 	= 	$this->COMP->get_tables($component, array($this->id_collumn, $this->title_collumn, $subtitle_collumn), $conditions, null, $start, $limit);


		// pass view data

		$data['head'] 		=  $comp_title;
		$data['subHead']	=	lang('comp_nav_overview');
		$data['list'] 		= 	$component_result;

		$data['pagination']['start']	= 	$start;
		$data['pagination']['end']		=	$start + count($component_result);
		$data['pagination']['total']	=	$total_count;


		$navUrlSubCat			=	$filter_key;
		$data['navUrlSubCat']	=	$navUrlSubCat;
		$data['navSuffix'] 		= 	null;

		//tabs
		$data['titleVal']		=	$this->title_collumn;
		$data['subtitleVal']	=	$subtitle_collumn;

		$data['comp_title']			=	$comp_title;
		$data['urlKey']				=	$this->id_collumn;
		$data['navUrlController']	=	'component';
		$data['navUrlVal']			=	$component;
		$data['in_dialog'] = $this ->hide_html_body;

		if($this ->hide_html_body){ // quick, hide the body!
			$this->load->view('comp_nav', $data);
		}else{
			$this->ac->place_header($data);
			$this->load->view('comp_nav');
			$this->ac->place_footer();
		}
	}


	//////////////////////////////////////////////////////////////////
	// 			maak gegevens voor een  nieuw component form	    //
	//////////////////////////////////////////////////////////////////

	public function edit($component, $id, $filter_key=null, $filter_value=null)
	{
		if(!$this->permission->get('update_'.$component) && ! $this->permission->get('tjuna'))
		{
			show_error('sorry, you do not have permissions to update a '.$component.' <a href="'.$this->input->server("HTTP_REFERER").'">Go back</a>');

		}
		$this->load->library('form_validation');

		$data['navSuffix'] = null;

		if($filter_key && $filter_value)
		{
			$conditions = array($filter_key.'_id' => $filter_value);
			$data['navSuffix']	=	$filter_key.'/'.$filter_value;

			if(!$this->filter_key){
				$this->filter_key 	= $filter_key;
				$this->filter_value = $filter_value;
			}
		}

		$this->lang->load('form');


		$component_result = $this->COMP->get_table($component, $id);


		// add data for our form
		$data['form']  			= get_object_vars($component_result);
		$values= $data['form'];

		$form = $this-> _form($data['form'], $id, $values);

        $data['formHtml'] 		= 	$form['html'];
		$data['switch']			= 	$form['switch'];
		$data['idVal']			=	$this->id_collumn;


		// form
		$data['formAction']		=	'';
		$data['langPrefix']		=	'comp_';
		$data['component']		=	$component;
		$data['in_dialog'] = $this ->hide_html_body;

		if($this->input->post()/* && $this->form_validation->run()*/)
		{
			$this->_update($component);
		}else{

			// load views
			if($this ->hide_html_body)
			{
				$this->load->view($this->form, $data);
			}else{
				$this->ac->place_header($data);
				$this->load->view($this->form);
				$this->load->view('adminFooter');
			}
		}
//		$this->output->cache(30);
	}

	public function create($component,$filter_key=null, $filter_value=null)
	{
		if(!$this->permission->get('create_'.$component) && ! $this->permission->get('tjuna'))
			show_error('sorry, you do not have permissions to create a '.$component);
		$this->load->library('form_validation');

		$form_values = array();
		$data['navSuffix'] = null;
		$data['idVal']			=	$this->id_collumn;
		foreach($this->db->list_fields($component) as $field)
		{
			$data['form'][$field] = '';
		}
		if($filter_key && $filter_value)
		{
			$conditions = array($filter_key.'_id' => $filter_value);

			$data['navSuffix']	=	$filter_key.'/'.$filter_value;

			if(!$this->filter_key)
			{
				$this->filter_key 	= $filter_key;
				$this->filter_value = $filter_value;
			}
		}

		$this->lang->load('form');

		// modify form, remove id

		if($filter_key && $filter_value){
			$form_values[$filter_key.'_id']	=	$filter_value;
		}

		$form = $this->_form($form_values);
		$this->form_validation->set_rules($this->analyzer->validation_rules);

		unset($form[$this->id_collumn]);

		$data['formHtml'] 	= $form['html'];
		$data['switch']		= $form['switch'];


		// set view data
		if(!$data['head'] 	= lang('comp_'.$component)){
			$data['head']	=	humanize($component);
		}
		$data['subHead']		=	lang('comp_nav_create');


		//nav

		//form
		$data['formAction']		=	'';
		$data['langPrefix']		=	'comp_';

		if($this->input->post()/* && $this->form_validation->run()*/)
		{
			$this->_update($component);

		}else{
			$data['fields'] = $form_values;
			$data['in_dialog'] = $this ->hide_html_body;
			// load views

			if($this ->hide_html_body){
				$this->load->view($this->form, $data);
			}else{
				$this->ac->place_header($data);
				$this->load->view($this->form);
				$this->load->view('adminFooter');
			}
		}
//		$this->output->cache(30);
	}



	///////////////////////////////////////////////////
	//  			 modify component			 	 //
	///////////////////////////////////////////////////

	private function _update($component)
	{
		$related_tables = $this->related_tables;
		$postData 		= $this->input->post();
		$relationData 	= array();

		if(empty($postData['password']))
		{
			unset($postData['password']);
		}else{
			$this->load->helper('password');
			$postData['password'] = password_hash(htmlspecialchars($postData['password']), PASSWORD_DEFAULT);
		}

		if(isset($related_tables['related']))
		{
			foreach($related_tables['related'] as $table)
			{
				if($this->input->post($table))
				{
					$relationData[$table][$table] = $postData[$table];
					unset($postData[$table]);
				}
			}
		}

		if($update_id = $this->input->post($this->id_collumn))
		{
			$this->COMP->update_table($component, $update_id, $postData);
		}else{
			$update_id = $this->COMP ->insert_table($component, $postData);
		}
		if(isset($related_tables['related']))
		{

			foreach($related_tables['related'] as $i => $table)
			{
				$relation_table_name = $related_tables['relation'][$i]->name;
				$this->COMP->delete_relation($relation_table_name, $this->id_collumn, $update_id);

				 if(isset($relationData[$table]))
				 {
				  	foreach($relationData[$table][$table] as $key => $value)
				  	{
				  		$relationModelData[$relation_table_name][$key][$this->id_collumn] 	= 	$update_id;
				  		$relationModelData[$relation_table_name][$key][$table.'_id']		=	$value;
				  	}

					$this->COMP->insert_relation($relation_table_name, $relationModelData[$relation_table_name]);
				}
			}
		}

		$this->output->set_status_header('201');
		$this->output->append_output($this->lang->line('success_content_saved'));
		return;
		// redirect(site_url(array('component','overview',$component,'0',$route,$route2)));
	}


	///////////////////////////////////////////////////////
	//  				 DELETE component 				 //
	///////////////////////////////////////////////////////

	public function delete($component, $id)
	{
		if(!$this->permission->get('delete_'.$component) && ! $this->permission->get('tjuna'))
			show_error('no access to delete '.$component.' <a href="'.$this->input->server("HTTP_REFERER").'">Go back</a>');

		$this->COMP ->delete($component,$id);

		$this->session->set_flashdata('ac_cms_message', $this->lang->line('success_content_deleted'));
		redirect($this->input->server('HTTP_REFERER'));

	}

	private function _form($form, $component_id=null, $values='')
	{
		$component = $this->table;
		$this->load->helper('list');

		$data['values'] 	= 	$values;
		$switch				=	'odd';
		$langPrefix 		= 	'comp_';
		$fields 			= 	$this->analyzer->get_fields_settings($component);
		$formHtml 			= 	'';
		// walk through the form, find stuff
		foreach($fields  as $key => $field_data)
		{

			$input_type 		= $field_data['input_type'];
			$input_hide_label 	= $field_data['hide_label'];

			$data['list']		= 	array();
			$data['key']		=	$key;
			$data['value'] 		= 	(isset($values[$key])) ? $values[$key] : $field_data['default_value'];

			if($key == 'password')$data['value']='';

			//compile html
			if($input_hide_label)
			{
				$formHtml .= $this->load->view('inputs/'.'input_'.$input_type, $data, true);

			} else {

				if($input_type == "select" || $input_type == "multi_select")
				{

					if($field_data['type'] == 'enum')
					{
						foreach ($field_data['options'] as $option)
						{
							$opt_lang = lang('select_'.$key.'_'.$option);
							$data['list'][$option] = ($opt_lang)?$opt_lang : humanize($option);
						}
					}
					else {
						$tableName 		= $field_data['table'];

						$title_field 	= 	$field_data['table_title_collumn'];
						$result 		= 	$this->COMP->get_tables($field_data['table']);
						$data['list'] 	=  	($result) ? select_list_items($result, $key, $title_field) : array(0 => '----');
					}

				}

				$data['label']		= 	$field_data['title'];

				$data['forced']		=	(in_array('required', $field_data['rules']['rules']));
				$data['label']		.=	(in_array('required', $field_data['rules']['rules']))? ' <small>*</small>' : '';
				$data['switch'] 	= 	$switch;
				$data['input_type']	=	'input_'.$input_type;

				$formHtml.= $this->load->view('inputs/form_input_container', $data, true);

				$switch = ($switch == 'even') ? 'odd' : 'even';
			}

		}

		if($multiselect = $this->analyzer->get_relation_list($component, $component_id, $switch)) $formHtml .= $multiselect['html'];

		return array('html' => $formHtml, 'switch' => $switch);
	}




}