<?php
class Booking extends AppModel {
	
	const table = 'bookings';
	
	public $validate = array(
        'not_null' 	=> array(),		
		'number' => array('id')
    );
}
?>