<?php
class Forum extends AppModel {
	
	const table = 'forums';
	
	public $validate = array(
        'not_null' 	=> array('forum'),		
		'number' => array('id')
    );
	
	public function get_domains() {
	
		if(!$this->id) {
			return false;
		}
	
		$rs = $this->query("SELECT d.* FROM forum_domain fd,domains d WHERE d.id = fd.domain_id AND fd.forum_id = '{$this->id}'");
		$return = array();
	
		while(($row = $rs->fetch()) !== false) {
			$return[$row['id']] = $row;
		}
	
		return $return;
	}
	
	
	public function update_domains($domains) {
	
		if(!is_array($domains) || !$this->id) {
			return false;
		}

		$domains = array_unique($domains);
		$this->query("DELETE FROM forum_domain WHERE forum_id = '{$this->id}' ");
	
		foreach($domains as $domain) {
			$this->query("REPLACE into forum_domain(domain_id, forum_id) VALUES ('{$domain}','{$this->id}')");
		}
	}
	
	
	public function get_unselected_domains() {
		
		$rs = $this->query("SELECT * FROM domains WHERE id NOT IN (SELECT domain_id FROM forum_domain)"); 
	
		$return = array();
	
		while(($row = $rs->fetch()) !== false) {
			$return[$row['id']] = $row;
		}
	
		return $return;
	}
	
	static function get_by_domain_id($domain_id) {
		
		$rs = Database::query( " SELECT forum_id FROM forum_domain WHERE domain_id = '{$domain_id}' ")->fetch();
		
		if($rs === false) {
			return false;
		}
		
		return new Forum($rs['forum_id']);

	} 
	
	static function delete($id = 0) {
		
		if(!$id) {
			return false;
		}
		
		parent::delete($id);
		$sql = "DELETE FROM forum_domain WHERE forum_id = {$id}";
		Database::query($sql);
		
	}
	
}
?>