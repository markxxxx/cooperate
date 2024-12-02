<?php declare(strict_types=1)
class Event extends AppModel {
	
	const table = 'events';

	private $instance_cache = array();
	
	public $validate = array(
		'not_null' 	=> array('event'),		
		'number' => array('id')
	);
	
	public static function find($filters) {

		if(isset($filters['account_type'])) {
			$where_clause .= " AND g.account = '{$filters['account_type']}' ";
		}


		if(isset($filters['universities'])) {
			if(is_array($filters['universities'])) {
				$where_clause .= ' AND ' . Database::in_clause('s.university', $filters['universities']);
			} else {
				$where_clause .= " AND s.university = '{$filters['universities']}' ";
			}
		}

		if(isset($filters['year_of_study'])) {
			if(is_array($filters['year_of_study'])) {
				$where_clause .= ' AND ' . Database::in_clause('s.year_of_study', $filters['year_of_study']);
			} else {
				$where_clause .= " AND s.year_of_study = '{$filters['year_of_study']}' ";
			}
		}

		if(isset($filters['where'])) {
			$where_clause .= $filters['where'];
		}

		$sql = "SELECT e.*, concat(u2.name, ' ' , u2.surname) as creator,ue.rsvp,count(*) as total_invites
				FROM events e, event_domain ed, user_event ue, users u2, users u LEFT JOIN scholarships s ON u.id = s.user_id,groups g
				WHERE e.id = ed.event_id
				AND u.id = ue.user_id
				AND e.id = ue.event_id
				AND e.id = ed.event_id
				AND e.created_by = u2.id
				AND u.group_id = g.id

				{$where_clause}
				GROUP BY e.id
				{$order}
				{$limit}";
			

		return Database::query($sql);
	}
	
	static function count($clause) {
		//return self::find(array('count'=>1, 'where'=> $clause['where']))->fetch('object')->cnt;
	}

	static function search(User $user, $date = false, $limited = true, $filters= array()) {
		

		//The event date is a hack 
		//first it was only per month 
		//but full calendar month can be from 26 jan - march 3...
		//These are the dates that show on full calendar
		//So i made it an array for date

		if(is_array($date)) {
			$start = $date['start'];
			$end = $date['end'];
		}elseif(!$date) {
			$date = date('Y-m');
		} else {
			$date = explode('-', $date);
			$date = date('Y-m', mktime(0,0,0,$date[1], $date[2], $date[0]));
		}

		if(isset($filters['rsvp'])) {
			$where = " AND ue.rsvp = '{$filters['rsvp']}' ";
		}
	
		$events = array();
		
		if($user->is_admin()) {
			if(isset($start)) {
				$where .= " AND e.event_date >= '{$start}' AND e.event_date <= '{$end}' ";
			} else {
				$where .= " AND e.event_date >= '{$date}-00' AND e.event_date <= '{$date}-32' ";
			}
			$events = Event::find(array('where' => $where))->fetch_all();
		}
		
		// if($user->is_bursar()) {	

		// 	if(isset($start)) {
		// 		$where .=  " AND e.event_date >= '{$start}' AND u.id = '{$user->id}' ";
		// 	} else {
		// 		$where .=  " AND e.event_date >= '{$date}-01' AND u.id = '{$user->id}' ";
		// 	}

			

		// 	if($limited) {

		// 		if(isset($start)) {
		// 			$where .= " AND e.event_date <= '{$end}'";
		// 		} else {
		// 			$where .= " AND e.event_date <= '{$date}-31'";
		// 		}
		// 	}
			
		// 	$events = Event::find(array('where' => $where))->fetch_all();
		// }
		
		return $events;
	}
	
	
	public function update_users($users) {
	
		if(!is_array($users) || !$this->id) {
			return false;
		}
		
		$admins = array_unique($users);
		
		$today = date('Y-m-d H:i:s');

		foreach($users as $user) {
			$this->query("REPLACE into user_event(user_id, event_id, invited_on) VALUES ('{$user}','{$this->id}','{$today}')");
		}
	}

	public function update_contacts($users) {
	
		if(!is_array($users) || !$this->id) {
			return false;
		}
		
		$admins = array_unique($users);
		
		$today = date('Y-m-d H:i:s');

		foreach($users as $user) {
			$this->query("REPLACE into contact_event(contact_id, event_id, invited_on) VALUES ('{$user}','{$this->id}','{$today}')");
		}
	}

