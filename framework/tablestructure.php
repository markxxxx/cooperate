<?php

class TableStructure {

	public $columns;
	public $cache = true;
	public $table;


	public function __construct($table) {
		$this->table = $table;
        
        $cache_name = 'tablestucture'.$table;
		
		if(($columns = Cache::get($cache_name)) === false ) {
        
            $columns =  Database::query('SHOW COLUMNS FROM `' .$table.'`');
            $temp = array();
            while($column = $columns->fetch()) {
                $temp[] = $column['Field'];
            }
			
			$columns = $temp;
			
			Cache::set($cache_name , $columns, 3 * HOUR );
		}

		$this->columns = $columns;
	}

	static function getInstance($table) {
		static $instant = array();
		if(!array_key_exists($table, $instant)) {
			$instant[$table] = new TableStructure($table);
		}
		return $instant[$table];
	}
	
	public function total_rows() {
		return Database::query('SELECT count(*) as total_rows FROM `' .$this->table.'`')->fetch('object')->total_rows;
	}
	
	public function field_exsists($field) {
		return (in_array($field,$this->columns));
	}

}

?>