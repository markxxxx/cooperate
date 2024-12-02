<?php declare(strict_types=1)

class Model {
	
	public $table = false;
	public $cache = false;
	public $structure;
	public $id = false;


	public function __construct($id = 0) {
        
        
        $class = get_called_class();

        $this->table = $class::table;
        
 
		if(!strlen($this->table)) {
			Error('Model::__constuct()','Model expects table const table');

        }

		$this->structure = TableStructure::getInstance($this->table);
		return $this->initialise($id);
	}

	private function initialise($id = 0) {

		if(!$id) {
			$this->id = 0;
			return false;
		}

		if($this->cache === true) {
			
			$cache_name = 'table_'.$this->table.'_'.$id;
			$row_data = Cache::get($cache_name);

			if($row_data === false) {
				
				$row_data = $this->_find("id = '$id'")->fetch();
				Cache::set($cache_name, $row_data);

			}
			

		} else
			$row_data = $this->_find("id = '$id'")->fetch();
		


		if(!$row_data)
			return false;
        
        $row_data = escape($row_data);
        
		foreach($row_data as $field => $value) {	
			$this->{$field} = $value;
		}

		return true;

	}

    public function auto_inc() {

        $table = $this->table;
        return Database::query("SHOW TABLE STATUS LIKE '{$table}'")->fetch('object')->Auto_increment;

    }

    static function edit( $fields=0, $where = " 1=1 ") {

        $class = get_called_class();
        $table = $class::table;

        if(!$fields) {

            Error('Model::edit()','Fields required');

        }

        if(is_array($fields)) {

            foreach($fields as $field => $value) {
                 $update[] = "$field = '$value'";
            }

            $update = implode($update,' , ');

        } else {
            $update = $fields;
        }
        
        if(is_numeric($where)) {
            $where = "id = '{$where}'";
        }

        Database::query("UPDATE `{$table}` SET {$update} WHERE {$where}");

    }

	static function getInstance($id=0) {
	
		static $instant;
		$class = get_called_class();
		if(@!is_object($instant[$class][$id])) {
			$instant[$class][$id] = new $class($id);
		}
		if(!$id)
			$instant[$class][$id]->clear();
		return $instant[$class][$id];
	}

	public function __toString() {
		return isset($this->id) ? (string) $this->id : '0';
	}

	function to_array() {
		$set_fields = array();
		foreach($this->structure->columns as $column) {
			if(isset($this->{$column})) {
				$set_fields[$column] = $this->{$column};
			}
		}
		return $set_fields;
	}
	
	function to_json() {
		return json_encode($this->to_array());
	}

	public function insert() {
		
		$columns = $this->to_array();
		
		if($this->structure->field_exsists('created_on')) {

			if(!strlen(@$columns['created_on'])) {
				$columns['created_on'] = date('Y-m-d H:i:s');
				$this->created_on = $columns['created_on'];
			}
		}
		
		$fields = '';
		$values = '';
		
		foreach($columns as $field => $value) {
			$fields .= $field . ',';
			$values .= "'" . $value . "',";
		}
		
		$fields = rtrim($fields,',');
		$values = rtrim($values,',');
		
		$sql = "INSERT INTO `{$this->table}` ($fields) VALUES ($values)";

		$id = $this->query($sql)->insert_id();
		
		if(!$id) {
			return false;
		}
		
		$this->id = $id;
		
		return true;
		
	}

	public function get() {
		
		$columns = $this->to_array();
		
		if(!count($columns))
			return false;
		
		$where = array();
		
		if(@$columns['id'] == 0) {
			unset($columns['id']);
		}
		
		foreach($columns as $field => $value) {
            $where[] = "$field = '$value'";
		}
		
		$where = implode($where,' AND ');
		
		$sql = 'SELECT * FROM '. $this->table . ' WHERE '.$where;
		
		$row = $this->query($sql)->fetch();
		
		if(!$row) {
			
			$this->id = 0;
			return false;
		}
			
		
		foreach($row as $field => $value) {	
			$this->{$field} = $value;
		}
		
		return true;
		
	}
	
