<?php declare(strict_types=1)

class CommentController extends AppController {

    private $comment_ajax_return = "
        <div id='comment-%s'>
            <div class='note-header'>
                <div class='note-by'> %s</div>
                <div class='note-date'>%s</div>
            </div>
             <div style='clear:both'></div>
            <p class='note'>%s</p>
            <div class='note-options'>
                <a href='/comment/edit/%s/%s' title='Edit Note' class='table-edit-link'></a>
                <a title='Delete Comment'  class='table-delete-link' href='/comment/delete/%s/%s'></a>&nbsp;&nbsp;
            </div>
             <div style='clear:both'></div>
        </div>
        ";

    public function add($comment_id = 0, $profile_id = 0, $ident = 0, $ident_id = 0) {

        $is_ajax = $this->_agent()->is_ajax();


        $comment = new Comment($comment_id);
        
        if($profile_id) {
            $profile = new User($profile_id);
            $this->set('profile', $profile->to_array());
            $this->can_modify($comment, $comment_id, $profile);
        }

        if (!$comment->id && $comment_id) {
            $this->redirect("comment");
        }

        if (isset($_POST['comment'])) {
            $_POST['data']['comment'] = $_POST['comment'];
        }

        if (array_key_exists('data', $_POST)) {

            $comment->update_map($_POST['data']);

            if (!$comment_id) {
                $comment->user_id = $profile_id;
                $comment->ident = $ident;
                $comment->ident_id = $ident_id;
                $comment->created_by = $this->user->id;
            }

            if ($comment->validate()) {
                if (!$comment->id) {
                    $comment->insert();
                } else {
                    $comment->update();
                }
                if ($is_ajax) {
                    printf($this->comment_ajax_return, $comment->id, $this->user->name . ' ' . $this->user->surame, date("F j, Y")
                            , $comment->comment, $comment->id, $profile->id, $comment->id, $profile->id);
                    exit();
                } else {
                    if($comment->user_id) {
                        $this->redirect($profile->id . '#comment');
                    } else {
                        $this->redirect($comment->ident.'/edit/'.$comment->ident_id);
                    }
                }
            } else {
                $_POST['data']['id'] = $comment->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $comment->to_array());
        }
    }




    public function edit($comment_id = 0, $profile_id = 0, $ident = 0, $ident_id = 0) {


        $this->set_view('comment_add');
        $this->add($comment_id, $profile_id);
    }

    public function delete($comment_id, $profile_id=0) {

        $comment = new Comment($comment_id);
        if($comment->user_id) {
            $profile = new User($profile_id);
            $this->can_modify($comment, $comment_id, $profile);
        }

        Comment::delete($comment_id);
        $this->redirect('referer');
    }

    public function delete_selected() {
        if (array_key_exists('id', $_POST)) {
            if (is_array($_POST['id'])) {
                $this->delete(array_keys($_POST['id']));
            }
        }
    }

    private function can_modify($comment, $comment_id, $profile) {

        $is_ajax = $this->_agent()->is_ajax();

        if (!$profile->id) {
            if ($is_ajax) {
                exit();
            } else {
                $this->redirect("user/home");
            }
        }

        if (!$comment->id && $comment_id) {
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