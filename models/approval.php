<?php declare(strict_types=1)

class Approval extends AppModel {

	const table = 'approvals';

	static $type_text = array(
		'supplier' 		=> "@full_name has updated @object_title banking details",
		'payment'  		=> "@full_name has closed a payment file: @object_title ",
		'profile'		=> "@full_name has up banking @object_title ",
		'profile_same'	=> "@full_name has updated his banking details",
		'user'			=> "@full_name has updated @object_title user account details"

	);

	static public function process($object, $user, $changes = array(), $args = array()) {
		
		if(!is_object($object)) {
			return false;
		}

		$full_name =  ucfirst(strtolower($user->name)) . ' ' . ucfirst(strtolower($user->surname));

        $args = array_merge(array(
        		'full_name'		=> $full_name,
        		'object_title' 	=> $object->get_title()
        ), $args);

        $conversions = array();
        foreach($args as $key => $value) {
            $conversions['@'.$key] = $value;
        }

		$class_name = strtolower(get_class($object));

		$domain = new Domain($user->domain_id);

		if(!isset(self::$type_text[$class_name])) {
			return false;
		}
		
		$can_approve = $user->can_approve();

		$approval = array(
			'ident' 		=> $class_name,
			'ident_id'		=> $object->id,
			'created_by' 	=> $user->id,
			'status'		=> $can_approve ? 'auto_approved' : 'pending',
			'domain_id'		=> isset($object->domain_id) ? $object->domain_id : 0,
			'approved_by'	=> $can_approve ? $user->id : 0,
			'notification'	=> escape(strtr(self::$type_text[$class_name], $conversions))
		);

		$has_changes = count($changes) != 0 ? true : false;

		if( $has_changes ) {
			$approval['changes'] = serialize($changes);
		}

		if($class_name != 'payment' && !$has_changes) {
			return false;
		}
		$approve = Approval::map($approval);
		$approve->insert();

		if($has_changes) {
			$where = " AND g.approve_changes = '1' ";
		} else {
			$where = " AND g.approve_payments = '1' ";
		}

		$admins = $domain->get_admins($where);

		$admin_names = '';
		foreach($admins as $a) {
			$admin_names .=  ucfirst(strtolower($a['name'])) . ' ' 
							. ucfirst(strtolower($a['surname'])) . '<br />';
		}

		foreach($admins as $a) {
			mail_template('admin_approval', "Approval required: ". $domain->domain, array(
				'admin_names'	=> $admin_names,
				'admin_name'	=> ucfirst(strtolower($a['name'])) . ' ' . ucfirst(strtolower($a['surname'])),
				'name'			=> $full_name
			));
		}

		$object->update_attributes(array('approval_id'=> $object->id));

		return $approve->id;
	}

	public function get_object() {
		$class_name = $this->ident;
		return new $class_name($this->ident_id);
	}


	public static function get_search_from_clause($criteria = array()) {
		return " FROM users u LEFT JOIN scholarships s ON u.id = s.user_id JOIN approvals a ON a.created_by = u.id ,groups g ";
	}


	//Not only bursars
	public static function search($criteria = array()) {
		unset($criteria['account_type']);
		return parent::search($criteria);
	}

	public static function get_search_select_clause($criteria = array()) {
		return "SELECT a.* ";
	}



	

}
?>