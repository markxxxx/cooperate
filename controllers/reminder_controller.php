<?php

class ReminderController extends AppController {

	private $per_page = 100;

	public function index($page=0) {
	
		$filter = 'TRUE';
		if(array_key_exists('search', $_GET)) {
			$filter = " (id = '{$_GET['search']}' OR reminder like '%{$_GET['search']}%' )";
		}
		$limit = ($page * $this->per_page) .' , ' .$this->per_page;
		
		$reminders = Reminder::find(array( 'where' => $filter))->fetch_all();
		$total_reminders = Reminder::count(array('where' => $filter));
		
		$this->set(array(
			'reminders' => $reminders,
			'total_reminders' => $total_reminders ,
			'per_page' => $this->per_page,
			'page' => $page
		));
		
	}

	public function complete($reminder_id = 0) {
		
		$reminder = new Reminder($reminder_id);
		if(!$reminder->id && $reminder_id) {
			$this->redirect("reminder");
		}

		if($reminder->privacy == 0 && $reminder->user_id != $this->user->id) {
			$this->redirect('?not_rights');
		}
		$now = date('Y-m-d');
		Reminder::edit("completed = 1 , completed_date = '{$now}'", $reminder_id);
		exit();
	}
	
	public function add($reminder_id = 0,$ident =null, $ident_id = 0) {
	
		$reminder = new Reminder($reminder_id);
		if(!$reminder->id && $reminder_id) {
			$this->redirect("reminder");
		}

		if(!is_null($ident)) {
			$obj = new $ident($ident_id);
			$this->set('obj', $obj);
			$this->set('ident', $ident);
			$this->set('ident_id', $ident_id);
		}


		
        if(array_key_exists('data', $_POST)) {

            $reminder->update_map($_POST['data']);
            $reminder->user_id = $this->user->id;
            

            if(isset($obj)) {
            	$reminder->ident = $ident;
            	$reminder->ident_id = $ident_id;
            }

            if( $reminder->validate() ) {
				if(!$reminder->id) {
					$reminder->insert();
				} else {
					$reminder->update();
				}
				  exit();

            } else {
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
                  exit();
            }

        } else {
            $this->set('data', $reminder->to_array());
        }
	}
	
	public function edit($reminder_id = 0) {
		
		if($reminder_id == 0) {
			$this->redirect("reminder");
		}

		$reminder = new Reminder($reminder_id);
		
		$this->set('ident', null);

		if(strlen($reminder->ident)) {
			$ident = new $reminder->ident($reminder->ident_id);
			if($ident->id) {
				$this->set('ident', $ident);
			}
		}

		if($reminder->privacy == 0 && $reminder->user_id != $this->user->id) {
			$this->redirect('?not_rights');
		}

		if(array_key_exists('data', $_POST)) {

            $reminder->update_map($_POST['data']);

             if( $reminder->validate() ) {
             	$reminder->update();
            }
            $this->redirect("reminder/edit/{$reminder->id}?success=1");

        }

		$this->set('comments', Comment::find(array('where' => " c.ident = 'reminder' and c.ident_id = '{$reminder->id}' "))->fetch_all());

		$this->set('data', $reminder->to_array());

		$this->set('completed', Reminder::search($this->user,false, true));
		$this->set('incomplete', Reminder::search($this->user,false, false));
		$this->set('reminder', $reminder);

	}
	
	public function delete($reminder_id) {
		Reminder::delete($reminder_id);
		$this->redirect('referer');
	}
	
	public function delete_selected() {
		if(array_key_exists('id', $_POST)) {
			if(is_array($_POST['id'])) {
				$this->delete(array_keys($_POST['id']));
			}
		}
	}
	

}
?>