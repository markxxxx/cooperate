<?php declare(strict_types=1)

//This was all fine till the contacts where and

class EventController extends AppController {

	private $per_page = 100;

	public function index($page=0) {

		$filter = 'TRUE';

		//some domain security
		$domains = $this->user->get_domains();
		$search = ' AND ' .Database::in_clause('ed.domain_id', array_keys($domains));

		if (array_key_exists('search', $_GET)) {
			$search .= " AND (e.id = '{$_GET['search']}' OR e.event like '%{$_GET['search']}%' OR e.name like '%{$_GET['search']}%' )";
		}

		$filters['where'] = $search;

		//$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

		$events = Event::find($filters)->fetch_all();
		$total_events = Event::count(array('where' => $filter));


		$this->set(array(
			'events' => $events,
			'domains' => array_values($domains),
			'total_events' => $total_events,
			'per_page' => $this->per_page,
			'page' => $page
		));
	}

	public function send_message($event_id = 0 ) {

		global $config;

		//if($this->_agent()->is_ajax()) {
			
			if(isset($_POST['title'])) {

				$event = new Event($event_id);

				if (!$event->id) {
					echo "Error - Event not found";
					exit();
				}
				
				if(!$this->user->has_domain_rights($event)) {
					echo "Error - Event not found";
					exit();
				}

				$rsvps = $event->get_rsvps();
				$users = array();

				if(in_array($_POST['send_to'], array('Yes','No','Pending'))) {

					foreach($rsvps[$_POST['send_to']] as $rsvp) {
						$users[] = $rsvp['id'];
					}

				} else {
					foreach($rsvps as $key => $values) {
						if(is_array($values)) {
							foreach ($values as $v) {
								$users[] = $v['id'];
							}
						}
					}
				}

			    foreach ($users as $user_id) {
                    if (is_numeric($user_id)) {
                        $find .= "'{$user_id}',";
                    }
                }
                $find = rtrim($find, ',');



                $message = Message::map(array(
					'title' => $_POST['title'],
					'message' => $_POST['message']
				));

				$message->sender_id = $this->user->id;

				$message->domain_id = $this->user->current_domain(); //This seams out of place!!!!!!

				if(strlen($find)) { 

					$users = User::find("id in ($find)")->fetch_all();

					foreach ($users as $user) {
						$message->recipient_id = $user['id'];
						$message->id = 0;
						$message->domain_id = $user['domain_id'];
						$message->insert();

						$mail_vars = array(
							'name' 	  => $user['name']. ' ' . $user['surname'],
							'title' => $message->title
						);

						Message_template::send($user['email'], Message_template::BURSAR_MESSAGE_NOTIFY, $mail_vars);
					}

				}



				/***********************************************************************************************/
				//Send Contacts
				/***********************************************************************************************/
				$find = '';
				$rsvps = $event->get_contacts_rsvps();
				$contacts = array();

				if(in_array($_POST['send_to'], array('Yes','No','Pending'))) {

					foreach($rsvps[$_POST['send_to']] as $rsvp) {
						$contacts[] = $rsvp['id'];
					}

				} else {
					foreach($rsvps as $key => $values) {
						if(is_array($values)) {
							foreach ($values as $v) {
								$contacts[] = $v['id'];
							}
						}
					}
				}

				foreach ($contacts as $user_id) {
				    if (is_numeric($user_id)) {
				        $find .= "'{$user_id}',";
				    }
				}

				$find = rtrim($find, ',');

				$mail_vars = array(
					'title' => $_POST['title'],
					'message' => $_POST['message']
				);

				if(strlen($find)) { 


					$contacts = Contact::find(array(
						'where' => " AND c.id in ($find) "
					))->fetch_all();

					foreach($contacts as $c) {
						$mail_vars['contact_rsvp_link'] = $config['site']['domain'].'/contact/rsvp/'.md5($event->id).'/'.md5($c['id']);
						Message_template::send($c['email'], Message_template::CONTACT_EVENT_MESSAGE, $mail_vars);
					}

				}

			}

		//}
	}



	public function rsvp_update($event_id = 0, $contact_id, $status ) {

		$event = new Event($event_id);

		if(!$event->id) {
			die();
		} 


		$user = new Contact($contact_id);

		
		if(!$user->id)  {
			die();
		}
		
		$sql = "UPDATE contact_event SET rsvp = '{$status}' WHERE contact_id = '{$contact_id}' AND event_id = '{$event_id}'";

		echo $sql;
		
		Database::query($sql);
		exit();


	}

