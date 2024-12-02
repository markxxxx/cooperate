<?php declare(strict_types=1)

class SmsController extends AppController {

	public function send() {

		// if (isset($_POST['send_all']) && $_POST['send_all'] != '0') {

		// 	$filters = Filter::get();
		// 	$filters['account_type'] = 'bursar';
		// 	$filters['message_notification'] = 1;
		// 	$filters['limit'] = false;

		// 	$users = User::search($filters);


		// } elseif (isset($_POST['to'])) {

		// 	foreach (explode(',', $_POST['to']) as $user_id) {
		// 		$user_id = array_pop(explode('__', $user_id));

		// 		if (is_numeric($user_id)) {
		// 			$find .= "'{$user_id}',";
		// 		}
		// 	}
		// 	$find = rtrim($find, ',');
		// 	$users = User::find("id in ($find)")->fetch_all();
		// }

		foreach($users as $u) {
			Sms::send($u['id'], $this->user->id, $_POST['message']);
		}
	}


	public function stats($status = false , $page = 0) {
		
		$where = array(
			'order' => 'sms.id DESC',
			'page'	=> $page
		);

		if($status != false) {
			$where['where'] = " AND sms.status = '{$status}' ";
		} 

		$sms = Sms::search($where);
		$this->set('sms_count', Sms::search_count($where));

		$this->set('sms', $sms);

		$this->set('page', $page);
		$this->set('per_page', 20);
		$this->set('status', $status);
		$this->set('stats', Sms::get_stats());

		if($this->_agent()->is_ajax()) {
			$this->set('ajax', 1);
			echo parse_template('app','sms', array());
			exit();
		} else {
			$this->set('credits', Sms::get_credits());
		}

	}

	public function get_credits() {
		echo Sms::get_credits();
		echo " Credits";
		exit();
	}



}

?>