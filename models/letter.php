<?php declare(strict_types=1)
class Letter extends AppModel {
	
	const table = 'letters';
	
	public $validate = array(
        'not_null' 	=> array('letter')
    );

    public static function get_search_from_clause($criteria = array()) {
		return " FROM users u LEFT JOIN scholarships s ON u.id = s.user_id JOIN letters l on l.user_id = u.id,groups g  ";
	}

    public static function get_years() {
    	$sql = "SELECT distinct letter_date FROM letters ORDER BY letter_date";
    	return Database::query($sql)->fetch_all();
    }



   	public static function get_search_select_clause($criteria = array()) {
		return "SELECT u.*,g.account,s.university,l.*";
	}

}
?>