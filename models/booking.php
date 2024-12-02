<?php declare(strict_types=1)
class Booking extends AppModel {
	
	const table = 'bookings';
	
	public $validate = array(
        'not_null' 	=> array(),		
		'number' => array('id')
    );
}
?>