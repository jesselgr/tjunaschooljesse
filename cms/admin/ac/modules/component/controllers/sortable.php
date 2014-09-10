<?php
class sortable extends CI_Controller{
	
	private $title_collumn;
	private $subtitle_collumn;
	
	private $related_tables;
	private $filter_key;
	private $filter_value;
	
	private $hide_html_body = false;
	
	public $tabs = array();
	
	private $table;
	private $collumns;
	private $fields;
	private $id_collumn;
	private $sortable_collumn;
	
	public $grouped = false;
	
	private $form;
	
	public function __construct()
    {
    	parent::__construct();	
		
//		if(!$this->permission->get('publisher')) show_404();;
		
		$current_table 	= $this->uri->segment(4);
		
       	$this->load->helper('list');
       	$this->load->helper('text');
       	$this->load->helper('language');
       	$this->lang->load('comp');
		

		$this->load->helper('inflector');
		$this->load->library('analyzer', array('table' => $current_table));
		
		// $this->load->model('sortable_model', 'SORT');
        $this->sortable_collumn = "store.store_id asc";
		// temp

        $this->grouped = $this->analyzer->is_grouped($current_table);

		// if(!$this->analyzer->is_sortable($current_table)) show_error('This component is not sortable!');
		
		
		
		$this->load->model('component/component_model', 'COMP');
		$this->load->model('component/component_group_model','COMPGR');
		// table of what were viewing now
		
		$this->table 		= $current_table;
		$this->collumns 	= $this->analyzer->get_collumns($current_table);
		$this->fields		= $this->analyzer->get_fields($current_table);
		$this->id_collumn  	= $current_table.'_id';
		
		
		$this->title_collumn 		= 	$this->analyzer->get_title_collumn($current_table);
		$this->subtitle_collumn 	= 	$this->analyzer->get_subtitle_collumn($current_table);
		$this->related_tables 		= 	$this->analyzer->get_related_tables($current_table);
		$this->ac->set_active_key('component',$current_table);
		$this->form = 'comp_form';
		
//		$this->analyzer->cache();
    }	
   
    
	//////////////////////////////////////////////////////////////////
	// 			maak gegevens voor een  nieuwe pagina form	  		//
	//////////////////////////////////////////////////////////////////
	
	public function overview($table, $filter_key=null,$filter_value=null)
	{
		$this->load->library('pagination');
		$this->lang->load('list');
		$this->load->helper('inflector');
		$this->cms->active_key = array($table.'/'.$filter_key.'/'.$filter_value);
		// walk through filters
		// die('test');
		$conditions = 	null;
		if($filter_key!= null && $filter_value!= null)
		{
			$this->filter_key 	= $filter_key;
			$this->filter_value = $filter_value;
			
			$data['tabSuffix']	=	$filter_key.'/'.$filter_value;
			$data['navSuffix']	=	'/'.$filter_key.'/'.$filter_value;
			
			$conditions = array($filter_key => $filter_value);

            $data['url_suffix'] = $data['navSuffix']."?d=".base64_encode(serialize($conditions));
		}else{
			$filter_key 	= $this->filter_key;
			$filter_value 	= $this->filter_value;

            $data['url_suffix'] = '';
		}

		
		// pagination data

		$total_count 	= 	$this->COMP->count_all($table, $conditions);
		

		
		$subtitle_collumn 	= $this->subtitle_collumn;
		// get results
        $grouper_table_candidate = 'store';
		if($this->grouped)
		{

			$data['create_url_group'] = 	site_url('component/create/'.$grouper_table_candidate). $data['url_suffix'];
			$table_result 	= 	$this->COMPGR->get_grouped_for_table($table, $grouper_table_candidate, array($this->id_collumn, $this->title_collumn, $subtitle_collumn, 'position'), $conditions, $this->sortable_collumn);
		}else{
			$table_result 	= 	$this->COMP->get_tables($table, array($this->id_collumn, $this->title_collumn, $subtitle_collumn, 'position'), $conditions, $this->sortable_collumn);
		}

		// pass view data
		
		if(!$data['head'] 	= lang('comp_'.$table)){
			$data['head']	=	humanize($table); 
		} 
		$data['subHead']		            =	'Overzicht';
		$data['category_delete_permission']          = 	$this->permission->get('delete_'.$grouper_table_candidate);
		$data['list_delete_permission']          = 	$this->permission->get('delete_'.$table);
		$data['list'] 	= 	$table_result;		
		$data['component_group_table']     =   $grouper_table_candidate;
		$navUrlSubCat			            =	$filter_key;
		$data['navUrlSubCat']	=	$navUrlSubCat;
		$data['navSuffix'] 		= 	null;
		$data['create_url'] 	= 	site_url('component/create/'.$table). $data['url_suffix'];
		//tabs
		$data['options']		=	$this->tabs;		
		$data['titleVal']		=	$this->title_collumn;
		$data['subtitleVal']	=	$subtitle_collumn;
		

		$data['urlKey']				=	$this->id_collumn;
		$data['navUrlController']	=	'table';
		$data['navUrlVal']			=	$table;
        $data['component']			=	$table;

		
		$this->ac->place_header($data);
		$this->load->view('sortable_nav');
		$this->ac->place_footer();	
		
	}
	
	
}