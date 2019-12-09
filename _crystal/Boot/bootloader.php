<?php


include_once libs('/Boot/APPBoot.php');
include_once libs('/Boot/controllersBoot.php');
include_once libs('/Boot/httpBoot.php');
include_once libs('/Boot/middlewaresBoot.php');
include_once libs('/Boot/dbBoot.php');
include_once libs('/Boot/formsBoot.php');

define('PUBLIC_PATH', str_replace('{apppath}' , app_path() , app::get_config('public_path')));

include_once libs('/Boot/jobsBoot.php');


$app_status_type = app::get_config('app_status')['type'];
if($app_status_type == 'down' || $app_status_type != 'up'){
	die('
<center><h3>We Are Down</h3></center>
');
}

session_start();
if( ! isset($_SESSION[app::get_config('app_name') . '_session'])){
	$content = 'start_time='.CRYSTAL_START_TIME.';';
	$_SESSION[app::get_config('app_name') . '_session'] = $content;
	AppEventListener::on_start();
}

AppEventListener::on_begin_request();

$router = new Router;

if(app::get_config('app_status')['type'] == 'debug'){
	include_once libs('/Console/cmd/mix-resources.php');
	cmd_run([]);
}


include_once app_path('/app/routes.php');





