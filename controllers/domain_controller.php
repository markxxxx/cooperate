<?php declare(strict_types=1)

class DomainController extends AppController {

    private $per_page = 100;

    public function index($page=0) {

        $filter = 'TRUE';
        if (isset($_GET['search'])) {
            $filter = " (id = '{$_GET['search']}' OR domain like '%{$_GET['search']}%' )";
        }
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $select_fields =   implode(',', Domain::fields());
        $select_fields .= ",(SELECT count(*) FROM users WHERE domain_id = domains.id ) as total_users";

        $domains = Domain::find(array(
             
            'where' => $filter,
            'fields' => $select_fields
        ))->fetch_all();

        $total_domains = Domain::count(array('where' => $filter));

        $this->set(array(
            'domains' => $domains,
            'total_domains' => $total_domains,
            'per_page' => $this->per_page,
            'page' => $page,
            'managed_domains' => array_keys($this->user->get_domains())
        ));
    }

    public function add($domain_id = 0) {

        $this->set('admins', User::search(array('account_type' => 'administrator')));

        $domain = new Domain($domain_id);
        if (!$domain->id && $domain_id) {
            $this->redirect("domain");
        }

        if (isset($_POST['data'])) {

            $domain->update_map($_POST['data']);
            $domain->payment_summary = isset($_POST['data']['payment_summary']) ? 1 : 0;

            $admins = isset($_POST['admins']) ? array_values($_POST['admins']) : array();
            
            $country = array('South Africa' => 'ZAR','Isreal'=>'ILS','Ukraine'=>'UAH');

            if(strlen($domain->country)) {
                $domain->currency = $country[$domain->country];
            }

            if ($domain->validate() && count($admins)) {
                if (!$domain->id) {
                    $domain->insert();
                } else {
                    $domain->update();
                }
                
                if (($image = $this->_upload($_FILES['uploadedfile'])->do_upload('media/domains/', $domain->id , array('png', 'jpg', 'jpeg', 'gif'))) !== false) {
                    //$this->_image()->resize($image, 500, 500);
                    Domain::edit(array('image' => basename($image)), 'id = ' . $domain->id);
                }
                
                $domain->update_admins($admins);
                $this->redirect('domain?success=1');
            } else {
                $_POST['data']['id'] = $domain->id;
                $this->set('current_admins', $admins);
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {

            $admins = $domain->admins;
            $this->set('current_admins', !$admins ? array() : array_keys($admins));
            $this->set('data', $domain->to_array());
        }
    }

    public function edit($domain_id = 0) {
        if ($domain_id == 0) {
            $this->redirect("domain");
        }
        $this->set_view('domain_add');
        $this->add($domain_id);
    }

    public function delete($domain_id) {
        Domain::delete($domain_id);
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



    public function remove($domain_id=0) {

        if(count($_SESSION['dashboard_domains']) == 1) {
            unset($_SESSION['dashboard_domains']);
            $_SESSION['domain_id'] = $this->user->current_domain();
            $this->redirect('dashboard/home');
        }

        unset($_SESSION['dashboard_domains'][array_search($domain_id, $_SESSION['dashboard_domains'])]);


        if(count($_SESSION['dashboard_domains']) == 1) {
            
            $_SESSION['domain_id'] = array_pop($_SESSION['dashboard_domains']);
            unset($_SESSION['dashboard_domains']);
            $this->redirect('dashboard/home');
        }
        $this->redirect('dashboard/home');
    }

    public function select($domain_id=0) {


        $domains = $this->user->get_domains();

        if(isset($_POST['domains']) && count($_POST['domains'])) {

            //Security fix for selecting a domain not managed by an administrator
            foreach($_POST['domains'] as $d) {
                if(!isset($domains[$d])) {
                    $this->redirect('dashboard/home?error=1');
                }
            }

            if(count($_POST['domains']) == 1) {
                unset($_SESSION['dashboard_domains']);
                $_SESSION['domain_id'] = array_pop($_POST['domains']);
            } else {
                $_SESSION['dashboard_domains'] = $_POST['domains'];
            }


            
            if (isset($_GET['redirect'])) {
                $this->redirect($_GET['redirect']);
            }
            $this->redirect('dashboard/home');
        }

        if ($domain_id && is_numeric($domain_id)) {

            //Security fix for selecting a domain not managed by an administrator

            if(!isset($domains[$domain_id])) {
                $this->redirect('dashboard/home?error=1');
            }
            
            $_SESSION['domain_id'] = $domain_id;
            unset($_SESSION['dashboard_domains']);

            if (isset($_GET['redirect'])) {
                $this->redirect($_GET['redirect']);
            }
            $this->redirect('dashboard/home');
        }

        $this->set('domains', array_values($domains));
        $this->set('messages', Message::inbox(false, $this->user, 0, 5, 0));
    }


}

?>