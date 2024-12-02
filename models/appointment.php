<?php
class Appointment extends Model {
	
	const table = 'appointments';
	
	public $validate = array(
        'not_null' => array(),
		'number' => array()
    );

	static public function ics_user_link(User $user) {

		global $config;
		return $config['site']['domain'].'/appointment/ics/'.md5($user->id);

	}

    public function get_event_dates($user, $start = 0, $end = 0) {

    	if(!$start && !$end) {
    		$where = ' 1 = 1';
    	} else {
    		$where = " (start_time > '{$start}' && start_time < '{$end}') ";
    	}

    	$bookings = Appointment::find(array(
			'fields'=> "appointments.*, (SELECT concat(name, ' ',surname,':',email) FROM users WHERE id = appointments.user_id) as by_user",
			'where' => $where
		))->fetch_all();
	
		$output = array();
		
		$json = array();

    	if(!$start && !$end) {
    		$year = date('Y');
			$events = Event::search($user, array('start'=> $year.'-01-01','end' => $year.'-12-31') , true , array());
		} else {
			$events = Event::search($user, array('start'=> $start,'end' => $end) , true , array());
		}

		foreach($events as $event) { 
			$json['allDay'] = true;
			$json['start'] = $event['event_date'];
			$json['title'] = $event['by_user'] . ' '.$event['name'];
			$json['className'] = 'event_date_cal';
			$json['id'] = $event['id'] + 10000;
			$json['url'] = '/event/edit/'.$event['id'];
			$json['by_user'] = $event['by_user'];
			$json['type'] = 'Event';
			$output[] = $json;
			$json = array();
		}

		$reminders = Reminder::search($user, true, Reminder::SHOW_ALL,true);

		$time = 8;

		foreach($reminders as $type) { 
			foreach($type as $r) {
				$json['allDay'] = false;
				$json['start'] = strtotime($r['reminder_date'] .' 08:00:00');
				$json['title'] =  $r['reminder'];
				$json['href'] = '/reminder/edit/'.$r['id'];
				++$time;
				$json['id'] = $r['id']+100000;
				$json['className'] = 'reminder_cal';
				$json['url'] = '/reminder/edit/'.$r['id'];
				$json['type'] = 'Reminder';
				$output[] = $json;
				$json = array();

			}
		}

		foreach($bookings as $booking) { 

//			if($booking['duration'] == 1000) {
//
				$json['allDay'] = true;
				$json['start'] = date('Y-m-d', strtotime($booking['start_time']));
				$json['title'] = 'Entire day:' . $booking['by_user'];
//
//			} else {
//
//				$json['allDay'] = false;
//				$json['start'] = $booking['start_time'];
//				$json['end'] = date('Y-m-d H:i:s' , strtotime($booking['start_time']) + ($booking['duration'] * 60));
//				$json['title'] = $booking['by_user'] . ' - '. $booking['title'];
//
//			}

			$json['className'] = 'colorbox';
			$json['url'] = '/appointment/edit/'.$booking['id'];
			$json['type'] = 'Appointment';
			$json['by_user'] = $booking['by_user'];
			$json['id'] = $booking['id'];

			$output[] = $json;

			$json = array();
		}

		return $output;
 
    }

    public function get_ics($user) {
		
		$events = Appointment::get_event_dates($user);
		$cal_user = $user->get_title();
		global $config;

		function dateToCal($timestamp) {
			return date('Ymd\THis\Z', $timestamp);
		}

		// Escapes a string of characters
		function escapeString($string) {
			return preg_replace('/([\,;])/','\\\$1', $string);
		}

$ics ="BEGIN:VCALENDAR
PRODID:-//Google Inc//Google Calendar 70.9054//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME:{$config['site']['name']}
X-WR-TIMEZONE:Africa/Johannesburg
BEGIN:VTIMEZONE
TZID:Africa/Johannesburg
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
END:VTIMEZONE";

		foreach ($events as $event) {

			$dt_start = dateToCal(strtotime($event['start']));
			if(isset($event['end'])) {
				$dt_end = dateToCal(strtotime($event['end']));
			} else {
				$dt_end = $dt_start;
			}

			$name = $config['site']['name'];
			$email = $config['site']['email_noreply'];

			if(isset($event['by_user'])) {
				$details = explode(':', $event['by_user']);
				$name = $details[0];
				$email = $details[1];
			}

			$title = $event['type'] . ': '.$event['title'];

			$title = escapeString($title);
			
			$decription = '';

			if(isset($event['url'])) {
				$decription ='Click here:' . $config['site']['domain'].'/' .$event['url'];
			}

			$ics .=
"
BEGIN:VEVENT
DTSTART;VALUE=DATE:{$dt_start}
DTEND;VALUE=DATE:{$dt_start}
DTSTAMP:{$dt_start}
ORGANIZER;CN={$name}:MAILTO:{$email}
UID:{$event['id']}
CLASS:PUBLIC
CREATED:{$dt_start}
LAST-MODIFIED:{$dt_start}
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:{$title}
DESCRIPTION:{$decription}
TRANSP:OPAQUE
END:VEVENT";
		}
		$ics .= 'END:VCALENDAR';
		return $ics;

	}

}
?>