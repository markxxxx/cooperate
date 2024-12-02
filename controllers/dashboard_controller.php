<?php declare(strict_types=1)

class DashboardController extends AppController {
	

	private $messages_per_page = 10;

    public function before_action(){

        parent::before_action();
        
         if(!$_SESSION['id']){
            $this->redirect('login');
          }


    }

	public function home($box='inbox', $page=0) {

        // $domain =  new Domain($this->user->current_domain());

        // if ($this->user->is_bursar()) {

        //     $this->set('incomplete_tasks', Task::find(array(
        //                 'where' => " t.user_id = '{$this->user->id}' AND t.completed = 0 ",
        //                 'order' => ' t.id asc ',
        //                 'limit' => '5')
        //             )->fetch_all());

        //     $this->set('complete_tasks', Task::find(array(
        //                 'where' => " t.user_id = '{$this->user->id}' AND t.completed = 1 ",
        //                 'order' => ' t.id asc ',
        //                 'limit' => '5')
        //             )->fetch_all());

        //     if($domain->show_payment_summary()) {
        //         $this->set('annual_user_summary', Payment::user_summary($this->user->id));
        //     }
            
        //     $rsvps = Event::search($this->user, false, false, array('rsvp'=> 'Pending'));
        //     $this->set('event_rsvps', $rsvps);

        //     $this->set('academic_results', $this->user->get_academic_results());



        //     if(($upcoming_events = Event::search($this->user, false, false, array('rsvp'=> 'Yes'))) !== false)  {
        //         $event_dates = array();
        //         foreach($upcoming_events as $event) {
        //             $index = date('F', strtotime($event['event_date']));
        //             $event_dates[$index] += 1;
        //         }
                
        //         $this->set('upcoming_events', $event_dates);
        //         $this->set('total_upcoming_events', count($upcoming_events));
        //     }

        //     $search_filter = array();

        //     if (isset($_GET['search'])) {
        //         $search_filter['search_mail'] = $_GET['search']; 
        //     }
        //     $messages = $box == 'inbox' ?
        //             Message::inbox($search_filter, $this->user, $page, $this->messages_per_page):
        //             Message::outbox($search_filter, $this->user, $page, $this->messages_per_page);
            
        // }

        // if ($this->user->is_admin()) {
        //     //Dashboard only shows bursars

        //     if($this->user->can_approve()) {
        //         $approval_filters = $filters;
        //         $approval_filters['where'] = " AND status = 'pending' ";
        //         $approvals = Approval::search($approval_filters);
        //     }

        //     $this->set(array(
        //         'domain_users'  => $domain_users,
        //         'actions'       => Action::recent(0, $filters, array()),
        //         'user_count'    => User::search_count($filters),
        //         'approvals'     => $approvals,
        //         'groups'        => array_values($this->user->get_group_bursars()), 
        //         'universities'  => Field::get('university'),
        //         'study_years'   => Field::get('year_of_study')
        //     ));
            
        //     if ($this->user->can_access('dashboard', 'set_filters')) {
        //         $this->set('domains', array_values($this->user->get_domains()));
        //     }
            
        //     if (isset($_GET['search'])) {
        //         $filters['search_mail'] = $_GET['search']; 
        //     }

        //     $messages = $box == 'inbox' ?
        //             Message::inbox($filters, $this->user, $page, $this->messages_per_page):
        //             Message::outbox($filters, $this->user, $page, $this->messages_per_page);

        //     $this->set('reminders', Reminder::search($this->user, true));

        //     $this->set('message_templates', Message_template::find(array('message_type'=>'general'))->fetch_all());

           
            
        // }

        //events calendar
        // $calendar = $this->_calendar(isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'));
        // $calendar->set_events(Event::search($this->user, false, true , $filters));

        // $this->set('calendar', $calendar->output_calendar());


        //$this->set(array(
            //'messages'          => $messages['messages'],
            //'attachment_count'	=> Attachment::attachments_count(),
            //'total_messages'    => $messages['messages_count'],
            //'domain_name'       => $group->domain,
            //'per_page'          => $this->messages_per_page,
            //'page'              => $page,
            //'box'               => $box,
        //));

    }

    public function get_users($filter=true) {

        if ($this->user->is_admin()) {
            
            if($filter) {
                $filters = Filter::get();
            }
            
            $filters['account_type'] = 'bursar';
            $filters['send_message'] = '1';
            $filters['limit'] = false;

            $users = User::search($filters);
            $json = array();

            foreach($users as $user) {
                $json[] = $user['name']. ' ' . $user['surname'] . '__' . $user['id'];
            }

            echo json_encode(array_values($json));
            exit();
        }
    }

    public function set_filters() {

        Filter::clear();
        Filter::set($_POST);
        $this->redirect('referer','?success=1');
    }

    public function remove_filters($key = false, $option = false) {

        Filter::remove($key, urldecode($option));
        $this->redirect('referer','?success=1');
    }

    public function user_count($bursars_only = true) {

        if($bursars_only) {
            $_POST['account_type'] = 'bursar';
        }
        

        $_POST['send_message'] = '1';
        $_POST['limit'] = false;


        echo json_encode(array(
            'total_users' => User::search_count($_POST)
        ));

        exit();
    }

}


?>