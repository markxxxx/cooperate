<?php declare(strict_types=1)

class Validate {
	
	public function check($regex, $value) {
		return  preg_match($regex, $value);
	}	

	public function number($value) {
		if(!strlen($value) or is_null($value)) {
            return true;
        }
		return is_numeric($value);
	}
	
	public function email($value) {
        if(!strlen($value) or is_null($value)) {
            return true;
        }
		$regex = '/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.(com|org|net|biz|info|name|net|pro|aero|coop|museum|[a-z]{2,4}))$)\\z/i';
		return $this->check($regex,$value);
		
	}
	
    public function url($value) {
        if(!strlen($value) or is_null($value)) {
            return true;
        }
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $value);
    }
    
	public function username($value) {
		$regex = '/^[A-Za-z0-9]+$/';
		return $this->check($regex,$value);
	}
	
	public function not_null($value) {
		$regex = '/\S/';
		return $this->check($regex,$value);
	}

	public function unique($value, $conditions) {
		$db = Database::getInstance();
		if(!array_key_exists('table',$conditions))
			Error('Validate::unique', "Requires the following parameter: table");
		if(!array_key_exists('field',$conditions))
			Error('Validate::unique', "Requires the following parameter: field");
		extract($conditions);
		
		$sql = "SELECT count(*) as cnt FROM {$table} WHERE {$field} = '{$value}'";
		return $db->query($sql)->fetch('object')->cnt == 0 ? true : false;
	}

	public function length($value,$conditions) {
	
		if(!strlen($value) or is_null($value)) {
            return true;
        }
		
		$value_length = strlen($value);
		if(!array_key_exists('min',$conditions))
			$min = null;
		if(!array_key_exists('max',$conditions))
			$max = null;
		if(!array_key_exists('equal',$conditions))
			$equal = null;
			
		extract($conditions);

		if(!is_null($equal)) {
			return $value_length == $equal;
		}elseif(!is_null($min) && !is_null($max)) {
			return $value_length >= $min && $value_length <= $max;
		} elseif(!is_null($min)) {
			return $value_length >= $min;
		} elseif(!is_null($max)) {
			return $value_length >= $string;
		}
		Error('Validate::length', "Expects at least 1 parameters: min or max or equal");

	}
	
	static function getInstance() {

		static $instant;
		if(!is_object($instant)) {
			$instant = new Validate();
		}
		return $instant;

	}

}


?>