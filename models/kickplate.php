<?php
class Kickplate extends AppModel {
	
	const table = 'kickplates';
	
	public $validate = array(
        'not_null' => array('kickplate_name'),
        'unique' => array('kickplate_name')
    );
}
?>