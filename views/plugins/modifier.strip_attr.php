<?php

function smarty_modifier_strip_attr($eat_a_dick_html) { 
	$allowable_tags = '<p><a><img><ul><ol><li><table><thead><tbody><tr><th><td>';
	$allowable_atts = array('href','src','alt');
	$strip_arr = array();
	$data_sxml = simplexml_load_string('<root>'. $eat_a_dick_html .'</root>', 'SimpleXMLElement', LIBXML_NOERROR | LIBXML_NOXMLDECL);

	if ($data_sxml ) {
	    foreach ($data_sxml->xpath('descendant::*[@*]') as $tag) {
	        foreach ($tag->attributes() as $name=>$value) {
	            if (!in_array($name, $allowable_atts)) {
	                $tag->attributes()->$name = '';
	                $strip_arr[$name] = '/ '. $name .'=""/';
	            }
	        }
	    }
	}

	$data_str = strip_tags(preg_replace($strip_arr,array(''), $data_sxml->asXML()), $allowable_tags);
	return $data_str;
}
?>