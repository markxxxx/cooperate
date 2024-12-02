<?php

include 'include/phpmailer/class.phpmailer.php';
include 'include/phpmailer/class.pop3.php';

class SendMail extends PHPMailer{

	public function __construct() {
		
		parent::__construct();
		global $config;

		$this->IsSMTP();

		$this->Host  = $config['smtp']['host'];

		$this->SMTPAuth  = true;                 
		                   
		$this->Username = $config['smtp']['username'];
		$this->Password = $config['smtp']['password'];

		
	}

	public static function getInstance() {
		static $instant;

		if(!is_object($instant)) {
			$instant = new SendMail();
		}

		return $instant;
	}

}
?>