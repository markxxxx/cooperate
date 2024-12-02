<?php

class MessageController extends AppController {

	private
		$error = array('success' => 0),
		$success = array('success' => 1),
		$per_page = 100;

	public function view($message_id = 0) {

		$message = Message::findby_id($message_id);

		if (!$message['id']) {
			$this->redirect('user/home');
		}

		if (!(($message['sender_id'] == $this->user->id) || ($message['recipient_id'] == $this->user->id)) && !$this->user->is_admin()) {
			$this->redirect('user/home');
		}

		if ($message['sender_id'] != $this->user->id && $message['opened'] == 0) {
			Message::edit(' opened = 1 ', $message['id']);
		}
		$thread = array();
		if ($message['parent_id'] == 0) {
			$thread['message'] = $message;
			$thread['replies'] = Message::findby_parent_id($message['id']);
		} else {

			$thread['message'] = Message::findby_id($message['parent_id']);
			$thread['replies'] = Message::findby_parent_id($message['parent_id']);
		}

		$this->set('thread', $thread);
		$messages = Message::inbox(false, $this->user, 0, 5);
		$this->set('messages', $messages['messages']);

	}



	public function inbox($page=0) {

		$filters = Filter::get();
        $filters['account_type'] = 'bursar';

        $this->set('user_count', User::search_count($filters));

		if (isset($_GET['search'])) {
			$filters['search_mail'] = $_GET['search']; 
		}

		$this->set(array(
			// 'domains' 		=> array_values($this->user->get_domains()),
			// 'groups'        => array_values($this->user->get_group_bursars()), 
			// 'universities'  => Field::get('university'),
			// 'study_years'   => Field::get('year_of_study')
		));

		$messages = Message::inbox($filters, $this->user, $page, 30);

		$this->set(array(
            // 'filter_domains'        => Filter::get('domains'),
            // 'filter_universities'   => Filter::get('universities'),
            // 'filter_study_years'    => Filter::get('study_years'),
            // 'filter_groups'         => Filter::get('groups'),
            'filters'               => Filter::get(),
            'box'					=> 'inbox',

        ));

		$this->set(array(
		    'messages'          => $messages['messages'],
            'attachment_count'	=> Attachment::attachments_count(),
            'total_messages'    => $messages['messages_count'],
            'message_templates'	=> Message_template::find(array('message_type'=>'general'))->fetch_all()
        ));

        $this->set('page', $page);


        $this->set_view('messages');

	}

	public function outbox($page=0) {


		$filters = Filter::get();
        $filters['account_type'] = 'bursar';

        $this->set('user_count', User::search_count($filters));

		if (isset($_GET['search'])) {
			$filters['search_mail'] = $_GET['search']; 
		}

		$this->set(array(
			// 'domains' 		=> array_values($this->user->get_domains()),
			// 'groups'        => array_values($this->user->get_group_bursars()), 
			// 'universities'  => Field::get('university'),
			// 'study_years'   => Field::get('year_of_study')
		));

		$messages = Message::outbox($filters, $this->user, $page, 30);

		$this->set(array(
            // 'filter_domains'        => Filter::get('domains'),
            // 'filter_universities'   => Filter::get('universities'),
            // 'filter_study_years'    => Filter::get('study_years'),
            // 'filter_groups'         => Filter::get('groups'),
            'filters'               => Filter::get(),
            'box'					=> 'outbox',

        ));

		$this->set(array(
		    'messages'          => $messages['messages'],
            'attachment_count'	=> Attachment::attachments_count(),
            'total_messages'    => $messages['messages_count'],
            'message_templates'	=> Message_template::find(array('message_type'=>'general'))->fetch_all()
        ));

        $this->set('page', $page);


        $this->set_view('messages');


	}

	public function search($user_id = 0, $box_type = 'inbox') {

		$user = new User($user_id);

        if(!$user->is_bursar()) {
            echo "Not a bursar";
            exit();
        }

        if (!$user->id) {
            echo "Not a bursar";
            exit();
        }

        $allowed_domains = $this->user->get_domains();
        $allowed_groups = $this->user->get_groups();

        if (!in_array($user->domain_id, array_keys($allowed_domains))) {
           echo "domain_violation";
        }

        if (!in_array($user->group_id, array_keys($allowed_groups))) {
           echo "group_violation";
        }

		if (strlen($_POST['search'])) {
            $search_filter['search_mail'] = $_POST['search']; 
        }

        $messages = $box_type == 'inbox' ?
            Message::inbox($search_filter, $user, 0, 20):
            Message::outbox($search_filter, $user, 0, 20);

        $this->set('messages', $messages['messages']);
        $this->set('box', $box_type);
	}

	public function attach() {
		include_once "include/uploader/UploadHandler.php";
		
		$upload_handler = new UploadHandler();
		exit();
		
	}

