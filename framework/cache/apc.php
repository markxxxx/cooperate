<?php declare(strict_types=1)

class CacheStorageAPC {
    
    private $settings = array();
    
    private function test() {
        return function_exists('apc_add');
    }
    
    public function __construct($settings) {
    
        $this->settings = $settings;
        
        if(!$this->test()) {
            Error('CacheStorageAPC', 'APC not installed');
        }
    }
    
    public function set($key,$data,$ttl) {
        apc_add($key,$data,$ttl);
    }
    
    public function get($key) {
        return apc_fetch($key);
    }

	public function delete($key) {
       apc_delete($key);
	}
    
    public function delete_all() {
        apc_clear_cache();
    }
}
?>