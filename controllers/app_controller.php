<?php declare(strict_types=1)

class AppController extends Controller {

    public $config;

    public function before_action() {

        global $config;

        parent::before_action();

        $this->user = User::current();

        // if (!$this->user->can_access($this->controller_name, $this->method_name)) {
        //     $_SESSION['redirect'] = urlencode(substr($_SERVER['REQUEST_URI'], 1));
        //     $this->redirect('login'); // this is a problem apparently
        // }

        // if($_SESSION['id']){ echo $_SESSION['id'];}
        
        //approval

        // if(isset($_SESSION['approve']) && $this->controller_name != 'approval') {
        //     $this->redirect("approval/reason/". $_SESSION['approve']);
        // }

        $this->set('user', $this->user);

        $this->set('template_dir', '/views/' . $this->template->get_theme());
        $this->set('controller', $this->controller_name);
        $this->set('method', $this->method_name);
        $this->set('current_domain', $this->user->current_domain());
        // $this->set('domain_image', Domain::image_by_id($this->user->current_domain()));
        
        $this->set('config', $this->config = $config);
        // $this->set('is_ie', $this->_agent()->is_ie());
    }

}

?>