<?php
class Toptype extends AppModel {
	
	const table = 'toptypes';
	
	public $validate = array(
        'not_null' => array('toptype_name','variant_name')
        // 'unique' => array('toptype_name')
    );
}
?>