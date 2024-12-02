<?php
class Project extends AppModel {
	
	const table = 'projects';
	
	public $validate = array(
        'not_null' => array('name','description'),
        'number' => array('id')
    );
}
?>