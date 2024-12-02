<?php
class Accessory extends AppModel {
	
	const table = 'accessories';
	
	public $validate = array(
        'not_null' => array('name'),
        // 'email' => array(''),
        // 'number' => array(''),
        'unique' => array('name')
    );
}
?>