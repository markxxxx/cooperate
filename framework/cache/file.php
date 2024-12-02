<?php declare(strict_types=1)

class CacheStorageFile {
    
    private $settings = array();
    
    public function __construct($settings) {
        $this->settings = $settings;
    }
    
    function set($key,$data,$ttl) {
		
		if(!$ttl) {
			$ttl = $this->settings['lifetime'];
		}
        $h = fopen($this->get_file($key),'w');
        if (!$h) 
            Error('CacheStorageFile::set','Permission denied in '.$this->get_file($key));
        $data = serialize(array(time()+$ttl,$data));
        
        if (fwrite($h,$data)===false) {
            Error('CacheStorageFile','Could not write to cache');
        }
        fclose($h);
        
    }
    
    private function get_file($key) {
        return $this->settings['cache_dir'].'/'.$key;
    }

    public function get($key) {
        $filename = $this->get_file($key);
        if (!file_exists($filename) || !is_readable($filename)) 
            return false;
        
        $data = file_get_contents($filename);
        $data = @unserialize($data);
        
        if (!$data) {
            unlink($filename);
            return false;
        }

        if (time() > $data[0]) {
            unlink($filename);
            return false;
        }
        return $data[1];
    }

	public function delete($key) {
        if(file_exists($this->get_file($key))) {
		    unlink($this->get_file($key));
        }
	}
    
    public function delete_all() {
        foreach( glob($this->settings['cache_dir'].'/*') as $cache_file) {
            unlink($cache_file) ;
        }
    }
    
}

?>