<?php

$config['public_holidays'] = array(
        '2015-04-03' => 'Good Friday',
        '2015-04-06' => 'Family Day',
        '2015-04-27' => 'Freedom Day',
        '2015-05-01' => "Workers' Day",
        '2015-06-16' => 'Youth Day',
        '2015-08-10' => "National Women's Day",
        '2015-09-24' => 'Heritage Day'
);

$config['database'] = array(
    'server' => 'localhost',
    'username' => 'yourtctw_ytuser',
    'password' => ')I6q1hcRdSGK',
    'database' => 'yourtctw_cooperate',
    'cache' => 0
);

$config['company'] = array(
    'name' => 'Cooperate',
    'tel' => '011 012 0310',
    'fax' => '011 012 0311',
    'email' => 'admin@yourtrack.co.za',
    'address' => 'Online Only',
    'town'=>'Johannesburg, Gauteng'
);

$config['cache'] =  array(
    'storage' => 'file',
    'lifetime' => 120,
    'cache_dir' => ROOT . DS . 'tmp/cache',
    'servers' => array(),
    'compress' => 0,
    'persistent' => 0
);

$config['smtp'] =  array(
    'host' => '',
    'username' => '',
    'password' =>''
);

$config['error'] = array(
    'display' => 1,//if display is 0 it will redirect
    'mail'  => 0,
    'mail_to' => array('','',''),
    'error_page' => '/error/unexpected'
);

$config['compressor'] = array(
    'enabled'  => '0',
    'username' => '21232f297a57a5a743894a0e4a801fc3',
    'password' => '887c2b4cd4563c224f0865d68bf3597b',
    'cache_dir' => ROOT . DS . 'tmp/compressor',
    'ignore_list' => ''
);

$config['site'] = array(
    'email_from' => 'Cooperate',
    'email_noreply' => 'noreply@yourtrack.co.za',
    'email_contact_us' => array(''),
    'name' => 'Cooperate',
    'domain' => 'http://cooperate.yourtrack.co.za/',
    'root'	=> ROOT . DS
);

$config['sms'] = array(
    'email' => 'nomonde@magnak.co.za',
    'token' => '85b0b2f8-4e2c-4015-baf7-80cdee29e996'
);

$config['template'] = array(
    'theme' => 'coact',
    'cache' => 1
);

$config['facebook'] = array(
    'secert_key' => '',
    'app_id' => '',
    'api_key' => ''
);

$config['posterous'] = array(
    'site' => '',
    'user_id' => ''
);

$config['debug'] =1;

$config['language'] = 'en_GB';

date_default_timezone_set('Africa/Johannesburg');
	


?>
