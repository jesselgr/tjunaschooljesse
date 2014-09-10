<?php
class Forum extends CI_Controller {

	 public function __construct()
    {
        parent::__construct();
        $this->load->model('Forum_model','FORUM');
        //$this->load->model('Blog_model','BLOG');
       	$this->load->library('template');
    }

	function index()
    {
        $data['title']      = "Forum";
        $data['heading']    = "Forum";
        $data['css'][]      = 'style2';

        $query              = $this->FORUM->get_category();
        $data['result']     = $query->result_array();

        $this->template->place_header($data);
        $this->template->place('blog/forum_view',$data);
        $this->template->place_footer($data);
    }

    function category()
    {
    	$data['title']      = "Topics";
        $data['heading']    = "Topics";
        $data['css'][]      = 'style2';
        $query              = $this->FORUM->get_topics();
        $data['result']     = $query->result_array();
        //$data['has_items']  = (bool)($query->num_rows() > 0);

        $this->template->place_header($data);
        $this->template->place('blog/blog_view',$data);
        $this->template->place_footer($data);
    }
}