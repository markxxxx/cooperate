<?php
class Prepbowl extends AppModel {
	
	const table = 'prepbowls';
	
	public $validate = array(
        'not_null' => array('prepbowl_name'),
        'unique' => array('prepbowl_name')
    );
}
?>