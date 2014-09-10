<?php
class page extends CI_Controller{
	
	public 	$page_names;
	public 	$lang_result;
	public 	$page_templates;
	public 	$language_id;
	public 	$nav;
	
	//////////////////////////////////////////////////////////////////
	// 		controller page voor managen ac pagina's	  		//
	//////////////////////////////////////////////////////////////////
	// 																//
	//////////////////////////////////////////////////////////////////
	
	public function __construct()
    {
       parent::__construct();
       	
		$this->lang->load('form');
		
		$this->load->model('language_model', 'LANG');
		$this->load->model('page_model', 'PAGE');
		$this->load->model('setting_model', 'SETT');
		$this->lang_result = $this->LANG->get_languages();
		
		$this->site_id 	= $this->session->userdata('site_id');
		$this->site_info = $this->SETT->get_site($this->site_id);
	//$this->language_ids = $this->config->item('ac_languages');
	//if($this->config->item('custom_cache_end_page_nav')== false){
	
			$this->load->library('navigation',array('lang'=>$this->language_id,'site_id'=>$this->site_id));
			
		//}
		
		
		$this->language_id = $this->config->item('site_language');
		
		
    }	
    
	
	
	public function children($page_name)
	{
		
		$this->ac->set_active_key('page', $page_name);
		
		$this->load->helper('inflector');
		$this->load->library('navigation');	
		if($page_name == 'root')
		{
			$page_tree = ($this->config->item('custom_cache_end_page_nav')) ? $this->load->view('generated/adminPageNav',null, true): $this->navigation->generate_page_tree('root', false, null, false,true,true);


			$data['head']				=	'Pages';
			$data['subHead']			=	$this->lang->line('page_subhead_overview');
			$data['page_id'] 			= 	'root';
			$data['parent_page_id'] 	= 	'root';
			$data['page_title']			= 	"Pages";
			$data['page_locked']		=	false;
			$data['create_button_text']	= 'Page';
			if($this->permission->get('sort_pages'))
				$data['scripts']	=	array('assets/js/pagesort.js', 'assets/js/pageNav.js', 'assets/js/libs/jquery.ui.nestedSortable.js');
		
		
		
		}else{
			$pageSelect = array('restricted', 'page.page_id', 'fixed','title', 'sub_title', 'fixed','group');
			$page_row = $this->PAGE->get_page_by_fixed($page_name,null, $pageSelect, $this->language_id);
			
			if(!$page_row) show_error('this page requires a valid fixed name!');
			$page_tree = $this->navigation->generate_page_tree($page_row->page_id, false, null, false, null, false);


			$data['head']			=	$page_row->group;
			$data['subHead']		=	$page_row->title;
			$data['scripts']		=	array('assets/js/pagesort.js', 'assets/js/pageNav.js', 'assets/js/libs/jquery.ui.nestedSortable.js');
			$data['page_locked']	= 	$page_row->restricted;
			$data['page_id']		= 	$page_row->page_id;
			$data['page_title']		= 	$page_row->title;

			$data['sub_page_name']		= (strstr($page_name,'level'))? 'Subject' : lang('page_create_button');
			$data['create_button_text'] = 'add';
		}
		
		// load the initiation for the sortable page browser, including the js for page sorting
	
		// get the pages we want to show
		$data['pageTree'] = $page_tree;

		$this->ac->place_header($data);
		$this->load->view('navigation/page_nav');	
		$this->ac->place_footer();
	}
		
	
	///////////////////////
	//  create new page	 //
	///////////////////////
	/**
	 * @param $parent_page_id int id of parent page
	 */
	
