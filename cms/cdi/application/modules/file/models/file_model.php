<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class file_model extends CI_Model {

	private $file_path 		= 	"files/";
	private $file_icon_path	=	"assets/img/ac/filetypes/big/";

    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }

	function get($image_id)
	{
		return  $this->db
		->get_where('file', array('file_id' => $image_id))
		->row();
	}


	public function update_image($bin, $image_id)
	{
		$url = $this->bin_to_url($bin, '#'.$image_id);
		return $url;
	}

	public function update($file_id, $data)
	{
		$this->db
			->where('file_id', $file_id)
			->update('file',$data);
	}

	public function delete($file_id)
	{
		$file_row= $this->db
			->where('file_id',$file_id)
			->get('file')
			->row();

		$this->load->helper('file');
		if($img_url = $this->get_file_url($file_row->sha1, $file_row->extension))
		{
			$other_file_count = $this->db
				->where('sha1',$file_row->sha1)
				->where('extension',$file_row->extension)
				->from('file')
				->count_all_results();

			$img_loc 	= FCPATH.$img_url;
			if($other_file_count == 0 && is_file($img_loc) === true) unlink($img_loc);
			$this->db->delete('file', array('file_id' => $file_id));
		}
	}

	/**
	 * [get_file_url description]
	 * @param  string $bin_sha1 file sha1 hash
	 * @param  string $ext      file extension
	 * @return string           absolute path to file
	 */
	public function get_file_url($bin_sha1, $ext)
	{
		return $this->file_path.$bin_sha1.'.'.$ext;
	}


	/*
	*	@param $url
	*	returns binary
	*/
	function url_to_bin($file_path)
	{
		$bin = (is_file($file_path) === true) ? read_file($file_path) : null;
		return ($bin);
	}


	/*
	*	@param $bin
	*	@param $name
	*	returns url
	*/
	function bin_to_url($bin,$ext)
	{
		$ext = strtolower($ext);
		$this->load->helper('file');
		$file_path = $this->get_file_url(sha1($bin),$ext);

		if(is_file(FCPATH.$file_path) === true) unlink(FCPATH.$file_path);
		write_file($file_path, $bin);

		return $file_path;
	}


}