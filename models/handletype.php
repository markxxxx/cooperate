<?php declare(strict_types=1)
class Handletype extends AppModel {
	
	const table = 'handletypes';
	
	public $validate = array(
        'not_null' => array('handletype_name'),
        'unique' => array('handletype_name')
    );
}
?>