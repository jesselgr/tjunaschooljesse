<?php
function minify_html($buffer)
{
	{
	    $search = array(
	        '/\>[^\S ]+/s', //strip whitespaces after tags, except space
	        '/[^\S ]+\</s', //strip whitespaces before tags, except space
	        '/(\s)+/s'  // shorten multiple whitespace sequences
	        );
	    $replace = array(
	        '>',
	        '<',
	        '\\1'
	        );
	  $buffer = preg_replace($search, $replace, $buffer);
	    return $buffer;
	}
}

function minify_css($buffer)
{
	if(ENVIRONMENT == 'production')
	{
	    /* remove comments */
	    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	    /* remove tabs, spaces, newlines, etc. */
	    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    }
    return $buffer;


}


function minify_js($str)
{
//	$str=preg_replace('@//.*@','',$str);//delete comments
//	$str=preg_replace('@\s*/>@','>',$str);//delete xhtml tag slash ( />)
	return $str;
}


function crunch_files($files, $type, $ext = false)
{
	$sha1_sum		= $type;
	$min_url 		= '';
	$composed_full	= '';
	$composed_min 	= '';
	if(!$ext) $ext = '.'.$type;
	
	if(is_array($files))
	{
		// loop files to crunch
		foreach($files as $file)
		{
			$file_name = 'assets/'.$type.'/'.$file.$ext;
			$file_path = FCPATH.$file_name;
			

			// get file, if it exists;
			if(file_exists($file_path)) {
				$file_mtime 	= 	filemtime($file_name);
				$composed_full	.=	"\n\n /*		file: ".$file_name ."; last modified: ".date ("F d Y H:i:s.", $file_mtime).";		*/ \n\n";
				$composed_full	.=	file_get_contents($file_path);
				$sha1_sum		.=	$file_name.$file_mtime;
			}else{
//				show_error('file \''.$file.$ext.'\' not loaded');
			}
		}
		
		// write minified file	 
		$min_url = 'assets/minify/'.$type.'/ac_min-'.sha1($sha1_sum).$ext; 
		if(!is_file(FCPATH.$min_url))
		{
			$composed_min = call_user_func('minify_'.$type, $composed_full);
			file_put_contents(FCPATH.$min_url, $composed_min);
		}
	}
	
	return $min_url;

}