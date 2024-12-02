<?php

class User extends AppModel {
	
	const table = 'users';

    public $cache = true;

    private $instance_cache = array();

    private
        $permissions = array(),
        $group = array();


    public $validate = array(
        'not_null' => array('name','surname','domain_id','group_id'),
        'email' => array('email'),
        'number' => array('id'),
        'unique' => array('email')
    );

    public function __construct($id) {
        parent::__construct($id);
        $this->permissions = $this->get_permissions();
    }
	
    public static function current() {

    	static $user_instant; 

    	if(!is_object($user_instant)) {
	        if (!isset($_SESSION['id'])) {
	            $user_instant = User::map(array('id' => 0, 'group_id' => 0));
	        } else {
	            $user_instant = new User($_SESSION['id']);
	        }
	    }

	    return $user_instant;

    }

    public function is_admin() {
        if(!$this->id) {
            return false;
        }
        return Group::getInstance($this->group_id)->is_admin();
    }

    public function is_super() {
        if(!$this->id) {
            return false;
        }
        return Group::getInstance($this->group_id)->is_super();
    }

    public function get_permissions() {
		
		if(!isset($this->group_id)) {
			$this->group_id = 0;
		}
        $cache_name = "group_permission_{$this->group_id}";

        if(($permissions = Cache::get($cache_name)) === false) {

            $permissions = array();
            
            foreach(Group::permissions($this->group_id) as $row) {
                $permissions[$row['class'].$row['method']] = $row['can_access'];
            }
            
            Cache::set($cache_name, $permissions, 10 * DAY );
        }
        return $permissions;
        
    }

    public function get_title() {
        if(!$this->id) {
            return false;
        }
        return ucfirst(strtolower($this->name)) . ' ' . ucfirst(strtolower($this->surname));
    }

    public function get_guid() {
        if(!$this->id) {
            return false;
        }
        return '/'.$this->id;
    }

    public function unread_messages() {

        if(!$this->id) {
            return 0;
        }
        $sql = "SELECT count(*) as cnt FROM messages WHERE recipient_id = '{$this->id}' AND opened = '0' ";
        
        return Database::query($sql)->fetch('object')->cnt;
    }

    public function get_groups($where ="") {

        if(!$this->id) {
            return false;
        }

        //precache
        if(isset($this->instance_cache['get_groups'])) {
        	return $this->instance_cache['get_groups'];
        }

        if(!$this->is_super()) {
            return $this->instance_cache['get_groups'] = Group::priorities($this->group_id);
        } else {
            
            $rs = Group::find("id <> 0");
            $rows = array();
            while($row = $rs->fetch()) {
                $rows[$row['id']] = $row;
            }
            return $this->instance_cache['get_groups'] = $rows;
        }
    }

	public function can_access($controller, $method) {
	
        if(!array_key_exists($controller.$method, $this->permissions)) {
            return true;
        }
        return (bool) $this->permissions[$controller.$method];
		
	}

    public function has_domain_rights($object) {

        if(!method_exists($object, 'get_domains') && !property_exists($object , 'domain_id')) {
            return true;
        }

        $user_domains = array_keys($this->get_domains());

        $object_domains = array();

        if(method_exists($object, 'get_domains')) {
            $object_domains = array_keys($object->get_domains());
        } else {
            $object_domains[] = $object->domain_id;
        }

        foreach($user_domains as $u) {
            if(in_array($u, $object_domains)) {
                return true;
            }
        }

        return false;

    }

	public function get_domains() {
	
		if(!$this->id) {
            return false;
        }
        //precache
        if(isset($this->instance_cache['get_domains'])) {
        	return $this->instance_cache['get_domains'];
        }
        
        if (!$this->is_super()) {
            $rs = $this->query("SELECT d.* FROM user_domain ud,domains d WHERE d.id = ud.domain_id AND ud.user_id = '{$this->id}'");
        } else {
            $rs = Domain::find();
        }
        while($row = $rs->fetch()) {
            $return[$row['id']] = $row;
        }

        return $this->instance_cache['get_domains'] = $return;
	}

    public function update_domains($domains) {
	
        if(!is_array($domains) || !$this->id) {
            return false;
        }
        //if($this->admin) {
        $domains[] = $this->domain_id;
        //}
        $domains = array_unique($domains);
        $this->query("DELETE FROM user_domain WHERE user_id = '{$this->id}' ");
        
        foreach($domains as $domain) {
            $this->query("REPLACE into user_domain(domain_id, user_id) VALUES ('{$domain}','{$this->id}')");
        }
    }
	
	public function current_domain() {
		
		if(isset($_SESSION['domain_id'])) {
			return $_SESSION['domain_id'];
		} else {
			return @$this->domain_id;
		}
	}

    public static function get_profile_info($user_id) {
        return Profile::findby_user_id($user_id);
    }

    public static function json_autocomplete($users =array()) {

        $json = array();

        foreach($users as $user) {
            $json[] = $user['name']. ' ' . $user['surname'] . '__' . $user['id'];
        }
        return json_encode(array_values($json));

    }

    public static function delete($user_id = 0) {

        if($user_id == 0) {
            return false;
        }

        $is_user = new User($user_id);
        if(!$is_user->id) {
            return false;
        }

        $tables = Database::tables();
        foreach($tables as $t) {
            if(TableStructure::getInstance($t)->field_exsists('user_id')) {
                Database::query("DELETE FROM `{$t}` WHERE user_id = {$user_id}");
            }
        }
        parent::delete($user_id);
    }

}

?>