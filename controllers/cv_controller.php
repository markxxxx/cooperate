<?php

class CvController extends AppController {

    public function before_action() {

        parent::before_action();
        $this->set('profile', Profile::find(" user_id = '{$this->user->id}' ")->fetch());

        $this->set('internships', Internship::find(" user_id = '{$this->user->id}'")->fetch_all());
        $this->set('academics', Academic::find(" user_id = '{$this->user->id}' ")->fetch_all());
        $this->set('documents', Document::find(" ident_id = '{$this->user->id}' AND ident = 'bursar' ")->fetch_all());
        $this->set('scholarship', Scholarship::find(" user_id = '{$this->user->id}' ")->fetch());
        $this->set('articles', Article::find(" user_id = '{$this->user->id}' ")->fetch_all());
        $this->set('letters', Letter::find(" user_id = '{$this->user->id}' ")->fetch_all());

        $where = array(
            'user_id'       => $this->user->id,
            'letter_date'   => date('Y')
        );

        $letter = Letter::find($where)->fetch();


        $this->set('completed_letter', $letter === false ? false : true);
        
        if($this->user->is_alumni()) {
            $this->set('alumni', Alumni::find( " user_id = {$this->user->id} ")->fetch_all());
        }

        $this->set('incomplete_tasks', Task::find(array(
                'where' => " t.user_id = '{$this->user->id}' AND t.completed = 0 ",
                'order' => ' t.id asc ',
                'limit' => '5')
            )->fetch_all());

        $this->set('complete_tasks', Task::find(array(
                'where' => " t.user_id = '{$this->user->id}' AND t.completed = 1 ",
                'order' => ' t.id asc ',
                'limit' => '5')
            )->fetch_all());
    }

}

?>