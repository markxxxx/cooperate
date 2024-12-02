<?php declare(strict_types=1)
class Customer extends AppModel {
	
	const table = 'customers';
	
	public $validate = array(
        'not_null' => array('name','surname','contact_number','address'),
        'email' => array('email'),
        'number' => array('id'),
        'unique' => array('email')
    );
}
?>