	public function update_domains($domains) {
	
		if(!is_array($domains) || !$this->id) {
			return false;
		}
		
		$domains = array_unique($domains);
		$this->query("DELETE FROM event_domain WHERE event_id = '{$this->id}'");
		
		foreach($domains as $domain) {
			$this->query("REPLACE into event_domain(domain_id, event_id) VALUES ('{$domain}','{$this->id}')");
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
		
		$rs = $this->query("SELECT d.* FROM event_domain ed, domains d WHERE d.id = ed.domain_id AND ed.event_id = '{$this->id}'");
		$return = array();
		
		while($row = $rs->fetch()) {
			$return[$row['id']] = $row;
		}

		return $this->instance_cache['get_domains'] = $return;
	}

	public function get_user_rsvp(User $user) {

		if(!$this->id) {
			return false;
		}
		return $this->query("SELECT * FROM user_event WHERE event_id = '{$this->id}' AND user_id = '{$user->id}'")->fetch();

	}

	public function add_action($action_id = 0) {

		if(!$this->id) {
			return false;
		}

		$this->query("REPLACE into event_action(event_id,action_id) VALUES ({$this->id}, {$action_id})");
	}

	static public function user_attendance($user_id = 0) {

		$sql = "SELECT e.*,ue.* FROM events e, user_event ue 
				WHERE ue.user_id = {$user_id} 
				AND e.id = ue.event_id
				AND ue.attended = '1'";

		return Database::query($sql)->fetch_all();

	}

	public function user_rsvp(User $user, $options) {

		if(!$this->id || !$user->id) {
			return false;
		}

		$set_claues = '';

		if(isset($options['rsvp'])) {
			if(!in_array($options['rsvp'], array('Yes','No'))) {
				return false;
			}

			$set .= " rsvp = '{$options['rsvp']}',";

			if($options['rsvp'] == 'No') {
				
				if(isset($options['feedback']) && strlen($options['feedback'])) {
					$set .= " feedback = '{$options['feedback']}',";
				}
			}
		}

		if(isset($options['food_option']) && isset($options['feedback'])) {
			$set .= "food_option = '{$options['food_option']}',";
		}

		if(!strlen($set)) {
			return false;
		}

		$today = date('Y-m-d H:i:s');

		$set = rtrim($set,',');
		$set .= " , rsvp_on = '{$today}' ";

		$sql = " UPDATE user_event SET {$set} WHERE user_id = '{$user->id}' AND event_id = '{$this->id}' ";
		Database::query($sql);

	}

	public function contact_rsvp(Contact $user, $options) {

		if(!$this->id || !$user->id) {
			return false;
		}

		$set_claues = '';
		// /http://moshal.svo.co.za/contact/rsvp/6512bd43d9caa6e02c990b0a82652dca/d395771085aab05244a4fb8fd91bf4ee

		if(isset($options['rsvp'])) {

			if(!in_array($options['rsvp'], array('Yes','No'))) {

				return false;
			}

			$set .= " rsvp = '{$options['rsvp']}',";

			if($options['rsvp'] == 'No') {
				
				if(isset($options['feedback']) && strlen($options['feedback'])) {
					$set .= " feedback = '{$options['feedback']}',";
				}
			}
		}


		if(isset($options['food_option'])) {
			$set .= "food_option = '{$options['food_option']}',";
		}

		if(!strlen($set)) {

			return false;
		}

		$today = date('Y-m-d H:i:s');

		$set = rtrim($set,',');
		$set .= " , rsvp_on = '{$today}' ";

		$sql = " UPDATE contact_event SET {$set} WHERE contact_id = '{$user->id}' AND event_id = '{$this->id}' ";

		Database::query($sql);

	}

	public function confirm_attended( $user_id = 0 , $attended = false, $is_contact  = false) {

		 if(!$this->id){ 
		 	return false;
		 }

		 if($is_contact) {
		 	 Database::query("UPDATE contact_event SET attended = '{$attended}' WHERE contact_id = {$user_id} AND event_id = '{$this->id}' ");

		 } else {
		 	 Database::query("UPDATE user_event SET attended = '{$attended}' WHERE user_id = {$user_id} AND event_id = '{$this->id}' ");

		 }

	}


	public function get_users() {
		
		if(!$this->id) {
			return false;
		}
		
		$rs = $this->query("SELECT u.id,u.name,u.surname,ue.attended,ue.food_option,ue.rsvp,ue.invited_on,ue.rsvp_on,ue.feedback FROM user_event ue,users u WHERE u.id = ue.user_id AND ue.event_id = '{$this->id}'");
		$return = array();
		
		while($row = $rs->fetch()) {
			$return[$row['id']] = $row;
		}
		return $return;
	}

	public function get_contacts() {
		
		if(!$this->id) {
			return false;
		}
		
		$rs = $this->query("SELECT c.id,c.email,c.name,ce.attended,ce.food_option,ce.rsvp,ce.invited_on,ce.rsvp_on,ce.feedback FROM contact_event ce,contacts c WHERE c.id = ce.contact_id AND ce.event_id = '{$this->id}'");
		$return = array();
		
		while($row = $rs->fetch()) {
			$return[$row['id']] = $row;
		}
		return $return;
	}


	public function get_actions() {

		if(!$this->id) {
			return false;
		}

		$sql = "SELECT a.* 
				FROM actions a, event_action ae 
				WHERE a.type_id = 'u_rsvp' 
				AND ae.action_id = a.id  
				AND ae.event_id = '{$this->id}'
				LIMIT 30";

		return $this->query($sql)->fetch_all();
	}

	public function get_rsvps() {
		
		$rsvps = $this->get_users();
		$rows = array('Yes'=>array(),'No'=>array(),'Pending'=>array());

		if(!count($rsvps)){
			return $rows;
		}

		foreach($rsvps as $r) {
			$rows[$r['rsvp']][] = $r;
		}
		return $rows;

	}


	public function get_contacts_rsvps() {
		
		$rsvps = $this->get_contacts();
		$rows = array('Yes'=>array(),'No'=>array(),'Pending'=>array());

		if(!count($rsvps)){
			return $rows;
		}

		foreach($rsvps as $r) {
			$rows[$r['rsvp']][] = $r;
		}
		return $rows;

	}


	public function get_uninvited_users(User $user) {

		$filters['account_type'] = 'bursar';
		$filters['send_message'] = '1';
		$filters['limit'] = false;


		$event_invites = $this->get_users();

		if($event_invites) {
		
			$exclude_users = '';
			foreach($event_invites as $e) {
				$exclude_users .= "'{$e[id]}',";
			}

			$exclude_users = rtrim($exclude_users ,',');

			$filters['where'] = " AND u.id NOT IN($exclude_users) ";

		}
		$users = User::search($filters);
		return $users;
	}


	public function get_uninvited_contacts() {


		$event_invites = $this->get_contacts();
		$filters = array(); 

		if($event_invites) {

			$exclude_users = '';
			foreach($event_invites as $e) {
				$exclude_users .= "'{$e[id]}',";
			}

			$exclude_users = rtrim($exclude_users ,',');

			$filters['where'] = " AND c.id NOT IN($exclude_users) ";
		}

		$contacts = Contact::find($filters)->fetch_all();

		return $contacts;

	}

	public function get_invited() {


		$contacts= $this->get_contacts();
		//$filters['account_type'] = 'bursar';
		//$filters['send_message'] = '1';
		//$filters['limit'] = false;

		$users = $this->get_users();

		//d($contacts+$users);

		return $contacts+$users;
	

	}
	

	static public function delete($id = 0) {
		parent::delete($id);
		Database::query("DELETE FROM user_event WHERE event_id = '{$id}' ");
		Database::query("DELETE FROM event_domain WHERE event_id = '{$id}' ");
		Database::query("DELETE FROM event_action WHERE event_id = '{$id}' ");

	}

	
	
	static public function ics($user_id = 0) {
		
		$events = Event::search(new User($user_id));
		
		$feed = "
BEGIN:VCALENDAR
PRODID:-//Google Inc//Google Calendar 70.9054//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME:domain das
X-WR-TIMEZONE:Africa/Johannesburg
BEGIN:VTIMEZONE
TZID:America/New_York
X-LIC-LOCATION:Africa/Johannesburg
BEGIN:DAYLIGHT
TZOFFSETFROM:-0500
TZOFFSETTO:-0400
TZNAME:EDT
DTSTART:19700308T020000
RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:-0400
TZOFFSETTO:-0500
TZNAME:EST
DTSTART:19701101T020000
RRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU
END:STANDARD
END:VTIMEZONE

BEGIN:VEVENT
DTSTART;VALUE=DATE:20070417
DTEND;VALUE=DATE:20070418
DTSTAMP:20071003T171517Z
ORGANIZER;CN=David:MAILTO:me@home.com
UID:41r8cefge2pi3tmt7tt766baf4@google.com
COMMENT;X-COMMENTER=MAILTO:me@home.com:<p>Hey Everyone: I think I have talked to everyone about setting up a brainstorm/initial planning meeting for a complete overhaul of the current FCAG site. I have penciled in a meeting for Tuesday April 10  @ 7:00 PM 8:30 PM.  Would you be able to attend?
CLASS:PUBLIC
CREATED:20070402T234821Z
DESCRIPTION:Website Brainstorm Session
LAST-MODIFIED:20070411T115625Z
LOCATION:FCAG
SEQUENCE:2
STATUS:CONFIRMED
SUMMARY:FCAG Website Meeting
TRANSP:TRANSPARENT
END:VEVENT

BEGIN:VEVENT
DTSTART;VALUE=DATE:20071225
DTEND;VALUE=DATE:20071225
DTSTAMP:20071003T171517Z
ORGANIZER;CN=David:MAILTO:me@home.com
UID:kaii6it1gmbpncmkavjkpkq1tk@google.com
CLASS:PUBLIC
CREATED:20070209T113646Z
LAST-MODIFIED:20070209T113646Z
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:Christmas
TRANSP:OPAQUE
END:VEVENT
END:VCALENDAR
";
		
	}
	
}
?>