	public function add() {
		$this->set('filters', Filter::get());
		$this->set('domains', array_values($this->user->get_domains()));
	}

	public function ajax_calendar($date = false) {

		$date = isset($date) ? $date : date('Y-m-d');
		$calendar = $this->_calendar($date);
		$calendar->set_events(Event::search($this->user, $date));
		echo $calendar->output_calendar();
		exit();

	}

	public function rsvp($event_id = 0) {

		$event = new Event($event_id);

		if (!$event->id) {
			echo "Error - Event not found";
		}


		//if($this->_agent()->is_ajax()) {
			if(isset($_POST['save'])) {
				$event->user_rsvp($this->user, $_POST);
				$action_id = Action::add($this->user, 'u_rsvp', array($_POST['rsvp'], $event->id, $event->name));
				$event->add_action($action_id);
				exit();
			}
		//}

		$this->set('event', $event->to_array());
		$this->set('event_user', $event->get_user_rsvp($this->user));
	}

	public function sync() {

		if ($this->user->is_admin()) {
			$feed = 'domain/' . md5('domain_' . $this->user->current_domain());
		} else {
			$feed = 'user/' . md5('user_' . $this->user->id);
		}

		$this->set('feed', 'http://' . $_SERVER['SERVER_NAME'] . '/f/' . $feed);
		$this->set('domains', array_values($this->user->get_domains()));
	}


	public function confirm_attended($event_id = 0, $user_id = 0, $attended = false, $is_contact = false ) {

		$is_contact = (bool) $is_contact;

		if($this->_agent()->is_ajax()) {

			$event = new Event($event_id);

			if(!$event->id) {
				die();
			} 

			if($is_contact) {
				$user = new Contact($user_id);

			} else {
				$user = new User($user_id);
			}
			
			if(!$user->id)  {
				die();
			}
			
			$event->confirm_attended($user_id , $attended, $is_contact);
		}

		exit();
	}

	public function export($event_id = 0) {

		$event = new Event($event_id);

		if(!$event->id) {
			$this->redirect('event?no_event');
		}

		if(!$this->user->has_domain_rights($event)) {
			$this->redirect('event?no_rights');
		}

		$rsvps = $event->get_rsvps();

		$contacts_rsvps = $event->get_contacts_rsvps();

		foreach($contacts_rsvps as $key => $values) {
			foreach ($values as $v) {
				$rsvps[$key][] = $v;
			}

		}

		function to_co_ord($row,$col) {

			if($row > 97) {

			}
			return chr($col+65).$row;
		}

		include('include/PHPExcel.php');

		$objPHPExcel = new PHPExcel;
		
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(9);

		$work_sheet_cnt = 0;

		foreach($rsvps as $key => $values) {

			$objSheet = new PHPExcel_Worksheet($objPHPExcel, 'RSVP  '.$key);

			for($i = 65;$i < 85; $i++) {
				$char = chr($i);
				$objSheet->getColumnDimension($char)->setWidth(23);
			}

			if(!count($values) > 0) {
				continue;
			}

			
			$headers = array_keys($values[0]);

			$heading_cnt = 0;
			foreach($headers as $heading) {
				$objSheet->getCell(to_co_ord(1 , $heading_cnt++ ))->setValue(ucfirst(str_replace('_', ' ', $heading)));
			}

			$row = 1;
			foreach($values as $rsvp) {
				$row++;
				$col=0;
				foreach($rsvp as $field) {
					$objSheet->getCell(to_co_ord($row  , $col++))->setValue($field);
				}
			}

			$objPHPExcel->addSheet($objSheet, $work_sheet_cnt++);


		}
		
        $objWriter = new PHPExcel_Writer_Excel2007 ($objPHPExcel);


        $filename = time().'event.xls';


        $objWriter->save("media/{$filename}");
        header("location: /media/{$filename}");
        
		exit();

	}

