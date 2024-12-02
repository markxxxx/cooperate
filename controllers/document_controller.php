<?php declare(strict_types=1)

class DocumentController extends CVController {

    private $per_page = 100;
    private $allowed_files = array('png', 'jpg', 'jpeg', 'gif', 'doc', 'docx', 'pdf', 'csv');
    private $upload_path = 'media/documents/';

    function index($page=0) {

        $filter = 'TRUE';
        if (array_key_exists('search', $_GET)) {
            $filter = " (id = '{$_GET['search']}' OR title like '%{$_GET['search']}%' )";
        }
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $documents = Document::find(array( 'where' => $filter))->fetch_all();
        $total_documents = Document::count(array('where' => $filter));

        $this->set(array(
            'documents' => $documents,
            'total_documents' => $total_documents,
            'per_page' => $this->per_page,
            'page' => $page
        ));
    }

    function add($document_id = 0) {

        $document = new Document($document_id);
        if (!$document->id && $document_id) {
            $this->redirect("document");
        }

        if (array_key_exists('data', $_POST)) {

            $document->update_map($_POST['data']);
            $document->ident_id = $this->user->id;
            $document->file = 'handle';
            if ($document->validate()) {
                $document_id = $document->auto_inc();
                if (($file = $this->_upload($_FILES['uploadedfile'])->do_upload($this->upload_path, 'documents_' . $document_id . slug($document->title), $this->allowed_files)) !== false) {
                    $document->file = basename($file);
                } else {
                    $this->set('upload_error', $this->_upload()->last_error);
                    $document->file = '';
                }
            } else {
                $document->file = '';
            }

            if ($document->validate()) {
                if (!$document->id) {
                    $document->insert();
                } else {
                    $document->update();
                }

                Action::add($this->user, 'a_upload', array($this->upload_path . $document->file, $document->title));
                Task::complete($this->user->id, 'a_upload');
                Task::complete($this->user->id, 'u_upload');



                $this->redirect('profile?success=1');
            } else {
                
                $_POST['data']['id'] = $document->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('document', $document->to_array());
        }
    }

    function edit($document_id = 0) {
        if ($document_id == 0) {
            $this->redirect("document");
        }
        $this->set_view('document_add');
        $this->add($document_id);
    }

    function delete($document_id) {

        if (is_array($document_id)) {
            foreach ($document_id as $d) {
                $document = new Document($d);
                if ($this->user->id == $document->user_id) {
                    unlink($this->upload_path . $document->file);
                    Document::delete($document_id);
                }
            }
        } else {

            $document = new Document($document_id);
            if (!$document->id) {
                $this->redirect("document");
            }
            unlink($this->upload_path . $document->file);
            Document::delete($document_id);
        }
        $this->redirect('referer');
    }

    function delete_selected() {
        if (array_key_exists('id', $_POST)) {
            if (is_array($_POST['id'])) {
                $this->delete(array_keys($_POST['id']));
            }
        }
        $this->redirect('referer');
    }

}

?>