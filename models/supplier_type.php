<?php
class Supplier_type extends Model {
	
	const table = 'supplier_types';
	
	public $validate = array(
        'not_null' 	=> array(),		
		'number' => array('id')
    );
}
?>