<?php declare(strict_types=1)

class NoteController extends AppController {

    private $per_page = 20;

    public function index($page=0) {

        $filter = 'TRUE';

        if (array_key_exists('search', $_GET)) {
            $filter = " (id = '{$_GET['search']}' OR note like '%{$_GET['search']}%' )";
        }

        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $notes = Note::find(array( 'where' => $filter))->fetch_all();
        $total_notes = Note::count(array('where' => $filter));

        $this->set(array(
            'notes' => $notes,
            'total_notes' => $total_notes,
            'per_page' => $this->per_page,
            'page' => $page
        ));
    }

    public function add($note_id = 0, $profile_id = 0, $parent_id=0) {

        $note = new Note($note_id);
        $profile = new User($profile_id);

        $is_ajax = $this->_agent()->is_ajax();

        $this->can_modify($note, $note_id, $profile);
        $this->set('profile', $profile->to_array());

        if (array_key_exists('data', $_POST)) {

            $note->update_map($_POST['data']);
            $note->user_id = $profile->id;
            $note->created_by = $this->user->id;
            if (!$note->parent_id) {
                $note->parent_id = $parent_id;
            }

            if ($note->validate()) {
                if (!$note->id) {
                    $note->insert();
                } else {
                    $note->update();
                }

                if ($is_ajax) {
                    echo parse_tpl($this->template->get_theme(), '_note', array(
                        'note' => $note->to_array(),
                        'full_name' => $this->user->name . ' ' . $this->user->surname,
                        'date' => date("F j, Y"),
                        'profile_id' => $profile->id
                    ));
                    exit();
                } else {
                    $this->redirect($profile->id . '#notes');
                }
            } else {
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $note->to_array());
        }
    }

    public function edit($note_id = 0, $profile_id = 0) {

        $note = new Note($note_id);
        $profile = new User($profile_id);

        $this->can_modify($note, $note_id, $profile);


        $this->set_view('note_add');
        $this->add($note_id, $profile_id);
    }

    public function delete($note_id, $profile_id = 0) {

        $note = new Note($note_id);
        $profile = new User($profile_id);
        $this->can_modify($note, $note_id, $profile);

        Note::delete($note_id);
        $this->redirect($profile_id . '#notes');
    }

    private function can_modify($note, $note_id, $profile) {

        $is_ajax = $this->_agent()->is_ajax();

        if (!$profile->id) {
            if ($is_ajax) {
                exit();
            } else {
                $this->redirect("user/home");
            }
        }

        if (!$note->id && $note_id) {
            if ($is_ajax) {
                exit();
            } else {
                $this->redirect("user/home");
            }
        }

        $allowed_domains = $this->user->get_domains();

        if (!in_array($profile->domain_id, array_keys($allowed_domains))) {
            if ($is_ajax) {
                exit();
            } else {
                $this->redirect("user/home");
            }
        }
    }

}

?>