<?php

class ContactController extends AppController {

	private $per_page = 20;

	private $allowed_files = array('png', 'jpg', 'jpeg', 'gif', 'doc', 'docx', 'pdf', 'csv');
    private $upload_path = 'media/documents/';


    public function rsvp($event_id_hash, $contact_id_hash, $rsvp_status = '') {

    	$event = Event::find(array('where'=>" AND md5(e.id) = '{$event_id_hash}'"))->fetch();
		$contact = Contact::find(array('where'=>" AND md5(c.id) = '{$contact_id_hash}'"))->fetch();



		if(!$event || !$contact) {
			$this->set_view('404');
		}


		$this->set('rsvp_success', 0);

		$this->set('event', $event);
		$this->set('contact', $contact);
		$this->set('event_id_hash', $event_id_hash);
		$this->set('contact_id_hash',$contact_id_hash);


		if($rsvp_status == 'Yes' || $rsvp_status == 'No') {

			$rsvp = array();

			$rsvp = array(
				'rsvp' => $rsvp_status,
			);

			if($rsvp_status == 'Yes') {
				$rsvp['food_option'] = 'Standard';
			}

			Event::map($event)->contact_rsvp(new Contact($contact['id']), $rsvp);
			$this->set('rsvp_success', 1);
		}


		if(isset($_POST['save'])) {

			Event::map($event)->contact_rsvp(new Contact($contact['id']), $_POST);

			$this->set_view('contact_rsvp_complete');
		}


    }

	public function index($page=0) {
	
		$this->set(array(
			'suppliers' => Supplier::find(array('fields'=>'id, supplier'))->fetch_all(),
			'domains' => Domain::find(array('fields'=>'id, domain'))->fetch_all()
		));

		$filter = 'AND TRUE';


		if(array_key_exists('search', $_GET) && strlen($_GET['search'])) {
			$filter .= " AND (c.id = '{$_GET['search']}' OR name like '%{$_GET['search']}%' OR c.email like '%{$_GET['search']}%' OR c.mobile like '%{$_GET['search']}%' OR c.office like '%{$_GET['search']}%')";
		}

		if(array_key_exists('supplier_id', $_GET) && strlen($_GET['supplier_id'])) {
			$filter .= " AND supplier_id = '{$_GET['supplier_id']}'";
		}

		if(array_key_exists('domain_id', $_GET) && strlen($_GET['domain_id'])) {
			$filter .= " AND domain_id = '{$_GET['domain_id']}'";
		}

		if(array_key_exists('rating', $_GET) && strlen($_GET['rating'])) {
			$filter .= " AND (rating > '{$_GET['rating']}' AND can_rate = 1) ";
		}

		if(array_key_exists('contact_type', $_GET) && strlen($_GET['contact_type'])) {
			$filter .= " AND (ct.contact_type = '{$_GET['contact_type']}') ";
		}


		$limit = ($page * $this->per_page) .' , ' .$this->per_page;
		
		$contacts = Contact::find(array( 'where' => $filter))->fetch_all();
		$total_contacts = Contact::count(array('where' => $filter));

		if($this->_agent()->is_ajax()) {
			$this->set_view('contacts');
		}

		$this->set(array(
			'contacts' => $contacts,
			'total_contacts' => $total_contacts ,
			'per_page' => $this->per_page,
			'page' => $page
		));
		
	}

	public function rate($contact_id, $score) {
		$contact = new Contact($contact_id);

		if(!$contact->id) {
			die('no contact');
		}

		$contact->rating = $score;
		Contact::edit(array('rating' => $score), $contact->id);

	}

	public function hovercard($contact_id) {

		$contact = new Contact($contact_id);

		$this->set('supplier', false);

		if(isset($contact->supplier_id) && $contact->supplier_id > 0 ) {
			$supplier = new Supplier($contact->supplier_id );
			$this->set('supplier', $supplier->to_array());

			$contacts  = Contact::find(" id <> '{$contact->id}' AND supplier_id = {$contact->supplier_id} ")->fetch_all();
			$this->set('contacts', $contacts);
		}

		$this->set('contact', $contact->to_array());
		
	}


