<?php declare(strict_types=1)
class Payment extends AppModel {
	
	const table = 'payments';

	private $instance_cache = array();

	public $validate = array(
        'not_null' 	=> array(),		
		'number' => array('id')
    );
    
	public static function delete($id) {
		parent::delete($id);
		Database::query("DELETE FROM user_payment WHERE payment_id = '{$id}' ");
	}

    //Override Model find
    public static function find($clause) {
    
        $where = isset($clause['where']) ? ' WHERE '. $clause['where'] : '';
        $limit = isset($clause['limit']) ? ' LIMIT ' .$clause['limit'] : '';
        $order = isset($clause['order']) ? ' ORDER BY ' .$clause['order'] : '';
		
		$group = '';

		if(isset($clause['count'])) {
			$fields = ' COUNT(DISTINCT p.id) as cnt ';
		} else {
			$fields = "p.id, p.name, p.created_on, p.modified_on, p.enabled,
		                CONCAT(u1.name,' ', u1.surname) created,
		                CONCAT(u2.name,' ', u2.surname) closed ";

		    $group = ' GROUP by p.id ';
           
		}
		
		
        $sql = "SELECT $fields
                FROM payments p INNER JOIN users u1
					ON p.created_by = u1.id
                LEFT JOIN users u2
					ON p.closed_by = u2.id 
				INNER JOIN payment_domain pd
					ON pd.payment_id = p.id
					
                {$where}
                {$group}
                {$order}
                {$limit}";

        return Database::query($sql);
    }

    static function count($clause) {
		return self::find(array('count'=>1, 'where'=> $clause['where']))->fetch('object')->cnt;
	}
    
    public function get_title() {
        return $this->name;
    }

    public function add_user($user_id = 0, $added_by = 0) {
        $sql = "INSERT into user_payment(user_id, payment_id, added_by) VALUES('{$user_id}', '{$this->id}', '{$added_by}') ";
        $rs = $this->query($sql);
        return $rs->insert_id();
    }
	
    public function add_supplier($supplier_id = 0, $added_by = 0, $user_id=0) {
        $sql = "INSERT into user_payment(user_id, payment_id, added_by, supplier_id) VALUES('0', '{$this->id}', '{$added_by}', '{$supplier_id}') ";
        $rs = $this->query($sql);
        return $rs->insert_id();
    }

	public function edit_user($payment_id, $amount, $reference, $reference_2 , $supplier_id) {
		Database::query("UPDATE user_payment SET amount = '{$amount}', reference = '{$reference}',reference_2 = '{$reference_2}' ,  supplier_id = '{$supplier_id}' WHERE id = '{$payment_id}'");
	}

	public function update_domains($domains) {
	
		if(!is_array($domains) || !$this->id) {
			return false;
		}
		
		$domains = array_unique($domains);
		$this->query("DELETE FROM payment_domain WHERE payment_id = '{$this->id}'");
		
		foreach($domains as $domain) {
			$this->query("REPLACE into payment_domain(domain_id, payment_id) VALUES ('{$domain}','{$this->id}')");
		}
	}
	
	public function get_domains() {
		
		if(!$this->id) {
			return false;
		}

		//precache
		if(isset($this->instance_cache['get_domains'])) {
			return $this->instance_cache['get_domains'];
		}
		
		$rs = $this->query("SELECT d.* FROM payment_domain pd, domains d WHERE d.id = pd.domain_id AND pd.payment_id = '{$this->id}'");
		$return = array();
		
		while($row = $rs->fetch()) {
			$return[$row['id']] = $row;
		}

		return $this->instance_cache['get_domains'] = $return;
	}
	

	public function get_budgets() {
		
		if(!$this->id) {
			return false;
		}

		$sql = "SELECT b.* 
				FROM budgets b, user u, user_payment up 
				WHERE b.id = u.budget_id 
				AND u.id = up.user_id 
				AND up.payment_id = {$this->id} 
				GROUP by b.id";

		return Database::query($sql)->fetch_all();
	}