	public function create($parent_page_id = null)
	{
		
	// permission check gate //
	///////////////////////////
	if(!$this->permission->get('create_page'))show_404();
	///////////////////////////
	//					 	 //
	
		if($this->_validate_form())
		{
			$this->_update();
			// indicate save was successfull and redirect user	///
			$result = $this->lang->line('success_page_saved') ;
			$this->output->set_status_header('201');
			$this->output->set_output($result);
		}else{
			$data['head']			=	$this->lang->line('page_head');
			$data['subHead']		=	$this->lang->line('create_page_subhead');
			$data['scripts']			=	array('assets/js/pageUrlNameCheck.js','assets/js/pageForm.js', 'assets/js/callImgAreaSelect.js');
			$data['form_will_create']	=	true;
			$attribute_collumns = $this->PAGE->get_description_collumns();


			$fields	= array_fill_keys(array_values($this->PAGE->get_collumns()), null);
			$fields['parent_page_id'] = $parent_page_id;
			if($parent_page_id)
			{
				$parent_row = $this->PAGE->get_page_by_id($parent_page_id);
				if($parent_row)
				{
					$fields['group'] =$parent_row->group;
					switch($parent_row->group)
					{
						case 'new-arrivals':
							$fields['template_id'] ='13';
						break;
						case 'collection':
							$data['head']			=	$parent_row->title;
							break;
						case 'levels':	// level
							$group =$parent_row->fixed;
							$data['head']			=	$group;
							$fields['template_id'] 	=	'3';
							$fields['group'] 		=	$parent_row->fixed;
							break;
						default: 
							$data['head']			=	$group;
							break;
					}
				}
				
			}else{
				$fields['page_group'] ='default';
			}
			foreach($this->lang_result as $i =>$lang_row)
				$fields['attributes'][$lang_row->language_id] 	= 	array_fill_keys(array_values($attribute_collumns),null);
			
			$this->ac->place_overlay_header( $data);
			$this->_form( $fields, $this->permission->get('update_page_full'));
			$this->ac->place_overlay_footer();
		}
	}
	
	
	
	
	
	////////////////////////////////////////////
	// 	  index shows a page editing form	 ///
	////////////////////////////////////////////
		
	public function modify($id)
	{
		
		// permission check gate //
		///////////////////////////
		if(!$this->permission->get('update_page')) show_404();
		///////////////////////////
		//					 	 //

		if($this->_validate_form())
		{	
			$this->_update($id);
			// indicate save was successfull and redirect user	///
			$result = $this->lang->line('success_content_saved') ;
			$this->output->set_status_header('201');
			$this->output->set_output($result);
		}else{
			
			// get resources

			$this->load->helper('list');
	//		$this->_get_page_list();
			
			$pageSelect = array('page.page_id', 'title', 'sub_title', 'template_id', 'site_id', 'parent_page_id', 'nav_prio', 'in_menu', 'mobile_thumb', 'thumb', 'fixed','group');
			
			
			$page_row = $this->PAGE->get_page_with_id($id,null, $pageSelect, $this->language_id, $this->site_id);
			if(!$page_row)die('Wrong site or invalid page!');
						
			// load resources //	
			$pageLangAttributes = 	$this -> PAGE -> get_page_description($page_row->page_id);
			$childrenCount 		= 	$this -> PAGE -> count_children($page_row -> page_id);
			
			
			
			$data['children'] 	= 	$childrenCount;
			
			// we set the tabs for our tab navigation
				
			//page settings
			$data['head']				=	$page_row->group;
			$data['subHead']			=	$page_row -> title;
			$data['currentController'] 	= 	'page';
			$data['form_will_create']	=	false;
			$data['scripts']			=	array('assets/js/pageUrlNameCheck.js','assets/js/pageForm.js', 'assets/js/callImgAreaSelect.js');

			$data['parent']			=	$page_row->parent_page_id;
			$fields					= 	get_object_vars($page_row);		


			foreach($this->lang_result as $i =>$lang_row) 
			{
				foreach($pageLangAttributes[0] as $collumn => $value)
					$fields['attributes'][$lang_row->language_id][$collumn] = "";
			}

			foreach($pageLangAttributes as $langAttribute)
			{
				foreach( $langAttribute as $collumn => $value)
					$fields['attributes'][$langAttribute->language_id][$collumn] = $value;
			}

			$this->ac->place_overlay_header( $data);
			$this -> _form($fields,($this->permission->get('update_page_full')));
			$this->ac->place_overlay_footer();
		}
	}
	
	
	private function _form($fields, $full = false)
	{
		$this->load->helper('object');
		$this->load->helper('language');
		$this->_get_page_list();
		foreach($this->lang_result as $i =>$lang_row) 
			$data['languages'][$lang_row->language_id]=$lang_row;
		
		if(!$fields) 
			show_error('form failed to load: incorrect page');
	
		$data['page'] = array_to_object(($post_data = $this->input->post(null,true)) ? $post_data : $fields);
		

		$page_id 	= $fields['page_id'];

		// $this->db
		// 	->join('template_setting','template_setting.template_setting_id = template_setting_value.template_setting_id')
		// 	->get('template_setting_value')
		
		
		$data['pageTemplates']	=	$this->page_templates;
		$data['pageNames'] 		= 	$this->page_names;
		$data['formAction']		=	current_url();
		
		$this->load->view(($full)? '/forms/page/pageForm' : '/forms/page/pageFormSimple',$data);
	}
	
	
	public function change_navprio()
	{

		$this->load->model('page_model', 'PAGE');
		
		$data = array();	
		 if($this->input->post('items'))
		 {
			$data =$this->input->post('items');
			$this->PAGE->update_page_batch($data);
			
			foreach ($data as $key => $value) 
			{
				$this->_update_parenthood($value['page_id']);
				$this->_update_parenthood($value['parent_page_id']);
			}
		}
        $this->_update_references();
        
    } 
 
