<?php declare(strict_types=1)

class GroupController extends AppController {

	private $per_page = 100;

	const admin_path = 'controllers/';
    const super_user = Group::super_user_group;

    private $ignored_controllers = array('admin_controller.php', 'app_controller.php', 'cv_controller.php', 'cron_controller.php');
    private $ingored_methods = array('before_action', 'after_action', '__construct', '__destruct', '__set', '__get');
  
    public function before_action() {

        parent::before_action();

        if (!$this->user->can_access($this->controller_name, $this->method_name)) {
            $_SESSION['redirect'] = urlencode(substr($_SERVER['REQUEST_URI'], 1));
            $this->redirect('login');
        }
    }
    
	public function index($page=0) {
	
		$filter = 'TRUE';
		if(array_key_exists('search', $_GET)) {
			$filter = " (id = '{$_GET['search']}' OR name like '%{$_GET['search']}%') and account <> 'Master'";
		} else {
            $filter = " account <> 'Master'";
        }

		$limit = ($page * $this->per_page) .' , ' .$this->per_page;
		
		$groups = Group::find(array( 'where' => $filter))->fetch_all();
		$total_groups = Group::count(array('where' => $filter));
		
		$this->set(array(
			'groups' => $groups,
			'total_groups' => $total_groups ,
			'per_page' => $this->per_page,
			'page' => $page
		));
		
	}

    //ajax function
    public function is_admin($group_id=0) {
        
        if(!is_numeric($group_id) || $group_id == 0) {
            echo json_encode(array('is_admin' => false));
            exit();
        }

        $group = new Group($group_id);
        
        if(!$group->id) {
            echo json_encode(array('is_admin' => false));
            exit();
        }
        echo json_encode(array('is_admin' => $group->is_admin()));
        exit();
    }

	public function add($group_id = 0) {
	
        if($group_id == 1) {
            $this->redirect("group");
        }

        if ($this->user->is_super()) {
            $allowed_groups = Group::find()->fetch_all();
        } else {
            $allowed_groups = $this->user->get_groups();
        }

		$group = new Group($group_id);
		if(!$group->id && $group_id) {
			$this->redirect("group");
		}

        $this->set('group_priority', $allowed_groups);
		
        if(array_key_exists('data', $_POST)) {

            $group->update_map($_POST['data']);
            // $group->approve_changes = isset($_POST['data']['approve_changes']) ? 1 : 0;
            // $group->message_notification = isset($_POST['data']['message_notification']) ? 1 : 0;

            $priorities = isset($_POST['priorities']) ? array_values($_POST['priorities']) : array();
            
            if( $group->validate() ) {
				if(!$group->id) {
					$group->insert();

                    $permissions = Permission::find()->fetch_all();
                    foreach($permissions as $p) {
                        Permission::update_group($group->id, $p['id'], 0);
                    }

				} else {
					$group->update();
				}
                $group->update_priorities($priorities);
                $this->redirect('group?success=1');
            } else {
                $_POST['data']['id'] = $group->id;
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
                $this->set('current_priorities', $priorities);

            }

        } else {
            $priorities = $group->get_priorities();
            $this->set('current_priorities', !$priorities ? array() : array_keys($priorities));
            $this->set('data', $group->to_array());
        }
	}
	
	public function edit($group_id = 0) {
		if($group_id == 0) {
			$this->redirect("group");
		}
		$this->set_view('group_add');
		$this->add($group_id);

	}
	
	public function delete($group_id) {
		Group::delete($group_id);
		$this->redirect('referer');
	}
	
	public function delete_selected() {
		if(array_key_exists('id', $_POST)) {
			if(is_array($_POST['id'])) {
				$this->delete(array_keys($_POST['id']));
			}
		}
	}

	public function generate_permissions() {

        $groups = Group::find()->fetch_all();
        $permissions = Permission::find()->fetch_all();
    
        //clean up
        foreach ($permissions as $permission) {

            $class_name = ucfirst($permission['class']) . 'Controller';
            include_once self::admin_path . $permission['class'] . '_controller.php';

            if (!method_exists($class_name, $permission['method'])) {
                Permission::delete($permission['id']);
            }
        }

        foreach (glob(self::admin_path . "*.php") as $filename) {

            $filename = basename($filename);

            if (strpos($filename, 'controller') !== false && !in_array($filename, $this->ignored_controllers)) {

                include_once self::admin_path . $filename;
                $permission_name = array_shift(explode('_', $filename));
                $class_name = ucfirst($permission_name) . 'Controller';
                $methods = get_class_methods($class_name);
                $code = file_get_contents(self::admin_path . $filename);


                foreach ($methods as $method) {

                    if (!in_array($method, $this->ingored_methods) && strpos($code, 'function ' . $method)) {

                        $map = array('class' => $permission_name, 'method' => $method);
                        $permission = Permission::map($map);

                        if (!$permission->get()) {
                        
                            $permission->insert();

                            foreach ($groups as $group) {
                                $can_access = self::super_user == $group['id'] ? 1 : 0;
                                Permission::update_group($group['id'], $permission->id, $can_access);
                            }
                            
                        }
                    }
                }
                
            }
        }
        $this->redirect('group/manage');
    }

    public function manage() {

        $groups = Group::find()->fetch_all();
        $permissions = Permission::find(array('order' => ' class '))->fetch_all();

        foreach ($groups as $group) {
            $temp = Group::permissions($group['id']);
            foreach ($temp as $g) {
                $group_permission[$group['id']][$g['id']] = $g;
            }
        }

        $this->set('group_permission', $group_permission);
        $this->set('groups', $groups);
        $this->set('permissions', $permissions);
    }

    public function update_permission($group_id =0, $permission_id=0, $can_access=0) {
        Database::query("UPDATE group_permission SET can_access = '{$can_access}' WHERE group_id = '{$group_id}' AND permission_id ='{$permission_id}'");
        Cache::delete('group_permission_' . $group_id);
        exit();
    }

}
?>