	public function update() {

		
		if(!$this->id) {
			Error('AcitiveRecord::update','Object not initialized');
		}
		
		$columns = $this->to_array();
		
		if($this->structure->field_exsists('modified_on')) {
			$columns['modified_on'] = date('Y-m-d H:i:s');
			$this->modified_on = $columns['modified_on'];
		}
		
		$set = array();
		
		foreach($columns as $field => $value) {
			$set[] = "{$field} = '{$value}'";
		}
		
		$set = implode($set,',');

		
		$sql = " UPDATE `{$this->table}` SET {$set} WHERE id = {$this->id} ";

		$this->query($sql);
        
        if($this->cache === true) {
            $this->delete_cache();
        }
		
	}
	
	public function destroy() {
		
		if(!$this->id) {
			Error('AcitiveRecord::destroy','Object not initialized');
		}
		$sql = "DELETE FROM {$this->table} WHERE id = '{$this->id}' LIMIT 1";
		$this->query($sql);
		$this->clear();
		unset($this);
		
	}
	
    static function delete($id = 0) {

        if(is_array($id)) {
			$temp = '';
            foreach($id as $i) $temp .= "'{$i}',";
			$id = rtrim($temp, ',');
        } elseif(is_numeric($id)) {
			$id = "'{$id}'";
		} else {
			return false;
		}
		
        $class = get_called_class();
        $table = $class::table;

        $sql = "DELETE FROM `{$table}` WHERE id in ({$id}) ";

        Database::query($sql);

    }

    static function find($args = array()) {
        $class = get_called_class();
		$ar = call_user_func_array(array($class,'getInstance'),array());
        return $ar->_find($args);    
    }
    
	public function _find($search_clause=0) {
		
		if(!is_array($search_clause)) {


            $search_clause = strlen($search_clause) == 0 ? ' 1 = 1 ' : $search_clause;

            
			$sql = 'SELECT * FROM `'. $this->table . '` WHERE '. $search_clause;
		
		} else {
			$clause = array_values($this->parse_array_clause($search_clause));

			$sql = sprintf('SELECT %1$s FROM `%2$s` %3$s %4$s %5$s',
				$clause[0],$this->table,$clause[1],$clause[2],$clause[3]);  
		}
		
		return $this->query($sql);
		
	}

	static public function fields() {
		$class = get_called_class();
		return TableStructure::getInstance($class::table)->columns;

	}
	
	public function parse_array_clause($qs_array=array()) {
		
		$clauses = array(
            'fields'=> '*',
            'where' => 'WHERE 1=1',
            'order' => 'ORDER BY id DESC',
            'limit' => ''
        );

    
        if(!is_assoc($qs_array)) {
            
            if(!is_array($qs_array)) {
            	if(strlen($qs_array) > 1)
                	$clauses['where'] = ' WHERE ' . $qs_array;
                return $clauses;
            } 
            return $clauses;
            
        } else {
	
			$keys=array_keys($qs_array);
			$is_valid = array_shift($keys);
			
			if(!array_key_exists($is_valid,$clauses)) {
                
                if(!count($qs_array)) {
                    return $clauses;
                }
                
                $where = array();
                foreach($qs_array as $key => $value){
                    $where[] = "$key = '$value'";
                }
				
                $where = implode(' AND ', $where);
                $clauses['where'] = ' WHERE ' .$where;
                return $clauses;
            }
	
            if(array_key_exists('where',$qs_array)) {
                
                $where = array();
                
                if(!is_array($qs_array['where'])) {
                
                    $clauses['where'] = ' WHERE ' .$qs_array['where'];
                    
                } else {

                    foreach($qs_array['where'] as $key => $value) {
                        $where[] = "$key = '$value'";
                    }

                    $where = implode(' AND ', $where);
                
                    $clauses['where'] = ' WHERE ' .$where;
                }
            } 
            
            if(array_key_exists('fields',$qs_array)) {
                $clauses['fields'] = $qs_array['fields'];
            }
            
            if(array_key_exists('order',$qs_array)) {
                $clauses['order'] = ' ORDER BY '. $qs_array['order'];
            }
            
            if(array_key_exists('limit',$qs_array)) {
                $clauses['limit'] .= ' LIMIT '. $qs_array['limit'];
            }
        
            return $clauses;
        
        }
    }
    
