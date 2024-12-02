<?php

function smarty_function_mime_type($params) {

	global $config;
	$filename = isset($params['filename']) ? $params['filename'] : Error('smarty_function_mime_type','param `filename` Required');
    $size = isset($params['size']) ? $params['size'].'/' : '';
    
	$ext = strtolower(substr(strrchr($filename, '.'), 1));


	$path = $config['site']['domain'] . "/views/app/mimes/".$size;
	if(isset($params['rel_path'])) {
		$path = $_SERVER['DOCUMENT_ROOT']."views/app/mimes/".$size;
	}

	
	switch($ext)
	{
		case 'zip': case 'tgz': case 'tar': case 'tgz2': case 'gz': $scr = $path."cab.png";
		break;
		case 'mp3': case 'mpeg': case 'mpg': case 'wma': case 'avi': $scr = $path."wav.png";
		break;
		case 'asm': case 'php': case 'cpp': case 'h': case 'pas': case 'c': case 'sh': case 'jar': case 'java' :$scr = $path."source_s.png";
		break;	
		case 'bmp':  case 'gif': $scr = $path."bmp.png";
		break;
		case 'doc': case 'txt': case 'odt': $scr = $path."wordprocessing.png";
		break;
		case 'exs': case 'exl':  $scr = $path."kword_kwd.png";
		break;
		case 'html': case 'htm': case 'xlsd': case 'css': $scr = $path."mozilla_doc.png";
		break;
		case 'pdf': case 'chm':$scr = $path."pdf.png";
		break;
		case 'pps': case 'ppt': $scr = $path."vcard.png";
		break;
		case 'mdb': $scr = $path."msexcel.png";
		break;
		case 'png': $scr = $path."png.png";
		break;
		case 'jpg': case 'jpeg': $scr = $path."jpg.png";
		break;
		default : $scr = $path."source_y.png";
		break;
	}
	echo "<img src='{$scr}' >";
}