	public function export() {


		$filter = 'AND TRUE';

		if(array_key_exists('search', $_GET) && strlen($_GET['search'])) {
			$filter .= " AND (c.id = '{$_GET['search']}' OR name like '%{$_GET['search']}%' OR c.email like '%{$_GET['search']}%' OR c.mobile like '%{$_GET['search']}%' OR c.office like '%{$_GET['search']}%')";
		}

		if(array_key_exists('supplier_id', $_GET) && strlen($_GET['supplier_id'])) {
			$filter .= " AND supplier_id = '{$_GET['supplier_id']}'";
		}

		if(array_key_exists('domain_id', $_GET) && strlen($_GET['domain_id'])) {
			$filter .= " AND domain_id = '{$_GET['domain_id']}'";
		}

		if(array_key_exists('rating', $_GET) && strlen($_GET['rating'])) {
			$filter .= " AND (rating > '{$_GET['rating']}' AND can_rate = 1) ";
		}

		if(array_key_exists('contact_type', $_GET) && strlen($_GET['contact_type'])) {
			$filter .= " AND (ct.contact_type = '{$_GET['contact_type']}') ";
		}


		
		$contacts = Contact::find(array( 'where' => $filter))->fetch_all();

		
		echo "contact type,name,email,cell number,office number,rating\n";

		foreach($contacts as $c) {
			echo "{$c['contact_type']},{$c['name']},{$c['email']},{$c['mobile']},{$c['office']}";
			echo "\n";
		}

		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=contacts.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		exit();

	}
	
	public function add($contact_id = 0) {
	
		$this->set(array(
			'suppliers' => Supplier::find(array('fields'=>'id, supplier'))->fetch_all(),
			'domains' => Domain::find(array('fields'=>'id, domain'))->fetch_all()
		));

		$this->set('contact_type', Field::get('contact_type'));

		$contact = new Contact($contact_id);
		if(!$contact->id && $contact_id) {
			$this->redirect("contact");
		}
		
        if(array_key_exists('data', $_POST)) {

            $contact->update_map($_POST['data']);

            foreach($_POST['contact_types'] as $t) {
            	if($t == 'Trainers/speakers') {
            		$contact->can_rate = 1;
            	}
            }



            if( $contact->validate() && count($_POST['contact_types'])) {
				if(!$contact->id) {
					$contact->insert();
				} else {
					$contact->update();
				}

				$contact->update_types($_POST['contact_types']);

                $this->redirect('contact?success=1');
            } else {


            	if(!isset($_POST['contact_types']) || !count($_POST['contact_types'])) {
	            	Template::getInstance()->error('contact_type', 'not_null');
	            	$_POST['contact_types'] = array();
	            }

                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $contact->to_array());
            //hack for array post
			$_POST['contact_types'] = array();             
        }


	}
	
	public function edit($contact_id = 0, $document_id = 0) {

		$contact = new Contact($contact_id);

		if(!$contact->id && $contact_id) {
			$this->redirect("contact");
		}

		$this->set('contact_type', Field::get('contact_type'));


		$this->set(array(
			'suppliers' => Supplier::find(array('fields'=>'id, supplier'))->fetch_all(),
			'domains' => Domain::find(array('fields'=>'id, domain'))->fetch_all()
		));

		$this->set('none_subcribed_events', $contact->get_none_subcribed_events());
		$this->set('events', array_values($contact->get_events()));

		if($document_id) {
			$document = new Document($document_id);
			if($document->ident_id <> $contact->id) {
				$this->redirect('contact/edit/'. $contact->id.'?doc_match');
			}

			$this->set('document', $document->to_array());
		}

		if(isset($contact->supplier_id) && $contact->supplier_id > 0 ) {
			$supplier = new Supplier($contact->supplier_id );
			$this->set('supplier', $supplier->to_array());

			$contacts  = Contact::find(array('where' => " AND c.id <> '{$contact->id}' AND c.supplier_id = {$contact->supplier_id} "))->fetch_all();
			$this->set('contacts', $contacts);
		}

		if(isset($contact->domain_id) && $contact->domain_id > 0 ) {
			$domain = new Domain($contact->domain_id);
			$this->set('domain', $domain->to_array());
		}

		if(strlen($contact->full_contact)) {
			$full_contact = json_decode(strip($contact->full_contact));
			$this->set('full_contact', $full_contact);
		}

		$this->set('documents', Document::find("ident_id = '{$contact->id}' AND ident = 'contact' ")->fetch_all());



		$this->set('comments', Comment::find(array('where' => " c.ident = 'contact' and c.ident_id = '{$contact->id}' "))->fetch_all());
		if(array_key_exists('data', $_POST) ) {

            $contact->update_map($_POST['data']);

            if(!isset($_POST['contact_types']) || !count($_POST['contact_types'])) {
            	Template::getInstance()->error('contact_types','not_null');
            	$_POST['contact_types'] = array();
            }

            foreach($_POST['contact_types'] as $t) {
            	if($t == 'Trainers/speakers') {
            		$contact->can_rate = 1;
            	}
            }

            if( $contact->validate() && count($_POST['contact_types']) ) {
				if(!$contact->id) {
					$contact->insert();
				} else {
					$contact->update();
				}
				
				$contact->update_types($_POST['contact_types']);


                $this->redirect("contact/edit/{$contact->id}?success=1");
            } else {
                $this->set('data', $contact->to_array());
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $contact->to_array());
            $this->set('contact_types', $_POST['contact_types'] = array_keys($contact->get_types()));
            $this->set('contact_types_string', implode(',', $_POST['contact_types']));
            
        }

        if(($sent_count = $contact->count_sent_items()) != 0) {
	        $this->set('sent_count', $sent_count);
	        $this->set('sent_from', $contact->get_sent_from());
	        $this->set('sent_mail', Contact::search_mail($contact_id, array('message_type'=> 'sent')));

		}

		if(($received_count = $contact->count_received_items()) != 0) {
	        $this->set('received_count', $received_count);
	        $this->set('received_from', $contact->get_received_from());
	        $this->set('received_mail', Contact::search_mail($contact_id, array('message_type'=> 'received')));
    	}

	}