	private function _get_page_list($exclude_id=false)
	{
		$this->load->model('page_model', 'PAGE');
		$this->load->library('navigation');
		$this->load->helper('list');
		
		$template_result = $this->PAGE-> get_templates();
		
		$page_names["root"] ="*No parent page*";
		
		// 			get pages	  		//	
		$page_result = $this->PAGE-> get_pages(null, false, array('page.page_id', 'description.url_name', 'title', 'parent_page_id', 'depth'),false,null,$this->language_id,$this->site_id);
		
		
		if($page_result)
		{
			foreach ($page_result as $page_row) 
				$page_names[$page_row->page_id] = str_repeat('-',$page_row->depth) . $page_row->title;
			
			
			// 			get templates	  		//
			$page_templates = ($template_result != NULL) ? select_list_items($template_result,'template_id','title'):	array(0 => 'No templates');

		/* if there are no pages */ 
		}else{
			$page_names		= 	array("root" => "*No parent page*");
			$page_templates	= 	array(0 => 'No templates');
		}

		if($exclude_id)
			unset($page_names[$exclude_id]);
		

		$this->page_names 		= 	$page_names;
		$this->page_templates 	= 	$page_templates;
	}
	
	
	//////////////////////////////////////////////////////////////////////////////
	//  	create content based on db-saved presets for the given template 	//
	//////////////////////////////////////////////////////////////////////////////
	
	private function _generate_page_content($page_id, $template_id)
	{
		// we'll be working with content, so we use the content model
		$this->load->model('content_model', 'CONT');

		//temp static
		$languages = $this->PAGE->get_languages();

		// we get the preset content types for our given template
		if($content_types = $this->CONT->get_content_types_per_template($template_id))
		{
		
			// for each preset content type we create one in the content table
			foreach($content_types as $type){
				
				$content['page_id'] 				= 	$page_id;
				$content['content_type_id'] 		= 	$type->content_type_id;
				$content['template_section_id']		=	$type->template_section_id;
				$content['restricted']				=	$type->restricted;
				
				$id = $this->CONT->insert($content);
				
				// we create seperate content for each language
				foreach($languages as $language){
					
					$lang = $language->language_id;
					
					$contentDescr[$lang]['content_id'] 		=	$id;
					$contentDescr[$lang]['language_id'] 	=	$lang;			
					$contentDescr[$lang]['title'] 			= 	$type->title;
					$contentDescr[$lang]['sub_title'] 		= 	$type->sub_title;
					$contentDescr[$lang]['content']			=	$type->description;			
												
				}
				$this->CONT->insert_descriptions($contentDescr);	
			}
		}
	}

	private function _validate_form()
	{
		$this->load->library('form_validation');
		foreach($this->lang_result as $lang_row)
		{
			$this->form_validation->set_rules('attributes['.$lang_row->language_id.'][title]', 'lang:form_page_title'.' ('.$lang_row->name.')' , 'required');
			// $this->form_validation->set_rules('attributes['.$lang_row->language_id.'][url_name]', 'lang:form_page_title'.' ('.$lang_row->name.')' , 'required');
		}
		
		$this->form_validation->set_rules('template_id',  	'lang:form_page_template_id', 'required|is_numeric');
		$this->form_validation->set_rules('parent_page_id',  'lang:form_page_parent_page_id', 'required|alpha_numeric');
		
		
		return $this->form_validation->run();
	}	
	
