<?php declare(strict_types=1)
class Internship extends AppModel {
	
	const table = 'internships';
	
	public $validate = array(
        'not_null' 	=> array('work_type', 'name', 'location', 'position_held' ,'reported_to', 'reported_to_num', 'description'),		
		'number' => array('id')
    );
}
?>