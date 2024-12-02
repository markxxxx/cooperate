<?php declare(strict_types=1)

class ProjectController extends AppController {

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
        if(array_key_exists('search', $_GET)) {
            $filter = " (id = '{$_GET['search']}' OR supplier like '%{$_GET['search']}%' )";
        }
        $limit = ($page * $this->per_page) .' , ' .$this->per_page;

        // $projects = Project::find(array( 'where' => $filter))->fetch_all();
        $total_projects = Project::count(array('where' => $filter));

        $projects = Project::query("SELECT
            p.id AS project_id,
            p.start_date,
            p.name AS project_name,
            p.description AS project_description,
            p.status,
            p.payment_type,
            c.id AS customer_id,
            c.name AS customer_name,
            c.surname AS customer_surname,
            c.contact_number AS customer_contact,
            u.name AS sales_name,
            u.surname AS sales_surname,
            t.id AS technical_id,
            iA.acount,
            iP.pcount,
            c.address AS customer_address
        FROM projects p
        LEFT JOIN customers c ON p.customer_id=c.id
        LEFT JOIN technicals t ON p.id=t.project_id
        LEFT JOIN users u ON u.id=p.user_id
        LEFT JOIN (SELECT project_id, COUNT(id) AS acount FROM invoices WHERE status = 'Approved' GROUP BY project_id) iA ON p.id = iA.project_id
        LEFT JOIN (SELECT project_id, COUNT(id) AS pcount FROM invoices WHERE status = 'Pending' GROUP BY project_id) iP ON p.id = iP.project_id;")->fetch_all();

        // $customers = Customer::query("SELECT * FROM customers")->fetch_all();

        // $sales_reps = User::query
        // ("SELECT *,
        //     u.name AS user_name,
        //     u.id AS user_id
        // FROM users u
        // LEFT JOIN groups g on u.group_id=g.id
        // WHERE g.name='Sales' ")->fetch_all();

        $teachers = User::query
        ("SELECT *,
            u.name AS user_name,
            u.id AS user_id
        FROM users u
        LEFT JOIN groups g on u.group_id=g.id
        WHERE g.name='Teachers' ")->fetch_all();


        $this->set(array(
        	'teachers' => $teachers,
            // 'sales_reps'=> $sales_reps,
            'projects' => $projects,
            'total_projects' => $total_projects,
            //'referer' => $_SERVER['HTTP_REFERER'],
            // 'payment_type' => Field::get('payment_type'),
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }  

	public function add($project_id = 0) {  

        // ADP 2019/03/07 Get a random colour

//        $colour = Colours::query("SELECT *
//                         FROM colours c
//                         WHERE c.hex NOT IN (SELECT color from projects)
//                         LIMIT 1;"
//                         )->fetch_all();

        // ADP 2019/03/07 Exclude projects that have been completed and declined, from the exclude list

        $colour = Colours::query("SELECT *
             FROM colours
             WHERE hex NOT IN (SELECT color FROM projects WHERE Status NOT IN ('Complete','Declined'))
             ORDER BY RAND()
             LIMIT 1;"
        )->fetch_all();

        // $sales_reps = User::query("SELECT *, u.name AS user_name,
        //                                     u.id AS user_id 
        //                             FROM users u 
        //                             LEFT JOIN groups g on u.group_id=g.id 
        //                             WHERE g.name='Sales' ")->fetch_all();

		//get customer list from dropdown
		$filter = 'TRUE';        
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;
		$this->set(array(
            'teachers'         =>  User::query
                                    ("SELECT *,
                                        u.name AS user_name,
                                        u.surname AS user_surname,
                                        u.id AS user_id
                                    FROM users u
                                    LEFT JOIN groups g on u.group_id=g.id
                                    WHERE g.name='Teachers' ")->fetch_all()
            // 'payment_type'      => Field::get('payment_type'),
            // 'sales_reps'        =>   $sales_reps
                    ));
       
        $project = new project($project_id);

        if (!$project->id && $project_id) {
            $this->redirect("project");
        }

        if (isset($_POST['data'])) {

            // print_r($_POST['data']);
            $project->update_map($_POST['data']);

            if ($project->id) {
                $project->remove_validation('email', 'unique');
            }
            $is_new_project = false;

            if ($project->validate()) {
                if (!$project->id) {
                                
                    // $project->email = trim($project->email);
                    $project->color = $colour[0]['hex'];
                    $project->status ="Active";

                    $project->insert();
                    $is_new_project = true;

                    //create automatic tasks (1)
                    $AutoTask = new Task();
                    $AutoTask->user_id= $this->user_id;
                    $AutoTask->task= 'Undescribed Lesson';
                    $AutoTask->created_on= date('Y-m-d H:i:s');
                    $AutoTask->project_id=$project->id;
                    $AutoTask->insert();
//                    //create automatic tasks (2)
//                    $AutoTask = new Task();
//                    $AutoTask->user_id= $this->user_id;
//                    $AutoTask->task= 'Orders';
//                    $AutoTask->created_on= date('Y-m-d H:i:s');
//                    $AutoTask->project_id=$project->id;
//                    $AutoTask->insert();
//                    //create automatic tasks (3)
//                    $AutoTask = new Task();
//                    $AutoTask->user_id= $this->user_id;
//                    $AutoTask->task= 'Production';
//                    $AutoTask->created_on= date('Y-m-d H:i:s');
//                    $AutoTask->project_id=$project->id;
//                    $AutoTask->insert();
//                    //create automatic tasks (4)
//                    $AutoTask = new Task();
//                    $AutoTask->user_id= $this->user_id;
//                    $AutoTask->task= 'Installation';
//                    $AutoTask->created_on= date('Y-m-d H:i:s');
//                    $AutoTask->project_id=$project->id;
//                    $AutoTask->insert();

                    //create automatic tasks (5)
//                    $install = new Task();
//                    $install->user_id= $this->user_id;
//                    $install->task= '';
//                    $install->created_on= date('Y-m-d H:i:s');
//                    $install->project_id=$project->id;
//                    $install->insert();

                    //send email to salesrep
                    // $filter="id=".$project->id;
                    // $user= User::find(array( 'where' => $filter))->fetch_all();
                    // $mail_vars = array(
                    //     'name' => $project->name,
                    //     'discription' => $project->description
                    //     // 'start_date' => $project->start_date,
                    //     // 'end_date' => $project->end_date
                    // );
                    // Message_template::send($user[0]->email, Message_template::PROJECT_ASSIGN, $mail_vars);

                    //if the customer is not set got to add new customer
                    // if (0==$project->customer_id){
                    //     $this->redirect('customer/add/0/'.$project->id);
                    // }

                } else {
                    $project->update();
                }

                if($is_new_project) {
                    $this->redirect('project?success=1');
                } else {
                    // $this->redirect('project/edit/'.$project->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('project?success=1');
                }

            } else {
                $_POST['data']['id'] = $project->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $project->to_array());
        }
    }

    function spec($project_id=0, $technical_id=0) {

        $filter = 'TRUE';        
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $technical = new Technical($technical_id);

        if (!$technical->id && $technical_id) {
            $this->redirect("project");
        }
        $this->set('technical_id',$technical_id);

        // $projects = Project::find(array( 'where' => $filter))->fetch_all();
        $technical_array = Technical::query
        ("SELECT *,
            t.id AS technical_id
        FROM technicals t
        LEFT JOIN projects p ON p.id=t.project_id
        WHERE t.project_id=$project_id;")->fetch();

        $project = Project::query
        ("SELECT *,
            p.id AS project_id,
            c.id AS customer_id,
            c.name AS customer_name,
            c.surname AS customer_surname,
            c.address AS customer_address,
            p.name AS project_name,
            u.name AS sales_name,
            u.surname AS sales_surname,
            u.mobile_number AS sales_contact,
            q.project_plan AS plan
        FROM projects p
        LEFT JOIN customers c ON p.customer_id=c.id
        LEFT JOIN users u ON p.user_id=u.id
        LEFT JOIN quotes q ON p.id = q.project_id
        WHERE p.id=$project_id;")->fetch();

        $accessories = Accessory::query("SELECT * FROM accessories")->fetch_all();
        $job_types= Jobtype::query("SELECT job_type_name FROM job_types")->fetch_all();
        $cupboard_heights= Cupboardheight::query("SELECT cupboard_height_name FROM cupboard_heights")->fetch_all();
        $finishes= Finish::query("SELECT finish_name FROM finishes")->fetch_all();
        $colours= Colour::query("SELECT colour_name FROM edging_colours")->fetch_all();
        $edgings= Edging::query("SELECT edging_name FROM edgings")->fetch_all();
        $kickplates= Kickplate::query("SELECT kickplate_name FROM kickplates")->fetch_all();
        $topthicknesses= Topthickness::query("SELECT topthickness_name FROM topthicknesses")->fetch_all();
        $toptypes= Toptype::query("SELECT toptype_name FROM toptypes group by toptype_name")->fetch_all();        
        $handlesizes= Handlesize::query("SELECT handlesize_name FROM handlesizes")->fetch_all();
        $handletypes= Handletype::query("SELECT handletype_name FROM handletypes")->fetch_all();
        $runners= Runner::query("SELECT runner_name FROM runners")->fetch_all();        
        $hinges= Hinge::query("SELECT hinge_name FROM hinges")->fetch_all();
        $sinks= Sink::query("SELECT sink_name FROM sinks")->fetch_all();
        $prepbowls= Prepbowl::query("SELECT prepbowl_name FROM prepbowls")->fetch_all();

        //dynamic setup for toptypes
        foreach ($toptypes as $key => $value) {
            $name = $value['toptype_name'];
            ${$value['toptype_name']}= Toptype::query("SELECT variant_name FROM toptypes WHERE toptype_name='$name'")->fetch_all();
            $this->set(array($name => ${$value['toptype_name']}));
        }

         // var_dump($job_types);exit;
        $this->set(array(
            'data'              => $technical_array,
            'project'           => $project,
            'per_page'          => $this->per_page,
            'page'              => $page,
            'accessories'       => $accessories,
            'job_type'          => $job_types,
            'cupboard_height'   => $cupboard_heights,
            'finishes'          => $finishes,
            'colours'           => $colours,
            'edging'            => $edgings,
            'kickplates'        => $kickplates,
            'yesno'             => Field::get('yesno'),
            'top_thickness'     => $topthicknesses,
            'top_type'          => $toptypes,
            'handle_size'       => $handlesizes,
            'handle_type'       => $handletypes,
            'runners'           => $runners,
            'hinges'            => $hinges,
            'sinks'             => $sinks,
            'prepbowls'         => $prepbowls
        ));

        if (isset($_POST['data'])) {

            $technical->update_map($_POST['data']);
            $is_new_technical= false;

            // var_dump($_POST['data']); exit();

            if ($technical->validate()) {
                if (!$technical->id) {
                    
                    $technical->project_id=$project_id;
                    $technical->created = date('Y-m-d H:i:s');

                    $accessories_array= explode(',', $_POST['data']['accessories']);
                    $technical->accessories= serialize($accessories_array);

                    $technical->insert();
                    $is_new_technical = true;

                } else {

                    $accessories_array= explode(',', $_POST['data']['accessories']);
                    $technical->accessories= serialize($accessories_array);
                    $technical->update();
                }

                if($is_new_project) {
                    $this->redirect('project?success=1');
                } else {
                    // $this->redirect('project/edit/'.$project->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('project?success=1');
                }

            } else {
                $_POST['data']['id'] = $project->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            
            $selected=unserialize(stripslashes($technical->accessories) );

            // var_dump($selected);exit();

            $this->set('selected_accessories', $selected );
            $this->set('data', $technical->to_array() );
        }

    }

    function spec_print($project_id=0, $technical_id=0) {

        require_once('include/fpdf/fpdf-custom.php');
        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $technical = new Technical($technical_id);

        if (!$technical->id && $technical_id) {
            $this->redirect("project");
        }
        $this->set('technical_id',$technical_id);

        // $projects = Project::find(array( 'where' => $filter))->fetch_all();
        $technical_array = Technical::query
        ("SELECT
            t.installation_address AS Installation_Address,
            t.job_type AS Job_Type,
            t.lead_time AS Lead_Time,
            t.ceiling_height AS Ceiling_Height,
            t.cupboard_height AS Cupboard_Height,
            t.big_unit_access AS Big_Unit_Access,
            t.finishes AS Finish,
            t.door_colour AS Door_Colour,
            t.edging AS Edging,
            t.edging_colour AS Edging_Colour,
            t.kickplates AS Kickplates,
            t.top_filler AS Top_Filler,
            t.scotia AS Scotia,
            t.light_shield AS Light_Shield,
            t.top_type AS Top_Type,
            t.top_thickness AS Top_Thickness,
            t.handle_size AS Handle_Size,
            t.handle_type AS Handle_Type,
            t.runners AS Runners,
            t.hinges AS Hinges,
            t.sinks AS Sinks,
            t.prep_bowl AS Prep_Bowl,
            t.swing_out_bin AS Swing_Out_Bin,
            t.accessories AS Accessories,
            t.Comments AS Notes
        FROM technicals t
        LEFT JOIN projects p ON p.id=t.project_id
        WHERE t.project_id=$project_id;" )->fetch();

        $accessories = unserialize($technical_array['Accessories']);
        $temp='';
        foreach($accessories as $item ){
            $temp.=$item.",";
        }
        if (str_replace(' ','',$temp) == ',') {$temp = '';}
        $technical_array['Accessories']=$temp;

        $project = Project::query
        ("SELECT *,
            p.id AS project_id,
            c.id AS customer_id,
            c.name AS customer_name,
            c.surname AS customer_surname,
            c.contact_number AS customer_contact,
            c.email AS customer_email,
            c.address AS customer_address,
            p.name AS project_name,
            u.name AS sales_name,
            u.surname AS sales_surname,
            u.mobile_number AS sales_contact,
            p.name AS project_name
        FROM projects p
        LEFT JOIN customers c ON p.customer_id=c.id
        LEFT JOIN users u ON p.user_id=u.id
        WHERE p.id=$project_id;" )->fetch();

        $pdf = new PDF_project_spec($project['project_name'].' (Status: '.$project['status'].')' );
        $pdf->setTitle($project['project_name'].' (Status: '.$project['status'].')' );
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',10);

        $fromheader = array('Magna Kitchens','Project Specification');
        // $fromdata = array(
        //                 array($config['company']['address'],"Flight Date: ".$bookingArray['flight_date']),
        //                 array("Tel: ".$config['company']['tel'],"Created: ".$bookingArray['created_on']),
        //                 array("Tel: "."Flight Date: ".$config['company']['cell'],"Status: ".$bookingArray['status']),
        //                 array("Email: ".$config['company']['email'],"")
        // array('0826147353','test'),
        // array('ck','ck')
        // );
        global $config;
        $fromdata = array(
            $config['company']['address'],
            $config['company']['town'],
            "Tel: ".$config['company']['tel'],
            "Fax: ".$config['company']['fax'],
            "Email: ".$config['company']['email']
        );
        $todata = array(
            "Customer: ".$project['customer_name']." ".$project['customer_surname'],
            "Address: ".$project['customer_address'],
            "Contact: ".$project['customer_contact'],
            "Email: ".$project['customer_email']
        );

        $pdf->boxinfosplit($fromdata,$todata);
        $pdf->Ln(15);
        //Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
        $pdf->Cell(190,10,'Description: '.$project['description'], 1, 1, 'L', false);
        $pdf->Ln(2);

        $header = array('Option','Selection');
        $pdf->FancyTable($header,$technical_array);

        //ADP 2018/10/25 Add a separate notes section
        $pdf->Ln(2);
        //$pdf->MultiCell(190,20,'Notes: '.$technical_array['Notes'],'LRTB', 1, 'T');
        //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(190,8,'Notes: ', 0, 1, 'L', false);
        $pdf->SetFont('Arial','',9);
        $pdf->MultiCell(0,5,$technical_array['Notes'], 0, 'L', false);
        //$pdf->Ln(4);

        $pdf->Output();

    }

    function statusNew($project_id=0) {

        $project = new Project($project_id);
        if (!$project->id && $project_id) {
            $this->redirect("project");
        }
        $project->status = 'New';
        $project->update();

        // ADP 2019/02/15 Move here as the tasks are not applicable if the project is not accepted
        // Create automatic tasks when the project is started
        // --------------------------------------------------------------------------------
        $AutoTask = new Task();
        $AutoTask->user_id= $this->user_id;
        $AutoTask->task= 'Orders';
        $AutoTask->created_on= date('Y-m-d H:i:s');
        $AutoTask->project_id=$project->id;
        $AutoTask->insert();
        //create automatic tasks (3)
        $AutoTask = new Task();
        $AutoTask->user_id= $this->user_id;
        $AutoTask->task= 'Production';
        $AutoTask->created_on= date('Y-m-d H:i:s');
        $AutoTask->project_id=$project->id;
        $AutoTask->insert();
        //create automatic tasks (4)
        $AutoTask = new Task();
        $AutoTask->user_id= $this->user_id;
        $AutoTask->task= 'Installation';
        $AutoTask->created_on= date('Y-m-d H:i:s');
        $AutoTask->project_id=$project->id;
        $AutoTask->insert();
        // --------------------------------------------------------------------------------

        $project_array = Project::query
        ("SELECT *,
            p.id AS project_id,
            c.id AS customer_id,
            c.name AS customer_name,
            c.surname AS customer_surname,
            c.email AS customer_email,
            p.name AS project_name,
            t.id AS technical_id
        FROM projects p
        LEFT JOIN customers c ON p.customer_id=c.id
        LEFT JOIN technicals t ON p.id=t.project_id
        WHERE p.id=$project_id     ;")->fetch();

        $mail_vars = array(
            'name' => $project_array['customer_name'] .' '.$project_array['customer_surname'],
            'email' => $project_array['customer_email']
        );
        Message_template::send($project_array['customer_email'], Message_template::STATUS_NEW, $mail_vars);

        $this->redirect('project?success=1');

    }

    function statusDeclined($project_id=0) {                
       
        $project = new project($project_id);

        if (!$project->id && $project_id) {
            $this->redirect("project");
        }

        if (isset($_POST['data'])) {

            $project->update_map($_POST['data']);
            $is_new_project = false;

            if ($project->validate()) {
                if (!$project->id) {
                    // $project->insert();
                    // $is_new_project = true;
                    $this->redirect("project"); //no creation happening

                } else {
                    //decline the quote
                    $filter = "project_id=".$project_id." AND quote_status='Pending'";        
                    //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;
                    $quote_array = Quote::find(array( 'where' => $filter))->fetch();

                    if($quote_array['id']){
                        $quote = new Quote ($quote_array['id']);
                        $quote->quote_status="Declined";
                        $quote->update();
                    }else{
                        $this->redirect('project?failure=No pending quotes');
                    }

                    //update the project status
                    $project->status = 'Declined';
                    $project->update();

                    $project_array = Project::query
                    ("SELECT *,
                        p.id AS project_id,
                        c.id AS customer_id,
                        c.name AS customer_name,
                        c.surname AS customer_surname,
                        c.email AS customer_email,
                        p.name AS project_name,
                        t.id AS technical_id
                    FROM projects p
                    LEFT JOIN customers c ON p.customer_id=c.id
                    LEFT JOIN technicals t ON p.id=t.project_id
                    WHERE p.id=$project_id;")->fetch();

                    $mail_vars = array(
                        'name' => $project_array['customer_name'] .' '.$project_array['customer_surname'],
                        'email' => $project_array['customer_email']
                    );
                    Message_template::send($project_array['customer_email'], Message_template::STATUS_DECLINED, $mail_vars);

                }

                if($is_new_project) {
                    $this->redirect('project?success=1');
                } else {
                    // $this->redirect('project/edit/'.$project->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('project?success=1');
                }

            } else {
                $_POST['data']['id'] = $project->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $project->to_array());
        }

    }

    function statusAccepted($project_id=0) {

        $project = new project($project_id);
        if (!$project->id && $project_id) {
            $this->redirect("project");
        }
        
        //accept the quote
        $filter = "project_id=".$project_id." AND quote_status='Pending'";        
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;
        $quote_array = Quote::find(array( 'where' => $filter))->fetch();

        if($quote_array['id']){
            $quote = new Quote ($quote_array['id']);
            $quote->quote_status="Accepted";
            $quote->update();
        }else{
            $this->redirect('project?failure=No pending quotes');
        }

        //update the project status
        $project->status = 'Accepted';
        $project->update();

        //get joint information for emailing
        $project_array = Project::query
        ("SELECT *,
            p.id AS project_id,
            c.id AS customer_id,
            c.name AS customer_name,
            c.surname AS customer_surname,
            c.email AS customer_email,
            p.name AS project_name,
            t.id AS technical_id
        FROM projects p
        LEFT JOIN customers c ON p.customer_id=c.id
        LEFT JOIN technicals t ON p.id=t.project_id
        WHERE p.id=$project_id     ;")->fetch();

        $mail_vars = array(
            'name' => $project_array['customer_name'] .' '.$project_array['customer_surname'],
            'email' => $project_array['customer_email']
        );
        Message_template::send($project_array['customer_email'], Message_template::STATUS_ACCEPTED, $mail_vars);

        $this->redirect('project?success=1');

    }

    function statusInstalled($project_id=0) {

        $project = new Project($project_id);
        if (!$project->id && $project_id) {
            $this->redirect("project");
        }
        $project->status = 'Installed';
        $project->update();

        // $project_array = Project::query("SELECT *,p.id AS project_id, 
        //                                      c.id AS customer_id, 
        //                                      c.name AS customer_name, 
        //                                      c.surname AS customer_surname, 
        //                                      c.email AS customer_email, 
        //                                      p.name AS project_name,
        //                                      t.id AS technical_id 
        //                             FROM projects p 
        //                             LEFT JOIN customers c ON p.customer_id=c.id
        //                             LEFT JOIN technicals t ON p.id=t.project_id
        //                             WHERE p.id=$project_id     ;")->fetch();   
        // $mail_vars = array(
        //                 'name' => $project_array['customer_name'] .' '.$project_array['customer_surname'],
        //                 'email' => $project_array['customer_email']
        //             );
        // Message_template::send($project_array['customer_email'], Message_template::STATUS_NEW, $mail_vars);

        $this->redirect('project?success=1');

    }

    function complete($project_id=0) {

        $project = new project($project_id);
        if (!$project->id && $project_id) {
            $this->redirect("project");
        }
        $project->status = 'Complete';
        $project->completed_on = date("Y-m-d H:i:s");
        $project->update();


        $project_array = Project::query
        ("SELECT *,
            p.id AS project_id,
            c.id AS customer_id,
            c.name AS customer_name,
            c.surname AS customer_surname,
            c.email AS customer_email,
            p.name AS project_name,
            t.id AS technical_id
        FROM projects p
        LEFT JOIN customers c ON p.customer_id=c.id
        LEFT JOIN technicals t ON p.id=t.project_id
        WHERE p.id=$project_id;")->fetch();

        $mail_vars = array(
            'name' => $project_array['customer_name'] .' '.$project_array['customer_surname'],
            'email' => $project_array['customer_email']
        );
        Message_template::send($project_array['customer_email'], Message_template::STATUS_COMPLETE, $mail_vars);

        $this->redirect('project?success=1');

    }

    function assign($project_id=0) {

        // $filter = 'TRUE';        
        // //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        // // $projects = Project::find(array( 'where' => $filter))->fetch_all();
        // $projects = Project::query("SELECT *,p.id AS project_id, 
        //                                      c.id AS customer_id, 
        //                                      c.name AS customer_name, 
        //                                      c.surname AS customer_surname, 
        //                                      p.name AS project_name 
        //                             FROM projects p 
        //                             LEFT JOIN customers c ON p.customer_id=c.id;"
        //                             )->fetch_all();
        // $total_projects = Project::count(array('where' => $filter));

        // $customers = Customer::query("SELECT * FROM customers")->fetch_all();

        // $this->set(array(
        //     'customers' => $customers,
        //     'projects' => $projects,
        //     'total_projects' => $total_projects,
        //     'per_page' => $this->per_page,
        //     'page' => $page
        // ));
    }  

    public function edit($project_id = 0) {

        if ($project_id == 0) {
            $this->redirect("project");
        }
        $this->set_view('project_add');
        $this->add($project_id);

    }

    public function delete($project_id) {

        Project::delete($project_id);
        $this->redirect('referer');

    }

    public function delete_appointment($appointment_id) {

        Appointment::delete($appointment_id);
        $this->redirect('referer');

    }

}

?>