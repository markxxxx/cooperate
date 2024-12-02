<?php

class ActivateController extends AppController {

    private 
        $users_per_page = 10;
        // $per_page = 10;

    public function before_action() {

        parent::before_action();

        // if (!$this->user->can_access($this->controller_name, $this->method_name)) {
        //     $_SESSION['redirect'] = urlencode(substr($_SERVER['REQUEST_URI'], 1));
        //     $this->redirect('login');
        // }
    }

   

    
  


 

    public function index($page=0) {

        // $filter = 'TRUE';
        // $limit = ($page * $this->users_per_page) . ' , ' . $this->users_per_page;

        // $domains = $this->user->get_domains();
        // $groups = $this->user->get_groups();

        // $this->set(array(
        //     'domains' => array_values($domains),
        //     'groups' => array_values($groups)
        // ));
        // $users = User::query("SELECT *, 
        //                             u.id AS user_id,
        //                             u.name AS first_name,
        //                             g.name AS group_name,
        //                             d.domain AS domain_name
        //                          FROM users u 
        //                          LEFT JOIN groups g ON (g.id=u.group_id) 
        //                          LEFT JOIN domains d ON (d.id=u.domain_id)
        //                     ")->fetch_all();
        // $total_users = User::count(array('where' => $filter));


        // $this->set(array(
        //     'users'         => $users,
        //     'total_users'   => $total_users,
        //     'per_page'      => $this->users_per_page,
        //     'page'          => $page
        // ));
    }

    public function add($user_id = 0) {

    
    }

    public function edit($user_id = 0) {
     
    }

    public function delete($user_id) {
    
    }

    public function delete_selected() {

    }

