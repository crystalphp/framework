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

		Bootloader::boot();
		
		define('APP_URL' , str_replace('{servername}' , $_SERVER['HTTP_HOST'] , app::get_config('app')['app_url']));

		
		define('FULL_REQUEST_URI' , $_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = explode('?' , $_SERVER['REQUEST_URI'])[0];

		$app_status = app::get_config('app')['app_status'];
		if($app_status == 'down' || $app_status != 'up'){
			if( ! \Crystal\View\View::system_view('down' , ['default_message' => 'We are down'])){
				die("
		<style>
		body{
			margin: 0;
			padding: 0;
		}
		</style>
		<center style='height: 100%; width: 100%; background-color: rgb(200,200,210); box-sizing: border-box;'><div style='padding-top: 20%;'>We are down</div></center>
		");
			}

			die();
		}


		if( ! isset($_SESSION['csrf_token'])){
			$_SESSION['csrf_token'] = \Crystal\Forms\Csrf::generate();
		}
		
		\Crystal\Http\Middleware::call_requireds();

		if( ! isset($_SESSION[app::get_config('app')['app_name'] . '_session'])){
			$content = 'start_time='.CRYSTAL_START_TIME.';';
			$_SESSION[app::get_config('app')['app_name'] . '_session'] = $content;
			AppEventListener::on_start();
		}

		

		AppEventListener::on_begin_request();

		$router = new Router;

		$router->any('/ajax-handler/{name}' , function($r , $p){
			return \Crystal\Ajax\Ajax::run($p['name']);
		});

		include_once app_path('/app/routes.php');

		$router->finish();

		return;
	}
}
