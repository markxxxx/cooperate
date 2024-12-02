<?php

class Supplier_typeController extends AppController {

	private $per_page = 20;

	function index($page=0) {
	
		$filter = 'TRUE';
		if(array_key_exists('search', $_GET)) {
			$filter = " (id = '{$_GET['search']}')";
		}
		$limit = ($page * $this->per_page) .' , ' .$this->per_page;
		
		$supplier_types = Supplier_type::find(array( 'where' => $filter))->fetch_all();
		$total_supplier_types = Supplier_type::count(array('where' => $filter));
		
		$this->set(array(
			'supplier_types' => $supplier_types,
			'total_supplier_types' => $total_supplier_types ,
			'per_page' => $this->per_page,
			'page' => $page
		));
		
	}
	
	function add($supplier_type_id = 0) {
	
		$supplier_type = new Supplier_type($supplier_type_id);
		if(!$supplier_type->id && $supplier_type_id) {
			$this->redirect("supplier_type");
		}
		
        if(array_key_exists('data', $_POST)) {

            $supplier_type->update_map($_POST['data']);

            if( $supplier_type->validate() ) {
				if(!$supplier_type->id) {
					$supplier_type->insert();
				} else {
					$supplier_type->update();
				}
                $this->redirect('supplier_type?success=1');
            } else {
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $supplier_type->to_array());
        }
	}
	
	function edit($supplier_type_id = 0) {
		if($supplier_type_id == 0) {
			$this->redirect("supplier_type");
		}
		$this->set_view('supplier_type_add');
		$this->add($supplier_type_id);
	}
	
	function delete($supplier_type_id) {
		Supplier_type::delete($supplier_type_id);
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