    public function user($user_id = 0) {
        if ($user_id == 0 || $user_id == 1) {
            $this->redirect("login");
        }
       
       $user = User::query("SELECT *, 
                                    u.id AS user_id,
                                    u.name AS first_name,
                                    g.name AS group_name,
                                    d.domain AS domain_name
                                 FROM users u 
                                 LEFT JOIN groups g ON (g.id=u.group_id) 
                                 LEFT JOIN domains d ON (d.id=u.domain_id)
                                 WHERE registered=$user_id
                            ")->fetch_all();

       // var_dump($user);exit();
       if( $user[0]['user_id'] > 0){
            Database::query("UPDATE `users` SET account_status = 'Active',registered = '1' WHERE id = '{$user[0]['user_id']}' ");
            $this->redirect("login?activate=1");
       }
       else{
            $this->redirect("login?failure=1");
       }
    }

    public function update_domain($user_id = 0, $domain_id = 0) {
        $user = new User($user_id);
        if (!$user->id) {
            exit();
        }
        $user->domain_id = $domain_id;
        $user->update();
        exit();
    }

    public function update_batch($all = true) {

        $this->set('all', $all);
        $this->set('filters', Filter::get());
        $this->set('groups', array_values($this->user->get_groups()));
        $this->set('domains', array_values($this->user->get_domains()));

        $this->set('account_status', Field::get('account_status'));

        $filters = array();
        $filters['show_suspended'] = true;

        if($all) {
            $filters = Filter::get();
            $filters['limit'] = false;

            $this->set('user_count', User::search_count($filters));
        }


        if($_POST['updates']) {

            if(!$all) {
                $users = $_POST['users'];
            } else {

                $users = array();
                foreach(User::search( $filters) as $user) {
                    $users[] = $user['id'];
                }
            }


            foreach($users as $u) {

                if(isset($_POST['update_group']) && strlen($_POST['updates']['group'])) {
                    User::edit("group_id = '{$_POST['updates']['group']}'", $u);
                }
                
                if(isset($_POST['update_domain']) && strlen($_POST['updates']['domains'])) {
                    User::edit("domain_id = '{$_POST['updates']['domains']}'", $u);
                }

                if(isset($_POST['update_status']) && strlen($_POST['updates']['status'])) {
                    User::edit("account_status = '{$_POST['updates']['status']}'", $u);
                }

            }

            $this->redirect('user?confirmation='.count($users). ' users updated successfully');
        }


        if(!$all && !isset($_POST['id'])) {
            echo "No users selected";
            die();
        }

        if(!$all) {
            $this->set('users', User::search(array('where' => " AND " . Database::in_clause('u.id', array_keys($_POST['id'])))));
        }

    }

    public function export_batch($all = true) {
/*
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=raw_data.csv");
        header("Pragma: no-cache");
        header("Expires: 0");*/




        if(!$all) {

            $filters['where'] = " AND " . Database::in_clause('u.id', array_keys($_POST['id']));

            $users = User::search(array('where' => " AND " . Database::in_clause('u.id', array_keys($_POST['id']))));

        } else {
            $filters = Filter::get();
            $filters['limit'] = false;
        }

        $sql = 'SELECT u.*,s.*,p.* FROM users u LEFT JOIN scholarships s ON u.id = s.user_id LEFT JOIN profiles p ON u.id = p.user_id,groups g';
        $sql .= User::get_search_where_clause($filters) . User::get_search_order_clause($filters);

        $rs = Database::query($sql);
        $rows = array();

        $last = array();


                $col = 3;
        $row = 12;
        

        function to_co_ord($row,$col) {

           // d($col);
            if($col > 76) {
                return 'C'.chr($col+65 - 77) . $row;
            } elseif($col > 50) {
                return 'B'.chr($col+65 - 51) . $row;
            } elseif($col > 24) {
                return 'A'.chr($col+65 - 25) . $row;
            }
            return chr($col+65).$row;
        }


        include('include/PHPExcel.php');



        $objPHPExcel = new PHPExcel;
        
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(9);

        $work_sheet_cnt = 0;

        $objSheet = new PHPExcel_Worksheet($objPHPExcel, 'Data');

        $rows = $rs->fetch_all();


        for($i = 65;$i < 85; $i++) {
            $char = chr($i);
            $objSheet->getColumnDimension($char)->setWidth(23);


        }
 
        $headers = array_keys($rows[0]);

        unset($headers[2]);

        $heading_cnt = 0;
        foreach($headers as $heading) {

            $coord = to_co_ord(1 , $heading_cnt++ );
            $objSheet->getCell($coord)->setValue(ucfirst(str_replace('_', ' ', $heading)));
        }


        $row = 2;
        foreach($rows as $details) {
            $row++;
            $col=0;

            
            foreach($details as $key => $field) {

                if($key != 'password') {

                    $objSheet->getCell(to_co_ord($row  , $col++))->setValue($field);

                } 
            }


        }






/*
        $row = 1;
        foreach($rows as $rsvp) {
            $row++;
            $col=0;
            foreach($rsvp as $field) {
                $objSheet->getCell(to_co_ord($row  , $col++))->setValue($field);
            }
        }



        }
  */      

        $objPHPExcel->addSheet($objSheet, 1);


        $objPHPExcel->setActiveSheetIndex(1);


        $objWriter = new PHPExcel_Writer_Excel2007 ($objPHPExcel);



        $filename = time().'event.xls';


        $objWriter->save("media/{$filename}");
        header("location: /media/{$filename}");


        exit();
    }

    public function update_group($user_id = 0, $group_id = 0) {

        $user = new User($user_id);
        if (!$user->id) {
            exit();
        }

        $group = new Group($group_id);

        if(!$group->id) {
            exit();
        }

        $user->group_id = $group_id;
        
        if($group->is_alumni()) {
            
            Task::map(array(
                'user_id'       => $user->id,
                'type_id'       => 'a_alumni'
            ))->insert();

            $user->alumni_date = date('Y-m-d');
        }
        
        $user->update();
        exit();
    }

    public function update_status($user_id, $status) {
        $user = new User($user_id);
        if (!$user->id) {
            exit();
        }


        $user->account_status = $status;
        $user->update();
        exit();
    }

    public function reset_password($email) {

        if ($this->_agent()->is_ajax()) {
            if (($user_id = User::id_by_email($email)) !== null) {
                $user = new User($user_id);
                $hash = md5($user->modified_on . '_' . $user_id);

                $domain = Domain::domain_by_id($user->domain_id);

                mail_template('forgot_password', $user->email, $domain . ' Bursary Management', array(
                    'domain' => $domain,
                    'hash' => $hash,
                    'name' => $user->name . ' ' . $user->surname
                ));

                echo json_encode(array('error' => 0));
                exit;
            }
        }
        echo json_encode(array(
            'error' => 1
        ));
        exit;
    }

    public function reset($hash='') {
        if (($user = User::find("md5(concat(modified_on,'_',id)) = '{$hash}'")->fetch()) !== false) {
            if (isset($_POST['new_password'])) {
                if (($_POST['new_password'] == $_POST['retyped_password']) && (strlen($_POST['new_password']) > 5)) {

                    $user = new User($user['id']);
                    $user->password = md5($_POST['new_password']);
                    $user->update();
                    $_SESSION['id'] = $user->id;
                    $domain = Domain::domain_by_id($user->domain_id);
                    mail_template('user_password', $user->email, 'Moshal: Password reset', array('name' => $user->name, 'surname' => $user->surname, 'email' => $user->email, 'domain' => $domain, 'password' => $_POST['new_password']));

                    $this->redirect('dashboard/home');
                } else {
                    $this->set('error', 2);
                }
            }
        } else {
            $this->set('error', 1);
        }
    }

    public function password() {

        if (isset($_POST['new_password'])) {

            if($this->user->registered == 1 && (md5($_POST['old_password']) != $this->user->password)) {
                $this->set('error', 1);
                return true;
            }

            if (($_POST['new_password'] == $_POST['retyped_password']) && (strlen($_POST['new_password']) > 5)) {
                $this->user->password = md5($_POST['new_password']);
                $this->user->registered = 1;
                $this->user->update();
                $domain = new Domain($this->user->domain_id);
                mail_template('user_password', $this->user->email, 'Password updated!', array('name' => $this->user->name, 'surname' => $this->user->surname, 'email' => $this->user->email, 'domain' => $domain->domain, 'password' => $_POST['new_password']));
                $this->redirect('dashboard/home?confirmation=Password updated successfully');
            } else {
                $this->set('error', 1);
            }
        }
    }

    public function update_academic_result($id, $result ) {
        $this->user->update_academic_result($id, $result);
        exit();
    }

    public function preview($user_id = 0) {

        $user = new User($user_id);

        if(!$user->is_bursar()) {
            echo "error not bursar";
            exit();
        }

        if (!$user->id) {
            echo "error";
            exit();
        }

        $allowed_domains = $this->user->get_domains();
        $allowed_groups = $this->user->get_groups();


        if (!in_array($user->domain_id, array_keys($allowed_domains))) {
            echo "error domain";
            exit();
        }

        if (!in_array($user->group_id, array_keys($allowed_groups))) {
            echo "error group";
            exit();
        }

        $this->set('preview', $user);

    }

    
    /*
    public function import_contacts() {
            
        $row = 1;

        http://moshal.svo.co.za/user/import_contacts
        
        if (($handle = fopen("moshal_contacts.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                
                $num = count($data);
                
                //echo "<p> $num fields in line $row: <br /></p>\n";
                
                $contact = Contact::find(array("where" => " AND c.email = '{$data['1']}' " ))->fetch();

                $data[0] = escape($data[0]);
                $data[1] = escape($data[1]);

                if($contact) {

                    $sql = "UPDATE contacts set name = '{$data[0]}' WHERE id = '{$contact['id']}' ";
                    Database::query($sql);
                    

                } else {

                    $sql = "INSERT INTO contacts(name, email) VALUES ('{$data[0]}', '{$data[1]}' ) ";

                    $rs = Database::query($sql);

                    $contact_id = $rs->insert_id();

                    $sql = "INSERT INTO contact_types (contact_id, contact_type) VALUES ('{$contact_id}', 'Corporates') ";

                    Database::query($sql);

                }


            }
        }
        
        fclose($handle);
    }
    

    //public function import() {
        /*

        $row = 1;

        $temp = array();

        if (($handle = fopen("book1.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $user = new User(0);

                $user->name = trim($data[0]);
                $user->surname = trim($data[1]);
                $user->email = strtolower($data[6]);
                $user->password = md5($user->email);

                $user->domain_id = 9;
                $user->group_id = 5;

                $password = $data[6];

                $user->insert();

                $scholarship = new Scholarship(0);

                $scholarship->user_id = $user->id;

                $scholarship->discipline = trim($data[4]);

                $scholarship->university = trim($data[2]);

                $scholarship->degree = trim($data[5]);

                $scholarship->insert();

                $mail_vars = array(
                    'name' => $user->name .' '.$user->surname,
                    'email' => $user->email, 
                    'password' => $user->email
                );

                Message_template::send($user->email, Message_template::REGISTRATION, $mail_vars);


                Message::map(array(
                    'title' => "Welcome to the Moshal Scholarship portal",
                    'message' => escape(parse_tpl('mail', 'welcome_message', array('name' => $user->name . ' ' . $user->surname))),
                    'domain_id' => $user->domain_id,
                    'sender_id' => 327, //jodi
                    'parent_id' => 0,
                    'recipient_id' => $user->id
                ))->insert();

            }
            fclose($handle);
        }

        /*

        foreach($users as $u) {

            $mail_vars = array(
                'name' => $user->name .' '.$user->surname,
                'email' => $user->email, 
                'password' => strtolower($user->email)
            );

            Message_template::send($user->email, Message_template::REGISTRATION, $mail_vars);


            Message::map(array(
                'title' => "Welcome to the Moshal Scholarship portal",
                'message' => escape(parse_tpl('mail', 'welcome_message', array('name' => $u['name'] . ' ' . $u['surname']))),
                'domain_id' => $user['domain_id'],
                'sender_id' => $admin->id,
                'parent_id' => 0,
                'recipient_id' => $u['id']
            ))->insert();

        }*/

    //} 


}

?>