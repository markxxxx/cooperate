<?php
class Alumni extends Model {
	
	const table = 'alumni';
	
	public $validate = array(
        'not_null' 	=> array('monthly_salary','hired_after','work_for','have_contributed','are_you_working','graduation_date'),		
		'number' => array('id')
    );



}
?>