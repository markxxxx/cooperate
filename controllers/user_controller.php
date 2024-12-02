<?php

class UserController extends AppController {

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

        $users = User::query("
            SELECT
              u.id as user_id,
              u.name as first_name,
              u.surname,
              u.email,
              u.mobile_number,
              g.name as group_name,
              d.domain,
              u.account_status
            FROM users u
            INNER JOIN groups g on u.group_id = g.id
            INNER JOIN domains d on u.domain_id = d.id
            WHERE g.name <> 'Super User';
        ")->fetch_all();

        $allowed_domains = $this->user->get_domains();
        //$allowed_groups = $this->user->get_groups();
        $groups = Group::query("SELECT * FROM groups WHERE Account <> 'Master' ORDER BY name")->fetch_all();

//        if ($this->user->is_super()) {
//            $allowed_groups = Group::find()->fetch_all();
//        } else {
//            $allowed_groups = $this->user->get_groups();
//        }

        //$total_users = Users::count(array('where' => $filter));

        $this->set(array(
            'users' => $users,
            'per_page' => $this->per_page,
            'domains' => array_values($allowed_domains),
            'groups' => $groups //array_values($allowed_groups)
        ));

    }

    public function reconnect() {exit();}

    public function export($user_id=0, $type="pdf") {
        
        $this->profile($user_id);
        $html = parse_template('app', 'user_export',array());
        $user = new User($user_id);
        $stream_name = slug($user->name.'_'.$user->surname);

        if($type == "pdf") { 
            $old_limit = ini_set("memory_limit", "120M");
            require_once("include/dompdf/dompdf_config.inc.php");

            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->render();
            $stream_name .= '.pdf';

            $dompdf->stream($stream_name);

            exit();
        
        } elseif($type== "word") {
            $stream_name .= '.doc';
            header("Content-type: application/vnd.ms-word");
            header("Content-Disposition: attachment;Filename={$stream_name}");
            echo $html;
        }
        exit();
    }

