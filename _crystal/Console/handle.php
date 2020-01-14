<?php

function app_path($path=null){
	return APP_PATH . $path;
}
function libs($path){
	return APP_PATH . '/_crystal' . $path;
}

$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '8000';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['REQUEST_METHOD'] = 'console';
$_SERVER['HTTP_HOST'] = 'localhost';
define('JUST_BOOTLOADERS' , true);
include app_path('/vendor/autoload.php');
\Crystal\Boot\Bootloader::boot();

\Crystal\Console\Handler::handle($argv);
