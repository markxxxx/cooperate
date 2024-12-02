<?php declare(strict_types=1)

class Controller {
	
	public $cache = array();
	public $cache_id = null;
	public $helpers = array();
	public $controller_name = null;
	public $method_name = null;
	public $args = array();
	public $template;


	public function __construct() {

		$this->template = Template::getInstance(); 
		$router = Router::getInstance(); 
		$this->controller_name = $router->controller;
		$this->method_name = $router->method;
		$this->args = $router->args;
		
	}

	public function is_cached() {
		
		if(!count($this->cache))
			return false;

		if(!array_key_exists($this->method_name, $this->cache)) 
			return false;

		$this->cache_id .= count($this->args) ? implode($this->args, '_') : 0;

		
		$this->template->cache_lifetime = $this->cache[$this->method_name];
		$this->template->caching = 1;
		
		$cache_name = $this->template->template_dir.DIRECTORY_SEPARATOR. 
						$this->controller_name .'_' . $this->method_name.'.tpl'; 

		if(!$this->template->is_cached($cache_name, $this->cache_id))
			return false;

		return true;
        
	}
	
	public function before_action() {}

	public function after_action() {}

	public function load_helper($helper, $args=null) {
		
		if($helper[0] !== '_')
			return false;
		
		$helper = strtolower($helper);
 
		$new_object = strpos($helper,'__') === 0 ? true : false;	

		$helper = ltrim($helper,'_');

		$core = array('validate','cache');
		
		if(!in_array($helper,$core)) {
			
			$filename = 'helpers/'.$helper.'.php';
			
            if(!file_exists($filename)) {
				Error("Controller::loadHelper()","failed to open stream: No such file or directory in $filename");
            }
            
			include_once $filename;

		} else {
			
			return call_user_func(array($helper,'getInstance'));

		}


		if(!$new_object) {
			if(array_key_exists($helper, $this->helpers))
				return $this->helpers[$helper];
			 else {
			
				if(!class_exists(ucfirst($helper)))
					Error("Controller::loadHelper()","class '$helper' not found");

				$this->helpers[$helper] = new $helper($args[0]);

				return $this->helpers[$helper];	
			}
		} else {
			
			return new $helper($args[0]);
		}
		
	}
    
    public function redirect($url = '',$extra='',$exit = true) {
    
        switch($url) {
            case 'referer':
            	$url = $_SERVER['HTTP_REFERER'];
            	if(strlen($extra)) {
            		if(strpos($_SERVER['HTTP_REFERER'], '?')) {
            			$url = array_shift(explode('?', $_SERVER['HTTP_REFERER']));
            		}
            	}
                header('location:'.$url.$extra);
            break;
			case 'close':
				echo "<script>opener.parent.location.reload(true);window.close();  </script>";
			break;
            default :
            	                // echo 'url: '.$url;
                header('location: /'.$url);

            break;
        }
        if($exit) {
            exit();
        }
	}
    
    public function clear_cache() {
        
        $this->template->clear_all_cache();
        Cache::delete_all();
        
        
    }

	public function query($sql) {
		return Database::query($sql);
	}

	public function set($field=null,$value=null) {

		if(is_null($value) && is_array($field))
			$this->template->assign($field);

		if(!is_null($field) && !is_null($value))
			$this->template->assign($field,$value); 
	}

	public function set_view($view) {
		$this->template->set_view($view);
	}

	public function set_theme($theme) {
		$this->template->set_theme($theme);
	}
	
	public function title($title) {
		$this->set('site_title', $title);
	}
    
    public function description($description) {
		$this->set('site_description', $description);
	}
    
    public function keyword($keywords) {
		$this->set('site_keywords', $keywords);
	}
    
    public function feed($feed) {
		$this->set('site_feed', $feed);
	}

	public function flash($type,$message ) {
		
		$this->set(array(
			'flash_type' => $type,
			'flash_message' => $message
		));
		
	}

	public function __call($method,$args) {
		return $this->load_helper($method,$args);
	}

}

?>