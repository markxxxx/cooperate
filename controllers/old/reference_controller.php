<?php

class ReferenceController extends AppController {

	private $per_page = 20;

	public function index($page=0) {
	
		$filter = 'TRUE';
		if(array_key_exists('search', $_GET)) {
			$filter = " (id = '{$_GET['search']}' OR reference like '%{$_GET['search']}%' )";
		}
		$limit = ($page * $this->per_page) .' , ' .$this->per_page;
		
		$references = Reference::find(array( 'where' => $filter))->fetch_all();
		$total_references = Reference::count(array('where' => $filter));
		
		$this->set(array(
			'references' => $references,
			'total_references' => $total_references ,
			'per_page' => $this->per_page,
			'page' => $page
		));
		
	}
	
	public function add($reference_id = 0) {
	
		$reference = new Reference($reference_id);
		if(!$reference->id && $reference_id) {
			$this->redirect("reference");
		}
		
        if(array_key_exists('data', $_POST)) {

            $reference->update_map($_POST['data']);

            if( $reference->validate() ) {
				if(!$reference->id) {
					$reference->insert();
				} else {
					$reference->update();
				}
                $this->redirect('reference?success=1');
            } else {
            	$_POST['data']['id'] = $reference->id;
            	
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $reference->to_array());
        }
	}
	
	public function edit($reference_id = 0) {
		if($reference_id == 0) {
			$this->redirect("reference");
		}
		$this->set_view('reference_add');
		$this->add($reference_id);
	}
	
	public function delete($reference_id) {
		Reference::delete($reference_id);
		$this->redirect('referer');
	}
	
	public function delete_selected() {
		if(array_key_exists('id', $_POST)) {
			if(is_array($_POST['id'])) {
				$this->delete(array_keys($_POST['id']));
			}
		}
	}
	

}
?>