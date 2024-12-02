<?php

class Cache {

    private $engines = array('file','apc','memcache');
    private $storage;
    public $stats = array('hits'=>array(),'misses'=>array(),'recached'=>array());


    public function __construct() {
    
		global $config;
        $settings = $config['cache'];
        $settings['storage'] = strtolower($settings['storage']);
        
        if(!array_key_exists($settings['storage'], $this->engines)) {
            
            $cache_engine = 'CacheStorage'.ucfirst($settings['storage']);
			include 'cache/'.$settings['storage'].'.php';
            $this->storage = new $cache_engine($settings);
            
        } else {
            Error('Cache::__construct',"Cache engine not found - {$engine}");
        }
        
    }
    
    static public function getInstance() {
        
        static $instant;
        
        if(!is_object($instant)) {
            $instant = new Cache();  
        }
    
        return $instant;
    }

    static public function get($key, $save_handle=null) {
    
        $_this = Cache::getInstance();

        if(($cache = $_this->storage->get(md5($key))) !== false) {
        
            $_this->stats['hits'][] = $key;
            return $cache;   
    
        } else {
            $_this->stats['misses'][] = $key;
            
            if(is_callable($save_handle)) {
            
                if(($results = $save_handle()) !== false) {
                    list($duration , $data) = $results;
                    $_this->storage->set(md5($key), $data , $duration);
                    $_this->stats['recached'][] = $key;
                    return $data;
                }
                
            }
            
        }
        
        return false;
    }
    
    static public function set($key, $data, $duration=false) {
        
        if(!$data) {
            return false;
        }
        
		$_this = Cache::getInstance();
        $_this->stats['recached'][] = $key;
        $_this->storage->set(md5($key), $data, $duration);
    }
    
    static public function delete($key) { 
        $_this = Cache::getInstance();
        $_this->storage->delete(md5($key));
    }

    static public function delete_all() { 
        $_this = Cache::getInstance();
        $_this->storage->delete_all();
    }

}
?>