<?php declare(strict_types=1)

class ArticleController extends CvController {

	function add($article_id = 0) {
	
		$article = new Article($article_id);
		if(!$article->id && $article_id) {
			$this->redirect("article");
		}


        if ($this->user->id != $article->user_id && $article_id) {
            $this->redirect("");
        }
		
        if(array_key_exists('data', $_POST)) {

            $article->update_map($_POST['data']);
            $article->year_to_start = $_POST['dob']['Date_Year'];
            $article->user_id = $this->user->id;

            if( $article->validate() ) {
				if(!$article->id) {
					$article->insert();
				} else {
					$article->update();
				}
                $this->redirect('profile?success=article');
            } else {
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $article->to_array());
        }
	}
	
	function edit($article_id = 0) {
		if($article_id == 0) {
			$this->redirect("article");
		}
		$this->set_view('article_add');
		$this->add($article_id);
	}
	
	function delete($article_id) {
		$article = new Article($article_id);
		
		if(!$article->id) {
			$this->redirect("referer");
		}

        if ($this->user->id != $article->user_id) {
            $this->redirect("referer");
        }

		$article->destroy();
		$this->redirect('referer');
	}
	
}
?>