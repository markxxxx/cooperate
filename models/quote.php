<?php

class Quote extends Model {
	
	const table = 'quotes';
	public $cache = true;
    
    private $permissions = array();
    
    public $validate = array(
        // 'not_null' => array('quantity'),
        // 'email' => array('')
    );

    public function __construct($id) {        
        global $config;       
        parent::__construct($id);
        
    }

}

?>