<?php

class CacheStorageMemcache extends Cache {
	
	private $engine = null;


	public function __construct($settings) {
		parent::__construct($settings);
		$this->connect();
	}
	
	public function test() {

		if(!extension_loaded('memcache') || !class_exists('Memcache'))
			return false;
    	
    	if(!array($this->setting->servers))
      		return false;
      		
      	foreach($this->setting->servers as $server) {
      	
      		if($memcache = memcache_connect($server['host'], $server['port'])) {
      			memcache_close($memcache);
      			return true;
      		}
      		
      	}
      	
      	return false;	
	}
	
	public function connect() {
	
		if(!$this->test())
			die('CacheStorageMemcache::connect() error connecting to server');
		
		$this->engine = new Memcache;
		
		foreach($this->setting->servers as $server) {
			$this->engine->addServer($server['host'], $server['port'], $this->settings->persistent);
		}
	
	}
	
	public function store($key,$data,$lifetime=null) {
		if(is_null($lifetime)) 
			$lifetime = $this->settings->lifetime;
		$key = $this->hash($key);
		$this->engine->set($cache_id, $data, $this->settings->compress, $lifetime);
	}
	
	public function get($key) {
		$key = $this->hash($key);
		return $this->engine->get($key);
	
	}
	
	public function delete($key) {
		$key = $this->hash($key);
		$this->engine->delete($cache_id);
	
	} 

}


?>