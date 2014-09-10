<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class graphic extends CI_Controller {

	private $scale = 1;
	private $dimensions = array(
	'square'			=> array(100, 100),
	'browser'			=> array(80,80),
	'checkbox_images'	=> array(450,250),
	'mpc_images'		=> array(450,250),
	'largeButtonImage'	=> array(400,300),
	'profile'			=> array(250,250)
	);


	private $thumbable_image_exts = array('jpg','jpeg','gif','png','svg');
	private $default_error_url = "assets/img/NoImageIcon.jpg";
	private $upload_img_url = "assets/img/add_item.jpg";
	 
	public function __construct()
	{
		
		parent::__construct();	
		$this->load->model('file/image_model', 'IMG');
		
	}
		
	

	public function getImage($file_id=0, $natural = 0) 
	{

		$img_url =($file_id == 0) ? $this->upload_img_url : $this->IMG->get_img_url_for_file_id($file_id) ;
	
		
		$this->_display_image($img_url, ($natural==1) ? null : 'square');			
	}


	public function getVideo($file_id=0) 
	{
		$img_row =$this->IMG->get_row_for_file_id($file_id);
		
		// var_dump($img_url);
		if($img_row) 
			$this->_display_video($img_row->url,$img_row->extension);			
	}
	
	

	private function _display_video($given_url)
	{	
		$file = FCPATH.$given_url;
		$fp = @fopen($file, 'rb');

		$size   = filesize($file); // File size
		$length = $size;           // Content length
		$start  = 0;               // Start byte
		$end    = $size - 1;       // End byte

		header('Content-type: video/mp4');
		header("Accept-Ranges: 0-$length");
		if (isset($_SERVER['HTTP_RANGE'])) {

		    $c_start = $start;
		    $c_end   = $end;

		    list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
		    if (strpos($range, ',') !== false) {
		        header('HTTP/1.1 416 Requested Range Not Satisfiable');
		        header("Content-Range: bytes $start-$end/$size");
		        exit;
		    }
		    if ($range == '-') {
		        $c_start = $size - substr($range, 1);
		    }else{
		        $range  = explode('-', $range);
		        $c_start = $range[0];
		        $c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
		    }
		    $c_end = ($c_end > $end) ? $end : $c_end;
		    if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
		        header('HTTP/1.1 416 Requested Range Not Satisfiable');
		        header("Content-Range: bytes $start-$end/$size");
		        exit;
		    }
		    $start  = $c_start;
		    $end    = $c_end;
		    $length = $end - $start + 1;
		    fseek($fp, $start);
		    header('HTTP/1.1 206 Partial Content');
		}
		header("Content-Range: bytes $start-$end/$size");
		header("Content-Length: ".$length);


		$buffer = 1024 * 8;
		while(!feof($fp) && ($p = ftell($fp)) <= $end) {

		    if ($p + $buffer > $end) {
		        $buffer = $end - $p + 1;
		    }
		    set_time_limit(0);
		    echo fread($fp, $buffer);
		    flush();
		}

		fclose($fp);
		exit();
	
	}

	
	

	private function _display_image($given_url, $preset=null)
	{	

		$this->load->model('cache_model','CACHE');
		$this->load->model('file/file_model', 'FILE');
		$this->load->helper('file');
		$scale = $this->scale;
		if(!$given_url ||  is_file(FCPATH.$given_url)== false)
		{	
			$given_url = $this->default_error_url;
		}
		
		if($this->input->get('preset')) $preset = $this->input->get('preset');
		$cache_sum 	= 	sha1($given_url.$preset.'@x'.$scale.filemtime($given_url).filesize($given_url));
	
		if(!$image = $this->CACHE->get($cache_sum))	// check if image was cached
		{
			
			if($preset && isset($this->dimensions[$preset]))
			{
				$height 	= 	$this->dimensions[$preset][0] ;
				$width 		= 	$this->dimensions[$preset][1] ;
				$image 		= 	$this->IMG->resize_from_path(FCPATH.$given_url, $height , $width);
			}else{
				$image = $this->FILE->url_to_bin(FCPATH.$given_url);
			}
			
			$this->CACHE->set($cache_sum, $image,'.jpg');
		}

		$this->output
		->set_content_type(get_mime_by_extension($given_url))
			->set_header("Etag: " . $cache_sum)
			->set_header('Expires: '.gmdate('r', time() + 1800))
			->set_header('Last-Modified: '.gmdate('r', time()))
			->set_header('Cache-Control: max-age=3600, must-revalidate')
			->set_output($image);
	
	}

	
	

}