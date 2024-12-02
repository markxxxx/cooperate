<?php
class Cupboardheight extends AppModel {
	
	const table = 'cupboard_heights';
	
	public $validate = array(
        'not_null' => array('cupboard_height_name'),
        'unique' => array('cupboard_height_name')
    );
}
?>