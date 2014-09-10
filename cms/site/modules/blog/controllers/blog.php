<?php
class Blog extends CI_Controller {
/**
 * load model library
 */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model','BLOG');
        $this->load->library('template');
    }
    /**
    * get title header css
    * get all entries
    * @return [view]
    */
    function index()
    {
        $data['title']      = "Blog";
        $data['heading']    = "Berichten";
        $data['css'][]      = 'style2';

        $query              = $this->BLOG->get_entries();
        $data['result']     = $query->result_array();

        $this->template->place_header($data);
        //$this->load->view('blog_view', $data);
        $this->template->place('blog/blog_view',$data);
        $this->template->place_footer($data);
    }
    /**
    * get title header 
    * @return [view]
    */
    function entry()
    {
        $data['title']  = "Toevoegen";
  	    $data['heading']= "Voeg bericht toe";

 	    $this->template->place_header($data);
        $this->load->view('entry_view', $data);
        $this->template->place_footer($data);
    } 
    /**
    * send entries to blog_model
    * @return [redirect]
    */
    function entry_insert()
    {
        //$data['query'] = $this->BLOG->insert_entry();
        //redirect('blog');
        $data['topic_entry']= $this->input->post('topic_entry');
        $data['title']      = $this->input->post('title');
        $data['body']       = $this->input->post('body');
        $data['user']       = $this->input->post('user');

        $this->BLOG->insert_entry($data);
        $data['topic_id'] = $this->db->insert_id();
        echo json_encode($data);
    }
    /**
    * get all comments 
    * @return [view]
    */
    function comments()
    {
        $data['title']      = "Reacties";
        $data['heading']    = "Reacties";
        
        $query              = $this->BLOG->get_comments();
        $data['result']     = $query->result_array();
        $data['has_items']  = (bool)($query->num_rows() > 0);

        $this->template->place_header($data);
        $this->template->place('blog/comment_view',$data);
        // $this->load->view('comment_view', $data);
        $this->template->place_footer($data);
    }

    /**
    * send comments to blog_model
    * @return [redirect]
    */
    function comment_insert()
    {
        $data['title']     = $this->input->post('title');
        $data['body']       = $this->input->post('body');
        $data['entry_id']   = $this->input->post('entry_id');
        $data['user']       = $this->input->post('user');

        $this->BLOG->insert_comments($data);
        $data['comment_id'] = $this->db->insert_id();
        echo json_encode($data);
        // redirect('blog/comments/'.$_POST['entry_id']);
    }

    /**
     * [comment_delete description]
     * @return [type]
     */
    function comment_delete()
    {
        // declare $data 
        $data['comment_id']     = $this->input->post('delete_id');

        $result = $this->BLOG->delete_comments($data);
        echo json_encode(array('message'=>$result));
    }

    /**
     * [comment_edit description]
     * @return [type]
     */
    function comment_edit()
    {
        $data['comment_id']         = $this->input->post('comment_id');
     
        $result = $this->BLOG->edit_comments($data);
        echo json_encode($result);
    }
} 