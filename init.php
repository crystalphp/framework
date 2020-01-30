<?php





if( ! function_exists('app_path')){
	function app_path($path=''){
	    return APP_PATH . $path;
	}
}

if( ! function_exists('libs')){
	function libs($path=''){
	    return app_path('/vendor/crystalphp/crystal/src/Crystal' . $path);
	}
}

define('CRYSTAL_START_TIME' , microtime());

require_once app_path('/vendor/autoload.php');

if(\Crystal\Http\Response::handle_file_request()){
	return FALSE;
}

$app = new \Crystal\Http\Kernel;
return $app->handle();
