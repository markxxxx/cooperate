<?php
class Topthickness extends AppModel {
	
	const table = 'topthicknesses';
	
	public $validate = array(
        'not_null' => array('topthickness_name'),
        'unique' => array('topthickness_name')
    );
}
?>