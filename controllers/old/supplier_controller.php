<?php declare(strict_types=1)

class SupplierController extends AppController {

	private $per_page = 20;

	public function index($page=0) {
	
		$filter = 'TRUE';
		if(array_key_exists('search', $_GET)) {
			$filter = " (id = '{$_GET['search']}' OR supplier like '%{$_GET['search']}%' )";
		}
		$limit = ($page * $this->per_page) .' , ' .$this->per_page;
		
		$suppliers = Supplier::find(array( 'where' => $filter))->fetch_all();
		$total_suppliers = Supplier::count(array('where' => $filter));
		
		$this->set(array(
			'suppliers' => $suppliers,
			'total_suppliers' => $total_suppliers ,
			'per_page' => $this->per_page,
			'page' => $page
		));
		
	}
	
	public function add($supplier_id = 0) {
	
		$supplier = new Supplier($supplier_id);
		if(!$supplier->id && $supplier_id) {
			$this->redirect("supplier");
		}
		

		$this->set('supplier_types', Supplier_type::find()->fetch_all());

        if(array_key_exists('data', $_POST)) {

        	if($supplier->id) { 
        		$old_supplier = $supplier->to_array();
        	}

            $supplier->update_map($_POST['data']);

            if( $supplier->validate() ) {
				if(!$supplier->id) {
					$supplier->insert();
				} else {
					$diffences = array_diff_assoc( $supplier->to_array(), $old_supplier);
					$approval_id = Approval::process($supplier, $this->user, $diffences);
					
					if(!$this->user->can_approve() && $approval_id) {
						$_SESSION['approve'] = $approval_id;
						$this->redirect("approval/reason/". $approval_id
							."?redirect=supplier/add/{$supplier_id}");
					}
					
					$supplier->update();
				}
                $this->redirect("supplier/edit/{$supplier->id}?success=1");
            } else {
            	$_POST['data']['id'] = $supplier->id;
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $supplier->to_array());
        }


	}
	
	public function edit($supplier_id = 0, $document_id = 0) {



		$supplier = new Supplier($supplier_id);
		if(!$supplier->id ) {
			$this->redirect("supplier");
		}
		
		if($document_id) {
			$document = new Document($document_id);
			if($document->ident_id <> $supplier->id) {
				$this->redirect('document/edit/'. $contact->id.'?doc_match');
			}

			$this->set('document', $document->to_array());
		}

		$this->set('supplier_types', Supplier_type::find()->fetch_all());

        if(array_key_exists('data', $_POST)) {

        	if($supplier->id) { 
        		$old_supplier = $supplier->to_array();
        	}

            $supplier->update_map($_POST['data']);

            if( $supplier->validate() ) {
				if(!$supplier->id) {
					$supplier->insert();
				} else {
					$diffences = array_diff_assoc( $supplier->to_array(), $old_supplier);
					$approval_id = Approval::process($supplier, $this->user, $diffences);
					/*
					if(!$this->user->can_approve() && $approval_id) {
						$_SESSION['approve'] = $approval_id;
						$this->redirect("approval/reason/". $approval_id
							."?redirect=supplier/edit/{$supplier_id}");
					}*/
					
					$supplier->update();
				}

                $this->redirect("supplier/edit/{$supplier->id}?success=1");
            } else {
            	$_POST['data']['id'] = $supplier->id;
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            }

        } else {
            $this->set('data', $supplier->to_array());
        }


        $this->set('documents', Document::find("ident_id = '{$supplier->id}' AND ident = 'supplier' ")->fetch_all());
        $this->set('comments', Comment::find(array('where' => " c.ident = 'supplier' and c.ident_id = '{$supplier->id}' "))->fetch_all());

		$contacts  = Contact::find(array('where' => " AND supplier_id = {$supplier->id} "))->fetch_all();
		$this->set('contacts', $contacts);

		$this->set('payment_logs', Supplier::payment_log($supplier->id));
		$this->set('payment_summary', Supplier::payment_summary($supplier->id));

		$this->set('free_contacts', Contact::json_autocomplete(Contact::find(array('where' => " AND supplier_id = 0 "))->fetch_all()) );


	}

	public function upload_document($supplier_id=0, $document_id=0) {
	
 		$document = new Document($document_id);
        if (!$document->id && $document_id) {
            $this->redirect("supplier?no_document");
        }

 		$supplier = new Supplier($supplier_id);
        if (!$supplier->id && $supplier_id) {
            $this->redirect("supplier?no_contact");
        }

        if (array_key_exists('data', $_POST)) {

            $document->update_map($_POST['data']);
            $document->ident_id = $supplier->id;
            $document->ident = 'supplier';
            $old_file = $document->file;
            $document->file = 'handle';


            if ($document->validate()) {
                $document_id = $document->auto_inc();
                if (($file = $this->_upload($_FILES['uploadedfile'])->do_upload('media/documents/documents_' . $document_id . slug($document->title), $this->allowed_files)) !== false) {
                    $document->file = basename($file);
                } else {
                    $this->set('upload_error', $this->_upload()->last_error);
                    if(!$document->id) {
                    	$document->file = '';

                	} else {
                		$document->file = $old_file;
                	}
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

                $this->redirect("supplier/edit/{$supplier->id}?document=1#document");
            } else {
                
                $_POST['data']['id'] = $document->id;
                $this->set('document', $_POST['data']);
                $this->set('invalid', 1);

            }
        } else {
            $this->set('data', $document->to_array());
        }
	}
	
	public function add_contact($supplier_id = 0) {

		
		if(isset($_POST['save'])) {

			$supplier = new Supplier($supplier_id);

			if(!$supplier->id) {
				echo "no event";
				die();
			}

			if(isset($_POST['to'])) {

				foreach (explode(',', $_POST['to']) as $user_id) {
					$user_id = array_pop(explode('__', $user_id));

					if (is_numeric($user_id)) {
						$find .= "'{$user_id}',";
					}
				}
				$find = rtrim($find, ',');
				$users = Contact::find(array('where' => " AND c.id in ($find)"))->fetch_all();

				
				$temp = array();
				foreach ($users as $user) {
					$temp[] = $user['id'];
				}


				$supplier->update_contacts($temp);
			}
		}
	}

	public function delete($supplier_id) {
		Supplier::delete($supplier_id);
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