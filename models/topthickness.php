<?php declare(strict_types=1)
class Topthickness extends AppModel {
	
	const table = 'topthicknesses';
	
	public $validate = array(
        'not_null' => array('topthickness_name'),
        'unique' => array('topthickness_name')
    );
}
?>