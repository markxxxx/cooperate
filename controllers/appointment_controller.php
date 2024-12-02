<?php
/******
*	This should of been called something else
*    like calendar
*******/

class AppointmentController extends AppController {

	private $per_page = 100;

	public function before_action() {

        parent::before_action();

        if (!$this->user->can_access($this->controller_name, $this->method_name)) {
            $_SESSION['redirect'] = urlencode(substr($_SERVER['REQUEST_URI'], 1));
            $this->redirect('login');
        }
    }

	public function index() {

		//$this->set('ics_link', Appointment::ics_user_link($this->user));
		//$filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;
        //$appointments = Appointment::find(array( 'where' => $filter))->fetch_all();
		//echo json_encode($appointments);
		//$filter = 'TRUE';
        //@$limit = ($page * $this->per_page) . ' , ' . $this->per_page;
        // $projects = Project::find(array( 'where' => $filter))->fetch_all();

        // Dropdown list : Projects
        // ADP 2019/03/06 Only show projects that are not completed
        $projects = Project::query(
            "SELECT *,
                  p.id AS project_id,
                  c.id AS customer_id,
                  c.name AS customer_name,
                  c.surname AS customer_surname,
                  p.name AS project_name,
                  p.color AS project_color
            FROM projects p
            LEFT JOIN customers c ON p.customer_id=c.id
            WHERE p.Status NOT IN ('Complete','Declined')
            ORDER BY c.name;"
        )->fetch_all();

        // ADP 2018/08/22 - Calender project list : Order the project list by newest first ORDER BY p.created_on desc
        // ADP 2019/03/06 Only show projects that are not completed
        $projects_desc = Project::query(
            "SELECT *,
                  p.id AS project_id,
                  c.id AS customer_id,
                  c.name AS customer_name,
                  c.surname AS customer_surname,
                  p.name AS project_name,
                  p.color AS project_color
            FROM projects p
            LEFT JOIN customers c ON p.customer_id=c.id
            WHERE p.Status NOT IN ('Complete','Declined')
            ORDER BY p.created_on desc;"
        )->fetch_all();

        // New appointment popup : Allocate new task to project team
        $groups = Group::query("SELECT * FROM groups WHERE color = ''")->fetch_all();

        $this->set(array(
            'projects' => $projects,
            'projects_desc' => $projects_desc,
            'groups' => $groups
        ));

	}

    // View Calendar: Initialize the calendar control with the selected / all project events (assets/js/pages/extra_fullcalendar_advanced.js)
    public function get_dates($project_id=0,$task=null) {

        $filter = 'TRUE';
        //@$limit = (@$page * $this->per_page) . ' , ' . $this->per_page;

        // Create the filter
        if($project_id > 0) {
            // Filter by project
            $filter = " title like '%SubRef:".$project_id."%'";
            if (isset($task)) {
                // Filter by task
                if (strlen(trim($task)) > 5) {
                    // Strings are encoded when posted. Use urldecode to return string to normal
                    $filter = " title like '%".urldecode($task)."'";
                }
            }
        }

        // Apply filter to the array
        $appointments = Appointment::find(array('where' => $filter))->fetch_all();

//        $update = $appointments;
//
//        // Get all the completed tasks, in order to change the event text colour in the cal to indicate that the task is complete
//        $tasks = Task::query("SELECT id AS task_id FROM tasks WHERE completed = 1;")->fetch_all();
//
//        // loop all value results
//        foreach($tasks as $task) {
//            // check if task_id exists in normalized attributes
//            if (isset($appointments[$task['task_id']])) {
//                // yes, grab the id
//                $id = $appointments[$task['task_id']];
//                echo json_encode($id);
//                //$appointments[ $id ] = $task['task_id'];
//            }
//        }

        echo json_encode($appointments);

        exit();

    }

