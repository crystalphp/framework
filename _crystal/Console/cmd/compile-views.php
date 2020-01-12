<?php





function cmd_run($args){
	$_SERVER['SERVER_NAME'] = 'localhost';
    $_SERVER['SERVER_PORT'] = '8000';
    $_SERVER['REQUEST_URI'] = '/';
    $_SERVER['REQUEST_METHOD'] = 'get';
	define('JUST_BOOTLOADERS' , true);
	include_once libs('/init.php');
	\Crystal\App\CViewCompiler::compile_views();
	echo 'all of views compiled';
}
