<?php
class Finish extends AppModel {
	
	const table = 'finishes';
	
	public $validate = array(
        'not_null' => array('finish_name'),
        'unique' => array('finish_name')
    );
}
?>