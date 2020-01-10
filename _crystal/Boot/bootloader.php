<?php

$bootloaders = [
	'utilitiesBoot',
	'APPBoot',
	'controllersBoot',
	'httpBoot',
	'middlewaresBoot',
	'dbBoot',
	'formsBoot',
];

foreach($bootloaders as $bootloader){
	include_once libs('/Boot/' . $bootloader . '.php');
}

use Crystal\App\app;
use Crystal\App\AppEventListener;
use Crystal\App\CViewCompiler;
use Crystal\Http\Router;
if( ! defined('JUST_BOOTLOADERS')){

include_once libs('/Exception/include.php');

include_once libs('/Boot/pluginsBoot.php');


include_once libs('/Boot/jobsBoot.php');


$app_status = app::get_config('app_status');
if($app_status == 'down' || $app_status != 'up'){
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


function do_cmd($cmd){
	include_once libs('/Console/cmd/'.$cmd.'.php');
	cmd_run([]);
}
if(app::get_config('app_debug') == 'true'){
	do_cmd('mix-resources');
	CViewCompiler::compile_views();
}




$variables_to_unset = [
	'controllers',
	'models',
	'model',
	'forms',
	'form',
	'middleware',
	'middlewares',
	'controller',
	'db_conf',
	'db_host',
	'db_user',
	'db_pass',
	'db_name',
	'result',
	'files',
	'file',
	'ex',
	'ex_s',
	'app_path',
	'bootloaders',
	'bootloader',
	'plugins',
	'plugin',
	'pn_tmp',
	'app_status_type',
	'content',
];
foreach($variables_to_unset as $vtu){
	unset($GLOBALS[$vtu]);
}
unset($GLOBALS['variables_to_unset']);
unset($GLOBALS['vtu']);




include_once app_path('/app/routes.php');
}





