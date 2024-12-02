<?php declare(strict_types=1)

class AuthController extends AppController {

    public function login() {

        if ($this->user->id) {
            $this->redirect('dashboard/home');
        }

        if (isset($_POST['login'])) {
            //Retards!!!!!!!!!!!!!!!!!!!!!
            $_POST['data']['email'] = trim($_POST['data']['email']); 
            $_POST['data']['password'] = trim($_POST['data']['password']); 

            // echo md5($user->password);
            // print_r( $_POST['data']);

            $user = User::map($_POST['data']);
            $user->password = md5($user->password);

            if (!$user->get()) {
                $this->set('login_error', 1);
            } 
            else 
            {

                if($user->account_status == 'Archived' || $user->account_status == 'Inactive') {
                    $this->redirect();
                }
                Action::add($user, 'login');
                $user->last_seen = date('Y-m-d H:i:s');
                $user->update();
                $_SESSION['id'] = $user->id;
                $_SESSION['domain_id'] = $user->domain_id;

                if (isset($_SESSION['redirect'])) {
                     $this->redirect(urldecode($_SESSION['redirect']));
                } 
                else {
                     $this->redirect('dashboard/home');

//                    if ($user->can_access('dashboard', 'home')){
//                        $this->redirect('user');
//                    } elseif ($user->can_access('appointment', 'team_week_view')) {
//                        $this->redirect('appointment/team_week_view');
//                    } elseif ($user->can_access('appointment', 'index')) {
//                        $this->redirect('appointment');
//                    } elseif ($user->can_access('appointment', 'events')) {
//                        $this->redirect('appointment/events');
//                    } elseif ($user->can_access('project', 'index')) {
//                        $this->redirect('project');
//                    } elseif ($user->can_access('quote', 'index')) {
//                        $this->redirect('quote');
//                    } elseif ($user->can_access('invoice', 'index')) {
//                        $this->redirect('invoice');
//                    } elseif ($user->can_access('snag', 'index')) {
//                        $this->redirect('snag');
//                    } elseif ($user->can_access('task', 'index')) {
//                        $this->redirect('task');
//                    } elseif ($user->can_access('report', 'index')) {
//                        $this->redirect('report');
//                    } elseif ($user->can_access('accessory', 'index')) {
//                        $this->redirect('accessory');
//                    } elseif ($user->can_access('customer', 'index')) {
//                        $this->redirect('customer');
//                    } elseif ($user->can_access('user', 'index')) {
//                        $this->redirect('user');
//                    } elseif ($user->can_access('group', 'index')) {
//                        $this->redirect('group');
//                    } elseif ($user->can_access('group', 'manage')) {
//                        $this->redirect('group/manage');
//                    }

                }
            }
        }

    }

    public function logout() {

        $_SESSION = array();
        $this->redirect('login');

    } 

}

?>