<?php


include_once libs('/Boot/APPBoot.php');
include_once libs('/Boot/controllersBoot.php');
include_once libs('/Boot/httpBoot.php');
include_once libs('/Boot/middlewaresBoot.php');
include_once libs('/Boot/dbBoot.php');
include_once libs('/Boot/formsBoot.php');

unset($GLOBALS['controllers']);
unset($GLOBALS['models']);
unset($GLOBALS['model']);
unset($GLOBALS['forms']);
unset($GLOBALS['form']);
unset($GLOBALS['middleware']);
unset($GLOBALS['middlewares']);
unset($GLOBALS['controller']);
unset($GLOBALS['db_conf']);
unset($GLOBALS['db_host']);
unset($GLOBALS['db_user']);
unset($GLOBALS['db_pass']);
unset($GLOBALS['db_name']);
unset($GLOBALS['result']);


include_once libs('/Boot/pluginsBoot.php');


define('PUBLIC_PATH', str_replace('{apppath}' , app_path() , app::get_config('public_path')));

include_once libs('/Boot/jobsBoot.php');


$app_status_type = app::get_config('app_status')['type'];
if($app_status_type == 'down' || $app_status_type != 'up'){
	die('
<center><h3>We Are Down</h3></center>
');
}

if(! isset($_SESSION)){
	session_start();
}
if( ! isset($_SESSION[app::get_config('app_name') . '_session'])){
	$content = 'start_time='.CRYSTAL_START_TIME.';';
	$_SESSION[app::get_config('app_name') . '_session'] = $content;
	AppEventListener::on_start();
}

AppEventListener::on_begin_request();

$router = new Router;


function do_cmd($cmd){
	include_once libs('/Console/cmd/'.$cmd.'.php');
	cmd_run([]);
}
if(app::get_config('app_status')['state'] == 'debug'){
	do_cmd('mix-resources');
	CViewCompiler::compile_views();
}


include_once app_path('/app/routes.php');





