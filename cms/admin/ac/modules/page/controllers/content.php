<?php
class content extends CI_Controller{
	
	public  $language_id;
	
	// set our languages
	public 	$languages;
	
	public  $page_row;

	private $children;
	private $permissions;
	private $language;
	private $site_language_id;
	
	public function __construct()
	{
	   parent::__construct();	
		// Your own constructor code


		$this->load->model('page_model', 	'PAGE');
		$this->load->model('content_model', 'CONT');
		$this->load->model('language_model','LANG');
		// $this->load->library('setting');

		if($language_result = $this->LANG->get_languages()){
			$this->languages = $language_result;

		}else{
			die('no languages set!');
		}

		$this->site_id 				= $this->session->userdata('site_id');
		$this->language 			= $this->config->item('ac_language');
		$this->language_id 			= 1;
		$this->lang->load('editors');

				
	}	
	

	/////////////////////////////////////////////////
	//	 shows a list of this page's content	  ///
	/////////////////////////////////////////////////
	/**
	 * List
	 * @param  int $id id of page
	 */
	public function overview($id)
	{

		// permission check gate //
		///////////////////////////
		if(!$this->permission->get('read_content')) show_404();
		///////////////////////////
		//					 	 //
		$data['scripts'] 	= 	array('assets/js/jquery.ui.tabs.js', 'assets/js/callImgAreaSelect.js', 'assets/js/contentNav.js','assets/js/content_sort.js', 'assets/js/libs/youtubePicker/jquery.youtube-video-picker.js');
		$data['descr']		=	'ac_content_overview';

		// load page
		$page_select = 'page.*, description.*, template.description as template_description, fixed';	
		if(!$page_row = $this->PAGE->get_full($id,null, $page_select,$this->language_id,$this->site_id)) die('Wrong site or invalid page!');	
		
		
		$this->lang->load('list');
		// load custom libraries & resources //	tple_functions
		$this->load->helper('list');
		$this->load->helper('text');	
		$selectedLang 		= 	$this->uri->segment(3);
		$language_result 	= 	$this->languages;
		$data['languages']	=	$language_result;
		
		$children_count = $this->PAGE->count_children($page_row->page_id);
		$data['children'] 	= 	$children_count;
		$this->children 	= 	$children_count;
		
		// we set the tabs for our tab navigation

		

		if($parent_page_id = $page_row->parent_page_id && $parent_row = $this->PAGE->get_page_with_id($page_row->parent_page_id))
		{
		
			$group=$parent_row->group;

			switch($group)
			{
				case 'collection':
					$this->ac->set_active_key('page', $page_row->group);
					$data['head']			=	$parent_row->title;
					break;
				case 'levels':	// level
					// $group =$parent_row->fixed;
					$this->ac->set_active_key('page',  $page_row->fixed);
					$data['head']			=	$group;
					break;
				default: 
					$this->ac->set_active_key('page', $group);
					$data['head']			=	$group;
					break;
			}
		}else{
			$data['head']			=	'Pages';
			$this->ac->set_active_key('page', 'root');
			$fields['group'] ='default';
		}
		
		//page settings
		
		$data['subHead']		=	$page_row->title;
		$data['template_description'] = $page_row->template_description;
		$data['pageName'] 		= 	$page_row->url_name;
		$data['pageID'] 		= 	$page_row->page_id;
		$data['title']			=	$page_row->title;
		$data['currentEditor'] 	= 	$this->uri->segment(3); 
		$data['template'] 		= 	$page_row->template_id;

		// set permissions
		$data['permissions']['page_delete'] =   ($this->permission->get('delete_page') && !$page_row->fixed && !$page_row->children);
		$data['permissions']['create'] 	    = 	$this->permission->get('create_content');
		$data['permissions']['update'] 	    = 	$this->permission->get('update_content');
		$data['permissions']['delete'] 	    = 	$this->permission->get('delete_content');
		
		$this->permissions = $data['permissions'];
		
				
	
		
		// load content list OR editor
		
		$content = array();
		$contentSelect = 'content_type.title as typeTitle, content_description.title, content_description.sub_title, content.content_id,  restricted, language_dependant, template_section_id';
		
		$contentResult = $this->CONT->get_content_by_page_id($page_row->page_id, $this->language_id, $contentSelect, true);
		$sectionResult = $this->CONT->get_content_sections($page_row->template_id);
	
		if($contentResult)
		{
			foreach($contentResult as $i => $contentRow)
			{
				$content[$contentRow->template_section_id][] = $contentRow;
			}
		}
		$content_no_active_section = $contentResult;
		if($sectionResult)
		{
			foreach($sectionResult as $section)
			{
				$data['contentTypes'][$section->template_section_id] = $this->get_content_types($section->template_section_id);
				if($contentResult)
				{
					foreach($contentResult as $value => $content_result)
					{
						if($content_result->template_section_id==$section->template_section_id)
						{
							unset($content_no_active_section[$value]);
						}
					}
				}
			}
		}

		//unassigned content items are put here
		
		$unassigned = (object)array(
		 'title'				=>	'unassigned', 
		 'template_section_id' 	=> 	0
		);
		// modify rights are given in parameters
		$data['sections'] 	= 	($sectionResult)? 	array_merge($sectionResult) :	array(0 => $unassigned);
		$data['content']	=	$content;
		$data['content'][0] = 	$content_no_active_section;

		//load the content view
		$this->ac->place_header($data);
		$this->load->view('navigation/content_nav');
		$this->ac->place_footer();
	}
	
