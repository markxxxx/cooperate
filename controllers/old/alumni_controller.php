<?php declare(strict_types=1)

class AlumniController extends CvController {

	private $per_page = 20;

	
	function add($alumni_id = 0) {
	

	    if (($alumni_id = Alumni::id_by_user_id($this->user->id)) === null) {
            $alumni_id = 0;
        }

		$alumni = new Alumni($alumni_id);

		if(!$alumni->id && $alumni_id) {
			$this->redirect("alumni");
		}

        if(array_key_exists('data', $_POST)) {

            $alumni->update_map($_POST['data']);
            $alumni->user_id = $this->user->id;

            if($alumni->are_you_working == 'No') {
        		$alumni->validate = array('not_null' => 'are_you_working');
            }

			if($alumni->have_contributed == 'Yes') {
				$alumni->add_validation('contributed','not_null');
			}

			if($alumni->have_contributed_moshal == 'Yes') {
				$alumni->add_validation('contributed_moshal','not_null');
			}

				
            $alumni->graduation_date =
                    $_POST['graduation_date']['Date_Year'] . '-' .
                    $_POST['graduation_date']['Date_Month'] . '-' .
                    '01';


            if( $alumni->validate() ) {
				if(!$alumni->id) {
					$alumni->insert();
				} else {
					$alumni->update();
				}

                Action::add($this->user, 'u_alumni');
                Task::complete($this->user->id, 'a_alumni');

                $this->redirect('profile?success=alumni');
            } else {
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $alumni->to_array());
        }
	}
	
	function edit($alumni_id = 0) {
		if($alumni_id == 0) {
			$this->redirect("alumni");
		}
		$this->set_view('alumni_add');
		$this->add($alumni_id);
	}
	
	function delete($alumni_id) {
		Alumni::delete($alumni_id);
		$this->redirect('referer');
	}
	
	function delete_selected() {
		if(array_key_exists('id', $_POST)) {
			if(is_array($_POST['id'])) {
				$this->delete(array_keys($_POST['id']));
			}
		}
	}
	

}
?>