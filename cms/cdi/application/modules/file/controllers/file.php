<?php


class file extends CI_Controller{

	private $thumbable_image_exts = array('jpg','jpeg','gif','png','svg');

	public function __construct()
	{

		parent::__construct();
		$this->load->library('api');
		$this->load->model('file_model', 'FILE');

	}

	public function convert()
	{
		$files = $this->db->get('file')->result();
		foreach($files as $file)
		{
			$old_file_name = FCPATH.'files/'.sha1('#'.$file->file_id);
			$new_file_name = FCPATH.'files/'.$file->sha1.'.'.$file->extension;

			if(is_file($old_file_name))
			{
				rename($old_file_name,$new_file_name);
				echo 'renamed '.$old_file_name.' to '.$new_file_name .'<br/>';
			}
		}
	}

	public function download($file_id)
	{
		$file_row = $this->db
			->from('file')
			->where('file_id',$file_id)
			->get()
			->row();
		if(!$file_row) show_404();

		$file_path = FCPATH.'files/'.$file_row->sha1.'.'.$file_row->extension;
		$download_file_name = (strstr($file_row->title,$file_row->extension)) ? $file_row->title : $file_row->title.'.'.$file_row->extension;


		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$download_file_name.'"'); //<<< Note the " " surrounding the file name
		header('Content-Transfer-Encoding: binary');
		header('Connection: Keep-Alive');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file_path));
		readfile($file_path);
		exit;
	}

	public function upload()
	{

		$file = array();
		if(isset($_FILES['file']))		$file =  $_FILES['file'];
		if(isset($_FILES['Filedata']))	$file =  $_FILES['Filedata'];

		if(!$file)$file['error'] =UPLOAD_ERR_NO_FILE;
		// ensure the file was successfully uploaded
		if($error = $this->_assertValidUpload($file['error']))
		{
			log_message('error',"file upload error: ".$error);
			$this->respond(array( 'error' => $error), 400);
		}

		$rawfile 	= 	file_get_contents($file['tmp_name']);
		$ext = 	strtolower(str_replace('.', '', strrchr($file['name'], '.')));

		$file_create_data['file_category_id'] 	= 	$this->input->post('file_category_id');
		$file_create_data['title']				=	$file['name'];
		$file_create_data['is_image'] 			=	in_array($ext, $this->thumbable_image_exts);
		$file_create_data['extension']			=	$ext;
		$file_create_data['sha1']				=	sha1($rawfile);
		$file_create_data['type']				=	$this->_get_file_type_by_extension($ext);

		//create file file in database
		$this->db->insert('file', $file_create_data);
		$file_id = $this->db->insert_id();

		// save file with id

		$file_url 	= 	$this->FILE->bin_to_url($rawfile, $ext);

		$this->respond(array( 'file_id' => $file_id, 'title' =>$file_create_data['title']), 201);
	}


	public function delete($file_id)
	{
		$this->_check_file_custody($file_id);

		$this->FILE->delete($file_id);
		$this->respond($file_id, 200);
	}


	public function update($file_id)
	{
		$this->_check_file_custody($file_id);

		$this->FILE->update($file_id,$this->input->post(null,true));
		$this->respond($file_id, 201);
	}

	public function get_name($file_id)
	{
		$file_row = $this->FILE->get($file_id);
		if($file_row)
		{
			$this->respond($title, 200);
		}else{
			$this->respond(null, 404);
		}
	}


	protected function respond($content,$http_code=200)
	{

		header('HTTP/1.1: ' . $http_code);
		header('Status: ' . $http_code);
		exit(json_encode($content));
	}
	private function _get_file_type_by_extension($ext)
	{
		switch($ext)
		{
			case 'jpg':
			case 'png':
			case 'bmp':
			case 'jpeg':

				return 'image';
				break;
			case 'mp4':
			case 'mpeg':
			case 'avi':
			case 'mov':
				return 'video';
				break;
			case 'pdf':
			case 'docx':
			case 'doc':
				return 'document';
				break;
			default:
				return 'unknown';
				break;
		}
	}
	private function _assertValidUpload($code)
	{
	    if ($code == UPLOAD_ERR_OK) {
	        return;
	    }

	    switch ($code) {
	        case UPLOAD_ERR_INI_SIZE:
	        case UPLOAD_ERR_FORM_SIZE:
	            $msg = 'file is too large';
	            break;

	        case UPLOAD_ERR_PARTIAL:
	            $msg = 'file was only partially uploaded';
	            break;

	        case UPLOAD_ERR_NO_FILE:
	            $msg = 'No file was uploaded';
	            break;

	        case UPLOAD_ERR_NO_TMP_DIR:
	            $msg = 'Upload folder not found';
	            break;

	        case UPLOAD_ERR_CANT_WRITE:
	            $msg = 'Unable to write uploaded file';
	            break;

	        case UPLOAD_ERR_EXTENSION:
	            $msg = 'Upload failed due to extension';
	            break;

	        default:
	            $msg = 'Unknown error';
	    }

		return $msg;
	}


	private function _check_file_custody()
	{
		return true;
	}

}