    // View Calendar: Get a list of tasks for the selected project filter
    public function get_project_tasks($project_id=0) {

        $tasks = Task::query("
            SELECT
                t.id AS task_id,
                t.task AS task_description,
                t.project_id
            FROM tasks t
            WHERE t.project_id = $project_id;
            ")->fetch_all();

        $this->set(array(
            'tasks' => $tasks
        ));

        echo json_encode($tasks);
        exit();

    }

    // Team Schedule: Initialize the calendar control with the selected / all team install events
    public function get_dates_team($team_id=0) {

        $filter = 'TRUE';
        //@$limit = (@$page * $this->per_page) . ' , ' . $this->per_page;

        if($team_id > 0){
            // Only get install tasks for the selected install team
            $tasks = Task::query("SELECT id FROM tasks WHERE group_id = ".$team_id)->fetch_all();
        } else {
            // Only get install team groups
            $groups = Group::query("SELECT id FROM groups WHERE account = 'student'")->fetch_all();
            $group_list = '';
            // Create a csv list of group id's
            foreach ($groups as $key => $value) {
                $group_list.=$value['id'].',';
            }
            $group_list.='-1';

            // Only get install tasks
            $tasks = Task::query("SELECT id FROM tasks WHERE group_id IN (".$group_list.") ")->fetch_all();
            // ADP 2019/03/07 Include strip and collection tasks
            // $tasks = Task::query("SELECT id FROM tasks WHERE group_id IN (".$group_list.") AND task IN ('Installation','Strip','Collection')")->fetch_all();
        }

        // Create a csv list of task id's
        $task_list = '';
        foreach ($tasks as $key => $value) {
            $task_list.=$value['id'].',';
        }
        $task_list.='-1';

        // Create the filter
        $filter = ' task_id in ('.$task_list.')';

        // Apply filter to the array
        $appointments = Appointment::find(array('where' => $filter))->fetch_all();

        //$appointments = Appointment::query("SELECT id, title, start, end, user_id, color, task_id, snag_id FROM appointments WHERE $filter LIMIT 10")->fetch_all();

        // Making appointments the same colour as the team
        foreach ($appointments as $key => $value) {
            $task = new Task($value['task_id']);
            $group = new Group($task->group_id);
            // $appointments[$key]['color'] = $group->colour;
        }

        echo json_encode($appointments);
        exit();

    }

    // Add a new event to the calendar by dragging it from the events (projects) list onto the calendar
	public function add($appointment_id = 0) {

		$appointment = new Appointment($appointment_id);
		if(!$appointment->id && $appointment_id) {
			$this->redirect("appointment");
		}

        if($_POST) {

        	if($_POST['start'] == $_POST['end']) {

	        	$endDate = DateTime::createFromFormat('Y-m-d H:i:s', $_POST['end']);

	        	//these are used to check if the time is set or if its fullday
	        	$endDateFull = explode(" " , $_POST['end']);
	        	$endDateStr = explode("-" , $endDateFull[0]);
	        	$endTimeStr = explode(":" , $endDateFull[1]);
	        	$endHour = (int)$endTimeStr[0];

                // Remove this section to force full day events
	        	if ($endHour == 0) {
	        		//24 hour event
	        		$endDate->add(new DateInterval('P1D'));
	        		$appointment->allDay="1";
	        	} else {
	        		//default 1 hours event
                    $endDate->add(new DateInterval('PT1H'));
                    // $endDate->add(new DateInterval('P1D')); //$endDate->add(new DateInterval('PT2H'));
	        		// $appointment->allDay="1"; //do not set this variable, it breaks the week view
	        	}

	        	$appointment->editable="true";
	        	$_POST['data']['end'] = $endDate->format('Y-m-d H:i:s');

	        } else {

	        	$_POST['data']['end'] = $_POST['end'];

	        }

			$_POST['data']['title'] = $_POST['title'];
			$_POST['data']['start'] = $_POST['start'];
			$_POST['data']['color'] = $_POST['color'];

            $appointment->update_map($_POST['data']);
            $appointment->user_id = $this->user->id;

            if ($appointment->validate()) {

                // Get the project ID from the project event text
                $ref = explode("SubRef:", $appointment->title);
                $project_id = (int)$ref[1];

                // Get the project information
                $project = Project::query("
                    SELECT
                        *,p.id AS project_id,
                        c.id AS customer_id,
                        c.name AS customer_name,
                        c.surname AS customer_surname,
                        c.email AS customer_email,
                        p.name AS project_name,
                        p.color AS project_color,
                        u.email AS sales_email
                    FROM projects p
                    LEFT JOIN customers c ON p.customer_id = c.id
                    LEFT JOIN users u ON p.user_id = u.id
                    WHERE p.id = '".$project_id."';
                ")->fetch_all();

                // Get the project tasks
                $tasks = Task::query("
                    SELECT *
                    FROM tasks t
                    WHERE t.project_id = '".$project_id."'
                    ORDER BY t.task;
                ")->fetch_all();

                if ($tasks) {

                    if (!$appointment->id) {

                        $appointment->insert();

                        // Send communication to client and to sales rep
                        $mail_vars = array(
                            'name' => $project[0]['customer_name'].' '.$project[0]['customer_name'],
                            'project' => $project[0]['project_name'].' '.$project[0]['description'],
                            'appointment' => $appointment->start
                        );

                        Message_template::send($project[0]['customer_email'], Message_template::EXT_APPOINTMENT, $mail_vars);
                        Message_template::send($project[0]['sales_email'], Message_template::INT_APPOINTMENT, $mail_vars);

                        // Sms::send($user->id, $this->user->id, "Welcome to the Gang. user:$user->email password:$user->email");

                    } else {

                        $appointment->update();

                        // Send communication to client and to sales rep
                        $mail_vars = array(
                            'name' => $project[0]['customer_name'].' '.$project[0]['customer_name'],
                            'project' => $project[0]['project_name'].' '.$project[0]['description'],
                            'appointment' => $appointment->start
                        );

                        Message_template::send($project[0]['customer_email'], Message_template::EXT_APPOINTMENT, $mail_vars);
                        Message_template::send($project[0]['sales_email'], Message_template::INT_APPOINTMENT, $mail_vars);

                    }

                }

                // $this->redirect('appointment?success=1');
                $_POST['appointment']=$appointment->id;
                $_POST['project_id']=$project[0]['project_id'];
                $this->set('project_id',$project[0]['project_id']);
                // echo $_POST['appointment'].'-'.$project[0]['project_id'];exit();

                // Add appointment_id key to the tasks array
                foreach ($tasks as $key => $value) {
                    $tasks[$key]['appointment_id'] = $appointment->id; //$_POST['appointment'];
                }

                echo json_encode($tasks);
                exit();

            } else {

                $this->set('data',$_POST['data']);
                $this->set('invalid',1);

            }

        } else {

            $this->set('data', $appointment->to_array());
            if($appointment->id) {
            	$this->set('selected_time', $appointment->start_time);
        	}

        }

	}

    // Update the appointment from the popup after selecting the relevant task and team
    public function task($appointment_id = 0) {

        if($_POST['data']['appointment_id']) {
            

            $appointment = new Appointment($_POST['data']['appointment_id']);
            if(!$appointment->id) {
                $this->redirect("appointment");
            }
            $task = new Task($_POST['data']['task_id']);
            if(!$task->id) {
                $this->redirect("task");
            }

            $project= new Project ($task->project_id);
            $group= new Group ($_POST['data']['group_id']);
            $group=explode('Grade', $group->name);

            //$group = new Group($task->group_id);

            $appointment->update_map($_POST['data']);
            //$appointment->title=$task->task."(".$task->id.") - ".$appointment->title;
            $appointment->title=$project->name.'-'.$group[1]."-SubRef:".$task->project_id."(".$task->id.")";
            $appointment->task_id=$_POST['data']['task_id'];
            // $appointment->color=$group->colour;

            $task->group_id=$_POST['data']['group_id'];

            $appointment->update();
            // $task->update();

            $this->redirect('appointment?success=1');
        }
    }

	public function FormAdd($appointment_id = 0) {

		$appointment = new Appointment($appointment_id);

        if (!$appointment->id && $appointment_id) {
            $this->redirect("appointment");
        }

        if (isset($_POST['data'])) {

        	if($_POST['data']['start']==$_POST['data']['end']){
                $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $_POST['data']['end']);
                $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $_POST['data']['end']);

	        	//these are used to check if the time is set or if its fullday
	        	$endDateFull = explode(" " , $_POST['data']['end']);
	        	$endDateStr = explode("-" , $endDateFull[0]);
	        	$endTimeStr = explode(":" , $endDateFull[1]);

	        	$endHour=(int)$endTimeStr[0];

                // Remove this section to force full day events
	        	if ( $endHour == 0 ){
	        		//24 hour event
	        		$endDate->add(new DateInterval('P1D'));
       		        $appointment->allDay="1";
	        	}else{
	        		//default 2 hours event
                    $endDate->add(new DateInterval('P1D')); //$endDate->add(new DateInterval('PT2H'));
	        		$appointment->allDay="1"; //do not set this variable, it breaks the week view
	        	}

	        	$appointment->editable="true";
                $_POST['data']['start']= $startDate->format('Y-m-d H:i:s');
                $_POST['data']['end']= $endDate->format('Y-m-d H:i:s');

	        }

            $appointment->update_map($_POST['data']);
            $is_new_appointment = false;

            if ($appointment->validate()) {
                if (!$appointment->id) {
                    $appointment->insert();
                    $is_new_appointment = true;
                    //send confirm mail

                    // Message::map(array(
                    //     'title' => "New appointment created",
                    //     'message' => escape(parse_tpl('mail', 'welcome_message', array('name' => $appointment->name . ' ' . $appointment->suraname))),
                    //     'sender_id' => $this->user->id,
                    //     'parent_id' => 0,
                    //     'recipient_id' => $appointment->id,
                    // ))->insert();

                    // $mail_vars = array(
                    //     'name' => $appointment->name .' '.$appointment->surname,
                    //     'email' => $appointment->email
                    // );
                    // Message_template::send($appointment->email, Message_template::REGISTRATION, $mail_vars);

                } else {
                    $appointment->update();
                }

                if($is_new_appointment) {
                    $this->redirect('appointment/events?success=1');
                } else {
                    // $this->redirect('appointment/edit/'.$appointment->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('appointment/events?success=1');
                }

            } else {
                $_POST['data']['id'] = $appointment->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $appointment->to_array());
        }

	}

    // Populate Calendar / Events view
	public function events() {

		$filter = 'TRUE';
        @//$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

		$appointments = Appointment::find(array( 'where' => $filter))->fetch_all();
		$total_appointments = Appointment::count(array('where' => $filter));

		$this->set(array(
            'appointments' => $appointments,
            'total_appointments' => $total_appointments,
            'per_page' => $this->per_page,
            'page' => $page
        ));

	}

	public function team_week_view() {

		$filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        // $projects = Project::find(array( 'where' => $filter))->fetch_all();
        $projects = Project::query("SELECT *,p.id AS project_id,
        									 c.id AS customer_id,
        									 c.name AS customer_name,
        									 p.name AS project_name,
        									 p.color AS project_color
        							FROM projects p
        							LEFT JOIN customers c ON p.customer_id=c.id;"
        							)->fetch_all();
       $tasks = Task::query("SELECT *,t.id AS task_id,
                                        t.created_on AS task_created,
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
                                         g.id AS group_id
                                FROM tasks t
                                LEFT JOIN users u ON t.user_id=u.id
                                LEFT JOIN groups g ON t.group_id=g.id
                                LEFT JOIN projects p ON p.id=t.project_id
                                LEFT JOIN customers c ON p.customer_id=c.id;"
                                )->fetch_all();
        $groups = Group::query("SELECT * FROM groups WHERE account='student' ORDER BY name")->fetch_all();

        $this->set(array(
            'projects' => $projects,
            'tasks' => $tasks,
            'groups' => $groups
        ));
	}

    // View the appointment details
    public function event_view($project_id=0,$task_id=0) {

//        if (!$this->user->can_access('invoice', 'index')) (
//
//            $project= Project::query(
//                "SELECT
//                    *,
//                    p.id AS project_id,
//                    c.id AS customer_id,
//                    c.name AS customer_name,
//                    c.surname AS customer_surname,
//                    p.name AS project_name,
//                    p.color AS project_color,
//                    q.project_plan AS plan,
//                    0 AS ViewPlan
//                FROM projects p
//                LEFT JOIN customers c ON p.customer_id=c.id
//                LEFT JOIN quotes q ON p.id = q.project_id
//                WHERE p.id = '".$project_id."';"
//            )->fetch();
//
//        ) else {

            $project= Project::query(
                "SELECT
                    *,
                    p.id AS project_id,
                    p.name AS project_name,
                    p.color AS project_color
                FROM projects p
                WHERE p.id = '".$project_id."';"
            )->fetch();

//        }

        $task = new Task ($task_id);

        $appointment= Appointment::query(
            "SELECT
                id AS appointment_id,
                title,
                task_id
            FROM appointments
            WHERE task_id = '".$task_id."';"
        )->fetch();

        $data = array('thisproject'=>$project,'thistask'=>$task->to_array(),'thisappointment'=>$appointment);

        echo json_encode($data);
        exit();

    }

	public function team_calendar() {

		//$limit = ($page * $this->per_page) . ' , ' . $this->per_page;
		$filter="account='Install' ";
		$teams = Group::find(array( 'where' => $filter))->fetch_all();

		$filter="TRUE";
		$projects = Project::find(array( 'where' => $filter))->fetch_all();
		// var_dump($teams);exit();

		$appointments = Group::query("SELECT  p.name AS project_name,
													date(a.start) AS start_date,
													date(a.end) AS end_date,
													t.task AS task_name,
													g.id AS group_id,
													a.color AS color
											FROM groups g
											LEFT JOIN tasks t ON (g.id=t.group_id)
											LEFT JOIN appointments a ON (t.id=a.task_id)
											LEFT JOIN projects p ON (p.id=t.project_id)
											WHERE g.account = 'Install'
											ORDER BY g.id ASC
										;")->fetch_all();

		$appointmentRange=array();
		foreach ($appointments as $key => $value) {
			// array_push($appointmentRange, $value);
	        $appointmentCurrent = new DateTime($value['start_date']);
	        $last = new DateTime($value['end_date']);
	        $days = date_diff($last,$appointmentCurrent);

	        $previousGroup='';
	        $previousDate='';
	        if ($key>1){$previousKey= $key-1;}
	        for ($i=0; $i <=$days ; $i++) {

	        	$overlap=0;
	        	if($previousGroup==$value['group_id'] && $previousDate==$appointmentCurrent->format('Y-m-d') ){
	        		$appointmentRange[$previousKey]['overlap']='Yes';
	        	}

	            $appointmentRange[$key] = array("project_name"=>$value['project_name'],
	            							"start_date"=>$appointmentCurrent->format('Y-m-d'),
	            							"task_name"=>$value['task_name'],
	            							"group_id"=>$value['group_id'],
	            							"color"=>$value['color'],
	            							"overlap"=>'No'
	            						);
	            $appointmentCurrent = $appointmentCurrent->add(new DateInterval('P1D'));

	            //set previous to check on next run
	            $previousGroup=$value['group_id'];
	        	$previousDate=$appointmentCurrent->format('Y-m-d');

	        }

		}

		var_dump( $appointmentRange);exit();

		$validDates = array();
        $current = Date('Y-m-d');
        $last = Date('Y-m-d', strtotime("+14 days"));

        for ($i=1; $i <=15 ; $i++) {
            $validDates[] = array("date"=>$current);
            $current = Date('Y-m-d', strtotime("+$i days"));
        }
        // var_dump($validDates);exit();

		// $filter = 'TRUE';
  //       //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

		// $appointments = Appointment::find(array( 'where' => $filter))->fetch_all();
		// $total_appointments = Appointment::count(array('where' => $filter));


        // var_dump($appointmentRange);exit();

		$this->set(array(
			'projects' => $projects,
			'dates' => $validDates,
            'teams' => $teams,
            'appointmentRange' => $appointmentRange,
            'appointments' => $appointments,
            'per_page' => $this->per_page,
            'page' => $page
        ));

	}

	public function update() {

		$id = $_POST['id'];
		$title = $_POST['title'];
		$start = $_POST['start'];
		$end = $_POST['end'];

	}

    // Update appointment comments
    public function update_comments($appointment_id = 0, $comments = '') {

        //if (isset($_POST['data'])) {

            $appointment = new Appointment($appointment_id);

//            if(!$appointment->id && $appointment_id) {
//            $this->redirect("appointment");
//            } else {
//            $comments = $_POST['data']['comments'];
//            $appointment->comments = $comments;
//            $appointment->update();
//            }
            if(!$appointment->id) {
                exit();
            }
            $appointment->comments = $comments;
            $appointment->update();
            exit();

        //}

        //$this->redirect('referer');

    }

    // Update appointment
	public function edit($appointment_id = 0) {

		if($appointment_id == 0) {
			$this->redirect("appointment");
		}
		$this->set_view('appointment_add');
		$this->add($appointment_id);

	}

    // Delete single appointment
	public function delete($appointment_id) {

        Appointment::delete($appointment_id);
        $this->redirect('referer');

	}

    // Delete multiple appointments
	public function delete_selected() {

		if(array_key_exists('id', $_POST)) {
			if(is_array($_POST['id'])) {
				$this->delete(array_keys($_POST['id']));
			}
		}

	}

	public function ics($user_hash=0) {

		$user_hash = rtrim($user_hash,'.ics');
		$user = User::map(User::find(" md5(id) = '{$user_hash}' ")->fetch());
		if(!$user->id) {
			die('no feed found');
		}
		global $config;

		header('Content-type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $config['site']['name'].' Calendar');

		echo Appointment::get_ics($user);
		exit();

	}

}
?>