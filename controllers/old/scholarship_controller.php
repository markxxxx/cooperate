<?php

class ScholarshipController extends CvController {

    public function add($scholarship_id = 0) {

        if (($scholarship_id = Scholarship::id_by_user_id($this->user->id)) === null) {
            $scholarship_id = 0;
        }

        $scholarship = new Scholarship($scholarship_id);

        if (array_key_exists('data', $_POST)) {

            $scholarship->update_map($_POST['data']);

            $scholarship->award_date =
                    $_POST['award_date']['Date_Year'] . '-' .
                    $_POST['award_date']['Date_Month'] . '-' .
                    '01';

            $scholarship->grad_date =
                    $_POST['grad_date']['Date_Year'] . '-' .
                    $_POST['grad_date']['Date_Month'] . '-' .
                    '01';
            

            if($scholarship->postgrad == 'Yes') {
                $scholarship->postgrad_date =
                    $_POST['postgrad_date']['Date_Year'] . '-' .
                    $_POST['postgrad_date']['Date_Month'] . '-' .
                    '01';

                $scholarship->add_validation('postgrad_type', 'not_null');
            }

            if($scholarship->residence == 'Other') {
                $scholarship->add_validation('residence_other', 'not_null');
            }

            $scholarship->user_id = $this->user->id;

            if ($scholarship->validate()) {

                Action::add($this->user, 'u_scolar');
                Task::complete($this->user->id, 'scolar');

                if (!$scholarship->id) {
                    $scholarship->insert();
                } else {
                    $scholarship->update();
                }
                $this->redirect('profile?success=scholarship');
            } else {
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $scholarship->to_array());
        }
    }

    public function edit($scholarship_id = 0) {
        if ($scholarship_id == 0) {
            $this->redirect("scholarship");
        }
        $this->set_view('scholarship_add');
        $this->add($scholarship_id);
    }

    public function delete($scholarship_id) {
        Scholarship::delete($scholarship_id);
        $this->redirect('referer');
    }

    public function delete_selected() {
        if (array_key_exists('id', $_POST)) {
            if (is_array($_POST['id'])) {
                $this->delete(array_keys($_POST['id']));
            }
        }
    }

    public function preview($user_id = 0) {

        $user = new User($user_id);

        if(!$user->is_bursar()) {
            echo "error not bursar";
            exit();
        }

        if (!$user->id) {
            echo "error";
            exit();
        }

        $allowed_domains = $this->user->get_domains();
        $allowed_groups = $this->user->get_groups();


        if (!in_array($user->domain_id, array_keys($allowed_domains))) {
            echo "error domain";
            exit();
        }

        if (!in_array($user->group_id, array_keys($allowed_groups))) {
            echo "error group";
            exit();
        }

        if (($scholarship_id = Scholarship::id_by_user_id($user_id)) === null) {
            echo "ERROR no Scholarship for this user";
            exit();
        }

        $scholarship = new Scholarship($scholarship_id);

        $this->set('scholarship', $scholarship->to_array());


    }

}

?>