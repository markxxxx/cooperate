<?php
class Message extends AppModel {
	
	const table = 'messages';
	
	public static function inbox($filter = false, $user, $page=0, $show=20, $count = false){
		return self::search(1, $user, $page, $show, 0, $filter);
	}
	
	public static function outbox($filter = false, $user, $page=0, $show=20, $count = false){
		return self::search(0, $user, $page, $show, 0, $filter);
	}
	

	/*
	public static function inbox_count($filter = false, $user) {
		return self::search(1, $user, 0, 1, 1, $filter);
	}
	
	public static function outbox_count($filter = false, $user) {
		return self::search(0, $user, 0, 1, 1, $filter);
	}*/
	
	public static function attachments($message_id = '') {

		$sql = "SELECT a.id,a.filename 
				FROM attachments a, message_attachment ma
				WHERE a.id = ma.attachment_id 
				AND ma.message_id = '{$message_id}'
				";
		return Database::query($sql)->fetch_all();
	}

	public static function search($is_inbox = 1, $user, $page = 0, $show = 20, $count = false, $filter = 0) {
		
		$curent_domain = $user->current_domain();
		$limit = ($page * $show) .','. $show;
		if(!$is_inbox) {
			unset($filter['account_type']);
		}
		//$filter['account_type'] = 'alumni';


		$where = self::get_search_where_clause($filter);
		
		//setup
		$from = '';
		$select = '';

		if(!$is_inbox) {
			if($user->is_admin()) {

				if(!isset($filter['domains']) && !count($filter['domains'])) {
					$domains = array_keys($user->get_domains());
				} else {
					$domains = $filter['domains'];
				}

				$in_clause = Database::in_clause('m.sender_id', array_keys(Domain::admins($domains)));

				$where .= " WHERE {$in_clause} AND u2.id = m.sender_id AND u.id = m.recipient_id ";
				$from = ',users u2';
				$select = ", CONCAT(u2.name, ' ', u2.surname) as sender ";

			} else {
				$where .= " WHERE m.sender_id = '{$user->id}' AND m.sender_id = u.id ";
			}
		} else {
			if($user->is_admin()) {
				$where .= " WHERE  m.recipient_id = 0 AND m.sender_id = u.id";
			} else {
				$where .= " WHERE m.recipient_id = '{$user->id}' ";
			}
		
		}

		if(isset($filter['search_mail'])) {
			$where .= " AND (m.id = '{$filter['search_mail']}' OR m.title like '%{$filter['search_mail']}%' or m.message like '%{$filter['search_mail']}%' )";
		}
		
		$messages_count = "SELECT count(*) as cnt 
			FROM users u LEFT JOIN scholarships s ON u.id = s.user_id,groups g, messages m 
			{$from}
			{$where}
			AND (m.sender_id = u.id OR m.recipient_id = u.id)";
		
		$messages = "SELECT u.name, u.surname, m.id,m.title, SUBSTRING(m.message,1,60) as message, m.created_on, m.opened, m.sender_id, m.recipient_id, u.group_id
			{$select}
			FROM users u LEFT JOIN scholarships s ON u.id = s.user_id,groups g,  messages m
			{$from}
			{$where}
			GROUP by m.id
			ORDER BY m.created_on DESC
			LIMIT {$limit}";

		return array(
			'messages_count' => Database::query($messages_count)->fetch('object')->cnt,
			'messages' => Database::query($messages)->fetch_all()
		);
		
	}
	
	static function findby_id($message_id=0) {
		return Database::query("SELECT m.* ,u.name, u.surname, u.id as user_id ,u.group_id
						FROM users u, messages m
						WHERE m.id = '{$message_id}'
						AND u.id = m.sender_id
						")->fetch();
	}
	
	static function findby_parent_id($parent_id=0) {
		return Database::query("SELECT m.* ,u.name, u.surname, u.id as user_id ,u.group_id
				FROM users u, messages m
				WHERE m.parent_id = '{$parent_id}'
				AND u.id = m.sender_id 
				ORDER BY m.id DESC
				")->fetch_all();
	}

	 

	
}
?>