	public function message_view($message_id) {

		$message = Contact::message_view($message_id);
		
		$this->set('message', Contact::message_view($message_id));
	}

	public function search_mail($contact_id) {
		$mails = Contact::search_mail($contact_id, $_POST);
		$this->set('mails', $mails);
	}


	public function event_add($contact_id) {

		global $config;
 		
 		$contact = new Contact($contact_id);
        if (!$contact->id && $contact_id) {
            $this->redirect("contact?no_contact");
        }
        $contact->update_events($_POST['events']);

        if(isset($contact->email) && strlen($contact->email)) {
        	foreach($_POST['events'] as $event_id) {
        		$event = new Event($event_id);

        		$mail_vars = array(
					'name'			 => $contact->name,
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

        $this->redirect('contact/edit/'. $contact->id.'?event=1#event');

	}
	
	public function upload_document($contact_id=0, $document_id=0) {
 		
 	 		$document = new Document($document_id);
        if (!$document->id && $document_id) {
            $this->redirect("contact?no_document");
        }

 		$contact = new Contact($contact_id);
        if (!$contact->id && $contact_id) {
            $this->redirect("contact?no_contact");
        }

        if (array_key_exists('data', $_POST)) {

            $document->update_map($_POST['data']);
            $document->ident_id = $contact->id;
            $old_file = $document->file;
            $document->ident = 'contact';
            $document->file = 'handle';

            if ($document->validate()) {
                $document_id = $document->auto_inc();
                if (($file = $this->_upload($_FILES['uploadedfile'])->do_upload($this->upload_path, 'documents_' . $document_id . slug($document->title), $this->allowed_files)) !== false) {
                    $document->file = basename($file);
                } else {
                    $this->set('upload_error', $this->_upload()->last_error);
                    if(!$document->id) {
                    	$document->file = '';

                	} else {
                		$document->file = $old_file;
                	}
                }
            } else {
                $document->file = '';
            }

            if ($document->validate()) {
                if (!$document->id) {
                    $document->insert();
                } else {
                    $document->update();
                }

                $this->redirect("contact/edit/{$contact->id}?document=1#document");
            } else {
                
                $_POST['data']['id'] = $document->id;
                $this->set('document', $_POST['data']);
                $this->set('invalid', 1);

            }
        } else {
            $this->set('data', $document->to_array());
        }
	}

	public function delete($contact_id) {

		$contact = new Contact($contact_id);

		if(!$contact->id) {
			$this->redirect('contact?no_contact');
		}

		if(!$this->user->has_domain_rights($contact)) {
			$this->redirect('contact?no_rights');
		}

		Contact::delete($contact_id);
		$this->redirect('referer');
	}
	
	public function delete_selected() {
		if(array_key_exists('id', $_POST)) {
			if(is_array($_POST['id'])) {
				$this->delete(array_keys($_POST['id']));
			}
		}
	}
	

	public function update_supplier($contact_id = 0, $supplier_id = 0) {
		$contact = new Contact($contact_id);
		if(!$contact->id) {
			exit();
		}
		$contact->supplier_id = $supplier_id;
		$contact->update();
		exit();
	}

	public function update_domain($contact_id = 0, $domain_id = 0) {
		$contact = new Contact($contact_id);
		if(!$contact->id) {
			exit();
		}
		$contact->domain_id = $domain_id;
		$contact->update();
		exit();
	}


	public function get_users() {

		if ($this->user->is_admin()) {
            
			$users = Contact::find(array(
					'where' => "AND (c.name <> '' AND c.email <> '')"
			))->fetch_all();

            foreach($users as $user) {
                $json[] = $user['name'] . '__' . $user['id'];
            }

            echo json_encode(array_values($json));
        }
        exit();

	}

}
?>