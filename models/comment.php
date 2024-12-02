<?php
class Comment extends AppModel {
	
	const table = 'comments';
	
	public $validate = array(
        'not_null' 	=> array(),		
		'number' => array('id','created_by')
    );
    
    static function find($clause) {
    
        $where = isset($clause['where']) ? ' AND '. $clause['where'] : '';
        $limit = isset($clause['limit']) ? ' LIMIT ' .$clause['limit'] : '';
        $order = isset($clause['order']) ? ' ORDER BY ' .$clause['order'] : '';
        
        $sql = "SELECT c.*, u.*, c.id as comment_id
            FROM users u , comments c
            WHERE u.id = c.created_by
            {$where}
            {$order}
            {$limit}";

        return Database::query($sql);
    
    }
}
?>