	/////////////////////////////////////
	//	Edit a single content item	  ///
	/////////////////////////////////////
	/**
	 * general form
	 * @param  int $id         		page_id
	 * @param  [type] $content_id [description]
	 * @return [type]             [description]
	 */
	public function form($id, $content_id=null)
	{
		$this->load->helper('cdi');
	
		if(!$this->page_row = $this->PAGE->get_page_with_id($id,null, '*',$this->language_id))	die('invalid page!');
		
				
		// get language file for editors
		$this->lang->load('editors');
		
		// load editor using the content library		
		$this->lang->load('form');

		$contentSelect 		= 'content_id, editor, page_id, language_dependant, file_id, content_type.title as type_title';
		$contentDescrSelect = 'content_description_id, language_id, title, sub_title, content';
		
		$content_row 			= 	$this->CONT->get_content($content_id,  $contentSelect);
		$content_descr_result 	=	$this->CONT->get_content_descr($content_id, $contentDescrSelect);
		
		
		// set fields
		if(count($content_descr_result) > 1 || $content_row['language_dependant'])
		{
			foreach($this->languages as $language_row)
			{
				$data['fields'][$language_row->language_id]['title'] 		= '';
				$data['fields'][$language_row->language_id]['sub_title'] 	= '';
				$data['fields'][$language_row->language_id]['content'] 		= '';
			}

			foreach($content_descr_result as $content_descr_row)
			{
				
				$data['fields'][$content_descr_row['language_id']] = $content_descr_row;
			}
			// set for not multilanguage gallery
			$data['fields']['title'] 		= $content_descr_result[0]['title'];
			$data['fields']['content'] 		= $content_descr_result[0]['content'];
			$data['fields']['sub_title'] 	= $content_descr_result[0]['sub_title'];
			
			
		}else
		{
			$data['fields'] = $content_descr_result[0];
			
		}

		$data['hidden']	= $content_row;
		$data['content_type_form']	= $content_row['editor'];
		$data['fields']['file_id']	= $content_row['file_id'];
		$data['languages']		=	$this->languages;
		$data['content_id']		=	$content_row['content_id'];
		$data['pageID']			=	$this->page_row->page_id;
		$data['hidden']['page'] = 	$data['pageID'];
		
		
		if($this->input->is_ajax_request() == true)
		{
			$this->load->view('/forms/content/content_form_container', $data);
		}else{
			$this->ac->load_view_with_wrapper('/forms/content/content_form_container', $data);

		}
			
			
			// finish the view with footer
	}
	

	
	/**
	 * *******************
	 *	Update content   *
	 *********************
	 * @see Update Content
	 * @description uses post data
	*/
	
			
	public function update_content()
	{
		$lang_dependant = $this->input->post('language_dependant');
		// permission check gate //
		///////////////////////////
		
		if(!$this->permission->get('update_content')) show_404();
		///////////////////////////
		//					 	 //

		$content_id 	= $this->input->post('content_id');
		//  get variables from post using 'input'  class 
		$id		= 	$this->input->post('page');
		
		$post['title'] 		= $this->input->post('title');
		$post['sub_title'] 	= $this->input->post('sub_title');
		$post['content'] 	= $this->input->post('content');

		
		$content_data = array();
		$content_data['randomize_answers']  = $this->input->post('randomize_answers');
		$content_data['file_id'] 			= $this->input->post('file_id');
		
		if( $content_data['file_id'] || $content_data['randomize_answers'])
		{
			$this->db
				->where('content_id',$content_id)
				->update('content', $content_data);
		}

		if($lang_dependant==1)
		{
			foreach($this->languages as $language_row) 
			{
				$lang_id = $language_row->language_id;
				
				//if given input is an array, make it multilanguage
				//else give both languages the given input value
				foreach ($post as $key => $item) {
					if(is_array($item)){
						if($key == 'content' && $this->input->post('serialize') == 1)
							$values[$lang_id][$key]	= implode(',', $post[$key]);
						else
							$values[$lang_id][$key]	= $post[$key][$lang_id];
					} else {
						$values[$lang_id][$key]	= $post[$key];
					}
				}	
			}
			// save changes to database 	//
			foreach($values as $lang_id => $value){
				$this ->CONT->update_content_description($content_id, $value, $lang_id);
			}

		}else{
			//$lang_id = $this->languages[0]->language_id;
			
			foreach($this->languages as $language_row) 
			{
				$lang_id = $language_row->language_id;
				
				$values = array(
				 'title' 		=> $post['title'],
				 'sub_title' 	=> $post['sub_title'],
				 'content' 		=> $post['content']
				);
				
				$this->CONT->update_content_description($content_id, $values, $lang_id);
			}
		}
		$content_data = array('file_id'=>$this->input->post('file_id'));
		
		$content_row = $this->CONT->get_content($content_id, 'content_type.title as content_type');
		$content_description_ids 	= $this->input->post('content_description_id');

		
		// indicate save was successfull and redirect user	///
		$result = $this->lang->line('success_content_saved') ;
		$this->output->set_status_header('201');
		$this->output->set_output($result);
		
	}

	
	/**
	 * *******************
	 *	Delete content   
	 *
	 * @see Delete Content
	 * @param $content_id - id of the content to be deleted
	*/

