<?php declare(strict_types=1)
class Runner extends AppModel {
	
	const table = 'runners';
	
	public $validate = array(
        'not_null' => array('runner_name'),
        'unique' => array('runner_name')
    );
}
?>