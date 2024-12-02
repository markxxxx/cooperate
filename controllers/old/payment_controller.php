<?php declare(strict_types=1)

class PaymentController extends AppController {

    private $per_page = 20,
    $payment_references = array();

    public function before_action() {
        parent::before_action();
        #quick hack for syncing payment_references

        $references = Reference::find(array(
            'order' => ' reference ASC'
        ))->fetch_all();

        $payment_references ='';
        foreach($references as $r) {
            $payment_references[] = $r['reference'];
        }

        $this->payment_references = $payment_references;
    }

    public function index($page=0) {

        $filter = 'TRUE';

        //some domain security
		$domains = $this->user->get_domains();
		$filter = Database::in_clause('pd.domain_id', array_keys($domains));

        if (array_key_exists('search', $_GET)) {
            $filter .= " AND (p.id = '{$_GET['search']}' OR p.name like '%{$_GET['search']}%' )";
        }
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        //domain security
        $payments = Payment::find(array( 'where' => $filter, 'order' => 'p.id DESC'))->fetch_all();
        $total_payments = Payment::count(array('where' => $filter));

        $this->set(array(
            'payments' => $payments,
            'total_payments' => $total_payments,
            'per_page' => $this->per_page,
            'page' => $page
        ));
    }

    public function add($payment_id = 0) {

        $payment = new Payment($payment_id);
        if (!$payment->id && $payment_id) {
            $this->redirect("payment");
        }

        if($payment->id) { 
	    	if(!$this->user->has_domain_rights($payment)) {
	    		echo "No permissions";
	    		exit();
	    	}
    	}

        $this->set('filters', Filter::get());


        $domains = $this->user->get_domains();
		$domain_clause = Database::in_clause('pd.domain_id', array_keys($domains));

        $this->set('payments', Payment::find(array('where' => " p.enabled = 1 AND {$domain_clause}"))->fetch_all());


        $this->set('domains', array_values($domains));

        if (array_key_exists('data', $_POST)) {

            $payment->update_map($_POST['data']);

            if(!isset($payment->created_by)) {
                $payment->created_by = $this->user->id;
            }
            if(!isset($payment->enabled)) {
                $payment->enabled = 1;
            } else {
            	$payment->enabled = isset($_POST['enabled']) ? true : false;
            }

            if(isset($_POST['domain_admins'])) {
            	$domains = $_POST['domain_admins'];
            } else {
            	$domains = array_keys($domains);
            }

            if ($payment->validate()) {
                if (!$payment->id) {
                    $payment->insert();
                } else {
                    $payment->update();
                }

                $payment->update_domains($domains);

                $this->redirect('payment/batch_edit/'.$payment->id.'?success=1');
            } else {
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $payment->to_array());
            if($payment->id) {
            	$this->set('payment_domains', array_keys($payment->get_domains()));
            } else {
            	$this->set('payment_domains', array());
            }
        }
    }


    public function edit($payment_id = 0) {
        if ($payment_id == 0) {
            $this->redirect("payment");
        }
        $this->set_view('payment_add');
        $this->add($payment_id);
    }

    public function delete($payment_id) {

    	$payment = new Payment($payment_id);
        if (!$payment->id && $payment_id) {
            $this->redirect("payment");
        }

    	if(!$this->user->has_domain_rights($payment)) {
			$this->redirect("payment?no_rights");
    	}

        Payment::delete($payment_id);
        $this->redirect('referer');
    }

    public function delete_selected() {
        if (array_key_exists('id', $_POST)) {
            if (is_array($_POST['id'])) {
                $this->delete(array_keys($_POST['id']));
            }
        }
        $this->redirect('referer');
    }

    public function enable($payment_id = 0) {
        $payment = new Payment($payment_id);
        if (!$payment->id) {
            $this->redirect("payment");
        }

    	if(!$this->user->has_domain_rights($payment)) {
			$this->redirect("payment?no_rights");
    	}

        $payment->enabled = !$payment->enabled;
        $payment->closed_by = $this->user->id;

        if ($payment->closed_by_date == '0000-00-00 00:00:00') {
            $payment->closed_by_date = date('Y-m-d H:i:s');
        }

        $payment->update();

        $this->redirect('referer');
    }

    public function add_users($payment_id = 0) {

        $payment = new Payment($payment_id);

        if (!$payment->id) {
            $this->redirect("payment");
        }

        if(!$this->user->has_domain_rights($payment)) {
			$this->redirect("payment?no_rights");
    	}

        if (isset($_POST['to'])) {

			foreach (explode(',', $_POST['to']) as $user_id) {
				$user_id = array_pop(explode('__', $user_id));

				if (is_numeric($user_id)) {
					for($i = 0; $i < $_POST['entries']; $i++) {
						$payment->add_user($user_id, $this->user->id);
					}
				}
			}

        }

        exit();

    }

    public function add_suppliers($payment_id = 0) {


        $payment = new Payment($payment_id);

        if (!$payment->id) {
            $this->redirect("payment");
        }

        if(!$this->user->has_domain_rights($payment)) {
            $this->redirect("payment?no_rights");
        }

        if (isset($_POST['to'])) {

            foreach (explode(',', $_POST['to']) as $supplier_id) {
                $supplier_id = array_pop(explode('__', $supplier_id));

                if (is_numeric($supplier_id)) {
                    for($i = 0; $i < $_POST['entries']; $i++) {
                        $payment->add_supplier($supplier_id, $this->user->id);
                    }
                }
            }

        }

        exit();

    }



