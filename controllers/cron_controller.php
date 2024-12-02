<?php

class CronController extends Controller {

	public 
		$jobs = array(),
		$profile_tmp = array();
	
	public function execute() {

		$jobs = Cron_job::find()->fetch_all();
		$time = time();

		foreach($jobs as $job) {
			if(($job['last_run'] + $job['duration']) < $time) {
				$this->jobs[] = $job['job'];
			}
		}

		foreach($this->jobs as $job) {
			$this->run($job);
			echo $job;
		}

		exit();
	}

	public function sms_send() {
		error_log("sms'ing");
		Sms::cron_send();
	}

	public function message_send() {

		global $config;		
		error_log("emailing");

		$sql = "SELECT * FROM  `message_cron` WHERE sent='' ";
		$messages = Database::query($sql)->fetch_all();

		foreach ($messages as $message) {

			$file = '/documents/'.$message['file'];
			$content = file_get_contents( $file);
			$content = chunk_split(base64_encode($content));
			$uid = md5(uniqid(time()));
			$name = basename($file);

			// header
			$header = "From: ".$config['site']['email_from']." <".$config['site']['email_noreply'].">\r\n";
			$header .= "Reply-To: ".$config['site']['email_noreply']."\r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

			// message & attachment
			$nmessage = "--".$uid."\r\n";
			$nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
			$nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
			$nmessage .= strip($message['body'])."\r\n\r\n";
			$nmessage .= "--".$uid."\r\n";
			$nmessage .= "Content-Type: application/octet-stream; name=\"".$message['file']."\"\r\n";
			$nmessage .= "Content-Transfer-Encoding: base64\r\n";
			$nmessage .= "Content-Disposition: attachment; filename=\"".$message['file']."\"\r\n\r\n";
			$nmessage .= $content."\r\n\r\n";
			$nmessage .= "--".$uid."--";

			_mail($message['email'], strip($message['subject']), $nmessage , $header  );
			// Database::query("DELETE  FROM `message_cron` WHERE id = '{$message['id']}' ");
			Database::query("UPDATE `message_cron` SET sent = now() WHERE id = '{$message['id']}' ");
		}
	} 

	public function run($job) {

		$time = date("Y-m-d H:i:s");

		if(method_exists($this, $job)) {
			Cron_job::edit("last_run = '{$time}'", " job ='{$job}' ");
			$this->{$job}();
		}
		if(PAGE) {
			$this->redirect('referer');
		}

	}
	
	public function before_action() {
		set_time_limit (HOUR);
		ini_set("memory_limit","1024M");
	}

	private function boot_with_super_user() {

        $sql = "SELECT * FROM users WHERE group_id = 1 LIMIT 1";
        $rs = Database::query($sql)->fetch();
        $_SESSION['id'] = $rs['id'];

	}



	public function birthday_reminder() {

		$month = date('m');
		$day = date('d');

		$sql ="SELECT * FROM users u, profiles p 
				WHERE u.id = p.user_id
				AND MONTH(p.date_of_birth) = '{$month}'
				AND DAY(p.date_of_birth) = '{$day}' ";

		$users = Database::query($sql)->fetch_all();


		foreach($users as $u) {

			$mail_vars = array(
				'name'	=> $u['name'] . $u['surname'],
				'email' => $u['email']
			);
			Message_template::send($u['email'], Message_template::BIRTHDAY, $mail_vars);
		}


	}


}

?>