<?php

DEFINE('MINUTE'	,60); 
DEFINE('HOUR'	,3600);
DEFINE('DAY'	,HOUR * 24);


function is_assoc($array) {
    return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
}

function slug($string) {
    $str = strtolower(trim($string));
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', "-", $str);
    return $str;
}

function escape ($value) {
    $value = is_array($value) ? array_map('escape', $value) : addslashes($value);
	return $value;
}

function strip($value) {    
    if(is_object($value)) {
        return $value;
    }
	$value = is_array($value) ? array_map('strip', $value) : stripslashes($value);
	return $value;
}

function mb_unserialize($value) {
  $out = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $value );
  return unserialize($out);
}

function getmicrotime() {
	list($usec, $sec) = explode(" ",microtime());
	return ((float)$usec + (float)$sec);
}

function __autoload($file) {

	$file = strtolower($file);
    
    //***************************
	//phpexcelhack for autoloader
    //***************************
    
    if( ($pos = strpos($file, 'phpexcel')) !== false ) {     
		if ((class_exists($file,FALSE)) || (strpos($file, 'PHPExcel') !== 0)) {
			return FALSE;
		}
		$file_path = '/include/' . str_replace('_',DIRECTORY_SEPARATOR,$file) .'.php';
		if ((file_exists($file_path ) === false) || (is_readable($file_path) === false)) {

			return FALSE;
		}
        include_once $file_path;
	}
	if( ($pos = strpos($file, 'controller')) === false ) { 

        //**********************************************
        // Need a proper autoloader
        //**********************************************


        if(!file_exists(ROOT.'/models/'.$file.'.php')) {
            $filename = mb_strtolower($file) . ".cls.php";
            // require_once(DOMPDF_INC_DIR . "/$filename");
        } else {
            include_once ROOT.'/models/'.$file.'.php';
        }

	} else {
		include_once ROOT.'/controllers/'.substr($file, 0 , $pos).'_controller.php';
	}
	
}

function d() {
	for ($i = 0, $count = func_num_args(); $i < $count; $i++) {
		echo "<pre>";
			var_dump( func_get_arg($i) );
		echo "</pre>";
	}
}

function Error($type , $error_msg) {
    
	global $controller, $method , $args, $config;
	$params = print_r($args,1);
    
    $last_error = print_r(error_get_last(),1);

    $error_msg .= "<br /><br /><i> Action: {$controller}->{$method}({$params})</i>" ; 
    $output = '<div style="padding: 15px; border: 1px solid #F99; background-color: #FFF0F0; margin: 20px; font-family: Arial, Helvetica, sans-serif; font-size: 12pt;">'.
		    '<br/><h2 style="margin: 0px 0px 5px; color: #C30;">'.$type.'</h2><br /><div style=" color:#000;">' . "\n\n "  . '<BR>'.$error_msg.'<br />DEBUG TRACE <pre>'.$last_error.'<br />'.print_r(debug_backtrace(),1).'</pre></div>';
    
    if($config['error']['mail']) {
        foreach($config['error']['mail_to'] as $email) {
            _mail($email,'Error on '.$config['site']['name'],$output);
        }
    }
    
    if($config['error']['display']) {
	    die($output);
    } else {
        header('location:'.$config['error']['error_page']);
        die();
    }
    
}

function _mail($to, $subject, $body, $aheaders=null) {
/*
    global $config;
    $mail = SendMail::getInstance();
    $mail->ClearAllRecipients();
    $mail->AddAddress($to);
    $mail->SetFrom($config['site']['email_noreply'] , $config['site']['email_from']);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $mail->Send();*/
    global $config;
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    if(!is_null($aheaders))
        $headers .= $aheaders;
    else
        $headers .= "From: {$config['site']['email_from']} <{$config['site']['email_noreply']}>" . "\r\n";
    
    return mail($to, $subject, $body, $headers);
}

function mail_template($tpl, $to, $subject, $vars=array()) {
    $body = parse_tpl('mail',$tpl, $vars);
    return _mail($to, $subject, $body);
}

function parse_template($theme, $tpl, $vars) {
    $template = Template::getInstance(); 
    $tpl = "../../views/{$theme}/{$tpl}.tpl";
    $template->assign($vars);
    return $template->fetch($tpl);
}

//deprecated
function parse_tpl($theme, $tpl, $vars) {
    return parse_template($theme, $tpl, $vars);
}

?>