    public function batch_edit($payment_id = 0, $show_all = true) {

        $payment = new Payment($payment_id);
        $suppliers = Supplier::find()->fetch_all();
        
        if (!$payment->id) {
            $this->redirect("payment");
        }

        if(!$this->user->has_domain_rights($payment)) {
			$this->redirect("payment?no_rights");
    	}

        $this->set(array(
            'domains'       => array_values($this->user->get_domains()),
            'universities'  => Field::get('university'),
            'study_years'   => Field::get('year_of_study'),
            'user_count'    => User::search_count(),
            'groups'        => array_values($this->user->get_group_bursars())
        ));

        $payments = $payment->get_users($show_all);

        if (isset($_POST['user'])) {

            foreach ($_POST['user'] as $key => $u) {
                $payment->edit_user($key, $u['amount'], $u['reference'], $u['reference_2'] , $u['supplier_id']);
            }
            $show_all = count($payment->get_users(false)) ? '0' : '';
            $this->redirect('payment/batch_edit/' . $payment_id . '/' . $show_all);
        }



        $this->set('users', User::json_autocomplete(User::search(array('limit'=>false, 'account_type' => 'bursar'))) );
        $this->set('payments', $payments);
        $this->set('payment', $payment->to_array());
        $this->set('references', $this->payment_references);
        $this->set('suppliers', $suppliers);
        $this->set('supplier_json', Supplier::json_autocomplete($suppliers));

        
    }

    public function delete_user($payment_id = 0, $user_id = 0) {

        $payment = new Payment($payment_id);
        if (!$payment->id) {
            $this->redirect("payment");
        }
        $payment->delete_user($user_id);
        $this->redirect('referer');
    }
    

    public function add_advanced($payment_id) {
        
        $payment = new Payment($payment_id);

        if(!$payment->id) {
            die('no payment file');
        }

        if(!$this->user->has_domain_rights($payment)) {
            $this->redirect("payment/edit/{$payment_id}?no_rights");
        }

        Filter::clear();
    

        Filter::set($_POST);
        $filters = Filter::get();
        $filters['account_type'] = 'bursar';
        $filters['limit'] = false;
                
        $users = User::search($filters);
        foreach($users as $user) {
            $insert_id = $payment->add_user($user['id'], $this->user->id);
            //So fucking lazy here
            //So fuck you
            $payment->edit_user($insert_id ,$_POST['amount'], $_POST['reference'], '', $_POST['supplier']);
        }

        Filter::clear();
        $this->redirect("payment/batch_edit/{$payment_id}?success=1");
    }
    
    public function export($payment_id) {
    
        $payment = new Payment($payment_id);
        
        if (!$payment->id) {
            $this->redirect("payment");
        }

        if(!$this->user->has_domain_rights($payment)) {
			$this->redirect("payment?no_rights");
    	}
        
        $payments = $payment->get_users(true);



        $date = date('Y/m/d');
        $export = "BInSol - U ver 1.00,,,,,,, \n $date ,,,,,,, \n 62105271176 ,,,,,,, \n";
        $export .=  "PAYEE NAME,TO ACCOUNT,ACCOUNT TYPE,BRANCHCODE,AMOUNT,FROM REFERENCE,TO REFERENCE,CREATED BY \n";
        
        $consolidated = array();

        $i = 0;
        foreach($payments as $payment) {
            if(!$payment['supplier_id']) {
                if(!isset($consolidated[$payment['user_id']])) {
                    $consolidated[$payment['user_id']] = $payment;
                } else {
                    $consolidated[$payment['user_id']]['amount'] += (int) $payment['amount'];
                }
            } else {
                $i++;
                $consolidated['supplier_'.$i] = $payment;
            }
        }
        
        $payments = array_values($consolidated);
        
        
        foreach($payments as $payment) {
            
            $profile =  Profile::findby_user_id($payment['user_id'])->fetch();
            $user = new User($payment['user_id']);
            $domain = new Domain($user->domain_id);
            
            //JACO's method i agree/concur
            //$from_ref  = 'BP.'. $domain->reference . '.' . substr($payment['reference'],0,2).'.' .$user->id;
            //RO && Shazzes method hard coding for now
            $initial = strtolower($user->name);
            $initial = $initial[0];
            $from_ref = $domain->reference.$initial.'.'.strtolower($user->surname);
            
            if(!$payment['supplier_id']) {
            
                //JACO's method i agree/concur
                //$export .= "{$payment['user']},{$profile['bank_acc']},{$profile['account_type']},{$profile['bank_branch']},{$payment['amount']},{$from_ref},{$domain->reference} Bursary,{$payment['added']}\n";
                //RO && Shazzes method hard coding
                $export .= "{$payment['user']},{$profile['bank_acc']},{$profile['account_type']},{$profile['bank_branch']},{$payment['amount']},{$from_ref},Moshal,{$payment['added']}\n";

            } else {
                $supplier = new Supplier($payment['supplier_id']);
                $supplier = $supplier->to_array();
                
                $to_ref = Scholarship::student_number_by_user_id($user->id) . '_' . $user->surname;
                
                $export .= "{$supplier['supplier']},{$supplier['bank_acc']},{$supplier['account_type']},{$supplier['bank_branch']},{$payment['amount']},{$from_ref},{$to_ref},{$payment['added']}\n";
            }
        }
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=paymentfile.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $export;

        exit;

    }


    

}

?>