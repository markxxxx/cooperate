<?php
class Sink extends AppModel {
	
	const table = 'sinks';
	
	public $validate = array(
        'not_null' => array('sink_name'),
        'unique' => array('sink_name')
    );
}
?>