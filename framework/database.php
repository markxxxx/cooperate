<?php declare(strict_types=1)

class Database {

	private $connection;
	public $settings = array();
	public $querys = array();


	function __construct() {
		global $config;
		$this->settings = $config['database'];
		$this->connection = mysqli_connect($this->settings['server'],$this->settings['username'],$this->settings['password']) or Error("Database::__construct()", mysqli_error($this->connection));
		mysqli_select_db($this->connection,$this->settings['database']) or Error("Database::__construct() ", mysqli_error($this->connection));
	}
	
	static function getInstance() {
		static $instant;
		if(!is_object($instant)) {
			$instant = new Database();
		}
		return $instant;
	}

	public static function query($sql) {
		$_this = Database::getInstance();
		
		$timer_start = getmicrotime();

		$rs = mysqli_query($_this->connection,$sql) or Error('Database::query',mysqli_error($_this->connection). '<br />' .$sql);
		$timer_stop = getmicrotime();
		$_this->querys[] = array(
			'sql'=>$sql,
			'time'=>round($timer_stop - $timer_start, 7)
		);
		return new Result($rs,$_this->connection) ;
	}
	
	function __destruct() {
		mysqli_close($this->connection) or Error('Database::__destruct',mysqli_error($this->connection));
	}

	public static function tables() {
		$tables = Database::query('SHOW TABLES')->fetch_all();
		$return = array();
		foreach ($tables as $t) {
			$return[] = array_pop(array_values($t));
		}
		return $return;
	}

	public static function not_in($field, $data = false) {
		if(!$data) {
			return false;
		}
		if(!is_array($data)) {
			return " '{$field}' = '{$data}' ";
		}

		$in_clause = '';
			foreach($data as $d) {
		$in_clause .= "'$d',"; 
		}
		$in_clause = rtrim($in_clause, ',');
		return " {$field} not in ($in_clause) ";
	}

	public static function in_clause($field, $data = false) {
		if(!$data) {
			return false;
		}
		if(!is_array($data)) {
			return " '{$field}' = '{$data}' ";
		}

		$in_clause = '';
			foreach($data as $d) {
		$in_clause .= "'$d',"; 
		}
		$in_clause = rtrim($in_clause, ',');
		return " {$field} in ($in_clause) ";
	}

}

?>