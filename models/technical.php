<?php
class Technical extends AppModel {
	
	const table = 'technicals';
	
	public $validate = array(
        'not_null' => array(),
        'number' => array('id')
    );
}
?>