	///////////////////////////////////////////////////
	//  				update/create page 			 //
	///////////////////////////////////////////////////
	
	
	/**
	 * Update page
	 * @param  int $id [description]
	 * @return [type]      [description]
	 */
	private function _update($id = false)
	{
		
		// permission check gate //
		///////////////////////////
		if(!$this->permission->get('update_page')) show_404();
		///////////////////////////
		//					 	 //
		
		$navprio 			= 	(int)$this->input->post('nav_prio');
		$parent_id 			= 	$this->input->post('parent_page_id');
		$page_attributes 	= 	$this->input->post('attributes',true);
		
		// genereer de navprioriteit   //
		$siblings 	= 	$this->PAGE->count_children($parent_id);
		if($parent_id != 'root') $siblings=$siblings+2;
		
		if(!$navprio || $navprio == 0)$navprio 	= 	$siblings++;
		
		//check for empty date, if empty, create now date


		// eigenschappen van de pagina opslaan in de database //
		$page_data['nav_prio'] 			= 	$navprio;
		$page_data['parent_page_id'] 	= 	$parent_id;
		$page_data['site_id'] 			= 	$this->site_id;
		$page_data['in_menu'] 			= 	$this->input->post('in_menu');
		$page_data['template_id'] 		= 	$this->input->post('template_id');
		$page_data['thumb'] 			= 	$this->input->post('thumb');
		$page_data['fixed'] 			= 	$this->input->post('fixed');
	
		
		// insert page into db
		if(!$id) 
		{
			$id = $this ->PAGE ->insert_page($page_data);
			$create = true;
		}else{
			$this -> _update_parenthood($id);
			$this -> _update_parenthood($parent_id);
			$this ->PAGE-> update_page($id, $page_data);
			$create = false;
		}
		
		
		//Check for url name in form
		foreach($this->lang_result as $lang_row)
		{
			$lang_id 	=	$lang_row->language_id;
			$name 		= 	$page_attributes[$lang_id]['url_name'];
			//make sure our urlname is unique
			while($this->PAGE->check_page_name_exists($name, $parent_id, $id)) $name.=$this->config->item('duplicate_page_add');		
			
				
			$page_attributes[$lang_id]['url_name']		= 	$name;
			$page_attributes[$lang_id]['page_id'] 		= 	$id;
			$page_attributes[$lang_id]['language_id'] 	= 	$lang_id;
		}
		$this->PAGE->update_page_description($id, $page_attributes);
		
		// $this->session->set_flashdata('ac_cms_message', $this->lang->line('success_page_saved'));
		// update generated navigations
		$this->_update_references();
		
		if($create == true)	$this->_generate_page_content($id, $page_data['template_id']);
		
		// redirect(site_url(array('page/content/overview',$id)));
		
	}

	///////////////////////////////////////////////////
	//  				 DELETE page 				 //
	///////////////////////////////////////////////////
	
	
	public function delete($page_id, $route=null,$type=null)
	{
		// permission check gate //
		///////////////////////////
		if(!$this->permission->get('delete_page')) show_404();
		///////////////////////////
		//					 	 //
		if(!$route)$route = base_url();
		$this->load->model('content_model', 'CONT');
		$delpage = $this->PAGE->get_page_with_id($page_id,null,'parent_page_id', $this->language_id, $this->site_id);
		$this->_update_parenthood($delpage->parent_page_id);

		$this->PAGE->delete('page',$page_id);
		$this->PAGE->delete_page_description($page_id);
		$this->CONT->delete_by_page_id($page_id);
			
		if($cont	=	$this->CONT->get_content_by_page_id($page_id, null, array('content.content_id')))
		{
			foreach ($cont as $row)
				$this->CONT->delete_content_descr($row->content_id);
		}
		
		$this->session->set_flashdata('ac_cms_message', $this->lang->line('success_page_deleted'));
		$this->_update_references();
		redirect($route);
		
		
	}
	
	
	
	
	
	/////////////////////////////////////////////////////////////////////////
	///	execute functions that update the static views referring to pages ///
	/////////////////////////////////////////////////////////////////////////
	
	private function _update_references()
	{
		$this->load->library('navigation');	
		$this->navigation->generate_all_navigations();
	}
	
	
	
	private function _update_parenthood($id = 'root')
	{
		if ($id == 'root') return;
		$children 	= 	$this->PAGE->count_children($id);
		$page_data['children'] 		= 	($children != 0);
		$this -> PAGE -> update_page($id, $page_data);
		
	}
	

}