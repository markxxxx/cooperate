<?php declare(strict_types=1)
class Group extends AppModel {
	
	const table = 'groups';
	const super_user_group = 1;


	public $cache = true;
	
	public $validate = array(
        'not_null' => array('name', 'account')
    );

	public function update_priorities($priorities) {

        if(!is_array($priorities) || !$this->id) {
            return false;
        }
 
        $priorities = array_unique($priorities);
        $this->query("DELETE FROM group_priority WHERE group_id = '{$this->id}' ");
        
        foreach($priorities as $priority) {
            $this->query("REPLACE into group_priority(group_id, group_priority_id) VALUES ({$this->id}, $priority)");
        }

    }

    public function get_priorities() {

    	if(!$this->id) {
            return false;
        }
        
        return Group::priorities($this->id);
    }

    static public function priorities($group_id=0) {

        $rs = Database::query("SELECT * FROM groups WHERE id in (SELECT group_priority_id FROM group_priority WHERE group_id = '{$group_id}')");
        $return = array();
		
        while($row = $rs->fetch()) {
            $return[$row['id']] = $row;
        }
        
        return $return;
    }

    public function get_permissions() {
    	if(!$this->id) {
            return false;
        }
        return Group::permissions($this->id);
    }

	static public function permissions($group_id = 0) {
		
		$sql = "SELECT p.*, gp.can_access 
				FROM group_permission gp , permissions p
				WHERE gp.permission_id = p.id
				AND gp.group_id = '{$group_id}'";
				
		return Database::query($sql)->fetch_all();
	}

	static public function delete($group_id = 0) {
		$sql = "DELETE FROM group_permission WHERE group_id = '{$group_id}' ";
		Database::query($sql);
		parent::delete($group_id);
	}

	// public function is_bursar() {
	// 	return $this->account == 'bursar' ? true : false ; 
	// }

	public function is_admin() {
		return $this->account == 'administrator' ? true : false ; 
	}

	public function is_mentor() {
		return $this->account == 'mentor' ? true : false ; 
	}

	public function is_super() {
		return $this->id == Group::super_user_group ? true : false;
	}

	public function can_approve() {
		return $this->approve_changes ? true : false;
	}
	
	public function is_alumni() {
        return (bool) $this->is_alumni  == true ? true : false;
    }

}
?>