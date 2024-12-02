<?php declare(strict_types=1)

class CustomerController extends AppController {

    private $per_page = 100;


    public function before_action() {

        parent::before_action();

        if (!$this->user->can_access($this->controller_name, $this->method_name)) {
            $_SESSION['redirect'] = urlencode(substr($_SERVER['REQUEST_URI'], 1));
            $this->redirect('login');
        }
    }

    function index($page=0) {

        $filter = 'TRUE';        
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $customers = Customer::find(array( 'where' => $filter))->fetch_all();
        $total_customers = Customer::count(array('where' => $filter));

        $this->set(array(
            'customers' => $customers,
            'total_customers' => $total_customers,
            'per_page' => $this->per_page,
            'page' => $page
        ));
    }  

	public function add($customer_id = 0, $project_id=0) {  
       
        $customer = new customer($customer_id);

        if (!$customer->id && $customer_id) {
            $this->redirect("customer");
        }

        if ($project_id>0){
            $project = new project($project_id);
        }

        if (isset($_POST['data'])) {

            $customer->update_map($_POST['data']);

            if ($customer->id) {
                $customer->remove_validation('email', 'unique');
            }
      
            $customer->email = trim($customer->email);

            $is_new_customer = false;

            if ($customer->validate()) {
                if (!$customer->id) {
                    
                    $customer->insert();
                    $is_new_customer = true;

                    if ($project->id){
                        //add customer to project
                        Database::query("UPDATE `projects` 
                                            SET customer_id ='".$customer->id."' 
                                            WHERE id = '".$project->id."'
                                        ");
                        $this->redirect('project?success=1');
                    }
                    //send confirm mail
                    
                    // Message::map(array(
                    //     'title' => "Welcome to the portal",
                    //     'message' => escape(parse_tpl('mail', 'welcome_message', array('name' => $customer->name . ' ' . $customer->suraname))),
                    //     'sender_id' => $this->user->id,
                    //     'parent_id' => 0,
                    //     'recipient_id' => $customer->id,
                    // ))->insert();                    

                    // $mail_vars = array(
                    //     'name' => $customer->name .' '.$customer->surname,
                    //     'email' => $customer->email
                    // );

                    // Message_template::send($customer->email, Message_template::REGISTRATION, $mail_vars);

                } else {
                    $customer->update();
                }

                if($is_new_customer) {
                    $this->redirect('customer?success=1');
                } else {
                    // $this->redirect('customer/edit/'.$customer->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('customer?success=1');
                }

            } else {
                $this->set('project_id', $project->id);
                $_POST['data']['id'] = $customer->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $customer->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function edit($customer_id = 0) {
        if ($customer_id == 0) {
            $this->redirect("customer");
        }
        $this->set_view('customer_add');
        $this->add($customer_id);
    }

    public function delete($customer_id) {
        Customer::delete($customer_id);
        $this->redirect('referer');
    }

}

?>