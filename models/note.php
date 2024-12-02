<?php
class Note extends AppModel {
	
	const table = 'notes';
	
	public $validate = array(
        'not_null' 	=> array(),		
		'number' => array('id','created_by')
    );
    
    //Override Model find
    public static function find($clause) {
    
        $where = isset($clause['where']) ? ' WHERE '. $clause['where'] : '';
        $limit = isset($clause['limit']) ? ' LIMIT ' .$clause['limit'] : '';
        $order = isset($clause['order']) ? ' ORDER BY ' .$clause['order'] : '';

        $sql = "SELECT n.*, CONCAT(u1.name,' ', u1.surname) created, u1.group_id
                FROM notes n INNER JOIN users u1
					ON n.created_by = u1.id
                LEFT JOIN users u
					ON u.id = n.user_id
                {$where}
                {$order}
                {$limit}";

        return Database::query($sql);
    }
}
?>