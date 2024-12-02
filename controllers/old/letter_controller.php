<?php declare(strict_types=1)

class LetterController extends CVController {

	private $per_page = 20;
	
	function add($letter_id = 0) {
	
		$where = array(
			'user_id' 		=> $this->user->id,
			'letter_date'	=> date('Y')
		);

		$letter = Letter::find($where)->fetch();

		if($letter) {
			$letter_id = $letter['id'];
		} 

		$letter = new Letter($letter_id);
		if(!$letter->id && $letter_id) {
			$this->redirect("letter");
		}
		
        if(array_key_exists('data', $_POST)) {

            $letter->update_map($_POST['data']);
            $letter->user_id = $this->user->id;
            $letter->letter_date = date('Y');

            Action::add($this->user, 'u_letter');
            Task::complete($this->user->id, 'a_letter');

            if( $letter->validate() ) {
				if(!$letter->id) {
					$letter->insert();
				} else {
					$letter->update();
				}
                $this->redirect('profile?success=letter');
            } else {
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $letter->to_array());
        }
	}	

}
?>