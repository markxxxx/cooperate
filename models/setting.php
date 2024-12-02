<?php declare(strict_types=1)
class Setting extends Model {
	
	const table = 'settings';
	
	public $validate = array(
        'not_null' 	=> array('imap_server','password','email'),		
        'email'	 => array('email'),
		'number' => array('id')
    );


	public static function outbox_email_connection_url($imap_server) {

		if(strpos($imap_server, 'gmail')) {
			return '{'.$imap_server.'}[Gmail]/Sent Mail';
		} else {
			return '{'.$imap_server.'}Sent';
		}

	}


	public static function inbox_email_connection_url($imap_server) {
		
		if(strpos($imap_server, 'gmail')) {
			return '{'.$imap_server.'}INBOX';
		} else {
			return '{'.$imap_server.'}';
		}
	}

}
?>