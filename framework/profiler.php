<?php

class Profiler {

	private $benchmarks = array();


	private $thresholds = array(
				'0.0001'  => '#00ff00',
				'0.001'   => '#55ff00',
				'0.005'   => '#aaff00',
				'0.05'    => '#ffff00',
				'0.5'     => '#ffaa00',
				'1'       => '#ff5500',
				'99999'   => '#ff0000');

	public static function run() {

		$_this = Profiler::getInstance();
		$template = Template::getInstance()->assign('__debug', array(
			'database'	=> $_this->db(),
			'action'	=> $_this->action(),
			'memory' 	=> $_this->memory(),
			'cache'		=> $_this->cache(),
			'hooks'		=> $_this->hook(),
            'routes'    => $_this->route(),
			'globals'	=> $_this->globals(),
			'benchmarks'=> $_this->benchmarks()
		));
	}

	private function db() {
		
		$db = Database::getInstance();
		$thresholds = $this->thresholds;
		$querys = $db->querys;

		foreach($querys as &$query) {		
			foreach($thresholds as $time => $color ) {
				if( (float) $query['time'] > (float)$time )
      				$query['color'] = $color;
			}
		}

		return $querys;
    }

	private function globals() {
		global $config;
		
		return array(
			'post'		=> $_POST,
			'get'		=> $_GET,
			'session'	=> $_SESSION,
            'server'    => $_SERVER,
			'config'	=> $config,
			'template'	=> Template::getInstance()->_tpl_vars
		);
	}

	private function benchmarks() {

		$thresholds = $this->thresholds;
		$benchmarks = $this->benchmarks;

		foreach($benchmarks as &$benchmark) {		
			foreach($thresholds as $time => $color ) {
				if( (float) $benchmark['time'] > (float)$time )
      				$benchmark['color'] = $color;
			}
		}

		return $benchmarks;

	}

	static public function start_timer($timer = false) {
		
		if(!$timer || !strlen($timer)) {
			return false;
		}
		$_this = Profiler::getInstance();
		$_this->benchmarks[$timer]['start'] = getmicrotime(); 

	}

	static public function stop_timer($timer = false) {
		
		if(!$timer || !strlen($timer)) {
			return false;
		}
		$_this = Profiler::getInstance();
		$_this->benchmarks[$timer]['stop'] = getmicrotime();
		$_this->benchmarks[$timer]['time'] = round($_this->benchmarks[$timer]['stop'] - 
						($_this->benchmarks[$timer]['start'] - 0.0001), 7); 
		
	}

	private function memory() {
		$memory_usage = memory_get_usage(true);
		return  array(
			'BYTES'	 	=> $memory_usage,
			'KB' => round($memory_usage / 1024,2) ,
			'MB' => round($memory_usage / 1048576,2) 
		);
	}

	private function hook() {

		$hook = Hook::getInstance();
		$thresholds = $this->thresholds;
		$hooks	= $hook->executed; 	

		foreach($hooks as $hook) {	
			foreach($thresholds as $time => $color ) {
				if( (float) $hook['time'] > (float)$time )
      				$hooks['color'] = $color;
			}

		}

		return @$return;
	}
	
	static function getInstance() {
		static $instant;
		if(!is_object($instant)) {
			$instant = new Profiler();
		}
		return $instant;
	}

    private function route() {
        return Router::getInstance()->routes;
    }

	private function cache() {
		return Cache::getInstance()->stats;		
	}

	private function action() {

		global $controller_class, $controller_file, $method, $_controller;
		
		$return = "<table class='main' cellspacing='0'><tr>
						<td class='hilight' width=150>File:</td><td> {$controller_file} </td></tr>";
		$return .= "<tr><td class='hilight' width=150>Controller:</td><td> {$controller_class} </td></tr>";
		$return .= "<tr><td class='hilight' width=150>Action</td><td> {$method} </td></tr>";
		if(is_object($_controller))
			$return .= "<tr><td class='hilight' width=150>Helpers:</td> <td>". print_r( array_keys($_controller->helpers), 1)."</td></tr>";
		
		$return .= "</table><br><br />";
		if(!file_exists($controller_file))
			return $return;


		$haystack = file_get_contents($controller_file);
		
		$start = strpos($haystack,"function $method");
		if(!$start)
			return $return;
	
		$haystack = substr($haystack,$start );	
		
		$stop = strpos($haystack,'function',40);
		if($stop === false)
			$stop = strpos($haystack,'?>',20) ;

		$return .= highlight_string("<?php \r\n ".substr($haystack,0,$stop).'?>',1);
		$return .= "<br /><br /><b>Controller Instant</b><pre>".var_export($_controller,1).'</pre>';
		
		return $return;

	}

}


?>