<?php

class ForumController extends AppController {

	private $per_page = 20;
	
	private $topics = array(
			0   => 'General Rules',
			1   => 'Accommodation Rules',
			2   => 'Stipend Rules',
			3   => 'Vac work rules',
			4	=> 'General Discussion'
	);
	
	
	function index($page=0) {
	
		$filter = 'TRUE';
		if(array_key_exists('search', $_GET)) {
			$filter = " (id = '{$_GET['search']}' OR forum like '%{$_GET['search']}%' )";
		}
		$limit = ($page * $this->per_page) .' , ' .$this->per_page;
		
		$forums = Forum::find(array( 'where' => $filter))->fetch_all();
		$total_forums = Forum::count(array('where' => $filter));
		
		$this->set(array(
			'forums' => $forums,
			'total_forums' => $total_forums ,
			'per_page' => $this->per_page,
			'page' => $page
		));
		
	}
	
	function view() {
		
		$forum = Forum::get_domain_by_id($this->user->current_domain());
		
		if(!$forum->id) {
			$this->redirect('forum');	
		}
		
		//$forum->clear()get_topics();
		
	}
	
	function add($forum_id = 0) {
	
		$forum = new Forum($forum_id);
		if(!$forum->id && $forum_id) {
			$this->redirect("forum");
		}
		
		if ($this->user->is_super()) {
			$allowed_domains = Domain::find(array('fields' => 'id, domain'))->fetch_all();
		} else {
			$allowed_domains = $this->user->get_domains();
		}
		
		$temp = array();
		foreach($allowed_domains as $d) {
			$temp[$d['id']] = $d;
		}
		$allowed_domains = $temp;

		$forum_domains = $forum->get_domains();

		$new_temp = array();
		
		if($forum_domains !== false) {
			foreach($forum_domains as $d) {
				$new_temp[ $d['id'] ] = $d;
			}		
		}
		
		$allowed_to_view = Forum::get_unselected_domains();

		
		foreach($allowed_to_view as $key => $d) {
			if(isset($allowed_domains[$key])) {
				$new_temp[ $key ] = $d; 
			}
			
		}
		
		$allowed_domains = $new_temp;		
		$allowed_domains = array_values($allowed_domains);
		
		$this->set('current_domains', array());
		$this->set('domains', $allowed_domains);

        if(array_key_exists('data', $_POST)) {
        	
			$domains = $_POST['domains'];
        	$this->set('current_domains', is_array($_POST['domains']) ?  $_POST['domains'] : array());
        	
            $forum->update_map($_POST['data']);
			
            if( $forum->validate() && count($_POST['domains'])) {
				if(!$forum->id) {
					$forum->insert();
				} else {
					$forum->update();
				}
				$forum->update_domains($domains);
                $this->redirect('forum?success=1');
            } else {
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }
            if(!count($_POST['domains'])) {
            	Template::getInstance()->error('domain', 'not_null');
            }
        } else {
        	$domains = $forum->get_domains();
            $this->set('current_domains', !$domains ? array() : array_keys($domains));
            
            $this->set('data', $forum->to_array());
        }

	}
	
	function edit($forum_id = 0) {
		if($forum_id == 0) {
			$this->redirect("forum");
		}
		$this->set_view('forum_add');
		$this->add($forum_id);
	}
	
	function delete($forum_id) {
		Forum::delete($forum_id);
		$this->redirect('referer');
	}
	
	function delete_selected() {
		if(array_key_exists('id', $_POST)) {
			if(is_array($_POST['id'])) {
				$this->delete(array_keys($_POST['id']));
			}
		}
	}
	

}
?>