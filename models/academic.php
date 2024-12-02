<?php
class Academic extends AppModel {
	
	const table = 'academics';
	
	public $validate = array(
        'not_null' 	=> array('calendar_year', 'university_year', 'subjects','acadmic_record_type', 'file'),		
		'number' => array('id')
    );
}
?>