	public function quick_edit($event_id = 0) {

		//hate myself for this but ow well
		//one permission for acl is better 

		$event = new Event($event_id);

		if(!$event->id) {
			echo "invalid event";
			exit();
		}

		if(!$this->user->has_domain_rights($event)) {
			echo "Access denied";
			exit();
		}

		$user_domains = array_keys($this->user->get_domains());
		$event_domains = array_keys($event->get_domains());

 

		if(isset($_POST['event'])) { 

			if ($_POST['date']) {
				$date_pieces = explode('-', $_POST['date']);

				if (!checkdate($date_pieces[0], $date_pieces[1], $date_pieces[2])) {
					exit();
				}
			}

			$domains = array_keys($this->user->get_domains());


			if(strlen($_POST['domains'])) {
				parse_str($_POST['domains'], $output);
				if(is_array($output) && array_key_exists('domain_admins', $output)) {
					$domains = $output['domain_admins'];
				}
			}

			$domains = array_unique($domains);

			$event->update_map(array(
				'event'         => $_POST['event'],
				'event_date'    => $date_pieces[2] . '-' . $date_pieces[0] . '-' . $date_pieces[1],
				'location'      => $_POST['location'],
				'created_by'    => $this->user->id,
				'name'          => $_POST['name'],
				'food_option'   => isset($_POST['food']) ? true : false
			));

			$event->update();
			$event->update_domains($domains);
		}

		$this->set('event_domains', $event_domains);
		$this->set('domains', array_values($this->user->get_domains()));
		$this->set('event', $event->to_array());

		list($year,$month,$day) = explode('-', $event->event_date);

		$this->set(array(
			'event_year'    =>  $year,
			'event_month'   =>  $month,
			'event_day'     =>  $day
		));

	}

	public function quick_add() {

		if (isset($_POST['event'])) {

			if ($_POST['date']) {
				$date_pieces = explode('-', $_POST['date']);

				if (!checkdate($date_pieces[0], $date_pieces[1], $date_pieces[2])) {
					exit();
				}
			}

			$domains = array_keys($this->user->get_domains());


			if(strlen($_POST['domains'])) {
				parse_str($_POST['domains'], $output);
				if(is_array($output) && array_key_exists('domain_admins', $output)) {
					$domains = $output['domain_admins'];
				}
			}

			$domains = array_unique($domains);

			if (isset($_POST['send_all'])) {

				$filters = Filter::get();
				$filters['account_type'] = 'bursar';
				$filters['message_notification'] = 1;
				$filters['limit'] = false;
				
				$users = User::search($filters);
	
			} elseif (isset($_POST['to'])) {

				foreach (explode(',', $_POST['to']) as $user_id) {
					$user_id = array_pop(explode('__', $user_id));

					if (is_numeric($user_id)) {
						$find .= "'{$user_id}',";
					}
				}
				$find = rtrim($find, ',');
				$users = User::find("id in ($find)")->fetch_all();
			}
			
			$event = Event::map(array(
				'event'         => $_POST['event'],
				'event_date'    => $date_pieces[2] . '-' . $date_pieces[0] . '-' . $date_pieces[1],
				'location'      => $_POST['location'],
				'created_by'    => $this->user->id,
				'name'          => $_POST['name'],
				'food_option'   => isset($_POST['food']) ? true : false
			));

			$event->insert();

			$temp = array();
			foreach ($users as $user) {
				$temp[] = $user['id'];
				
				$mail_vars = array(
					'name'			 => $user['name']. ' '.$user['surname'],
					'event_title' 	 => $event->event,
					'event_location' => $event->location,
					'event_name'	 => $event->name
				);

				Message_template::send($user['email'], Message_template::BURSAR_INVITE, $mail_vars);

			}

			$event->update_users($temp);
			$event->update_domains($domains);

		}
		
	}

	public function resend_invite($event_id = 0) {

		
		$event = new Event($event_id);

		if(!$event->id) {
			$this->redirect('?no_event');
		}
		
		$users = $event->get_rsvps();

		$users = $users['Pending'];

		foreach ($users as $user) {
			
			$mail_vars = array(
				'name'			 => $user['name']. ' '.$user['surname'],
				'event_title' 	 => $event->event,
				'event_location' => $event->location,
				'event_name'	 => $event->name
			);


			Message_template::send(User::getInstance($user['id'])->email, Message_template::BURSAR_INVITE, $mail_vars);

		}


		$users = $event->get_contacts_rsvps();

		$users = $users['Pending'];

		foreach ($users as $user) {
			
			$mail_vars = array(
				'name'			 => $user['name'],
				'event_title' 	 => $event->event,
				'event_location' => $event->location,
				'event_name'	 => $event->name
			);



			if($event_id == 11) {
				Message_template::send($user['email'], Message_template::CUSTOM_INVITE, $mail_vars);

			} else {
				Message_template::send($user['email'], Message_template::CONTACT_INVITE, $mail_vars);
			}
		}



		$this->redirect('event/edit/'.$event->id.'?confirmation=Event invitations resent');


	}