    public function add($user_id = 0) {

        global $config;
        $allowed_domains = $this->user->get_domains();
        //$allowed_groups = $this->user->get_groups();
        $groups = Group::query("SELECT * FROM groups WHERE Account <> 'Master' ORDER BY name")->fetch_all();

        $this->set(array(
            'domains' => array_values($allowed_domains),
            'groups' => $groups //array_values($allowed_groups)
        ));

        $user = new User($user_id);
        if (!$user->id && $user_id) {
            $this->redirect("user");
        }

        $this->set('is_admin', false);

        if($user->is_admin() || (isset($_POST['is_admin']) && $_POST['is_admin'] == 1) ) {
            $this->set('is_admin', true);
        }

        if (isset($_POST['data'])) {

            $user->update_map($_POST['data']);

            if ($user->id) {
                $user->remove_validation('email', 'unique');
            }

            $domains = isset($_POST['domains']) ? array_values($_POST['domains']) : array();

            $user->email = trim($user->email);

            $is_new_user = false;

            if ($user->validate()) {

                if (!$user->id) {

                    // Send confirm mail to new users
                    $domain = new Domain($user->domain_id);
                    $user->password = md5(strtolower($user->email));
                    $user->registered = rand();
                    $user->insert();

                    $is_new_user = true;

                    // Message::map(array(
                    //     'title' => "Welcome to the  portal",
                    //     'message' => escape(parse_tpl('mail', 'welcome_message', array('name' => $user->name . ' ' . $user->suraname, 'domain' => $domain->domain))),
                    //     'domain_id' => $domain->id,
                    //     'sender_id' => $this->user->id,
                    //     'parent_id' => 0,
                    //     'recipient_id' => $user->id,
                    // ))->insert();

                    $mail_vars = array(
                        'name' => $user->name .' '.$user->surname,
                        'email' => $user->email,
                        'password' => strtolower($user->email),
                        'link' => $config['site']['domain']."activate/user/".$user->registered
                    );

                    Message_template::send($user->email, Message_template::REGISTRATION, $mail_vars);
                    Sms::send($user->id, $this->user->id, "Welcome to the Gang. user:$user->email password:$user->email");

                } else {
                    $user->update();
                }

                if($user->is_admin()) {
                    $user->update_domains($domains);
                }

                if (($image = $this->_upload(@$_FILES['uploadedfile'])->do_upload('media/users/', 'users_' . $user->id . slug($user->name), array('png', 'jpg', 'jpeg', 'gif'))) !== false) {
                    $this->_image()->resize($image, 500, 500);
                    User::edit(array('image' => basename($image)), 'id = ' . $user->id);
                }

                if($is_new_user) {
                    $this->redirect('user?success=1');
                } else {
                    // $this->redirect('user/edit/'.$user->id.'?confirmation=details updated');
                    $this->redirect('user?success=1');
                }

            } else {

                $_POST['data']['id'] = $user->id;
                $_POST['data']['admin'] = isset($_POST['data']['admin']) ? 1 : 0;
                $this->set('current_domains', $domains);
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);

            }

        } else {

            $domains = $user->get_domains();
            $this->set('current_domains', !$domains ? array() : array_keys($domains));
            $this->set('data', $user->to_array());

        }

    }

    public function edit($user_id = 0) {
        if ($user_id == 0) {
            $this->redirect("user");
        }
        $this->set_view('user_add');
        $this->add($user_id);
    }

    public function delete($user_id) {
        User::delete($user_id);
        $this->redirect('referer');
    }

    public function delete_selected() {

        if (isset($_POST['id'])) {
            if (is_array($_POST['id'])) {
                $this->delete(array_keys($_POST['id']));
            }
        }
        $this->redirect('referer');

    }

    public function activate($user_id = 0) {
        if ($user_id == 0) {
            $this->redirect("user");
        }
       
       $users = User::query("SELECT *, 
                                    u.id AS user_id,
                                    u.name AS first_name,
                                    g.name AS group_name,
                                    d.domain AS domain_name
                                 FROM users u 
                                 LEFT JOIN groups g ON (g.id=u.group_id) 
                                 LEFT JOIN domains d ON (d.id=u.domain_id)
                                 WHERE registered=$user_id
                            ")->fetch_all();

       var_dump($users);

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

    //   public function profile($user_id=0) {

    //       $user = new User($user_id);

    //       // if(!$user->is_bursar()) {
    //       //     $this->redirect('dashboard/home?not_bursar');
    //       // }

    //       if (!$user->id) {
    //           $this->redirect('dashboard/home?no_user');
    //       }

    //       //events calendar
    //       $calendar = $this->_calendar(isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'));
    //       $calendar->set_events(Event::search($user));
    //       $this->set('calendar', $calendar->output_calendar());

    //       $allowed_domains = $this->user->get_domains();
    //       $allowed_groups = $this->user->get_groups();

    //       if (!in_array($user->domain_id, array_keys($allowed_domains))) {
    //           $this->redirect('dashboard/home?domain_violation');
    //       }

    //       if (!in_array($user->group_id, array_keys($allowed_groups))) {
    //           $this->redirect('dashboard/home?group_violation');
    //       }

    //       $actions = Action::recent($user->id, 0, array(), 0, 40);

    //       $this->set('annual_user_summary', Payment::user_summary($user->id));
    //       $this->set('payment_logs', Payment::user_log($user->id));
    //       $this->set('actions', $actions);

    //       $this->set('profile', Profile::find(array('where' => " user_id = '{$user->id}' "))->fetch());
    //       $this->set('internships', Internship::find(array('where' => " user_id = '{$user->id}' "))->fetch_all());
    //       $this->set('scholarship', Scholarship::find(array('where' => " user_id = '{$user->id}' "))->fetch());
    //       $this->set('articles', Article::find(array('where' => " user_id = '{$user->id}' "))->fetch_all());
    //       $this->set('documents', Document::find(array('where' => " ident_id = '{$user->id}' AND ident = 'user' "))->fetch_all());
    //       $this->set('notes', Note::find(array('where' => " n.user_id = '{$user->id}' ", 'order' => ' n.id DESC'))->fetch_all());
    //       $this->set('note_count', Note::count(array('where' => " user_id = '{$user->id}' AND parent_id = 0")));
    //       $this->set('comments', Comment::find(array('where' => " c.ident = 'intern' and c.user_id = '{$user->id}' "))->fetch_all());
    //       $this->set('alumni', Alumni::find(array('where' => " user_id = '{$user->id}' "))->fetch());
    //       $this->set('letters', Letter::find(" user_id = '{$user->id}' ")->fetch_all());

    //       $this->set('sms', Sms::search(array('where' => " AND u.id = {$user->id} ")));
    //       $this->set('sms_count', Sms::count(array('where' => " user_id = '{$user->id}' ")));
    //       $this->set('per_page', 50);
    //       $this->set('page', 0);
    //       $this->set('inbox', Message::inbox(array(), $user, 0, 50));
    //       $this->set('outbox', Message::outbox(array(), $user, 0, 50));

    //       $this->set('academic_results', $user->get_academic_results(false));

    //       $this->set('sent_attachments', Attachment::send_attachments($user->id));
    // $this->set('received_attachments', Attachment::received_attachments($user->id));

    //       $this->set('total_unread_messages', $user->unread_messages());
    //       $this->set('total_incomplete_tasks', $user->incomplete_tasks());

    //       $this->set('is_alumni', $user->is_alumni());

    //       $this->set('domains', array_values($allowed_domains));
    //       $this->set('groups', array_values($this->user->get_group_bursars()));

    //       $this->set('user_event_attendance', Event::user_attendance($user->id));

    //       $this->set('u_profile', $user->to_array());

    //       $academics = Academic::find(array(
    //           'where' => " user_id = '{$user->id}' ",
    //           'order' => " calendar_year ASC  "
    //       ))->fetch_all();

    //       $this->set('message_templates', Message_template::find(array('message_type'=>'general'))->fetch_all());

    //       foreach ($academics as &$record) {
    //           $record['subjects'] = unserialize($record['subjects']);
    //       }

    //       $this->set('academics', $academics);
    //   }

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