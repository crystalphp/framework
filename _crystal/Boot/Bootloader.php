<?php

namespace Crystal\Boot;

use Crystal\App\app;
use Crystal\App\AppEventListener;
use Crystal\View\CViewCompiler;
use Crystal\Http\Router;
use Crystal\Forms\Csrf;

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
	
	if( ! is_dir(app_path('/storage'))){
		mkdir(app_path('/storage'));
	}
        include_once app_path('/app/ExceptionHandler.php');	
	include_once libs('/Exceptions/include.php');
	
	$db_conf = app::get_config('database');
	if($db_conf['use_db']){
		$db_conf = $db_conf['connections'][$db_conf['db']];
		$db_host = $db_conf['host'];
		$db_user = $db_conf['username'];
		$db_pass = $db_conf['password'];
		$db_name = $db_conf['name'];
		\Crystal\Database\DB::connect($db_host , $db_user , $db_pass , $db_name);
	}

	if( ! defined('JUST_BOOTLOADERS')){
	
		include_once libs('/App/helpers.php');
		
		static::jobs_boot();

		include_once app_path('/app/events.php');

		
		define('FULL_REQUEST_URI' , $_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = explode('?' , $_SERVER['REQUEST_URI'])[0];

		$aliases = require libs('/Boot/set_aliases.php');
		foreach($aliases as $key => $value){
			if( ! class_exists($value)){
				class_alias($key , $value);
			}
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

		if(app::get_config('hide_php_version_header') === true){
			header('X-Powered-By: ');
		}

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

		if( ! isset($_SESSION['csrf_token'])){
			$_SESSION['csrf_token'] = \Crystal\Forms\Csrf::generate();
		}

		AppEventListener::on_begin_request();

		$router = new Router;


		
		if(app::get_config('app_debug') == 'true'){
			static::do_cmd('mix-resources');
			CViewCompiler::compile_views();
		}



		if(request()->requestMethod() == 'POST'){
			if( ! Csrf::validate(request()->post('csrf_token'))){
				die(httpcode(419));
			}
		}



		include_once app_path('/app/routes.php');
	}






	}
}
