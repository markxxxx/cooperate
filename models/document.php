<?php declare(strict_types=1)
class Document extends AppModel {
	
	const table = 'documents';
	
	public $validate = array(
        'not_null' 	=> array('title', 'description', 'file'),		
		'number' => array('id')
    );


    
}
?>