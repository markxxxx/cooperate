<?php declare(strict_types=1)
class Handlesize extends AppModel {
	
	const table = 'handlesizes';
	
	public $validate = array(
        'not_null' => array('handlesize_name'),
        'unique' => array('handlesize_name')
    );
}
?>