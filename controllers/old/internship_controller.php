<?php declare(strict_types=1)

class InternshipController extends CvController {

    public function add($internship_id = 0) {

        $internship = new Internship($internship_id);
        if (!$internship->id && $internship_id) {
            $this->redirect("");
        }
        
        if ($this->user->id != $internship->user_id && $internship_id) {
            $this->redirect("");
        }

        if (array_key_exists('data', $_POST)) {

            $internship->update_map($_POST['data']);
            $internship->user_id = $this->user->id;

            $internship->date_started =
                    $_POST['date_started']['Date_Year'] . '-' .
                    $_POST['date_started']['Date_Month'] . '-' .
                    $_POST['date_started']['Date_Day'];

            $internship->date_ended =
                    $_POST['date_ended']['Date_Year'] . '-' .
                    $_POST['date_ended']['Date_Month'] . '-' .
                    $_POST['date_ended']['Date_Day'];

            if ($internship->validate()) {

                if (!$internship->id) {
                    $internship->insert();
                    Action::add($this->user, 'a_work');
                } else {
                    $internship->update();
                    Action::add($this->user, 'u_work');
                }

                Task::complete($this->user->id, 'a_work');
                Task::complete($this->user->id, 'u_work');

                $this->redirect('profile?success=internship');
            } else {
                $_POST['data']['id'] = $internship->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $internship->to_array());
        }
    }

    public function edit($internship_id = 0) {
        if ($internship_id == 0) {
            $this->redirect("internship");
        }
        $this->set_view('internship_add');
        $this->add($internship_id);
    }

    public function delete($internship_id) {
        $internship = new Internship($internship_id);
        
        if(!$internship->id) {
            $this->redirect("referer");
        }

        if ($this->user->id != $internship->user_id) {
            $this->redirect("referer");
        }

        $internship->destroy();
        $this->redirect('referer');
    }

    public function delete_selected() {
        if (array_key_exists('id', $_POST)) {
            if (is_array($_POST['id'])) {
                $this->delete(array_keys($_POST['id']));
            }
        }
    }

}

?>