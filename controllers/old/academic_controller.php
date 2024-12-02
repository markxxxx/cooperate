<?php declare(strict_types=1)

class AcademicController extends CvController {


    private $allowed_files = array('png', 'jpg', 'jpeg', 'gif', 'doc', 'docx', 'pdf', 'csv','tiff','tif');
    private $upload_path = 'media/academics/';

    public function add($academic_id = 0) {

        $academic = new Academic($academic_id);
        if (!$academic->id && $academic_id) {
            $this->redirect("academic");
        }

        if ($this->user->id != $academic->user_id && $academic_id) {
            $this->redirect("academic");
        }

        if (array_key_exists('data', $_POST)) {

            $academic->update_map($_POST['data']);
            $academic->user_id = $this->user->id;
            $academic->calendar_year = $_POST['calendar_year']['Date_Year'];

            //add validation if Matric
            if ($academic->university_year == 'Matric') {
                $academic->acadmic_record_type = '';
                $academic->remove_validation('acadmic_record_type', 'not_null');
                $academic->add_validation('school_name', 'not_null');
                $academic->add_validation('school_address', 'not_null');
            }

            $is_valid = false;
            if (is_array($_POST['data']['subjects'])) {
                foreach ($_POST['data']['subjects'] as $key => $value) {
                    if ($value['subject'] != '') {
                        $is_valid = true;
                    } else {
                        unset($_POST['data']['subjects'][$key]);
                    }
                }
            }


            if ($is_valid) {
                $academic->subjects = serialize(@array_values($_POST['data']['subjects']));
            } else {
                $academic->subjects = '';
            }

            $error = false;
            if (!($image = $this->_upload($_FILES['uploadedfile'])->do_upload($this->upload_path, 'academic' .time() , $this->allowed_files)) !== false) {
                $this->set('upload_error', $this->_upload()->last_error);
                $error = true;
            } else {
                $academic->file = basename($image);
            }


            if ($academic->validate() && !$error) {

                    if (!$academic->id) {
                        $academic->insert();
                        Action::add($this->user, 'a_academic');
                    } else {
                        $academic->update();
                        Action::add($this->user, 'u_academic');
                    }

                    Task::complete($this->user->id, 'a_academic');
                    Task::complete($this->user->id, 'u_academic');

                    $this->redirect('profile?success=academic');

            } else {
                if ($academic->subjects == '') {
                    $_POST['data']['subjects'] = array_fill(0, 6, array('subject' => '', 'symbol' => '', 'mark' => '', 'credits' => ''));
                }
                $_POST['data']['id'] = $academic->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {

            $academics = array();

            if (!$academic_id) {
                $academics['subjects'] = array_fill(0, 6, array('subject' => '', 'symbol' => '', 'mark' => '', 'credits' => ''));
            } else {

                $academics = $academic->to_array();

                if (strlen($academics['subjects'])) {

                    $academics['subjects'] = mb_unserialize(strip($academics['subjects']));
                } else {
                    $academics['subjects'] = array_fill(0, 6, array('subject' => '', 'symbol' => '', 'mark' => '', 'credits' => ''));
                }
            }


            if (!count($academics['subjects'])) {
                $academics['subjects'] = array_fill(0, 6, array('subject' => '', 'symbol' => '', 'mark' => '', 'credits' => ''));
            }


            $this->set('data', $academics);
        }
    }

    public function edit($academic_id = 0) {
        if ($academic_id == 0) {
            $this->redirect("academic");
        }
        $this->set_view('academic_add');
        $this->add($academic_id);
    }

    public function delete($academic_id) {
        Academic::delete($academic_id);
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