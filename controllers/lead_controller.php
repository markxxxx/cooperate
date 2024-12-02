<?php declare(strict_types=1)

class LeadController extends AppController {

    private $per_page = 100;

    function index($page=0) {

       
    }  

	public function add($customer_id = 0) {  

        $filter = 'TRUE';        
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $users = User::find(array( 'where' => $filter))->fetch_all();

        $this->set(array(
            'users' => $users,
            'per_page' => $this->per_page,
            'page' => $page
        ));
       
        $customer = new customer($customer_id);

        if (!$customer->id && $customer_id) {
            $this->redirect("customer");
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
                    $this->redirect('lead/add/?success=1');
                } else {
                    // $this->redirect('customer/edit/'.$customer->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('lead/add/?failure=1');
                }

            } else {
                $_POST['data']['id'] = $customer->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $customer->to_array());
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
        Lead::delete($customer_id);
        $this->redirect('referer');
    }

}

?>