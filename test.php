<?php

//-----------------------------
/**Run this every 5 minutes **/
//-----------------------------


//This is a flag used for idenitifing 
//if the request came from the cron 
define('PAGE', FALSE);



define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)));

include 'config.php';
define('DEBUG', $config['debug']);

set_include_path(get_include_path() . PATH_SEPARATOR . realpath("./"));

include 'framework/basics.php';
include 'framework/validate.php';
include 'framework/cache.php';
include 'framework/database.php';
include 'framework/result.php';
include 'framework/tablestructure.php';
include 'framework/model.php';
include 'framework/controller.php';
include 'framework/template.php';
include 'framework/profiler.php';
include 'framework/hook.php';
include 'framework/router.php';
include 'models/app.php';
//include 'include/simple_html_dom.php';


include 'hooks.php';
include 'routes.php';

$template = Template::getInstance();

Message_template::send_custom();

//$cron_controller->execute();

?>