<?php

namespace Crystal\Boot;

use Crystal\App\app;
use Crystal\App\AppEventListener;
use Crystal\View\CViewCompiler;

class Bootloader{

	private static $aliases = [
	    '\Crystal\App\app' => '\app',
	    '\Crystal\App\AppEventListener' => '\AppEventListener',
    	'\Crystal\Database\DB' => '\DB',
    	'\Crystal\Database\Model' => '\Model',
    	'\Crystal\Http\Cookie' => '\Cookie',
    	'\Crystal\Http\Request' => '\Request',
    	'\Crystal\Utilities\Auth' => '\Auth',
    	'\Crystal\Utilities\File' => '\File',
    	'\Crystal\Utilities\Hash' => '\Hash',
    	'\Crystal\Utilities\Kev' => '\Kev',
    	'\Crystal\Utilities\Session' => '\Session',
    	'\Crystal\Utilities\Str' => '\Str',
    	'\Crystal\View\View' => '\View',
	];

	private static function boot_providers(){
		$providers = glob(app_path('/app/providers/*.php'));

		static::include_files($providers);

		foreach($providers as $provider){
			$class_name = explode('/' , $provider);
			$class_name = $class_name[count($class_name) - 1];

			$class_name = explode('.' , $class_name);
			$class_name = $class_name[0];

			$class_name = '\App\Providers\\' . $class_name;


			$obj = new $class_name;
			$obj->boot();

		}

	}

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
	if( ! is_dir(app_path('/storage/cache'))){
		mkdir(app_path('/storage/cache'));
	}

    include_once app_path('/app/ExceptionHandler.php');	
	include_once libs('/Exceptions/include.php');

	$db_conf = app::get_config('database');
	if($db_conf['use_db']){
		$db_conf = $db_conf['connections'][$db_conf['db']];
		\Crystal\Database\DB::connect($db_conf);
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

	if(app::get_config('app')['app_debug'] == 'true'){
		static::do_cmd('mix-resources');
		CViewCompiler::compile_views();
	}


	if(app::get_config('http')['hide_php_version_header'] === true){
		header('X-Powered-By: ');
	}

	$aliases = static::$aliases;
	foreach($aliases as $key => $value){
		if( ! class_exists($value)){
			class_alias($key , $value);
		}
	}

	static::boot_providers();
	AppEventListener::lock();


	static::jobs_boot();



	}
}
