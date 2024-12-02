<?php
class Jobtype extends AppModel {
	
	const table = 'job_types';
	
	public $validate = array(
        'not_null' => array('job_type_name'),
        'unique' => array('job_type_name')
    );
}
?>