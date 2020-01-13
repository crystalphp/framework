<?php

$path = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];
if(is_file($path)){
	$type = mime_content_type($path);
	header('Content-type: ' . $type);
	readfile($path);
	die();
}
unset($path);

if( ! function_exists('app_path')){
	function app_path($path=''){
	    return APP_PATH . $path;
	}
}

if( ! function_exists('libs')){
	function libs($path=''){
	    return app_path('/_crystal' . $path);
	}
}

define('CRYSTAL_START_TIME' , microtime());

include_once app_path('/vendor/autoload.php');
\Crystal\Boot\Bootloader::boot();
