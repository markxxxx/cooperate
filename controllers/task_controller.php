<?php declare(strict_types=1)

class TaskController extends AppController {

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
            $filter .= " AND  (t.id = '{$_GET['search']}' OR t.task like '%{$_GET['search']}%' ) ";
        }
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $currentProject = new Project($project_id);

        if (!$currentProject->id && $project_id==0) {

//        CASE
//            WHEN t.completed = 1 THEN DATEDIFF(t.completed_on, t.created_on)
//                    ELSE DATEDIFF(t.created_on, CURDATE())
//                END AS task_age,

            // Global list of tasks
            $tasks = Task::query("SELECT
                t.id AS task_id,
                DATE_FORMAT(t.created_on, '%Y-%m-%d') AS task_created,
                u.id AS user_id,
                u.name AS user_name,
                u.surname AS user_surname,
                t.task AS task_description,
                c.name AS customer_name,
                c.surname AS customer_surname,
                c.company AS customer_company,
                c.address AS customer_address,
                p.name AS project_name,
                g.name AS group_name,
                g.id AS group_id,
                t.completed AS task_completed,
                CASE
                    WHEN IFNULL(a.start,'') <> '' THEN DATE_FORMAT(a.start, '%Y-%m-%d')
                    ELSE ''
                END AS appointment_start
            FROM tasks t
            LEFT JOIN users u ON t.user_id=u.id
            LEFT JOIN groups g ON t.group_id=g.id
            LEFT JOIN projects p ON p.id=t.project_id
            LEFT JOIN customers c ON p.customer_id=c.id
            LEFT JOIN appointments a ON t.id = a.task_id;")->fetch_all();
            // $total_tasks = Task::count(array('where' => $filter));

        }
        else {

            // Selected project list of tasks
//        CASE
//            WHEN t.completed = 1 THEN DATEDIFF(t.completed_on, t.created_on)
//                    ELSE DATEDIFF(t.created_on, CURDATE())
//                END AS task_age,

            $tasks = Task::query("SELECT
                t.id AS task_id,
                DATE_FORMAT(t.created_on, '%Y-%m-%d') AS task_created,
                u.id AS user_id,
                u.name AS user_name,
                u.surname AS user_surname,
                t.task AS task_description,
                c.name AS customer_name,
                c.surname AS customer_surname,
                c.company AS customer_company,
                c.address AS customer_address,
                p.name AS project_name,
                g.name AS group_name,
                g.id AS group_id,
                t.completed AS task_completed,
                CASE
                    WHEN IFNULL(a.start,'') <> '' THEN DATE_FORMAT(a.start, '%Y-%m-%d')
                    ELSE ''
                END AS appointment_start
            FROM tasks t
            LEFT JOIN users u ON t.user_id=u.id
            LEFT JOIN groups g ON t.group_id=g.id
            LEFT JOIN projects p ON p.id=t.project_id
            LEFT JOIN customers c ON p.customer_id=c.id
            LEFT JOIN appointments a ON t.id = a.task_id
            WHERE p.id = $project_id;")->fetch_all();

            $filter="id = ".$project_id;
            $project = Project::find(array('where' => $filter))->fetch();

        }        

        //$groups = Group::find(array('where' => 'TRUE'))->fetch_all();
        $groups = Group::query("SELECT * FROM groups WHERE account NOT IN ('Master','administrator') ORDER BY name")->fetch_all();

        $projects = Project::query("SELECT *,p.id AS project_id, 
                                             c.id AS customer_id, 
                                             c.name AS customer_name, 
                                             c.surname AS customer_surname, 
                                             p.name AS project_name 
                                    FROM projects p 
                                    LEFT JOIN customers c ON p.customer_id=c.id;"
                                    )->fetch_all(); 

        $this->set(array(
            'groups' => $groups,
            'projects' => $projects,
            'data' => array('project_id' =>$project_id, 'project_name'=> $project['name'] ),
            'tasks' => $tasks,
            'per_page' => $this->per_page,
            'page' => $page
        ));
    }

    public function add($task_id=0) {

        $filter = 'TRUE';
        if (array_key_exists('search', $_GET)) {
            $filter .= " AND  (t.id = '{$_GET['search']}' OR t.task like '%{$_GET['search']}%' ) ";
        }

        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        //$groups = Group::find(array('where' => $filter))->fetch_all();
        $groups = Group::query("SELECT * FROM groups WHERE account NOT IN ('Master','administrator') ORDER BY name")->fetch_all();

        $projects = Project::query("SELECT *,p.id AS project_id, 
                                             p.color AS project_color, 
                                             c.id AS customer_id, 
                                             c.name AS customer_name, 
                                             c.surname AS customer_surname, 
                                             p.name AS project_name 
                                    FROM projects p 
                                    LEFT JOIN customers c ON p.customer_id=c.id;"
                                    )->fetch_all();      
        $this->set(array(
            'groups' => $groups,
            'projects' => $projects
        ));

        $task = new Task($task_id);

        if (!$task->id && $task_id) {
            $this->redirect("task");
        }
        $task->user_id=$this->user->id;

        if (isset($_POST['data'])) {

            $task->update_map($_POST['data']);
            $task->group_id=$_POST['data']['group_id'];
            $is_new_task = false;

            if ($task->validate()) {

                $project= new Project($_POST['data']['project_id']);
                // $customer= new Customer ($project->customer_id);
                $group= new Group ($task->group_id);
                $group=explode('Grade', $group->name);

                if (!$task->id) {

                    // Create Task
                    $task->insert();
                    $is_new_task = true;

                    // Additional check to see if we have dates in the task in order to create the appointment
                    // This works for when adding task on cal drop, but not when creating or updating tasks
                    //if ($this->validateDate($_POST['data']['start_date']) && $this->validateDate($_POST['data']['end_date'])) {

                        // Create Appointment
                        $appointment= new Appointment();
                        //$project= new Project($_POST['data']['project_id']);
                        //$customer= new Customer ($project->customer_id);

                        

                        // var_dump($_POST);exit();
                        //$appointment->title= $task->task."(".$task->id.")"." - ".$customer->name." ".$customer->surname." - ".$project->name.": ".$project->description." SubRef:".$project->id;
                        // $appointment->title = $project->name."-".$group->name."-".$_POST['data']['start_date']."-".$_POST['data']['end_date'];
                        $appointment->title= $project->name.'-'.$group[1]."-SubRef:".$project->id."(".$task->id.")";
                        $appointment->editable = "true";
                        $appointment->start = $_POST['data']['start_date'];
                        $appointment->end = $_POST['data']['end_date'];
                        $appointment->user_id = $this->user->id;
                        $appointment->task_id = $task->id;
                        $appointment->color = $project->color;
                        // $appointment->allDay = "1"; // ADP 20180926 Set this default for all appointments to discard the times on the calendar view
                        $appointment->insert();

                    //} else {
                    //    $this->redirect('referer','?start_date: '.$_POST['data']['start_date'].'end_date: '.$_POST['data']['end_date']);
                    //}

                    // Send confirm mail
                    // Message::map(array(
                    //     'title' => "New task created",
                    //     'message' => escape(parse_tpl('mail', 'welcome_message', array('name' => $task->name . ' ' . $task->suraname))),
                    //     'sender_id' => $this->user->id,
                    //     'parent_id' => 0,
                    //     'recipient_id' => $task->id,
                    // ))->insert();                    
                    //
                    // $mail_vars = array(
                    //     'name' => $task->name .' '.$task->surname,
                    //     'email' => $task->email
                    // );
                    // Message_template::send($task->email, Message_template::REGISTRATION, $mail_vars);

                } else {

                    // Update Task
                    $task->update();

                    // Additional check to see if we have dates in the task in order to create the appointment
                    // This works for when adding task on cal drop, but not when creating or updating tasks
                    //if ($this->validateDate($_POST['data']['start_date']) && $this->validateDate($_POST['data']['end_date'])) {

                        // Look for appointment
                        $filter = 'task_id='.$task->id;
                        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

                        $appointment_array = Appointment::find(array('where' => $filter))->fetch();
                        // Update appointment
                        $appointment= new Appointment($appointment_array['id']);
                        if (!$appointment_array['id']) {
                            $appointment= new Appointment();
                            $appointment->insert(); // if there are no existing appointments add one
                        }

                        //$project= new Project($_POST['data']['project_id']);
                        //$customer= new Customer ($project->customer_id);

                        // var_dump($_POST);exit();
                        //$appointment->title= $task->task."(".$task->id.")"." - ".$customer->name." ".$customer->surname." - ".$project->name.": ".$project->description." SubRef:".$project->id;
                        // $appointment->title= $project->name."-".$group->name."-".$_POST['data']['start_date']."-".$_POST['data']['end_date'];
                        $appointment->title= $project->name.'-'.$group[1]."-SubRef:".$project->id."(".$task->id.")";
                        $appointment->editable="true";
                        $appointment->start=$_POST['data']['start_date'];
                        $appointment->end=$_POST['data']['end_date'];
                        $appointment->user_id = $this->user->id;
                        $appointment->task_id = $task->id;
                        $appointment->color=$project->color;
                        // $appointment->allDay = "1"; // ADP 20180926 Set this default for all appointments to discard the times on the calendar view
                        $appointment->update();

                    //}

                }

                $this->redirect('referer','?success=1');
//                if($is_new_task) {
//                    // $this->redirect('task?success=1');
//                    $this->redirect('referer','?success=1');
//                } else {
//                    // $this->redirect('task/edit/'.$task->id.'?confirmation=detailsupdated&success=1');
//                    // $this->redirect('task?success=1');
//                    $this->redirect('referer','?success=1');
//                }

            } else {
                $_POST['data']['id'] = $task->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }

        } else {
            //for editing before post
            $filter = 'task_id='.$task->id;
            //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;
            $appointment_array = Appointment::find(array('where' => $filter))->fetch();

            $_POST['data'] = $task->to_array();
            $_POST['data']['start_date'] = $appointment_array['start'];
            $_POST['data']['end_date'] = $appointment_array['end'];
            // var_dump($appointment_array);exit();
            $this->set('data', $_POST['data']);
            // var_dump($task->to_array() );exit();
        }

    }

    public function delete($task_id) {

        Task::delete($task_id);
        $this->redirect('referer');

    }

    function complete($task_id=0) {

        $task = new task($task_id);
        if (!$task->id && $task_id) {
            $this->redirect("referer");
        }
        $task->completed = '1';
        $task->completed_on = date("Y-m-d H:i:s");
        $task->update();

        // $task_array = Project::query("SELECT *,p.id AS task_id, 
        //                                      c.id AS customer_id, 
        //                                      c.name AS customer_name, 
        //                                      c.surname AS customer_surname, 
        //                                      c.email AS customer_email, 
        //                                      p.name AS task_name,
        //                                      t.id AS technical_id 
        //                             FROM tasks p 
        //                             LEFT JOIN customers c ON p.customer_id=c.id
        //                             LEFT JOIN technicals t ON p.id=t.task_id
        //                             WHERE p.id=$task_id     ;")->fetch();   
        // $mail_vars = array(
        //                 'name' => $task_array['customer_name'] .' '.$task_array['customer_surname'],
        //                 'email' => $task_array['customer_email']
        //             );
        //  Message_template::send($task_array['customer_email'], Message_template::STATUS_COMPLETE, $mail_vars);

       $this->redirect('referer','?success=1');
    }

    public function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, urldecode($date));

        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === urldecode($date);
    }

}

?>