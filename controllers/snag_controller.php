<?php

class SnagController extends AppController {

    private $per_page = 100;

    public function before_action() {

        parent::before_action();

        if (!$this->user->can_access($this->controller_name, $this->method_name)) {
            $_SESSION['redirect'] = urlencode(substr($_SERVER['REQUEST_URI'], 1));
            $this->redirect('login');
        }
    }    

    public function index($project_id=0, $page=0) {

        $filter = 'TRUE';
        if (array_key_exists('search', $_GET)) {
            $filter .= " AND  (t.id = '{$_GET['search']}' OR t.snag like '%{$_GET['search']}%' ) ";
        }

        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $currentProject = new Project($project_id);

        if (!$currentProject->id && $project_id==0) {

            // Global list of snags
            $snags = Snag::query("SELECT
                    s.id AS snag_id,
                    DATE_FORMAT(s.created_on, '%Y-%m-%d') AS snag_created,
                    CASE
                        WHEN IFNULL(a.start,'') <> '' THEN
                            CASE
                                WHEN a.start > CURDATE() THEN ''
                                ELSE DATEDIFF(a.start, CURDATE())
                            END
                        ELSE ''
                    END AS snag_age,
                    u.id AS user_id,
                    u.name AS user_name,
                    u.surname AS user_surname,
                    s.snag AS snag_description,
                    c.name AS customer_name,
                    c.surname AS customer_surname,
                    c.company AS customer_company,
                    c.address AS customer_address,
                    p.name AS project_name,
                    g.name AS group_name,
                    g.id AS group_id,
                    s.completed AS snag_completed,
                    CASE
                        WHEN IFNULL(a.start,'') <> '' THEN DATE_FORMAT(a.start, '%Y-%m-%d')
                        ELSE ''
                    END AS appointment_start
                FROM snags s
                LEFT JOIN users u ON s.user_id = u.id
                LEFT JOIN groups g ON s.group_id = g.id
                LEFT JOIN projects p ON p.id = s.project_id
                LEFT JOIN customers c ON p.customer_id = c.id
                LEFT JOIN appointments a ON s.id = a.snag_id;")->fetch_all();

            // $total_snags = Snag::count(array('where' => TRUE'));

        }
        else{

            // Selected project list of snags
            $snags = Snag::query("SELECT
                    s.id AS snag_id,
                    DATE_FORMAT(s.created_on, '%Y-%m-%d') AS snag_created,
                    CASE
                        WHEN IFNULL(a.start,'') <> '' THEN
                            CASE
                                WHEN a.start > CURDATE() THEN ''
                                ELSE DATEDIFF(a.start, CURDATE())
                            END
                        ELSE ''
                    END AS snag_age,
                    u.id AS user_id,
                    u.name AS user_name,
                    u.surname AS user_surname,
                    s.snag AS snag_description,
                    c.name AS customer_name,
                    c.surname AS customer_surname,
                    c.company AS customer_company,
                    c.address AS customer_address,
                    p.name AS project_name,
                    g.name AS group_name,
                    g.id AS group_id,
                    s.completed AS snag_completed,
                    CASE
                        WHEN IFNULL(a.start,'') <> '' THEN DATE_FORMAT(a.start, '%Y-%m-%d')
                        ELSE ''
                    END AS appointment_start
                FROM snags s
                LEFT JOIN users u ON s.user_id = u.id
                LEFT JOIN groups g ON s.group_id = g.id
                LEFT JOIN projects p ON p.id = s.project_id
                LEFT JOIN customers c ON p.customer_id = c.id
                LEFT JOIN appointments a ON s.id = a.snag_id
                WHERE p.id = $project_id;")->fetch_all();

            // $total_snags = Snag::count(array('where' => $filter));

            // Get the selected project details
            $filter = "id=".$project_id;
            $project = Project::find(array('where' => $filter))->fetch();

        }

        // Get all the projects that have not been completed yet
        $projects = Project::query("SELECT
                p.id AS project_id,
                c.id AS customer_id,
                c.name AS customer_name,
                c.surname AS customer_surname,
                p.name AS project_name
            FROM projects p
            LEFT JOIN customers c ON p.customer_id = c.id
            WHERE p.status <> 'Complete'
            ORDER BY p.name;")->fetch_all();

        // Only get all the install team groups
        //$filter = "account='Install'";
        //$groups = Group::find(array( 'where' => $filter))->fetch_all(); //'TRUE'
        $groups = Group::query("SELECT * FROM groups WHERE account IN ('install','company') ORDER BY name")->fetch_all();

        $limit = 20;

        $this->set(array(
            'groups' => $groups,
            'projects' => $projects,
            'data' => array('project_id' => $project_id, 'project_name'=> $project['name']),
            'snags' => $snags,
            'per_page' => $this->per_page,
            'limit' => $limit,
            'page' => $page
        ));

    }

    public function add($snag_id=0) {

//        $filter = 'TRUE';
//        if (array_key_exists('search', $_GET)) {
//            $filter .= " AND  (t.id = '{$_GET['search']}' OR t.snag like '%{$_GET['search']}%' ) ";
//        }

        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        // Only get all the install team groups
        //$filter = "account = 'Install'";
        //$groups = Group::find(array( 'where' => $filter))->fetch_all();
        $groups = Group::query("SELECT * FROM groups WHERE account='install' ORDER BY name")->fetch_all();

        // Get all the projects that have not been completed yet
        $projects = Project::query("SELECT
                p.id AS project_id,
                c.id AS customer_id,
                c.name AS customer_name,
                c.surname AS customer_surname,
                p.name AS project_name
            FROM projects p
            LEFT JOIN customers c ON p.customer_id = c.id
            WHERE p.status <> 'Complete'
            ORDER BY p.name;")->fetch_all();

        $this->set(array(
            'groups' => $groups,
            'projects' => $projects
        ));

        // Create snag object
        $snag = new Snag($snag_id);

        // Back to snag list if we cant create the object
        if (!$snag->id && $snag_id) {
            $this->redirect('snag');
        }

        // Set the user that is managing the snag
        $snag->user_id = $this->user->id;

        // Add or Update snag
        if (isset($_POST['data'])) {

            $snag->update_map($_POST['data']);
            $snag->group_id = $_POST['data']['group_id'];
            $is_new_snag = false;

            if ($snag->validate()) {

                if (!$snag->id) {

                    $snag->insert();
                    $is_new_snag = true;

                    // Create appointment
                    $appointment = new Appointment();
                    $project = new Project($_POST['data']['project_id']);
                    $customer = new Customer ($project->customer_id);

                    // var_dump($_POST);exit();
                    $appointment->title = $snag->snag." - ".$customer->name." ".$customer->surname." - ".$project->name.": ".$project->description." SubRef:".$project->id;
                    $appointment->editable = "true";
                    $appointment->start = $_POST['data']['start_date'];
                    $appointment->end = $_POST['data']['end_date'];
                    $appointment->user_id = $this->user->id;
                    $appointment->snag_id = $snag->id;
                    $appointment->color = $project->color;
                    $appointment->allDay = "1"; // ADP 20180926 Set this default for all appointments to discard the times on the calendar view
                    $appointment->insert();
                    //send confirm mail
                    
                    // Message::map(array(
                    //     'title' => "New snag created",
                    //     'message' => escape(parse_tpl('mail', 'welcome_message', array('name' => $snag->name . ' ' . $snag->suraname))),
                    //     'sender_id' => $this->user->id,
                    //     'parent_id' => 0,
                    //     'recipient_id' => $snag->id,
                    // ))->insert();                    

                    // $mail_vars = array(
                    //     'name' => $snag->name .' '.$snag->surname,
                    //     'email' => $snag->email
                    // );
                    // Message_template::send($snag->email, Message_template::REGISTRATION, $mail_vars);

                } else {

                    $snag->update();

                    // Look for appointment
                    $filter = 'snag_id='.$snag->id;
                    //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

                    $appointment_array = Appointment::find(array( 'where' => $filter))->fetch();
                     // Update appointment
                    $appointment = new Appointment($appointment_array['id']);
                    $project = new Project($_POST['data']['project_id']);
                    $customer = new Customer ($project->customer_id);

                    // var_dump($_POST);exit();
                    $appointment->title = $snag->snag." - ".$customer->name." ".$customer->surname." - ".$project->name.": ".$project->description." SubRef:".$project->id;
                    $appointment->editable = "true";
                    $appointment->start = $_POST['data']['start_date'];
                    $appointment->end = $_POST['data']['end_date'];
                    $appointment->user_id = $this->user->id;
                    $appointment->snag_id = $snag->id;
                    $appointment->color = $project->color;
                    $appointment->update();
                }

                if($is_new_snag) {
                    // $this->redirect('snag?success=1');
                    $this->redirect('referer','?success=1');
                } else {
                    // $this->redirect('snag/edit/'.$snag->id.'?confirmation=detailsupdated&success=1');
                    // $this->redirect('snag?success=1');
                    $this->redirect('referer','?success=1');
                }

            } else {
                $_POST['data']['id'] = $snag->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }

        } else {

            //for editing before post
            $filter = 'snag_id='.$snag->id;
            //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;
            $appointment_array = Appointment::find(array( 'where' => $filter))->fetch();

            $_POST['data'] = $snag->to_array();
            $_POST['data']['start_date'] = $appointment_array['start'];
            $_POST['data']['end_date'] = $appointment_array['end'];
            // var_dump($appointment_array);exit();
            $this->set('data', $_POST['data']);
            // var_dump($snag->to_array() );exit();

        }

    }

    public function delete($snag_id) {

        // Check for the snag id
        if ($snag_id) {

            // Delete the selected snag
            Snag::delete($snag_id);
            // Back to snag list
            $this->redirect('referer','?success=1');

        } else {

            // Back to snag list
            $this->redirect('referer','?success=0');

        }

    }

    function complete($snag_id=0) {

        // Create snag object
        $snag = new snag($snag_id);

        // Back to snag list if we cant create the object
        if (!$snag->id && $snag_id) {
            $this->redirect('referer');
        }

        $snag->completed = '1';
        $snag->completed_on = date("Y-m-d H:i:s");
        $snag->update();

        // Send a mail notification
        // $snag_array = Project::query("SELECT *,p.id AS snag_id, 
        //                                      c.id AS customer_id, 
        //                                      c.name AS customer_name, 
        //                                      c.surname AS customer_surname, 
        //                                      c.email AS customer_email, 
        //                                      p.name AS snag_name,
        //                                      t.id AS technical_id 
        //                             FROM snags p 
        //                             LEFT JOIN customers c ON p.customer_id=c.id
        //                             LEFT JOIN technicals t ON p.id=t.snag_id
        //                             WHERE p.id=$snag_id     ;")->fetch();   
        // $mail_vars = array(
        //                 'name' => $snag_array['customer_name'] .' '.$snag_array['customer_surname'],
        //                 'email' => $snag_array['customer_email']
        //             );
        //  Message_template::send($snag_array['customer_email'], Message_template::STATUS_COMPLETE, $mail_vars);

        // Back to snag list
        $this->redirect('referer','?success=1');

    }

}

?>