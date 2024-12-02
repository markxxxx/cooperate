<?php declare(strict_types=1)
class Action extends AppModel {
	
	const table = 'actions';
	
	static $type_text = array(
		'login' 		=> "<a href='/%s'>%s %s</a> has logged in.",
		'u_personal' 	=> "<a href='/%s#personal'>%s %s</a> has updated their personal information.",
		'u_contact' 	=> "<a href='/%s#contact'>%s %s</a> has updated their contact information.",
		'u_banking'		=> "<a href='/%s#banking'>%s %s</a> has updated their banking details.",
		'u_misc'		=> "<a href='/%s#misc'>%s %s</a> has updated their `More about yourself` information.",
		'u_social'	 	=> "<a href='/%s#social'>%s %s</a> has updated their social bookmark information.",
		'u_scolar'		=> "<a href='/%s#scolar'>%s %s</a> has updated their scholarship information.",
		'a_work'		=> "<a href='/%s#work'>%s %s</a> has added a new `Part-time/Vac work` record.",
		'u_work'		=> "<a href='/%s#work'>%s %s</a> has updated a new `Part-time/Vac work` record.",
        'u_academic'    => "<a href='/%s#academic'>%s %s</a> has updated their academic records.",
        'a_academic'    => "<a href='/%s#academic'>%s %s</a> has added a new academic record.",
		'a_upload'		=> "<a href='/%s#academic'>%s %s</a> has uploaded a document: <a href='/%s'>%s</a>",
		'u_rsvp' 		=> "<a href='/%s'>%s %s</a> has RSVP'd %s to <a href='/event/edit/%s'>%s</a>",
		'u_alumni'		=> "<a href='/%s#alumni'>%s %s</a> has updated their alumni information.",
		'u_letter'		=> "<a href='/%s#letter'>%s %s</a> has submitted their annual letter to Martin."
	);
	
	static function add(User $user, $type, $args= array()) {
    
        global $config;

		if(!isset(self::$type_text[$type])) {
			return false;
		}
		$args = array_merge(array($user->id, $user->name, $user->surname) , $args);
        
        
        
		$action = Action::map(array(
			'action'  	=> escape(vsprintf(self::$type_text[$type], $args)),
			'user_id' 	=> $user->id,
			'type_id'	=> $type,
			'domain_id' => $user->current_domain()
		));
		$action->insert();

		return $action->id;
	}
	
	static function recent($user_id = 0, $filter = array(), $ignore_types = array(),$page =0, $per_page =100) {
		$where = self::get_search_where_clause($filter);
		
		if($user_id) {
			$where .= " AND a.user_id = '{$user_id}' "; 
		}
		
		if(count($ignore_types)) {
			$temp = '';
			foreach($ignore_types as $type) {
				$temp .= "'{$type}',"; 
			}
			$where .= ' AND a.type_id not in ('.rtrim($temp, ',').') '; 
		}

		// ADP 2019/02/19 Added this as it was not defined
		$show = 100;

		$sql = 'SELECT a.* ' .
				 self::get_search_from_clause() .
				 ", actions a {$where} AND a.user_id = u.id ORDER by id DESC " .
				 self::get_search_limit_clause(array('page'=> $page, 'per_page' => $show));

		return Database::query($sql)->fetch_all();
	}

}

?>