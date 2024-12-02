<?php


include("controller/compressor.php");
include("libs/php/view.php"); //Include this for path getting help
include("libs/php/user_agent.php"); //Include this for getting user agent


## Access control
$compress_options['username'] = $config['compressor']['username'];
$compress_options['password'] = $config['compressor']['password'];
## Path info
$compress_options['javascript_cachedir'] = $config['compressor']['cache_dir'];
$compress_options['css_cachedir'] = $config['compressor']['cache_dir'];
## Comma separated list of JS Libraries to include
$compress_options['js_libraries'] = "";
## Ignore list
$compress_options['ignore_list'] = $config['compressor']['ignore_list'];
## Minify options
$compress_options['minify']['javascript'] = "1";
$compress_options['minify']['page'] = "1";
$compress_options['minify']['css'] = "1";
## Gzip options
$compress_options['gzip']['javascript'] = "1";
$compress_options['gzip']['page'] = "1";
$compress_options['gzip']['css'] = "1";
## Versioning
$compress_options['far_future_expires']['javascript'] = "1";
$compress_options['far_future_expires']['css'] = "1";
## On or off 
$compress_options['active'] = "1";
## Display a link back to PHP Speedy
$compress_options['footer']['text'] = "0";
$compress_options['footer']['image'] = "0";
## Should Speedy Clean Up the cache directory?
$compress_options['cleanup']['on'] = "1";
## Should Speedy use data URIs for background images?
$compress_options['data_uris']['on'] = "0";

//Con. the view library
$view = new compressor_view();

//Con. the user agent library
$user_agent = new _speedy_User_agent();

//Con. the js min library
if(substr(phpversion(),0,1) == 5) {
require_once('libs/php/jsmin.php');
$jsmin = new JSMin($contents);
}

//Con. the compression controller
$compressor = new compressor(array('view'=>$view,
								   'options'=>$compress_options,
								   'jsmin'=>$jsmin,
								   'user_agent'=>$user_agent)
							 );
?>