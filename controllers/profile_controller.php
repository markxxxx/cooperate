<?php declare(strict_types=1)

class ProfileController extends CvController {

    private $per_page = 100;

    public function test($a=0, $b=0) {
        $this->set(array(
            'a' => $a,
            'b' => $b
        ));

        $this->set('test', 'category');
    }

    public function index($page=0) {

        $this->set('domain_name', Domain::domain_by_id($this->user->domain_id));
    }

    public function add($profile_id = 0, $form = 0) {


        $action_type = array(
            0 => 'personal',
            1 => 'contact',
            2 => 'banking',
            3 => 'misc',
            4 => 'social'
        );

        if (($profile_id = Profile::id_by_user_id($this->user->id)) === null) {
            $profile_id = 0;
        }

        $profile = new Profile($profile_id);

        if (array_key_exists('data', $_POST)) {


            $profile->update_map($_POST['data']);
            $profile->user_id = $this->user->id;

            //Yes no More about hack
            if($form == 3) {

                if($profile->volunteer == 'Yes') {
                    $profile->add_validation('volunteer_comment','not_null');
                }

                if($profile->medical == 'Yes') {
                    $profile->add_validation('medical_comment', 'not_null');
                }


            }

            //custom form hax //personal
            if ($form == 0) {
                $profile->date_of_birth =
                        $_POST['dob']['Date_Year'] . '-' .
                        $_POST['dob']['Date_Month'] . '-' .
                        $_POST['dob']['Date_Day'];

                if (strlen($_POST['user']['name']))
                    $this->user->name = $_POST['user']['name'];

                if (strlen($_POST['user']['surname']))
                    $this->user->surname = $_POST['user']['surname'];

                if($this->user->is_israelie()) {
                    $profile->remove_validation('race');
                }

                if($profile->marital_status == 'Other') {
                    $profile->add_validation('marital_status_other', 'not_null');    
                }

                $this->user->update();
            }


            if ($profile->validate($form)) {

                Action::add($this->user, 'u_' . $action_type[$form]);
                Task::complete($this->user->id, $action_type[$form]);

                if (!$profile->id) {
                    $profile->insert();
                } else {
                    $profile->update();
                }

                if ($form == 0) {

                    if (($image = $this->_upload($_FILES['uploadedfile'])->do_upload('media/profiles/', $profile->id . '_profile_' . $user->id . slug($this->user->name), array('png', 'jpg', 'jpeg', 'gif'))) !== false) {
                        $this->_image()->resize($image, 500, 500);
                        Profile::edit(array('image' => basename($image)), 'id = ' . $profile->id);
                    }

                    if (($image = $this->__upload($_FILES['uploadedfile2'])->do_upload('media/passport/', $profile->id . '_passport_' . $user->id . slug($this->user->name), array('png', 'jpg', 'jpeg', 'gif'))) !== false) {
                        $this->_image()->resize($image, 500, 500);
                        Profile::edit(array('passport_image' => basename($image)), 'id = ' . $profile->id);
                    }


                }

                $this->redirect('profile?success=' . $action_type[$form]);
            } else {
                $_POST['data']['id'] = $profile->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', $action_type[$form]);
            }
        } else {
            $this->set('data', $profile->to_array());
        }
    }

    public function edit($profile_id = 0) {
        if ($profile_id == 0) {
            $this->redirect("profile");
        }
        $this->set_view('profile_add');
        $this->add($profile_id);
    }

    public function delete($profile_id) {
        Profile::delete($profile_id);
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