	public function delete_content($content_id)
	{
		// permission check gate //
		///////////////////////////
		if(!$this->permission->get('update_content')) show_404();
		///////////////////////////
		//					 	 //
		
		$this->CONT ->delete($content_id);
		$this->CONT->delete_content_descr($content_id);
		
		$this->session->set_flashdata('ac_cms_message', $this->lang->line('success_content_deleted'));
		
	
		redirect($this->input->server('HTTP_REFERER', TRUE));
		
		
	}
	
	/********************************
	 *	Create content   
	 *
	 * @see Create Content db call
	*/
	public function create_content()
	{
		// permission check gate //
		///////////////////////////
		if(!$this->permission->get('create_content')) show_404();
		///////////////////////////
		//					 	 //
		
		$content_type_id 		= $this->input->post('type');
		$page_name				= $this->input->post('pageName');
		$page_id 				= $this->input->post('pageID');
		$template_section_id 	= $this->input->post('section_id');	
		
		$content_type 			= $this->CONT->get_content_type($content_type_id);
		$content_count			= $this->CONT->count_for_page_and_section($page_id, $template_section_id);

		$contentProperties = array(
			'page_id'				=> 	$page_id,
			'content_type_id'		=>  $content_type_id,
			'sort_order'			=>	$content_count + 1,
			'template_section_id'	=>	$template_section_id
		);
		
		// language checker
		$content_id = $this->CONT->insert($contentProperties);
		
			
		$descrProperties['content_id']	=	$content_id;
		
		if(!isset($descrProperties['title']))
		{
			$descrProperties['title']		=	lang('content_type_title_'.$content_type->title);
		}
		$language_id = $this->setting->get('language_id');
		
		foreach($this->languages as $language_row)
		{
			$descrProperties['language_id'] = $language_row->language_id;
			$this->CONT->insert_description($descrProperties);
		}
		
		$this->session->set_flashdata('ac_cms_message', $this->lang->line('success_content_added'));
		
		redirect($this->input->server('HTTP_REFERER'));
	}


	
	   
	public function get_content_types($section_id=null)
	{
		
		$types			= $this->CONT->get_content_types('*',$section_id);
		
		foreach($types as $type){
			$label = $this->lang->line('content_type_title_'.$type->title);;
			if(!$label) $label = humanize($type->title);
			$contentTypes[$type->content_type_id]= $label;
		}
		
		return $contentTypes;
	}
		
   
		
	public function update_section_order()
	{
		$params = $this->input->post('items');

		if((isset($params['section_id'])) && (isset($params['content_id'])))
		{
			$data = array('template_section_id'=> $params['section_id']);
			$this->CONT->update_content_order($params['content_id'], $data);
		}
		
		if(isset($params['list']))
		{
			$listData = array();
			
			foreach($params['list'] as $i => $content_id)
			{
				if($content_id)
				{
					$listData[] = array('sort_order' => $i, 'content_id' => $content_id);
				}
			
			}
			
			if($listData){
				$this->db->update_batch('content', $listData, 'content_id');
			}
		}
		
	}
	
}