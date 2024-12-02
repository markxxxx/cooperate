<?php declare(strict_types=1)

class Result {

	private $rs;
	private $conn;


	public function __construct($result,$connection) {
		$this->rs = $result;
		$this->conn = $connection;
	}
	
	public function fetch($type = 'assoc') {
		$function = 'mysqli_fetch_' . $type;
		return $function($this->rs);
	}
	
	public function fetch_all($type = 'assoc') {
		$temp = array();
		while($row = $this->fetch($type)) 
			$temp[] = $row;
		return $temp;
	}
	
	public function num_rows() {
		return mysqli_num_rows($this->rs);
		
	}
	
	public function insert_id() {
		return mysqli_insert_id($this->conn) ;
	}

	public function __call($method,$args) {
		
		$method = strtolower($method);

		if(strpos($method ,'fetch_') !== false) {

			$amount_of_records = substr($method,6);
			
			if(!is_numeric($amount_of_records)) {
				Error("Result::__call(fetch_X)"," expects X to be numeric, X = $amount_of_records");	
			}

			$temp = array();

			for($i = 0; $i < $amount_of_records; $i++) {
				$return = strlen($args[0]) > 0 ? $args[0] : 'assoc';
				$temp[] = $this->fetch();
			}
			
			return $temp; 


		} else {
			Error("Result::__call($method)", "Call to undefined method Result::$method()");
		}
		
	}

}

?>