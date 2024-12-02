<?php declare(strict_types=1)
class Hinge extends AppModel {
	
	const table = 'hinges';
	
	public $validate = array(
        'not_null' => array('hinge_name'),
        'unique' => array('hinge_name')
    );
}
?>