	public function edit($event_id = 0) {

		$event = new Event($event_id);

		if (!$event->id) {
			$this->redirect('event?no_event');
		}

		if(!$this->user->has_domain_rights($event)) {
			$this->redirect('event?no_rights');
		}

		$rsvps = $event->get_rsvps();
		
		$contacts_rsvps = $event->get_contacts_rsvps();

		foreach($contacts_rsvps as $key => $values) {
			foreach ($values as $v) {
				$rsvps[$key][] = $v;
			}

		}


		$this->set('event', $event->to_array());
		$this->set('rsvp', $rsvps);
		$this->set('actions', $event->get_actions());
		$this->set('event_domains', array_values($event->get_domains()));
		$this->set('owner', new User($event->created_by));
		$this->set('uninvited_users', User::json_autocomplete($event->get_uninvited_users($this->user)));
		$this->set('uninvited_contacts', User::json_autocomplete($event->get_uninvited_contacts()));
		$this->set('invited', User::json_autocomplete($event->get_invited()));
		$this->set('contacts', array_values($event->get_contacts()));


	}


	public function invite($event_id = 0) {
		
		if(isset($_POST['save'])) {

			$event = new Event($event_id);

			if(!$event->id) {
				echo "no event";
				die();
			}

			if(!$this->user->has_domain_rights($event)) {
				echo "no rights";
				die();
			}

			if(isset($_POST['to'])) {

				foreach (explode(',', $_POST['to']) as $user_id) {
					$user_id = array_pop(explode('__', $user_id));

					if (is_numeric($user_id)) {
						$find .= "'{$user_id}',";
					}
				}
				$find = rtrim($find, ',');
				$users = User::find("id in ($find)")->fetch_all();

				$temp = array();
				foreach ($users as $user) {
					$temp[] = $user['id'];

					if($_POST['send'] == "true"){
						$mail_vars = array(
							'name'			 => $user['name']. ' '.$user['surname'],
							'event_title' 	 => $event->event,
							'event_location' => $event->location,
							'event_name'	 => $event->name
						);
						Message_template::send($user['email'], Message_template::BURSAR_INVITE, $mail_vars);
					}

				}

				$event->update_users($temp);
			}
		}

	}


// adding without sending mail
	// public function add_invitee($event_id = 0) {
		
	// 	if(isset($_POST['save'])) {

	// 		$event = new Event($event_id);

	// 		if(!$event->id) {
	// 			echo "no event";
	// 			die();
	// 		}

	// 		if(!$this->user->has_domain_rights($event)) {
	// 			echo "no rights";
	// 			die();
	// 		}

	// 		if(isset($_POST['to'])) {

	// 			foreach (explode(',', $_POST['to']) as $user_id) {
	// 				$user_id = array_pop(explode('__', $user_id));

	// 				if (is_numeric($user_id)) {
	// 					$find .= "'{$user_id}',";
	// 				}
	// 			}
	// 			$find = rtrim($find, ',');
	// 			$users = User::find("id in ($find)")->fetch_all();

				
	// 			$temp = array();
	// 			foreach ($users as $user) {
	// 				$temp[] = $user['id'];

	// 				// $mail_vars = array(
	// 				// 	'name'			 => $user['name']. ' '.$user['surname'],
	// 				// 	'event_title' 	 => $event->event,
	// 				// 	'event_location' => $event->location,
	// 				// 	'event_name'	 => $event->name
	// 				// );
	// 				// Message_template::send($user['email'], Message_template::BURSAR_INVITE, $mail_vars);

	// 			}

	// 			$event->update_users($temp);
	// 		}
	// 	}

	// }

