<?php declare(strict_types=1)

class ReportController extends AppController {

    private $per_page = 100;

    public function before_action() {

        parent::before_action();

        if (!$this->user->can_access($this->controller_name, $this->method_name)) {
            $_SESSION['redirect'] = urlencode(substr($_SERVER['REQUEST_URI'], 1));
            $this->redirect('login');
        }
    }

    function index($page=0) {

        $this->set('data', array('filter_date_from' => "",'filter_date_to' => ""));

    }

    function newclients($page=0) {

        // $date=date("Y-m-d");
        // var_dump($date);exit();
        $customers = Customer::query('
                        SELECT *
                        FROM `customers`             
                        ')->fetch_all();

         if (isset($_POST['data']) ) {

            $from=$_POST['data']['filter_date_from']." 00:00:00";            
            $to=$_POST['data']['filter_date_to']." 11:59:59";

            // var_dump($_POST['data']);exit();

            $customers = Customer::query('
                        SELECT *
                        FROM `customers`
                        WHERE DATE(created) >= "'.$from.'"
                        AND DATE(created) < "'.$to.'"             
                        ')->fetch_all();
            $this->set('data', array('filter_date_from' => $from,'filter_date_to' => $to ) );   
        }

        // var_dump($customers);exit();
        $this->set('customers',$customers);
        // $this->set('data', array('filter_date' => $date ) );
    }

    function oldclients($page=0) {

        // $date=date("Y-m-d");
        // var_dump($date);exit();
        $customers = Customer::query('
                        SELECT *
                        FROM `customers`
                        ')->fetch_all();

        if (isset($_POST['data']) ) {

            $from=$_POST['data']['filter_date_from']." 00:00:00";
            $to=$_POST['data']['filter_date_to']." 11:59:59";

            // var_dump($_POST['data']);exit();

            $customers = Customer::query('
                        SELECT *
                        FROM `customers`
                        WHERE DATE(created) >= "'.$from.'"
                        AND DATE(created) < "'.$to.'"
                        ')->fetch_all();
            $this->set('data', array('filter_date_from' => $from,'filter_date_to' => $to ) );
        }

        // var_dump($customers);exit();
        $this->set('customers',$customers);
        // $this->set('data', array('filter_date' => $date ) );
    }

    function snagsperproject($page=0){
        
            // $date=date("Y-m-d");
        // var_dump($date);exit();
        $snags = Snag::query('SELECT *,s.id AS snag_id, 
                                            s.created_on AS snag_created,
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
                                             count(s.id) AS snag_count
                                    FROM snags s 
                                    LEFT JOIN users u ON s.user_id=u.id
                                    LEFT JOIN groups g ON s.group_id=g.id
                                    LEFT JOIN projects p ON p.id=s.project_id
                                    LEFT JOIN customers c ON p.customer_id=c.id
                                    GROUP BY p.id            
                        ')->fetch_all();

         if (isset($_POST['data']) ) {

            $from=$_POST['data']['filter_date_from']." 00:00:00";            
            $to=$_POST['data']['filter_date_to']." 11:59:59";

            // var_dump($_POST['data']);exit();

            $snags = Snag::query('SELECT *,s.id AS snag_id, 
                                            s.created_on AS snag_created,
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
                                             count(s.id) AS snag_count
                                    FROM snags s 
                                    LEFT JOIN users u ON s.user_id=u.id
                                    LEFT JOIN groups g ON s.group_id=g.id
                                    LEFT JOIN projects p ON p.id=s.project_id
                                    LEFT JOIN customers c ON p.customer_id=c.id
                                    WHERE DATE(s.created_on) >= "'.$from.'"
                                    AND DATE(s.created_on) < "'.$to.'"
                                    GROUP BY p.id            
                        ')->fetch_all();

            $this->set('data', array('filter_date_from' => $from,'filter_date_to' => $to ) );   
        }

        // var_dump($snags);exit();
        $this->set('snags',$snags);
        // $this->set('data', array('filter_date' => $date ) );
    }

    function quotesvsinvoices($page=0) {

        // $date=date("Y-m-d");
        // var_dump($date);exit();

//        ADP 2019/01/28 This query is not giving the correct details
//        $quotes = Quote::query('SELECT *,
//                                u.name AS sales_rep,
//                                count(q.id) AS num_quotes
//                                FROM users u
//                                LEFT JOIN groups g ON (u.group_id=g.id)
//                                LEFT JOIN projects p ON (p.user_id=u.id)
//                                LEFT JOIN quotes q ON (q.project_id=p.id)
//                                WHERE g.name="Sales"
//                            ')->fetch_all();
//        $invoices = Invoice::query('SELECT *,
//                                u.name AS sales_rep,
//                                count(i.id) AS num_invoices
//                                FROM users u
//                                LEFT JOIN groups g ON (u.group_id=g.id)
//                                LEFT JOIN projects p ON (p.user_id=u.id)
//                                LEFT JOIN invoices i ON (i.project_id=p.id)
//                                WHERE g.name="Sales"
//                            ')->fetch_all();

        $count = Quote::query(
            'select
              u.name AS Rep,
              ifnull(qcount,0) as qcount,
              ifnull(icount,0) AS icount
            from users u
            left join
            (
              select count(q.id) AS qcount, p.user_id from quotes q
              inner join projects p on q.project_id = p.id
              group by p.user_id
            ) qq on u.id = qq.user_id
            left join
            (
              select count(i.id) AS icount, p.user_id from invoices i
              inner join projects p on i.project_id = p.id
              group by p.user_id
            ) ii on u.id = ii.user_id
            where ifnull(qcount,0) > 0 or ifnull(icount,0) > 0
            order by u.name')->fetch_all();

        // var_dump($invoices);exit();

         if (isset($_POST['data']) ) {

            $from=$_POST['data']['filter_date_from']." 00:00:00";            
            $to=$_POST['data']['filter_date_to']." 11:59:59";

            // var_dump($_POST['data']);exit();

//            ADP 2019/01/28 This query is not giving the correct details
//            $quotes = Quote::query('SELECT *,
//                                u.name AS sales_rep,
//                                count(q.id) AS num_quotes
//                                FROM users u
//                                LEFT JOIN groups g ON (u.group_id=g.id)
//                                LEFT JOIN projects p ON (p.user_id=u.id)
//                                LEFT JOIN quotes q ON (q.project_id=p.id)
//                                WHERE g.name="Sales"
//                                AND DATE(q.created) >= "'.$from.'"
//                                AND DATE(q.created) < "'.$to.'"
//                            ')->fetch_all();
//            $invoices = Invoice::query('SELECT *,
//                                    u.name AS sales_rep,
//                                    count(i.id) AS num_invoices
//                                    FROM users u
//                                    LEFT JOIN groups g ON (u.group_id=g.id)
//                                    LEFT JOIN projects p ON (p.user_id=u.id)
//                                    LEFT JOIN invoices i ON (i.project_id=p.id)
//                                    WHERE g.name="Sales"
//                                    AND DATE(i.created) >= "'.$from.'"
//                                    AND DATE(i.created) < "'.$to.'"
//                                ')->fetch_all();

             $count = Quote::query(
                 'select
                  u.name AS Rep,
                  ifnull(qcount,0) as qcount,
                  ifnull(icount,0) AS icount
                from users u
                left join
                (
                  select count(q.id) AS qcount, p.user_id from quotes q
                  inner join projects p on q.project_id = p.id
                  where (date(q.created) >= "'.$from.'" and date(q.created) <= "'.$to.'")
                  group by p.user_id
                ) qq on u.id = qq.user_id
                left join
                (
                  select count(i.id) AS icount, p.user_id from invoices i
                  inner join projects p on i.project_id = p.id
                  where (date(i.created) >= "'.$from.'" and date(i.created) <= "'.$to.'")
                  group by p.user_id
                ) ii on u.id = ii.user_id
                where ifnull(qcount,0) > 0 or ifnull(icount,0) > 0
                order by u.name')->fetch_all();

            $this->set('data', array('filter_date_from' => $from,'filter_date_to' => $to ) );   
        }

        // var_dump($customers);exit();

        //$this->set('quotes',$quotes);
        //$this->set('invoices',$invoices);

        $this->set('counts',$count);

        // $this->set('data', array('filter_date' => $date ) );
    }

    function jobsvsfreebies($page=0) {

            // $date=date("Y-m-d");
            // var_dump($date);exit();
            $freebies = Project::query('SELECT * ,
                                    count(p.id) AS freebies
                                    FROM projects p
                                    WHERE p.payment_type="NO PAYMENT"
                                ')->fetch_all();
            $invoiced = Project::query('SELECT * ,
                                    count(p.id) AS invoiced
                                    FROM projects p
                                    WHERE p.payment_type<>"NO PAYMENT"
                                ')->fetch_all();

            // var_dump($invoices);exit();

             if (isset($_POST['data']) ) {

                $from=$_POST['data']['filter_date_from']." 00:00:00";            
                $to=$_POST['data']['filter_date_to']." 11:59:59";

                // var_dump($_POST['data']);exit();

                $freebies = Project::query('SELECT * ,
                                    count(p.id) AS freebies
                                    FROM projects p
                                    WHERE p.payment_type="NO PAYMENT"
                                    AND DATE(p.created_on) >= "'.$from.'"
                                    AND DATE(p.created_on) < "'.$to.'"
                                ')->fetch_all();
                $invoiced = Project::query('SELECT * ,
                                    count(p.id) AS invoiced
                                    FROM projects p
                                    WHERE p.payment_type<>"NO PAYMENT"
                                    AND DATE(p.created_on) >= "'.$from.'"
                                    AND DATE(p.created_on) < "'.$to.'"
                                ')->fetch_all();

                $quotes = Quote::query('SELECT *,
                                    u.name AS sales_rep,
                                    count(q.id) AS num_quotes
                                    FROM users u 
                                    LEFT JOIN groups g ON (u.group_id=g.id) 
                                    LEFT JOIN projects p ON (p.user_id=u.id) 
                                    LEFT JOIN quotes q ON (q.project_id=p.id)  
                                    WHERE g.name="Sales"
                                    AND DATE(q.created) >= "'.$from.'"
                                    AND DATE(q.created) < "'.$to.'"
                                ')->fetch_all();
                $invoices = Invoice::query('SELECT *, 
                                        u.name AS sales_rep,
                                        count(i.id) AS num_invoices
                                        FROM users u 
                                        LEFT JOIN groups g ON (u.group_id=g.id) 
                                        LEFT JOIN projects p ON (p.user_id=u.id) 
                                        LEFT JOIN invoices i ON (i.project_id=p.id)  
                                        WHERE g.name="Sales"
                                        AND DATE(i.created) >= "'.$from.'"
                                        AND DATE(i.created) < "'.$to.'"
                                    ')->fetch_all();

                $this->set('data', array('filter_date_from' => $from,'filter_date_to' => $to ) );   
            }

            // var_dump($customers);exit();
            $this->set('freebies',$freebies);
            $this->set('invoiced',$invoiced);
            // $this->set('data', array('filter_date' => $date ) );
    }

    function projectscompleted($page=0) {

            // $date=date("Y-m-d");
            // var_dump($date);exit();
            $completed = Project::query('SELECT p.name, p.description, p.completed_on
                                    FROM projects p
                                    WHERE p.status="Complete"
                                ')->fetch_all();

            // var_dump($invoices);exit();

             if (isset($_POST['data']) ) {

                $from=$_POST['data']['filter_date_from']." 00:00:00";            
                $to=$_POST['data']['filter_date_to']." 11:59:59";

                // var_dump($_POST['data']);exit();

                $completed = Project::query('SELECT p.name, p.description, p.completed_on
                                    FROM projects p
                                    WHERE p.status="Complete"
                                    AND DATE(p.created_on) >= "'.$from.'"
                                    AND DATE(p.created_on) < "'.$to.'"
                                ')->fetch_all();

                $this->set('data', array('filter_date_from' => $from,'filter_date_to' => $to ) );   
            }

            // var_dump($customers);exit();
            $this->set('completed',$completed);

            // $this->set('data', array('filter_date' => $date ) );
        }

    function leadtime($page=0) {

        // $date=date("Y-m-d");
        // var_dump($date);exit();
        $completed = Project::query('SELECT * ,
                                count(p.id) AS complete
                                FROM projects p
                                WHERE p.status="Complete"
                            ')->fetch_all();


        // var_dump($invoices);exit();

         if (isset($_POST['data']) ) {

            $from=$_POST['data']['filter_date_from']." 00:00:00";
            $to=$_POST['data']['filter_date_to']." 11:59:59";

            // var_dump($_POST['data']);exit();

            $completed = Project::query('SELECT * ,
                                count(p.id) AS complete
                                FROM projects p
                                WHERE p.status="Complete"
                                AND DATE(p.created_on) >= "'.$from.'"
                                AND DATE(p.created_on) < "'.$to.'"
                            ')->fetch_all();



            $this->set('data', array('filter_date_from' => $from,'filter_date_to' => $to ) );
        }

        // var_dump($customers);exit();
        $this->set('completed',$completed);

        // $this->set('data', array('filter_date' => $date ) );
    }

    function snagsperteam($page=0) {

        // $date=date("Y-m-d");
        // var_dump($date);exit();
        $snags = snag::query('SELECT
            u.name AS sales_rep,
            g.name AS group_name,
            count(s.id) AS snags
        FROM groups g
        LEFT JOIN
        (
            select ss.id, ss.group_id, ss.project_id, aa.start
            from snags ss
            INNER JOIN appointments aa ON (aa.snag_id = ss.id)
        ) s ON (s.group_id = g.id)
        LEFT JOIN projects p ON (p.id=s.project_id)
        LEFT JOIN users u ON (u.group_id=g.id)
        WHERE g.account = "Install"
        GROUP BY g.id
        ')->fetch_all();

        // var_dump($invoices);exit();

         if (isset($_POST['data']) ) {

            $from=$_POST['data']['filter_date_from']." 00:00:00";
            $to=$_POST['data']['filter_date_to']." 11:59:59";

            // var_dump($_POST['data']);exit();

            $snags = snag::query('SELECT
                u.name AS sales_rep,
                g.name AS group_name,
                count(s.id) AS snags
            FROM groups g
            LEFT JOIN
            (
                select ss.id, ss.group_id, ss.project_id, aa.start
                from snags ss
                INNER JOIN appointments aa ON (aa.snag_id = ss.id)
            ) s ON (s.group_id = g.id)
            LEFT JOIN projects p ON (p.id=s.project_id)
            LEFT JOIN users u ON (u.group_id=g.id)
            WHERE g.account = "Install" AND
            (DATE(s.start) >= "'.$from.'" AND DATE(s.start) <= "'.$to.'")
            GROUP BY g.id
            ')->fetch_all();

            $this->set('data', array('filter_date_from' => $from,'filter_date_to' => $to ) );
        }

        // var_dump($customers);exit();
        $this->set('snags',$snags);

        // $this->set('data', array('filter_date' => $date ) );
    }

    function jobsperteam($page=0) {

       $tasks = Task::query('SELECT
            u.name AS sales_rep,
            g.name AS group_name,
            count(t.id) AS tasks
        FROM groups g
        LEFT JOIN
        (
          select tt.id, tt.group_id, tt.project_id, aa.start
          from tasks tt
          INNER JOIN appointments aa ON (aa.task_id = tt.id)
        ) t ON (t.group_id = g.id)
        LEFT JOIN projects p ON (p.id = t.project_id)
        LEFT JOIN users u ON (u.group_id = g.id)
        WHERE g.account = "Install"
        GROUP BY g.id
        ')->fetch_all();

        // var_dump($invoices);exit();

         if (isset($_POST['data']) ) {

            $from=$_POST['data']['filter_date_from']." 00:00:00";
            $to=$_POST['data']['filter_date_to']." 11:59:59";

            // var_dump($_POST['data']);exit();

            $tasks = Task::query('SELECT
                u.name AS sales_rep,
                g.name AS group_name,
                count(t.id) AS tasks
            FROM groups g
            LEFT JOIN
            (
              select tt.id, tt.group_id, tt.project_id, aa.start
              from tasks tt
              INNER JOIN appointments aa ON (aa.task_id = tt.id)
            ) t ON (t.group_id = g.id)
            LEFT JOIN projects p ON (p.id = t.project_id)
            LEFT JOIN users u ON (u.group_id = g.id)
            WHERE g.account = "Install" AND
            (DATE(t.start) >= "'.$from.'" AND DATE(t.start) <= "'.$to.'")
            GROUP BY g.id
            ')->fetch_all();

            $this->set('data', array('filter_date_from' => $from,'filter_date_to' => $to ) );
        }

        // var_dump($customers);exit();
        $this->set('tasks',$tasks);

        // $this->set('data', array('filter_date' => $date ) );
    }

}
?>