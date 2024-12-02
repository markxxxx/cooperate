<?php declare(strict_types=1)
class Supplier extends AppModel {
	
	const table = 'suppliers';
	
	public $validate = array(
        'not_null' 	=> array('supplier','bank','bank_acc','bank_branch','account_type','supplier_type_id'),
		'number' => array('id')
    );
    

    public function get_title() {
    	return $this->supplier;
    }

    public function get_guid() {
        return '/supplier/edit/'.$this->id;
    }

    static public function payment_log($supplier_id = 0, $year = -1) {
    
        $where = '';
        
        if($year != '-1') {
            $where .= " AND YEAR(p.created_on) = '{$year}'";
        }
        
        $sql = "SELECT p.*, up.amount, up.reference , up.reference_2, SUBSTR(p.created_on,1,4) as year,CONCAT(u.name, ' ', u.surname) as full_name, u.id as user_id
                FROM user_payment up, payments p,users u
                WHERE p.id = up.payment_id
                AND u.id = up.user_id
                {$where}
                
                AND up.supplier_id = '{$supplier_id}'";
                
        return Database::query($sql)->fetch_all();
        
    }
    
    static public function payment_summary($supplier_id = 0) {
        
        if(!$supplier_id) {
            return false;
        }
        
        $sql =" SELECT SUBSTR(p.created_on,1,4) as year, sum(up.amount) as total_expenditure,up.reference
                FROM user_payment up INNER JOIN suppliers s
                    ON up.supplier_id = s.id
                INNER JOIN payments p
                    ON p.id = up.payment_id
                WHERE s.id = '{$supplier_id}'
                GROUP by SUBSTR(p.created_on,1,4),up.reference ";
        
        $rs = Database::query($sql);
        
        $rows = array();
        while($row =  $rs->fetch()) {
            $rows[$row['year']]['rows'][] = $row;
            $rows[$row['year']]['summary'] += $row['total_expenditure'];
        }
        
        return $rows;
        
    }

    public function update_contacts($contacts=array()) {

        if(!is_array($contacts) || !$this->id) {
            return false;
        }
        
        $contacts = array_unique($contacts);
        
        $today = date('Y-m-d H:i:s');

        foreach($contacts as $contact) {
            $this->query("UPDATE contacts SET supplier_id = '{$this->id}' WHERE id = '{$contact}' ");
        }
    
    }

    public static function delete($supplier_id) {
        Database::query("UPDATE contacts SET supplier_id = '0' WHERE supplier_id = '{$supplier_id}'");
        parent::delete($supplier_id);
    }

    public static function json_autocomplete($suppliers =array()) {

        $json = array();

        foreach($suppliers as $supplier) {
            $json[] = $supplier['supplier']. '__' . $supplier['id'];
        }
        return json_encode(array_values($json));

    }



}
?>