<?php declare(strict_types=1)

class Router {
	
	private $uri;	
	public $routes = array();
	public $controller = null;
	public $method = null;
	public $args = array();


	public function __construct() {

		@preg_match( "([^?]+)", $_SERVER['REQUEST_URI'], $matches);
		@$this->uri = $matches[0];
		
	}

	static function parse() {
	
		$_this = Router::getInstance();
		
		$route = false;
		
		$uri = $_this->uri;
		

		if(strlen($uri) > 1)
			$uri = rtrim($uri , '/');
		
		
		if(array_key_exists($uri , $_this->routes)) {
			
			$route = $_this->routes[$uri]; 
		
		} else {
		
			foreach($_this->routes as $key => $value ) {

				if(!strpos($key, ':'))
					continue;

				$key = trim($key,'/');
				$uri = trim($uri,'/');
				
				
				$replacements = array(
					':string' => '([a-zA-z0-9-_]+)',
					':int' => '([0-9]+)',
					':all' => '(.*)',
					'/' => '\/'
				);
				
				$regex = '/^'.strtr($key , $replacements) .'$/';
		
				if(preg_match($regex, $uri, $matches)) {

					array_shift($matches);
					$route = $value;
					$index = 1;
				
					foreach($matches as $match) {
					
						$route = str_replace(":$index", $match, $route );
						++$index;
					
					}
				
					break;
				
				}
			}
		}
		
		if($route === false) {
			$route = $uri;
		}
		
		$route = explode('/', trim($route,'/'));
		
		if(is_dir('controllers/'.$route[0] .'/'))
			$controller_folder = 'controllers/'.array_shift($route).'/';
		else
			$controller_folder = 'controllers/';
	
		switch(count($route)) {
			
			case 1: 
				$_this->controller = $route[0];
				$_this->method = 'index';
				return array($controller_folder, $route[0], 'index', array()); 
			break;

			case 2: 
				$_this->controller = $route[0];
				$_this->method = $route[1];
				return array($controller_folder, $route[0], $route[1], array()); 
			break;
			
			default:
				$controller = array_shift($route);	
				$method = array_shift($route);
				$_this->controller = $controller;
				$_this->method = $method;
				$_this->args = $route;
				return array($controller_folder, $controller, $method, $route);	

			break;
		}
		
		
	}
	
	static function connect($route=null, $actual_path = null) {
		
		if(is_null($route) || is_null($actual_path)) return false;
		
		$_this = Router::getInstance();
		
		if(strlen($route) > 1)
			$route = rtrim($route,'/');

		if(!isset($_this->routes[$route])) {
			$_this->routes[$route] = $actual_path;
		}
	}
	
	static function getInstance() {

		static $instant;
		if(!is_object($instant)) {
			$instant = new Router();
		}
		return $instant;

	}

}

?>