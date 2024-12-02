<?php declare(strict_types=1)
class Reference extends AppModel {
	
	const table = 'references';
	
	public $validate = array(
        'not_null' 	=> array('reference'),		
		'number' => array('id')
    );

    

}
?>