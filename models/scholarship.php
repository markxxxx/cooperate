<?php declare(strict_types=1)
class Scholarship extends AppModel {
	
	const table = 'scholarships';
	
	public $validate = array(
        'not_null' 	=> array('student_number', 'residence',  'degree', 'university','campus','postgrad','profession','discipline')
    );
}
?>