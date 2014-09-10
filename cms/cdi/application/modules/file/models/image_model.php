<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class image_model extends CI_Model {

	private $img_path 		= 	"files/";
	private $file_icon_path	=	"assets/img/filetypes/big/";

    function __construct()
    {
        // Call the Model constructor	//
        parent::__construct();
    }

	private function _get_ctype_img_url($ext)
	{
		return $this->file_icon_path.$ext.'.png';
	}

	public function get_img_url_for_file_id($file_id)
	{
		$this->load->model('file/file_model','FILE');
		$file_row = $this->db
			->where('file_id', $file_id)
			->get('file')
			->row();
		// var_dump($file_id);

		if($file_row)
		{
			$url = ($file_row->is_image)
				? $this->FILE->get_file_url($file_row->sha1, $file_row->extension)
				: $this->_get_ctype_img_url($file_row->extension);

			// var_dump($url);
			return (is_file(FCPATH.$url))? $url : false;
		}

	}

	public function resize_from_path($path, $desired_height, $desired_width)
	{
		if(is_file($path) == false) return null;
		list($original_width, $original_height, $type, $attr) = getimagesize($path);
		$thumbOptions = array(
		 'jpegQuality' 				=> 	90,
		  'resizeUp'				=> 	true,
		 'alphaMaskColor'			=> 	array(255,255,255),
		 'transparencyMaskColor'	=>	array(255,255,255)
		);	
		// dump($path);

		require_once APPPATH.'libraries/thumb/ThumbLib.inc.php';
		
		$thumb = PhpThumbFactory::create($path, $thumbOptions);
		// $thumb->setFormat ('JPG');

		$desired_aspect_ratio 	= $desired_width / $desired_height;
		$original_aspect_ratio 	= $original_width / $original_height;

        $should_crop    = ($desired_aspect_ratio != $original_aspect_ratio);
        $should_resize  = ($desired_width != $original_width && $desired_height != $original_width);

		// we resize our height or width (whichever is the largest) but keep the aspect ratio, then we crop.
		//(ex: 800x600 is resized to 400x300, then cropped to 300x300)
		if(!$should_crop)
		{ // if we have a square starter image
			$resize_width 	= 	$desired_width;
			$resize_height 	= 	$desired_height;
		}
		else
		{
			// we check how much we have to factor our height/width to keep the current aspect ratio bit fut our new size
			$height_gap 	=	 $desired_height - $original_height;
			$width_gap 		=	 $desired_width - $original_width;

			$condition = ($height_gap < 0 && $width_gap < 0) ? ($height_gap > $width_gap) : ($height_gap < $width_gap);

			$multiplier 	= 	($condition)?  $desired_height / $original_height:	$desired_width / $original_width ;

			$resize_height 	= 	round($original_height * $multiplier);
			$resize_width 	= 	round($original_width * $multiplier);
		}

		// does the same stuff again, to correct (quickfix)
		if($resize_height < $desired_height)
		{
			$diff = $desired_height / $resize_height ;
			$resize_height = $resize_height * $diff;
			$resize_width = $resize_width * $diff;
		}
		if($resize_width < $desired_width)
		{
			$diff =  $desired_width / $resize_width ;
			$resize_height = round($resize_height * $diff);
			$resize_width = round($resize_width * $diff);
		}

		//resize
		 if($should_resize)$thumb->adaptiveResize($resize_width,$resize_height);
		//crop
		 if($should_crop)$thumb->cropFromCenter($desired_width, $desired_height);
		//output
		// var_dump('from:',$original_height ,$original_width,$height_gap , $width_gap ,'<br/> resize to:', $resize_height, $resize_width,'<br/> crop to:',$desired_height, $desired_width);

		 return $thumb->getImageAsString();
	}

	/*
	*	@param $bin
	*	@param $name
	*	returns url
	*/
	public function bin_to_url($bin, $file_path)
	{
		$this->load->helper('file');
		if(is_file($file_path) === true) unlink($file_path);

		write_file(FCPATH.$file_path, $bin);


		return $file_path;
	}

	public function get_row_for_file_id($file_id)
	{
		$this->load->model('file/file_model','FILE');
		$file_row = $this->db
			->where('file_id', $file_id)
			->get('file')
			->row();
		// var_dump($file_id);

		if($file_row)
		{
			$file_row->url = $this->FILE->get_file_url($file_row->sha1, $file_row->extension);
			var_dump($file_row);
			return (is_file(FCPATH.$file_row->url))? $file_row : false;
		}
	}

}