	public function method_name_to_sql($method_name, $function='findby_' , $args = array()) {

        $clean_text_to_decode = substr($method_name,strlen($function));
        $arg_pos = 0;
        $total_joins = count(explode('_and_',$clean_text_to_decode)) + 
        		count(explode('_or_',$clean_text_to_decode)) - 2;
 
        
        if((count($args) -1  != $total_joins ) && $total_joins)
        	Error('Model::method_name_to_sql', "Too few arguments");
        		
        
        $sql = "1 = 1 AND ";
        
        while(true) {
            
            $and_pos = strpos($clean_text_to_decode,'_and_');
            $or_pos = strpos($clean_text_to_decode,'_or_');


            
            if(($and_pos === false ) && ($or_pos === false)) {
            	if($total_joins)
                	$sql .= " $clean_text_to_decode = '{$args[$arg_pos]}' ";
                else
                	$sql .= " $clean_text_to_decode in ('" . rtrim(implode("','",$args),',') ."')" ; 
                break;
            }
            
            
            if( ($and_pos < $or_pos) && ($and_pos !== false))
                $seperator = '_and_';
            else
                if($or_pos === false)
                    $seperator = '_and_';
                else
                    $seperator = '_or_';
                
            
                

            $join_method = strtoupper(trim($seperator,'_'));
            
            $clean_text_to_decode = explode($seperator, $clean_text_to_decode);
            $field = array_shift($clean_text_to_decode);
            $clean_text_to_decode = implode($seperator, $clean_text_to_decode);
            
            
            $sql .= " {$field} =  '{$args[$arg_pos]}' {$join_method} ";
            
            ++$arg_pos;
            
        }
        return $sql;
    
    }

    static public function map($fields=array()) {
    	
    	$class = get_called_class();
		$ar = call_user_func_array(array($class,'getInstance'),array());

		foreach($fields as $field => $value) {
			if($ar->structure->field_exsists($field)) {
				$ar->{$field} = $value;
			}
		}
		return $ar;
    }

    public function update_attributes($fields) {

		if(!isset($this->id) or !$this->id) {
			return false;
		}

		$update = '';
		foreach($fields as $field => $value) {
			if($this->structure->field_exsists($field)) {
				$this->{$field} = $value;
                
                //evil hack
                if(strpos($value, '+') === false) {
                    $update .= " {$field} = '{$value}',";
                } else {
                    $update .= " {$field} = {$value},";

                }
                    
			}
		}
		if(!strlen($update)) {
			return false;
		}
        $update = rtrim($update, ',');
        
		$this->query("UPDATE {$this->table} SET $update WHERE id = {$this->id}");
		
	}

    public function update_map($fields) {

        foreach($fields as $field => $value) {

			if($this->structure->field_exsists($field)) {
				$this->{$field} = $value;
			}
		}
    }

    public function aggregate($field,$aggregation_method='max',$qs=array()) {
    	
        $clauses = $this->parse_array_clause($qs);
        
        $sql = "SELECT {$aggregation_method}($field) as ar_aggregation ". 
        		"FROM `{$this->table}` {$clauses['where']} {$clauses['limit']}";
        return $this->query($sql)->fetch('object')->ar_aggregation;
        
    }
    
	private function increment($field, $increment_by=1) {
		
		$this->{$field} += $increment_by;
        $sql = "UPDATE `{$this->table}` SET {$field} = {$field} + {$increment_by} WHERE id = '{$this->id}' "; 

        $this->query($sql);
        return true;
		
	}
	
	public function clear() {
		$columns = $this->to_array();
		foreach($columns as $field => $value) {
			unset($this->{$field});
		}
	}
	
	public function add_validation($field=null,$rule=null) {
	
		if(is_null($field) || is_null($rule)) 
			Error('Model::addValidation', "Requires the following parameters: field, rule");
		
		$field = strtolower($field);
		$rule = strtolower($rule);
		
		if(array_key_exists($rule,$this->validate)) {
		
			$current_fields = $this->validate[$rule];
			if(!is_array($current_fields))
				$current_fields = array($current_fields);
			$current_fields[] = $field;
			$this->validate[$rule] = array_unique($current_fields);
			
			
		} else {
			$this->validate[$rule] = array($field);
		}
	
	}
	