	public function download_attachment($hash = 0) {

		//I know just to lazy to write security for this
        $attachment = Attachment::instant_by_hash($hash);
        if (!$attachment->id) {
            $this->redirect("referer");
        }

        $d = 'media/attachments/' . $attachment->filename;
        $download_filename = $attachment->filename;
        $mime = mime_content_type ($d);
 
        header("Content-type: {$mime}"); 
        header('Content-Length: ' . filesize($d));
        header("Content-Disposition:attachment;filename={$download_filename}");
        echo file_get_contents($d);        

        exit();
    }

	public function send() {

		global $config;

		if (isset($_POST['message'])) {

			$message = Message::map(array(
				'title' => $_POST['title'],
				'message' => $_POST['message']
			));

			$message->sender_id = $this->user->id;
			$message->domain_id = $this->user->current_domain();

			if (!$message->validate()) {
				json_encode($message->errors + $this->error);
				exit();
			}

			$domain = new Domain($message->domain_id);

			if (!$this->user->is_admin()) {


				$message->recipient_id = 0;
				$message->insert();

				if(Attachment::attachments_count()) {
					Attachment::add_to_message($message->id);
				}

				foreach ($domain->get_admins(" AND g.message_notification = 1 ") as $admin) {

					$mail_vars = array(
						'name'		=> $this->user->get_title(),
						'title' 	=> $message->title,
						'message' 	=> $message->message,
						'link'	 	=> $config['site']['domain'].'/message/view/'.$message->id
					);

					Message_template::send($admin['email'], Message_template::ADMIN_MESSAGE_NOTIFY, $mail_vars);

				}

				echo json_encode($this->success);
				exit();
			} else {

				if (isset($_POST['send_all']) && $_POST['send_all'] != '0') {

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

				$domains[$domain->id] = $domain->to_array();

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

					if(Attachment::attachments_count()) {
						Attachment::add_to_message($message->id);
					}
				}

				Attachment::reset();

				echo json_encode($this->success);
				
				//add cc hack
				if(strlen($_POST['cc'])) {

					$find = '';
					foreach (explode(',', $_POST['cc']) as $user_id) {
						$user_id = array_pop(explode('__', $user_id));

						if (is_numeric($user_id)) {
							$find .= "'{$user_id}',";
						}
					}
					$find = rtrim($find, ',');
					$contacts = Contact::find("id in ($find)")->fetch_all();

					foreach($contacts as $c) {
						_mail($c['email'], $message->title, $message->body);
					} 

				}


				die();
			}
		}

		echo json_encode($this->error);
		exit();
	}

	public function reply($message_id = 0) {

		if (isset($_POST['message'])) {

			$message = new Message($message_id);

			if (!$message->id) {
				$this->redirect('user/home');
			}

			if ($this->user->is_admin()) {
				if ($message->parent_id > 0) {
					$parent = new Message($message->parent_id);
					if ($parent->recipient_id == 0) {
						$recipient_id = $parent->sender_id;
					} else {
						$recipient_id = $parent->recipient_id;
					}
				} else {
					if ($message->recipient_id == 0) {
						$recipient_id = $message->sender_id;
					} else {
						$recipient_id = $message->recipient_id;
					}
				}
			} else {
				$recipient_id = 0;
			}

			$reply = Message::map(array(
				'message' => $_POST['message'],
				'domain_id' => $message->domain_id,
				'sender_id' => $this->user->id,
				'parent_id' => $message->parent_id != 0 ? $message->parent_id : $message->id,
				'recipient_id' => $recipient_id,
				'title' => 'Re: ' . $message->title
			));


			$domain = new Domain($message->domain_id);
			$reply->insert();

			if(Attachment::attachments_count()) {
				Attachment::add_to_message($reply->id);
			}
			Attachment::reset();



			if ($reply->recipient_id && ($this->user->id != $message->recipient_id)) {

				$temp_user = new User($reply->recipient_id);

				$mail_vars = array(
					'name'	=> $temp_user->get_title(),
					'title'	=> $message->title
				);

				Message_template::send($temp_user->email, Message_template::BURSAR_MESSAGE_REPLY, $mail_vars);
			}
			
			
			foreach ($domain->get_admins(" AND g.message_notification = 1 ") as $admin) {
				
				if ($this->user->id != $admin['id']) {

					$mail_vars = array(
						'name'	=> $this->user->get_title(),
						'title'	=> $message->title
					);

					Message_template::send($admin['email'], Message_template::ADMIN_MESSAGE_REPLY, $mail_vars);
				}
			}

			$this->redirect('message/view/' . $message_id);
		}

		echo json_encode($this->error);
		exit();
	}

	public function remove_attachments() {
		Attachment::reset();
		$this->redirect();
	}


}

?>