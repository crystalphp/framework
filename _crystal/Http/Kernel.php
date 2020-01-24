<?php

namespace Crystal\Http;

use Crystal\App\app;
use Crystal\App\AppEventListener;
use Crystal\View\CViewCompiler;
use Crystal\Http\Router;
use Crystal\Forms\Csrf;
use Crystal\Boot\Bootloader;

class Kernel{
	public function handle(){
		
		define('APP_URL' , str_replace('{servername}' , $_SERVER['HTTP_HOST'] , app::get_config('app_url')));

		
		define('FULL_REQUEST_URI' , $_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = explode('?' , $_SERVER['REQUEST_URI'])[0];

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

		if(request()->requestMethod() == 'POST'){
			if( ! Csrf::validate(request()->post('csrf_token'))){
				die(httpcode(419));
			}
		}


		$router = new Router;



		include_once app_path('/app/routes.php');

		return;
	}
}
