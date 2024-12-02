<?php declare(strict_types=1)

include_once 'include/xmlrpc.php';

class SV_client extends IXR_Client {

    var $user_id = 0;
    
    public function __construct() {
        parent::__construct('http://www.studentvillage.co.za/server.php');
    }
    
    
    static public function getInstance() {
    
        static $instant;
        if(!is_object($instant)) {
            $instant = new SV_Client();
        }
        
        return $instant;
    }
    
    function call($function = null,$args = null) {
    
        if(is_null($function)) return false;
        
        $_this = SV_Client::getInstance();


        
        $params = array();
        
        if(!is_null($args)) {
            $params = $args;
        } else {
            $params = array($_this->user_id);
        }
        
        if (!$_this->query($function, $params)) {
            die('An error occurred - '.$_this->getErrorCode().":".$_this->getErrorMessage());
        }
        
        return $_this->getResponse();
    
    }
 
}

?>