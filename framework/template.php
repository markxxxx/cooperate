<?php

include_once ROOT.DIRECTORY_SEPARATOR.'include/smarty_new/libs/Smarty.class.php';

function smarty_block_nocache($param, $content, &$smarty) {
    return $content;
}

class Template extends Smarty {
	
	private $view;
	private $theme;
    private $compress;
    
	
	public function __construct() {
    
		global $config;
        parent::__construct();

		$this->set_theme($config['template']['theme']);
		$this->caching		= 0;
 		$this->cache_dir	= 'tmp/smarty';
		$this->plugins_dir	= array(ROOT.'/views/plugins','plugins','\views\plugins');
        //$this->compile_check = false; 
        $this->register_block('nocache', 'smarty_block_nocache', false);
        $this->compress = $config['compressor']['enabled'];

	}

	public function update_paths() {
		$this->template_dir = ROOT.DIRECTORY_SEPARATOR.'views/'.$this->theme;
		$this->compile_dir = ROOT.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR.'templates_c/'.$this->theme;
	}

	static public function getInstance() {
		static $instant;
		if(!is_object($instant)) {
			$instant = new Template();
		}
		return $instant;
	}

	public function render($cache_id = 0) {

        if(!is_dir($this->compile_dir)) {
            @mkdir($this->compile_dir, 0755);
        }
		
        $this->_tpl_vars = strip($this->_tpl_vars);
		$tpl_path = $this->template_dir.DIRECTORY_SEPARATOR.$this->view;
		if(!file_exists($tpl_path)) {
			$tpl_path = ROOT.DIRECTORY_SEPARATOR.'views/default/'.$this->view;
			if(!file_exists($tpl_path))
				$tpl_path = ROOT.DIRECTORY_SEPARATOR.'views/default/'.'error_404.tpl';
		}
		
        if($this->compress) {
            global $config;
            require('include/compressor/php_speedy.php');
        }
        
		$this->display($tpl_path, $cache_id);
        
        if($this->compress) {
            $compressor->finish();
        }
        
        
	}
    
    public function error($field, $rule=null) {
        if(!is_array($field)) {
            $this->_tpl_vars['validation_errors'][$field] = $rule;
        } else {
            foreach($field as $f => $rule) {
                $this->_tpl_vars['validation_errors'][$f] = $rule;
            }
        }
        
    }

    #hack to fix smarty permission;s
    public function clear_all_cache($exp_time = NULL) {
    
        parent::clear_all_cache($exp_time);
        chmod($this->cache_dir, 0755);
    }

	public function get_theme() {
		return $this->theme;
	}
	
	public function set_theme($theme) {
		$this->theme = $theme;
		$this->update_paths();
	}

	public function set_view($view) {
		$this->view = $view.'.tpl';
	}
	
	public function get_view() {
		return $this->view;
	}

}

?>
