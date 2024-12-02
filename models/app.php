<?php declare(strict_types=1)
class AppModel extends Model {

	public function __construct($id = 0) {
		parent::__construct($id);
	}

	public static function search($criteria = array())  {
		$called_class = get_called_class();
		$sql = $called_class::get_search_select_clause($criteria) . $called_class::get_search_from_clause($criteria);
		$sql .= $called_class::get_search_where_clause($criteria) . $called_class::get_search_order_clause($criteria) . $called_class::get_search_limit_clause($criteria);
		return Database::query($sql)->fetch_all();
	}

	public static function get_search_order_clause($criteria) {
		
		if(isset($criteria['order'])) {
			return ' ORDER BY '. $criteria['order'] .' ';
		}
	}


	public static function search_count($criteria = array())  {
		$called_class = get_called_class();
		$sql = 'SELECT count(*) as cnt  ' . $called_class::get_search_from_clause($criteria);
		$sql .= $called_class::get_search_where_clause($criteria);

		return Database::query($sql)->fetch('object')->cnt;
	}

	public static function get_search_from_clause($criteria = array()) {
		return " FROM users u LEFT JOIN scholarships s ON u.id = s.user_id,groups g ";
	}

	public static function get_search_select_clause($criteria = array()) {
		return "SELECT u.*,g.account,s.university";
	}

	public static function get_search_limit_clause($criteria = array()) {

		if(isset($criteria['limit']) && !$criteria['limit']) {
			return '';
		}

		if(!isset($criteria['page'])) {
			$criteria['page'] = 0;
		}
		if(!isset($criteria['per_page'])) {
			$criteria['per_page'] = 20;
		}

		return 'LIMIT '.($criteria['page'] * $criteria['per_page']) . ' , ' . $criteria['per_page'] ;

	}
  
	public static function get_search_where_clause($criteria = array()) {

		// if(!isset($criteria['user'])) {
		// 	$user = User::current();
		// } else {
		// 	$user = $criteria['user'];
		// }

		// $domains = $user->get_domains();
		// $groups = $user->get_groups();


		// $where_clause = " WHERE g.id = u.group_id  ";

		// if(isset($criteria['account_type'])) {
		// 	$where_clause .= " AND g.account = '{$criteria['account_type']}' ";
		// }

		// if(isset($criteria['send_message'])) {
		// 	$where_clause .= " AND g.message_notification = '{$criteria['send_message']}' ";
		// }

		// if(isset($criteria['account_status']) && strlen($criteria['account_status'])) {
		// 	$where_clause .= " AND u.account_status = '{$criteria['account_status']}' ";
		// } else {

		// 	if(!isset($criteria['show_suspended'])) {
		// 		$where_clause .= " AND u.account_status <> 'Suspended' AND u.account_status <> 'Inactive' ";
		// 	}

		// }

		// if(isset($criteria['domains'])) {

		// 	if(is_array($criteria['domains'])) {

		// 		$allowed_domains = array();
		// 		foreach($criteria['domains'] as $d) {
		// 			if(in_array($d, array_keys($domains))) {
		// 				$allowed_domains[] = $d;
		// 			}
		// 		}

		// 		$where_clause .= ' AND '. Database::in_clause('u.domain_id', $allowed_domains);

		// 	} else {

		// 		if(count($domains) && in_array($criteria['domains'], array_keys($domains))) {
		// 			$where_clause .= " AND u.domain_id = '{$criteria['domains']}' ";
		// 		} else {
		// 			$where_clause .= " AND u.domain_id = '{$user->domain_id}' ";
		// 		}

		// 	}
		// } else {
		// 	if(count($domains)) { 
		// 		$where_clause .= ' AND '. Database::in_clause('u.domain_id', array_keys($domains));
		// 	} else {
		// 		$where_clause .= " AND u.domain_id = '{$user->domain_id}' ";
		// 	}
		// }


		// if(isset($criteria['groups'])) {

		// 	if(is_array($criteria['groups'])) {

		// 		$allowed_groups = array();
		// 		foreach($criteria['groups'] as $d) {
		// 			if(in_array($d, array_keys($groups))) {
		// 				$allowed_groups[] = $d;
		// 			}
		// 		}

		// 		$where_clause .= ' AND '. Database::in_clause('u.group_id', $allowed_groups);

		// 	} else {

		// 		if(in_array($criteria['groups'], array_keys($groups))) {
		// 			$where_clause .= " AND u.group_id = '{$criteria['groups']}' ";
		// 		} else {
		// 			$where_clause .= " AND u.group_id = '{$user->group_id}' ";
		// 		}

		// 	}
		// } else {
		// 	if(count($groups)) { 
		// 		$where_clause .= ' AND '. Database::in_clause('u.group_id', array_keys($groups));
		// 	} else {
		// 		$where_clause .= " AND u.group_id = '{$user->group_id}' ";
		// 	}
		// }


		// if(isset($criteria['universities'])) {
		// 	if(is_array($criteria['universities'])) {
		// 		$where_clause .= ' AND ' . Database::in_clause('s.university', $criteria['universities']);
		// 	} else {
		// 		$where_clause .= " AND s.university = '{$criteria['universities']}' ";
		// 	}
		// }

		// if(isset($criteria['study_years'])) {
		// 	if(is_array($criteria['study_years'])) {
		// 		$where_clause .= ' AND ' . Database::in_clause('s.year_of_study', $criteria['study_years']);
		// 	} else {
		// 		$where_clause .= " AND s.year_of_study = '{$criteria['study_years']}' ";
		// 	}
		// }

		// if (isset($criteria['search'])) {
		// 	$where_clause .= " AND (u.id = '{$_GET['search']}' OR u.name like '%{$_GET['search']}%' OR u.surname like '%{$_GET['search']}%' OR u.email like '%{$_GET['search']}%' )";
		// }

		// if (isset($criteria['where'])) {
		// 	$where_clause .= $criteria['where'];
		// }


		// return $where_clause;

	}
}
?>