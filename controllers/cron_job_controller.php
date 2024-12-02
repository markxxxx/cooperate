<?php

class Cron_jobController extends AppController {

	private $per_page = 100;

	function index($page=0) {
	
		$filter = 'TRUE';
		if(array_key_exists('search', $_GET)) {
			$filter = " (id = '{$_GET['search']}')";
		}
		$limit = ($page * $this->per_page) .' , ' .$this->per_page;
		
		$cron_jobs = Cron_job::find(array( 'where' => $filter))->fetch_all();
		$total_cron_jobs = Cron_job::count(array('where' => $filter));
		
		$this->set(array(
			'cron_jobs' => $cron_jobs,
			'total_cron_jobs' => $total_cron_jobs ,
			'per_page' => $this->per_page,
			'page' => $page
		));
		
	}
	
	function add($cron_job_id = 0) {
	
		$cron_job = new Cron_job($cron_job_id);
		if(!$cron_job->id && $cron_job_id) {
			$this->redirect("cron_job");
		}
		
        if(array_key_exists('data', $_POST)) {

            $cron_job->update_map($_POST['data']);

            if( $cron_job->validate() ) {
				if(!$cron_job->id) {
					$cron_job->insert();
				} else {
					$cron_job->update();
				}
                $this->redirect('cron_job?success=1');
            } else {
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $cron_job->to_array());
        }
	}
	
	function edit($cron_job_id = 0) {
		if($cron_job_id == 0) {
			$this->redirect("cron_job");
		}
		$this->set_view('cron_job_add');
		$this->add($cron_job_id);
	}
	
	function delete($cron_job_id) {
		Cron_job::delete($cron_job_id);
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