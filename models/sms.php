<?php declare(strict_types=1)

class Sms extends AppModel {
	
	const table = 'sms';

	public static function send($user_id = 0, $sender_id = 0, $message = '' ) {

		if($user_id && $sender_id) {
			$sms = Sms::map(array(
				'message' 	=> $message,
				'sender_id' => $sender_id,
				'user_id'	=> $user_id,
				'status'	=> 'Pending'
			));

			$sms->insert();
		}
	}

	// public static function get_search_from_clause($criteria = array()) {
	// 	return " FROM users u LEFT JOIN scholarships s ON u.id = s.user_id JOIN profiles p on p.user_id = u.id JOIN sms ON sms.user_id = u.id JOIN users u2 ON sms.sender_id = u2.id ,groups g  ";
	// }

	// public static function get_search_select_clause($criteria = array()) {
	// 	return "SELECT u.*,sms.*,u2.name as sender_name, u2.surname as sender_surname, u.id as user_id";
	// }


	public static function get_credits() {
		global $config;
		return file_get_contents("http://www.logicsms.co.za/querycredits.aspx?username={$config['sms']['username']}&password={$config['sms']['password']}");
	
	}


	public static function api_send($number, $message) {
		global $config;
		$message = urlencode($message);

		$credentials = "{$config['sms']['email']}:{$config['sms']['token']}";

		$url = "https://www.zoomconnect.com/app/api/rest/v1/sms/send-url-parameters?recipientNumber=$number&message=$message";

		$result = file_get_contents($url, null, stream_context_create(array(
		    'http' => array(
		        'method'           => 'POST',
		        'header'           => "Content-type: application/json\r\n".
		                              "Connection: close\r\n" .
		                              "Authorization: Basic " . base64_encode($credentials)
		    ),
		)));

		// if ($result) {
		//     echo 'Message id: ' . $result;
		// } else {
		//     echo "POST failed";
		// }

		return base64_decode($result);

		// return file_get_contents("https://www.zoomconnect.com/app/api/rest/v1/sms/send?email={$config['sms']['email']}&token={$config['sms']['token']}");
	}

	public static function get_stats() {

		$sql ="SELECT status,count(*) as cnt FROM sms GROUP BY status";

		$rs = Database::query($sql);
		$return = array();

		while($row = $rs->fetch()) {
			$return[$row['status']] = $row;
		}

		return $return;
	}

	public static function cron_send() {


		// $sql = "SELECT s.*,p.cell_number FROM profiles p,sms s
		// 		WHERE p.user_id = s.user_id
		// 		AND s.status = 'Pending'";

		$sql = "SELECT s.*,u.mobile_number AS cell_number
				FROM users u
				LEFT JOIN sms s ON (u.id=s.user_id)
		 		WHERE s.status = 'Pending'";

		$rows = Database::query($sql)->fetch_all();


		foreach($rows as $row) {

			if(!strlen($row['cell_number'])) {
				$update = array('status' => 'Error', 'status_message' => 'No mobile');
			} elseif(!is_numeric($row['cell_number'])) {
				$update = array('status' => 'Error', 'status_message' => 'Invalid mobile');
			} elseif(strlen($row['cell_number'] < 10)) {
				$update = array('status' => 'Error', 'status_message' => 'Invalid mobile');
			} else {
				
				$result = Sms::api_send($row['cell_number'], $row['message']);
				// error_log($result);
				// $result = new SimpleXMLElement($result);

				if($result) {
					$update = array('status' => 'Sent', 'status_message' => 'Sent successfully');
				} else {
					$update = array('status' => 'Error', 'status_message' => 'Provider error');
				}

			}

			Sms::edit($update, $row['id']);
		}

		
	}

}

?>