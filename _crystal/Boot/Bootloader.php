<?php

namespace Crystal\Boot;

use Crystal\App\app;
use Crystal\App\AppEventListener;
use Crystal\View\CViewCompiler;

class Bootloader{
	private static function do_cmd($cmd){
		include_once libs('/Console/Cmd/'.$cmd.'.php');
		$class_name = '\Crystal\Console\Cmd\\' . str_replace('-' , '_' , $cmd);
		$obj = new $class_name;
		echo $obj->handle([]);
		echo '
';
	}


	private static function include_files($files){
		foreach($files as $file){
			if(is_file($file)){
				include_once $file;
			}
		}
	}


	private static function jobs_boot(){
		$jobs = glob(app_path('/jobs/*.php'));
		foreach($jobs as $job){
    		if(is_file($job)){
        		include_once $job;
    		}
		}
	}




	public static function boot(){

	session_start();
	
	if( ! is_dir(app_path('/storage'))){
		mkdir(app_path('/storage'));
	}
    include_once app_path('/app/ExceptionHandler.php');	
	include_once libs('/Exceptions/include.php');
	include_once libs('/App/helpers.php');

	$db_conf = app::get_config('database');
	if($db_conf['use_db']){
		$db_conf = $db_conf['connections'][$db_conf['db']];
		$db_host = $db_conf['host'];
		$db_user = $db_conf['username'];
		$db_pass = $db_conf['password'];
		$db_name = $db_conf['name'];
		\Crystal\Database\DB::connect($db_host , $db_user , $db_pass , $db_name);
	}


	$dirs = [
		'controllers',
		'forms',
		'middlewares',
		'models',
	];
	foreach($dirs as $dir) {
		$files = glob(app_path('/' . $dir . '/*.php'));
		static::include_files($files);
	}

	if(app::get_config('app_debug') == 'true'){
		static::do_cmd('mix-resources');
		CViewCompiler::compile_views();
	}


	if(app::get_config('hide_php_version_header') === true){
		header('X-Powered-By: ');
	}

	$aliases = require libs('/Boot/set_aliases.php');
	foreach($aliases as $key => $value){
		if( ! class_exists($value)){
			class_alias($key , $value);
		}
	}

	include_once app_path('/app/events.php');
	AppEventListener::lock();


	static::jobs_boot();



	}
}
