<?php declare(strict_types=1)
class Domain extends AppModel {
	
	const table = 'domains';
	
    public $cache = true;

    public $admins = array();
    
	public $validate = array(
        'not_null' 	=> array('domain','reference','country'),		
		'number' => array('id')
    );
    
    public function __construct($id) {
        parent::__construct($id);
        if($this->id) {
            $this->admins = $this->get_admins();
        }
    }

    public static function delete($id = 0) {

    }
    
    public function update_admins($admins) {
	
        if(!is_array($admins) || !$this->id) {
            return false;
        }
        
        $admins = array_unique($admins);
        $this->query("DELETE FROM user_domain WHERE domain_id = '{$this->id}'");
        
        foreach($admins as $admin) {
            $this->query("REPLACE into user_domain(user_id, domain_id) VALUES ('{$admin}','{$this->id}')");
        }
    }
    
    public function get_admins($where=" ") {
	
        if(!$this->id) {
            return false;
        }
        
        $sql = "SELECT u.id,u.name,u.surname,u.email 
                FROM user_domain ud,users u, groups g
                WHERE u.id = ud.user_id 
                AND u.group_id = g.id
                AND g.account = 'administrator'
                AND ud.domain_id = '{$this->id}' {$where}";

        $rs = $this->query($sql);
        $return = array();
		
        while($row = $rs->fetch()) {
            $return[$row['id']] = $row;
        }
        
        return $return;
    }
	
    public function show_payment_summary() {
        return $this->payment_summary == 1 ? true : false;
    }

	static public function admins($domain_id = 0) {
        
        if(!is_array($domain_id)) {
            $where = " AND (u.domain_id = {$domain_id}) ";
        } else {
            $where = ' AND '. Database::in_clause('ud.domain_id', $domain_id);
        }

        $sql =  "SELECT distinct u.id,u.name,u.surname 
                FROM user_domain ud,users u, groups g
                WHERE u.id = ud.user_id 
                AND u.group_id = g.id
                AND g.account = 'administrator'
                {$where}";

        $rs = Database::query($sql);
        $return = array();
		
        while($row = $rs->fetch()) {
            $return[$row['id']] = $row;
        }
        
        return $return;
    }
	
    //hack domain_id can be an array
	static function users($domain_id = 0) {
        
        if(!is_array($domain_id)) {
            $where = "u.domain_id = {$domain_id} OR ud.domain_id = '{$domain_id}'";
        } else {
            $main_domain = Database::in_clause('u.domain_id', $domain_id);
            $linked_domain = Database::in_clause('ud.domain_id', $domain_id);
            $where = " {$main_domain} OR {$linked_domain} ";
        }

        $sql = "SELECT u.*,p.cell_number,  concat(u.name,' ',u.surname) as full_name
                FROM users u 
                LEFT JOIN profiles p
					ON p.user_id = u.id
                LEFT JOIN user_domain ud
                    ON u.id = ud.user_id
				WHERE {$where}
                GROUP by u.id
                ";
                
        return Database::query($sql)->fetch_all();
	}

    //hack domain_id can be an array
    static function bursars($domain_id, $where='') {
        if(!is_array($domain_id)) {
            $where .= " AND u.domain_id = {$domain_id} ";
        } else {
            $main_domain = Database::in_clause('u.domain_id', $domain_id);
            $linked_domain = Database::in_clause('ud.domain_id', $domain_id);
            $where .= " AND ({$main_domain} OR {$linked_domain}) ";
        }

        $sql = "SELECT u.*,p.cell_number,  concat(u.name,' ',u.surname) as full_name
                FROM groups g, users u
                LEFT JOIN profiles p
                    ON p.user_id = u.id
                LEFT JOIN user_domain ud
                    ON u.id = ud.user_id

                WHERE {$where} 
                AND g.account = 'bursar'
                AND g.id = u.group_id
                GROUP by u.id
                ";
                
        return Database::query($sql)->fetch_all();

    }

}
?>