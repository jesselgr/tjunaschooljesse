<?php
class Blog_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    /**
    * get database tabel entries
    * @return [query]
    */
    function get_entries()
    {
        $query = $this->db->get('entries');
        return $query;
    }
    /**
     * get database tabel comments
     * @return [query]
     */
    function get_comments()
    {
        $this->db->where('entry_id', $this->uri->segment(3));
        $query = $this->db->get('comments');
        return $query;
    } 

    function get_subtitle()
    {
        $this->db->where('topic_id', $this->uri->segment(3));
        $query = $this->db->get('entries');
        return $query;
    }
    /**
     * insert entries into database
     */
    function insert_entry($data)
    {
        $this->db->insert('entries',$data);
    }
    /**
     * insert comments into database
     */
    function insert_comments($data)
    {
        $this->db->insert('comments',$data);
    }
    /**
     * delete comments 
     */

    function delete_comments($data)
    {
        
        $this->db->delete('comments',$data);
        $comment_id = $_POST['delete_id'];
        $query = "delete from comments where ID = $comment_id";
        return $query;
    }

    function edit_comments($data)
    {
        $comment_id = $_POST['comment_id'];
        $body = $_POST['edit_body'];

        $data = array(
            'body' => $body
            );

        $this->db->where('comment_id', $comment_id);
        $this->db->update('comments',$data);
        
        $result = array(
            'comment_id'=>$comment_id,
            'message'=>$body,
           
        );
        return $result;
    }
}