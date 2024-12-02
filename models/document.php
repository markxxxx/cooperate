<?php
class Document extends AppModel {
	
	const table = 'documents';
	
	public $validate = array(
        'not_null' 	=> array('title', 'description', 'file'),		
		'number' => array('id')
    );


    
}
?>