<?php declare(strict_types=1)
class Contact extends AppModel {
	
	const table = 'contacts';
	private $instance_cache = array();
	
	public $validate = array(
        'not_null' 	=> array('name','domain_id','email')		
    );


    static public function find($filter = array()) {

        //this is for contact search
        $user = User::current();

        if($user->id) {
            $where_clause .= ' AND '. Database::in_clause('c.domain_id', array_keys($user->get_domains()));
        }
        
        if(isset($filter['where'])) {
            $where_clause .= $filter['where'];
        }

        if(isset($filter['limit']) && strlen($filter['limit'])) {
            $limit = "LIMIT {$filter['limit']}";
        } else {
            $limit = "LIMIT 0, 1000";
        }

        $sql = "SELECT c.* 
                FROM contacts c , contact_types ct 
                WHERE ct.contact_id = c.id
                {$where_clause}
                GROUP by c.id
                ORDER by c.image_src DESC
                {$limit}
                
                ";

        return Database::query($sql); 
    }   


    static public function count($filter = array()) {

        $where_clause .= ' AND '. Database::in_clause('c.domain_id', array_keys(User::current()->get_domains()));
        
        if(isset($filter['where'])) {
            $where_clause .= $filter['where'];
        }



        $sql = "SELECT count(DISTINCT(c.id)) as cnt 
                FROM contacts c , contact_types ct 
                WHERE ct.contact_id = c.id
                {$where_clause}
                ";


        return Database::query($sql)->fetch('object')->cnt; 
    }   

    public function get_title() {
        return $this->name;
    }


    public function get_guid() {
        return '/contact/edit/'.$this->id;
    }

	public function update_events($events) {
	
		if(!is_array($events) || !$this->id) {
			return false;
		}
		
		$events = array_unique($events);
		
		$today = date('Y-m-d H:i:s');

		foreach($events as $event) {
			$this->query("REPLACE into contact_event(contact_id, event_id) VALUES ('{$this->id}','{$event}')");
		}
	}

	public function get_events() {

		if(!$this->id) {
			return false;
		}

		if(isset($this->instance_cache['get_events'])) {
			return $this->instance_cache['get_events'];
		}

		$rs = $this->query("SELECT e.*,ce.rsvp,ce.food_option FROM contact_event ce,events e 
								WHERE e.id = ce.event_id AND ce.contact_id = '{$this->id}'");
		$return = array();
		
		while($row = $rs->fetch()) {
			$return[$row['id']] = $row;
		}

		return $this->instance_cache['get_events'] = $return;
	}

    public function get_none_subcribed_events() {

    	$events = $this->get_events();
    	$where = '';
    	if(count($events)) {
    		$where = " AND " . Database::not_in('id', array_keys($events));
    	}

    	$date = date('Y-m-d');
    	$sql = "SELECT *
    			FROM events
    			WHERE event_date >=  {$date}
    			{$where}";

    	return Database::query($sql)->fetch_all();
    }

    public function count_sent_items() {

		if(!$this->id) {
			return 0;
		}

		$sql = "SELECT count(*) as cnt FROM contact_messages WHERE message_type = 'sent' AND contact_id = {$this->id}";
		return Database::query($sql)->fetch('object')->cnt;
    }

    public function get_sent_from() {
		$sql = "SELECT DISTINCT u.id, concat(u.name, ' ', u.surname) as name FROM users u, contact_messages cm WHERE cm.message_type = 'sent' AND contact_id = {$this->id} AND cm.user_id = u.id";
		return Database::query($sql)->fetch_all();
    }


    public function get_received_from() {
    	$sql = "SELECT DISTINCT u.id, concat(u.name, ' ', u.surname) as name FROM users u, contact_messages cm WHERE cm.message_type = 'received' AND contact_id = {$this->id} AND cm.user_id = u.id";
    	return Database::query($sql)->fetch_all();
    }

    public function count_received_items() {
		
		if(!$this->id) {
			return 0;
		}

		$sql = "SELECT count(*) as cnt FROM contact_messages WHERE message_type = 'received' AND contact_id = {$this->id}";
		return Database::query($sql)->fetch('object')->cnt;

    }

	/******
	** To to to fucken lazy to add pagnation and sort
	** Todo:never
	** So Limit 50
	*******/
    public static function search_mail($contact_id, $filters) {

    	$where = " AND cm.contact_id = '{$contact_id}' ";

    	if(isset($filters['user_id']) && (int) $filters['user_id'] > 0) {
    		$where .= " AND u.id = '{$filters['user_id']}' ";
    	}

    	if(isset($filters['search']) && strlen($filters['search'])) {
    		$where .= " AND (cm.subject like '%{$filters['search']}%' or cm.subject like '%{$filters['search']}%') ";
    	}

    	if(isset($filters['message_type']) && in_array($filters['message_type'], array('sent','received'))) {
    		$where .= " AND cm.message_type = '{$filters['message_type']}' ";
    	} else {
    		$where .=  " AND cm.message_type = 'sent' ";
    	}

    	$sql = "SELECT cm.id,concat(u.name, ' ', u.surname) as name, cm.subject, cm.message_date 
    			FROM contact_messages cm, users u WHERE cm.user_id = u.id {$where} ORDER by cm.message_date DESC LIMIT 50 ";

    	return Database::query($sql)->fetch_all();
    }

    public static function message_view($message_id=0) {
    	$sql = "SELECT * FROM contact_messages WHERE id='{$message_id}'";
    	return Database::query($sql)->fetch();
    }

    public static function json_autocomplete($users =array()) {

        $json = array();

        foreach($users as $user) {
            $json[] = $user['name']. '__' . $user['id'];
        }
        return json_encode(array_values($json));

    }


    public function get_types() {

        if(!$this->id) {
            return false;
        }

        $sql = "SELECT * FROM contact_types WHERE contact_id = '{$this->id}' ";

        $rows = array();

        $rs = Database::query($sql);

        while($row = $rs->fetch()) {
            $rows[$row['contact_type']] = $row;
        }

        
        return $rows;

    }


    public function update_types($types = array()) {

        if(!$this->id) {
            return false;
        }

        $sql = "DELETE FROM contact_types WHERE contact_id = '{$this->id}' ";

        Database::query($sql);

        foreach($types as $t) {
            $sql = "INSERT INTO contact_types(contact_id, contact_type) VALUES('{$this->id}', '{$t}' ) ";
            Database::query($sql);

        }

        return true;

    }




}
?>