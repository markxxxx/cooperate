<?php declare(strict_types=1)
class Colour extends AppModel {
	
	const table = 'edging_colours';
	
	public $validate = array(
        'not_null' => array('colour_name'),
        'unique' => array('colour_name')
    );
}
?>