	public function remove_validation($field=null,$rule=null) {
		
		if(is_null($field)) 
			Error('Model::removeValidation', "Requires the following parameters: field");
				
		$source = $this->validate;
		
		if(!is_null($rule)) {
            
            if(array_key_exists($rule, $this->validate)) {
                
                $index = array_search($field, $this->validate[$rule]);
    
			    if($index !== false) {

                    unset($this->validate[$rule][$index]);
                }
		    }

            return true;

        }
		

		foreach($source as $rule => $value) {
			
			$temp = $this->validate[$rule];

			$index = array_search($field,$temp);
           
			if($index !== false) {
				
				$this->validate[$rule] = $temp;

				unset($this->validate[$rule][$index ]);
			}

		}	
    
	}
		
	public function validate() {
		
		if(!isset($this->validate)) 
			return true;
			
		$validate =  Validate::getInstance();
		
		$validation_errors = array();
		
		foreach($this->validate as $rule => $fields) {
	
			if(!method_exists($validate,$rule))
				Error("Model::validate()", "Method not found Validate::$rule'");
			
			
			if(!is_array($fields))
				$fields = array($fields);


			
			foreach($fields as $key => $value) {
				
				if(is_array($value)) {
					$conditions = $value;
					$field = $key;
				} else {
					$field = $value;
					$conditions = array();
				}
				
				if(!array_key_exists($field,$validation_errors)) { 
			
					$conditions = array_merge($conditions,array('field'=>$field,'table'=>$this->table));
	
					if(!isset($this->{$field}))
						$validation_errors[$field] = $rule; 
					else 
						if(!$validate->$rule($this->{$field}, $conditions))
							$validation_errors[$field] = $rule; 
				
				}
			
			}
		
		}
		

        Template::getInstance()->assign('validation_errors', $validation_errors);

        
		return count($validation_errors) > 0 ? false : true;

        
	}

	public function delete_cache() {

		Cache::delete('table_'.$this->table.'_'.$this->id);
		
		for ($i = 0, $count = func_num_args(); $i < $count; $i++) {
			Cache::delete(func_get_arg($i).'_'.$this->id);
		}

	}

	public static function query($sql) {
		
		return Database::query($sql);
	}
	
	public function __call($method,$args) {
		
		$method = strtolower($method);
		
		switch(true) {
	        case substr($method,0,strpos($method,'_')) == 'inc' :
	        	
	        	if($this->id) {
	        		$field = substr($method,strpos($method,'_'));
	        		$this->increment(substr($method,strpos($method,'_') + 1),$args[0]);
	        	} else {
	        		Error('Model::__call(increment)','Object not initialized');
	        	}
	        break;
			default :
				Error("Model::__call()", "Call to undefined method Model::$method() ");
			break;
		}
		
	}

	static function __callStatic($method,$args) {

		$method = strtolower($method);
		$class = get_called_class();
		$ar = call_user_func_array(array($class,'getInstance'),array());
		
		switch(true) {

	        case (strpos($method,'_by_') == true) :
	            list($select_field,$find_field) = explode('_by_',$method);
			    return $ar->query("SELECT {$select_field} as method_return FROM `{$ar->table}` WHERE {$find_field} = '{$args[0]}'")->fetch('object')->method_return;

	        break;
			
	        case substr($method,0,7) == 'findby_':
	        	$where = $ar->method_name_to_sql($method,'findby_',$args);
	        	return  $ar->query("SELECT * FROM `{$ar->table}` WHERE {$where}");
	         
	        break;
			
			case $method == 'count':
				return $ar->aggregate('*','count', $args[0]);
			break;
			
			case in_array(substr($method,0,strpos($method,'_')),array('min','max','count','sum')) :
				$function = substr($method,0,strpos($method,'_'));
				$field = substr($method, strlen($function)+1);
				return $ar->aggregate($field, $function, $args[0]);
				
			break;	
			default :
				Error("Model::__callStatic()", "Call to undefined method Model::$method() ");
			break;

		}
		

	
	}

}

?>