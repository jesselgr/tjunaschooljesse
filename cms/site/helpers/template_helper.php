<?php 


function whisper($value, $key)
{
	echo (isset($value[$key]))? $value[$key] : '';
}

function print_label($key)
{
	$CI =& get_instance();
	$labels = $CI->site->lang_labels;
	return (isset($labels[$key])) ? $labels[$key] : $key.' [N.A.]';
}

function compare_key($key)
{
	return $key['type'];

}

function get_section_html($type, $section)
{
	$CI =& get_instance();
	$CI->page_content->format_content_row_html($type, $section);
}

function get_basic_form($action, $fields, $submitText = "Opslaan")
{
	$html = form_open($action);
	
	foreach($fields as $key => $field)
	{
		$class=  isset($field['class'])? $field['class'] : 'input_'.$key;
		$html.='<div class="inputContainer '. $class .'">';	
		$html.=form_label($field['label'], $key);
		$html.=form_input($key, isset( $field['value'])? $field['value']: set_value($key),'class="inputField"');
		$html.=form_error($key,'<div class="inputError">','</div>');
		$html.='</div>';	
	
	}
	if($submitText) $html.= '<p><input type="submit" value="'.$submitText.'"></p>';
	$html.= form_close();
	return $html;
}