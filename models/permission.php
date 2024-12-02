<?php
class Permission extends AppModel {
    
    const table = 'permissions';
    
    static public function delete($permission_id = 0) {
        
        parent::delete($permission_id);
        Database::query("DELETE FROM group_permission WHERE permission_id = {$permission_id}");
        
    }
    
    static public function update_group ($group_id, $permission_id, $can_access) {
        
        $sql = "INSERT INTO group_permission (group_id, permission_id, can_access)
            VALUES('{$group_id}', '{$permission_id}', '{$can_access}')";
        
        Database::query($sql);
        
    }
    
    static function findby_user($user ,$method_name=false) {
        
        $where = '';
        if($method_name !== false) {
            $where = " AND p.method = '{$method_name}' ";
        }
        
        $sql = "SELECT p.*
                FROM group_permission gp, permissions p
                WHERE p.id = gp.permission_id
                AND gp.group_id = '{$user->group_id}'
                AND gp.can_access = 1
                $where
				ORDER by p.class
				";

        return Database::query($sql)->fetch_all();
        
    }
    
}
?>