	public function invite_contact($event_id = 0) {

		global $config; 
		
		if(isset($_POST['save'])) {

			$event = new Event($event_id);

			if(!$event->id) {
				echo "no event";
				die();
			}

			if(!$this->user->has_domain_rights($event)) {
				echo "no rights";
				die();
			}

			if(isset($_POST['to'])) {

				foreach (explode(',', $_POST['to']) as $user_id) {
					$user_id = array_pop(explode('__', $user_id));

					if (is_numeric($user_id)) {
						$find .= "'{$user_id}',";
					}
				}
				$find = rtrim($find, ',');
				$users = Contact::find(array('where' => "AND c.id in ($find)"))->fetch_all();

				
				$temp = array();
				foreach ($users as $user) {
					$temp[] = $user['id'];

					if($_POST['send'] == "true"){
						$mail_vars = array(
							'name'			 => $user['name'],
							'event_title' 	 => $event->event,
							'event_location' => $event->location,
							'event_name'	 => $event->name,
							'event_url'		 => $config['site']['domain'].'/contact/rsvp/'.md5($event->id).'/'.md5($user['id'])
						);

						
						if($event_id == 11) {
							Message_template::send($user['email'], Message_template::CUSTOM_INVITE, $mail_vars);

						} else {
							Message_template::send($user['email'], Message_template::CONTACT_INVITE, $mail_vars);
						}
					}

				}	

				$event->update_contacts($temp);
			}
		}

	}

	public function add_contact($event_id = 0) {

		global $config; 
		
		if(isset($_POST['save'])) {

			$event = new Event($event_id);

			if(!$event->id) {
				echo "no event";
				die();
			}

			if(!$this->user->has_domain_rights($event)) {
				echo "no rights";
				die();
			}

			if(isset($_POST['to'])) {

				foreach (explode(',', $_POST['to']) as $user_id) {
					$user_id = array_pop(explode('__', $user_id));

					if (is_numeric($user_id)) {
						$find .= "'{$user_id}',";
					}
				}
				$find = rtrim($find, ',');
				$users = Contact::find(array('where' => "AND c.id in ($find)"))->fetch_all();

				
				$temp = array();
				foreach ($users as $user) {
					$temp[] = $user['id'];

					// $mail_vars = array(
					// 	'name'			 => $user['name'],
					// 	'event_title' 	 => $event->event,
					// 	'event_location' => $event->location,
					// 	'event_name'	 => $event->name,
					// 	'event_url'		 => $config['site']['domain'].'/contact/rsvp/'.md5($event->id).'/'.md5($user['id'])
					// );

					
					// if($event_id == 11) {
					// 	Message_template::send($user['email'], Message_template::CUSTOM_INVITE, $mail_vars);

					// } else {
					// 	Message_template::send($user['email'], Message_template::CONTACT_INVITE, $mail_vars);
					// }

				}	

				$event->update_contacts($temp);
			}
		}

	}


	public function delete($event_id) {

		$event = new Event($event_id);

		if(!$event->id) {
			$this->redirect('event?no_event');
		}

		if(!$this->user->has_domain_rights($event)) {
			$this->redirect('event?no_rights');
		}

		Event::delete($event_id);
		$this->redirect('referer');
	}

	public function delete_selected() {
		if (array_key_exists('id', $_POST)) {
			if (is_array($_POST['id'])) {
				$this->delete(array_keys($_POST['id']));
			}
		}
		$this->redirect('referer');
	}

	public function feed($ident = '', $hash='') {

		if ($ident == 'domain') {
			$sql = "SELECT id 
					FROM users 
					WHERE md5(concat('domain_', domain_id)) = '{$hash}' LIMIT 1";

			$found = Database::query($sql)->fetch();
		} else {
			$sql = "SELECT id 
				FROM users 
				WHERE md5(concat('domain_', id)) = '{$hash}' LIMIT 1";

			$found = Database::query($sql)->fetch();
		}

		if (!$found) {
			exit();
		} else {
			echo Event::ics($found['id']);
		}
	}


	// Search
	// public function search_invited($event_id = 0) {
		
	// 	foreach (explode(',', $_POST['searchfor']) as $user_id) {
	// 		$user_id = array_pop(explode('__', $user_id));

	// 		if (is_numeric($user_id)) {
	// 			$find .= "'{$user_id}',";
	// 		}
	// 	}
	// 	$find = rtrim($find, ',');
	// 	$users = User::find("id in ($find)")->fetch_all();
	// 	d($users);

					

	// 	return $users;

	// }

}

?>