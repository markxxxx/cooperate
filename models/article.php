<?php
class Article extends AppModel {
	
	const table = 'articles';
	
	public $validate = array(
        'not_null' 	=> array('company','agreement','contact_name','contact_number','description'),		
		'number' => array('id','year_to_start')
    );
}
?>