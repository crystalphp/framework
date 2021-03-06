<?php

ini_set('display_errors' , '0');

function crystal_error_handler($errno , $errstr , $file , $line){
	\Crystal\Http\Router::$do_finish = false;
	if($_SERVER['REQUEST_METHOD'] != 'console'){
		ob_clean();
	}
	$tmp = new \App\ExceptionHandler;
	echo $tmp->handle(new \Crystal\Exceptions\Error([$errno , $errstr , $file , $line]));
	die();
}

function crystal_shutdown_handler(){
	$le = error_get_last();
	if($le !== null){
		crystal_error_handler($le['type'] , $le['message'] , $le['file'] , $le['line']);
	}
}

register_shutdown_function('crystal_shutdown_handler');

$ex_s = glob(libs('/Exceptions/Exceptions/*.php'));
include_once libs('/Exceptions/render.php');



set_error_handler('crystal_error_handler' , E_ALL);

foreach($ex_s as $ex){
	if(is_file($ex)){
		include_once $ex;
	}
}
