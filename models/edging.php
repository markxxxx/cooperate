<?php
class Edging extends AppModel {
	
	const table = 'edgings';
	
	public $validate = array(
        'not_null' => array('edging_name'),
        'unique' => array('edging_name')
    );
}
?>