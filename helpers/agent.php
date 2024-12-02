<?php


class agent {
    
    private $info = array();
    
    public function __construct() {
        
        if(!function_exists('get_browser')) {
            Error('helper::agent', 'get_browser not found');
        }
        
        $this->info = get_browser(null, true);
    
    }
    
    public function is_bot() {
        return $this->info['crawler'] ? true : false;
    }
    
    public function is_mobile() {
        return $this->info['ismobiledevice'] ? true : false;
    }
    
    public function is_ie_6() {
        return  (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.') !== FALSE);

    }

    public function is_ie() {
        return (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE);
    }
    
    public function is_ajax() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
            return true;
        } else {
            return false;
        }
    }
    
    
}



?>