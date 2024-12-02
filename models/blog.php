<?php declare(strict_types=1)
class Blog extends AppModel {
	
	const table = 'blogs';
	
	public $validate = array(
        'not_null' 	=> array('user_id'),		
		'number' => array('id')
    );
}
?>