	public function get_users($show_all=false) {
		
		$where = '';
		if(!$show_all) {
			$where = " and (up.amount = 0 OR up.reference = '') ";
		}
		
		// $sql = "SELECT up.amount, 
		// 				up.reference,
		// 				up.reference_2, 
		// 				up.id, 
		// 				u1.id as user_id, 
		// 				u2.id as added_id,
		// 				d.reference as domain_ref, 
		// 				up.supplier_id ,
		// 				CONCAT(u1.name,' ', u1.surname) user,
		// 				CONCAT(u2.name,' ', u2.surname) added
		// 		FROM user_payment up 
		// 		INNER JOIN users u1	ON up.user_id = u1.id
		// 		INNER JOIN users u2 ON up.added_by = u2.id
		// 		INNER JOIN domains d ON d.id = u1.domain_id
		// 		WHERE 
		// 			up.payment_id = {$this->id}
		// 		{$where}
		// 		";

		$sql = "SELECT up.amount, 
						up.reference,
						up.reference_2, 
						up.id, 
						u1.id as user_id, 
						u2.id as added_id,
						d.reference as domain_ref, 
						up.supplier_id ,
						s.supplier,
						CONCAT(u1.name,' ', u1.surname) user,
						CONCAT(u2.name,' ', u2.surname) added
				FROM user_payment up 
				LEFT JOIN users u1	ON up.user_id = u1.id
				LEFT JOIN users u2 ON up.added_by = u2.id
				LEFT JOIN domains d ON d.id = u1.domain_id
				LEFT JOIN suppliers s ON s.id = up.supplier_id
				WHERE 
					up.payment_id = {$this->id}
				{$where}

				UNION ALL

				SELECT up.amount, 
						up.reference,
						up.reference_2, 
						up.id, 
						u1.id as user_id, 
						u2.id as added_id,
						d.reference as domain_ref, 
						up.supplier_id ,
						s.supplier,
						CONCAT(u1.name,' ', u1.surname) user,
						CONCAT(u2.name,' ', u2.surname) added
				FROM user_payment up 
				RIGHT JOIN users u1	ON up.user_id = u1.id
				RIGHT JOIN users u2 ON up.added_by = u2.id
				RIGHT JOIN domains d ON d.id = u1.domain_id
				RIGHT JOIN suppliers s ON s.id = up.supplier_id
				WHERE 
					up.payment_id = {$this->id}
				{$where}
				";

		return $this->query($sql)->fetch_all();
	
	}
	
	public function delete_user($user_id = 0) {
		$this->query("DELETE FROM user_payment where id = '{$user_id}' AND payment_id = '{$this->id}' ");
	}
    
    static public function user_log($user_id = 0, $year = -1, $supplier_id = 0) {
    
        $where = '';
        
        if($year != '-1') {
            $where .= " AND YEAR(p.created_on) = '{$year}' ";
        }

        if($supplier_id != 0) {
        	$where .= " AND up.supplier_id = '{$supplier_id}' ";
        }
        
        $sql = "SELECT p.*, up.amount, up.reference , up.reference_2, SUBSTR(p.created_on,1,4) as year
                FROM user_payment up, payments p
                WHERE p.id = up.payment_id
                {$where}
                
                AND up.user_id = '{$user_id}'";
        return Database::query($sql)->fetch_all();
        
    }
    
    static public function user_summary($user_id = 0) {
        
        if(!$user_id) {
            return false;
        }
        
        $sql =" SELECT SUBSTR(p.created_on,1,4) as year, sum(up.amount) as total_expenditure,up.reference
                FROM user_payment up INNER JOIN users u
                    ON up.user_id = u.id
                INNER JOIN payments p
                    ON p.id = up.payment_id
                WHERE u.id = '{$user_id}'
                GROUP by SUBSTR(p.created_on,1,4),up.reference ";
        
        $rs = Database::query($sql);
        
        $rows = array();
        while($row =  $rs->fetch()) {
            $rows[$row['year']]['rows'][] = $row;
            $rows[$row['year']]['summary'] += $row['total_expenditure'];
        }
        
        return $rows;
        
    }

    static public function get_years() {

        $sql =" SELECT SUBSTR(p.created_on,1,4)  as year
        		FROM payments p
                GROUP by year
                ORDER by SUBSTR(p.created_on,1,4) DESC
                ";
                
       return Database::query($sql)->fetch_all();
    }

    
    static public function get_years_by_domain($domain_id = 0) {
        
        if(is_numeric($domain_id)) {
            $filter = " u.domain_id = {$domain_id} ";
        } else {
            $filter = " u.domain_id in ({$domain_id}) ";
        }
        
        $sql =" SELECT SUBSTR(p.created_on,1,4) as year
                FROM user_payment up INNER JOIN users u
                    ON up.user_id = u.id
                INNER JOIN payments p
                    ON p.id = up.payment_id
                WHERE {$filter}
                GROUP by SUBSTR(p.created_on,1,4)
                ORDER by SUBSTR(p.created_on,1,4) DESC
                ";
                
       return Database::query($sql)->fetch_all();
    }

    public function get_guid() {
        if(!$this->id) {
            return false;
        }
        return '/payment/batch_edit/'.$this->id;
    }


}
?>