<?php

namespace Crystal\Boot;

use Crystal\App\app;
use Crystal\App\AppEventListener;
use Crystal\App\CViewCompiler;
use Crystal\Http\Router;
use Crystal\Forms\Csrf;

class Bootloader{
	public static function do_cmd($cmd){
		include_once libs('/Console/cmd/'.$cmd.'.php');
		cmd_run([]);
	}


	public static function include_files($files){
		foreach($files as $file){
			if(is_file($file)){
				include_once $file;
			}
		}
	}




	public static function boot(){
	
	if( ! is_dir(app_path('/storage'))){
		mkdir(app_path('/storage'));
	}
	
	if( ! defined('JUST_BOOTLOADERS')){

		include_once libs('/Exceptions/include.php');
		include_once libs('/App/helpers.php');
		include_once libs('/Boot/pluginsBoot.php');
		include_once libs('/Boot/jobsBoot.php');
		include_once app_path('/app/events.php');
		include_once app_path('/app/Exception.php');
		include_once libs('/Http/include.php');

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


		$db_conf = app::get_config('database');
		if($db_conf['use_db']){
			$db_conf = $db_conf['connections'][$db_conf['db']];
			$db_host = $db_conf['host'];
			$db_user = $db_conf['username'];
			$db_pass = $db_conf['password'];
			$db_name = $db_conf['name'];
			\Crystal\Database\DB::connect($db_host , $db_user , $db_pass , $db_name);
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
