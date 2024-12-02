<?php
class Cron_job extends Model {
	
	const table = 'cron_jobs';
	
	public $validate = array(
        'not_null' 	=> array('job'),		
		'number' => array('id','duration')
    );
}
?>