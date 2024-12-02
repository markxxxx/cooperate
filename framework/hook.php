<?php declare(strict_types=1)

class Hook {

	private $hooks = array();
	
	public $executed = array();


	static function call($hook_name, $args = array()) {
	

		$_this = Hook::getInstance();
		
		if(!isset($_this->hooks[$hook_name]))
			return true;
		
		$hooks = $_this->hooks[$hook_name];

		foreach($hooks as $hook) {
			
			$call = true;
			
			list($hook_function, $hook_args) = $hook;
			
			if(is_string($hook_function)) {
			
				if(!is_callable($hook_function)) 
					$call = false;

			}
			
			if($call) {
				
				$args = array_merge( $hook_args , $args );
				
				$timer_start = getmicrotime() ;
				$result = call_user_func_array($hook_function, $args);
				$timer_stop = getmicrotime();
				
				$_this->executed[] = array(
					'hook' => $_this->serialize($hook_function),
					'time' => round($timer_stop - ($timer_start - 0.0001), 7),
					'args' => var_export($args,1),
					'name' => $hook_name,
					'result' => $result
				);

			}
		}
	}

	static function register($hook_name=null, $callback=null, $args = array()) {

		if(is_null($hook_name) || is_null($callback)) return false;
		$_this = Hook::getInstance();

		$index = count($_this->hooks);

		$_this->hooks[$hook_name][$_this->serialize($callback)] = array($callback, $args);
		

	}

	static function unregister($hook_name, $callback=null) {
	
		$_this = Hook::getInstance();
		if(is_null($callback)) {
			unset($_this->hooks[$hook_name]);
		} else {
			unset($_this->hooks[$hook_name][$_this->serialize($callback)]);
		}
		
	}

	private function serialize($hook_name) {
		if(is_array($hook_name))
			$hook_name = implode('::', $hook_name);
		return $hook_name;
	}

	private function unserialize($hook_name) {
		if(strpos($hook_name,'::'))
			$hook_name = explode('::', $hook_name);
		return $hook_name;
	}
	
	static function getInstance() {

		static $instant;
		if(!is_object($instant)) {
			$instant = new Hook();
		}
		return $instant;

	}

}


?>