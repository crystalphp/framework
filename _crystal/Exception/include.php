<?php
ini_set('display_errors', '1');
ini_set('error_reporting', '1');
function crystal_error_handler($errno , $errstr , $file , $line){
	echo make_exception_render('Error' , $errstr , $file , $line - 1);
	die();
}

$ex_s = glob(libs('/Exception/Exceptions/*.php'));
include_once libs('/Exception/BaseException.php');
include_once libs('/Exception/render.php');

set_error_handler('crystal_error_handler' , E_ALL);

foreach($ex_s as $ex){
	if(is_file($ex)){
		include_once $ex;
	}
}
