<?php
class Reminder extends Model {
	
	const table = 'reminders';
	private $ident_obj = null;

	const SHOW_ALL = '3';
	
	public $validate = array(
        'not_null' 	=> array()		
    );

	public static function search(User $user, $group = false, $completed = false ,$past_reminders = false) {

		if(!$user->id) {
			return false;
		}

		$where = '';

		//yet another hack
		//i dont think these things through
		if($completed == Reminder::SHOW_ALL) {

		}elseif($completed == true) {
			$where .= " AND r.completed = '1 ' ";
		} else {
			$where .= " AND r.completed = '0 ' ";
		}

		if($past_reminders != true) {
			$date = date('Y-m-d');
			$where .= " AND r.reminder_date >= '{$date}' ";
		}

		$sql ="SELECT r.*,u.name ,u.surname 
				FROM users u, reminders r
				WHERE r.user_id = u.id
				AND (r.user_id = '{$user->id}' OR privacy = 1)
				{$where}";

		$rs = Database::query($sql);

		if($group) {
			$return = array();

			while($row = $rs->fetch()) {
			
				if($row['user'] != $user_id) {
					$return['all'][] = $row;
				} else {
					$return['mine'][] = $row;
				}

			}
			return $return;
		} else {
			return $rs->fetch_all();
		}


	}



	public function ident() {
		
		if(!$this->id || !strlen($this->ident)) {
			return false;
		}
		if(is_object($this->ident_obj)) {
			return $this->ident_obj;
		}

		$this->ident_obj = new $this->ident($this->ident_id);
		
		if(!$this->ident_obj->id) {
			$this->ident_obj = null;
			return false;
		}

		return $this->ident_obj;

	}

}
?>