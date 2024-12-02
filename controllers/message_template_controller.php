<?php declare(strict_types=1)

class Message_templateController extends AppController {

	private $per_page = 100;

	public function index($page=0) {
	
		$filter = 'TRUE';
		if(array_key_exists('search', $_GET)) {
			$filter = " (id = '{$_GET['search']}' OR name like '%{$_GET['search']}%' )";
		}
		$limit = ($page * $this->per_page) .' , ' .$this->per_page;
		
		$message_templates = Message_template::find(array( 'where' => $filter))->fetch_all();
		$total_message_templates = Message_template::count(array('where' => $filter));
		
		$this->set(array(
			'message_templates' => $message_templates,
			'total_message_templates' => $total_message_templates ,
			'per_page' => $this->per_page,
			'page' => $page
		));
		
	}

	
	public function add($message_template_id = 0) {
	
		$message_template = new Message_template($message_template_id);
		if(!$message_template->id && $message_template_id) {
			$this->redirect("message_template");
		}

        if(array_key_exists('data', $_POST)) {

            $message_template->update_map($_POST['data']);

            if( $message_template->validate() ) {
				if(!$message_template->id) {
					$message_template->insert();
				} else {
					$message_template->update();
				}
                $this->redirect('message_template?success=1');
            } else {
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $message_template->to_array());
        }
	}
	
	public function edit($message_template_id = 0) {
		if($message_template_id == 0) {
			$this->redirect("message_template");
		}
		$this->set_view('message_template_add');
		$this->add($message_template_id);
	}
	
	public function delete($message_template_id) {

		$message = new Message_template($message_template_id);
		
		if($message->message_type == 'system') {
			return false;
		}



		Message_template::delete($message_template_id);
		$this->redirect('referer');
	}
	

	public function load($id) {

		$template = new Message_template($id);

		if(!$template->id) {
			echo json_encode(array(
				'title' 	=>	'',
				'message'   => ''
			));

		} else {

			$template->message = str_replace('<br>', "\n", $template->message);
			echo json_encode(array(
				'title' 	=> strip($template->title),
				'message'   => strip_tags($template->message,'<a>')
			));
		}

		exit();

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