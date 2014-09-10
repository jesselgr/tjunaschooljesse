<?php

class thumbnail extends CI_Controller{

	private $path_image;
	private $path_thumb;
	
	
	private $max_img_width  	= 500;
	private $max_img_height 	= 700;

	private $width  	= 0;
	private $height 	= 0;
		
	public function __construct() { 
	    parent::__construct();	
		
		
		$this->path_image = 'uploads/files/';
		$this->path_thumb = 'uploads/thumbs/img_thumbs/';

	}
	
	public function index(){
		$this->load->view('thumb_form');
	}

	public function create_by_post(){
		$path = $this->input->post('path');
		$file	= 	$this->input->post('file',true);
		$ext	= 	$this->input->post('ext',true);
		
		$this->width	=	$this->input->post('width',true);
		$this->height	=	$this->input->post('height',true);
		
		$coordinates['x1'] = (int)$this->input->post('x1');
		$coordinates['y1'] = (int)$this->input->post('y1');
		$coordinates['x2'] = (int)$this->input->post('x2');
		$coordinates['y2'] = (int)$this->input->post('y2');
		
		$this->create_thumb($file, $ext, $coordinates, $path);
	}
	
	/***************************************************
	*	Create Thumb
	*	@param $file 			filename
	*	@param $ext	 			file extension
	*	@param $coordinates 	optional array with x1,x2,y1,y2 coordinates	
	*/
	
	public function create_thumb($file, $ext, $loc = null, $path){
		$this->load->library('image_lib');
		
		// crop
		$config['image_library'] 	= 'GD2';
		$config['source_image']		= FCPATH.$path.$file.'.'.$ext;
		$config['new_image'] 		= FCPATH.$this->path_thumb.$file.'.'.$ext;
		$config['maintain_ratio'] 	= false;
		
		// if custom crop
		if($loc){
			$config['x_axis'] = $loc['x1'];
			$config['y_axis'] = $loc['y1'];
			
			$config['width'] 	= 	$loc['x2'] - $loc['x1'];
			$config['height'] 	= 	$loc['y2'] - $loc['y1'];
		
		}else{ // auto crop
			// prepare cropping proportions
			$fileData = $this->image_lib->get_image_properties($config['source_image'], TRUE);
	
			// complicated math stuff right here
			if ($fileData['width'] > $fileData['height']) {
			    $config['width'] 	= 	$fileData['height'];
			    $config['height'] 	= 	$fileData['height'];
			    $config['x_axis'] 	= 	(($fileData['width'] / 2) - ($config['width'] / 2));
			}
			else {
			    $config['height'] 	= 	$fileData['width'];
			    $config['width'] 	= 	$fileData['width'];
			    $config['y_axis'] 	= 	(($fileData['height'] / 2) - ($config['height'] / 2));
			}
		}
		$this->image_lib->initialize($config); 
		$this->image_lib->crop();
		// resize
		$config['source_image']		= FCPATH.$this->path_thumb.$file.'.'.$ext;
		$config['width']	 		= $this->width;
		$config['height']			= $this->height; 
		$config['maintain_ratio'] 	= FALSE;
		
		$this->image_lib->initialize($config);
		$this->image_lib->resize();		
	
		if($errors = $this->image_lib -> display_errors()){
			echo $errors;
		}else{
			echo 'success';
		}
		
	}
}