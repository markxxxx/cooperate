<?php



// $servername = "localhost";
// $username = "magnak_user";
// $password = "QA$*.kI0o]XtFA+";
// $dbname = "db_magnak";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }else{
//     die("Connection made: " . $conn->connect_error);
// }


error_reporting(E_ALL);
ini_set('display_errors', 1);

error_log("start top",3,'errorlog.txt');

//This flag is for cron identification
define('PAGE', TRUE);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)));

include 'config.php';
define('DEBUG', $config['debug']);

set_include_path(get_include_path() . PATH_SEPARATOR . realpath("./"));

include 'framework'.DS.'basics.php';
include 'framework'.DS.'validate.php';
include 'framework'.DS.'cache.php';
include 'framework'.DS.'database.php';
include 'framework'.DS.'result.php';
include 'framework'.DS.'tablestructure.php';
include 'framework'.DS.'model.php';
include 'framework'.DS.'controller.php';
include 'framework'.DS.'template.php';
include 'framework'.DS.'profiler.php';
include 'framework'.DS.'hook.php';
include 'framework'.DS.'router.php';
include 'framework'.DS.'mail.php';

DEBUG ? Profiler::start_timer('application') : null;

include 'hooks.php';
include 'routes.php';

session_start();

error_log("start session",3,'errorlog.txt');

$_POST = escape($_POST);
$_GET = escape($_GET);
$_COOKIE = escape($_COOKIE);

$template = Template::getInstance();

Hook::call('before_route');

list($controller_folder, $controller, $method, $args) = Router::parse();

Hook::call('after_route');

$controller_file = $controller_folder . $controller . '_controller.php';
$controller_class = ucfirst($controller) . 'Controller';
$application_controller = $controller_folder . 'app_controller.php';
$application_model = 'models'.DS.'app.php';

if (file_exists($application_controller)) {
    include_once $application_controller;
}

if (file_exists($application_model)) {
    include_once $application_model;
}

$template->set_view($controller . '_' . $method);

error_log("setview",3,'errorlog.txt');

DEBUG ? Profiler::start_timer('controller') : null;

if (file_exists($controller_file)) {

    include_once $controller_file;

    if (class_exists($controller_class)) {

        $_controller = new $controller_class();
        $_controller->before_action();

        if (method_exists($_controller, $_controller->method_name)) {

            if (!$_controller->is_cached()) {

                /**
                 * Provides an OO wrapper for call_user_func_array, 
                 * and improves performance by using straight method calls in most cases.
                 * */
                switch (count($args)) {
                    case 0:
                        $_controller->{$_controller->method_name}();
                        break;
                    case 1:
                        $_controller->{$_controller->method_name}($args[0]);
                        break;
                    case 2:
                        $_controller->{$_controller->method_name}($args[0], $args[1]);
                        break;
                    case 3:
                        $_controller->{$_controller->method_name}($args[0], $args[1], $args[2]);
                        break;
                    case 4:
                        $_controller->{$_controller->method_name}($args[0], $args[1], $args[2], $args[3]);
                        break;
                    default:
                        call_user_func_array(array($_controller, $_controller->method_name), $args);
                        break;
                }
            }

            $cache_id = $_controller->cache_id;
        }
        $_controller->after_action();
    }
}

error_log("controllers loaded",3,'errorlog.txt');

DEBUG ? Profiler::stop_timer('controller') : null;

Hook::call('before_render');

$template->assign('config', $config);

$template->load_filter('output', 'move_to_head');

DEBUG ? Profiler::stop_timer('application') : null;
DEBUG ? Profiler::run() : null;

$template->render(isset($cache_id) ? $cache_id : 0);

Hook::call('after_render');

error_log("index end",3,'errorlog.txt');

?>