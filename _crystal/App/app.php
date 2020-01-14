<?php

namespace Crystal\App;

use Crystal\Middlewares\Middleware;
use Crystal\Http\Request;
use Crystal\Utilities\KEVRender;


class app{
	public static function controller($action , $middlewares=[] , $params=[])
	{
		$tmp = $action;
		$action = explode('@' , $action);

		$controller_name = explode('\\', $action[0]);
    	$controller_name = $controller_name[count($controller_name) - 1];

		if(count($action) != 2){
			throw new \Crystal\Exceptions\InvalidRouteActionFormat([$tmp]);
		}

		Middleware::call_list($middlewares);
		$action[0] = '\Controllers\\' . $action[0];
		if( ! class_exists($action[0])){
			throw new \Crystal\Exceptions\ControllerNotFound([$action[0]]);
		}

		$controller_obj = new $action[0];

		if( ! method_exists($controller_obj , $action[1])){
			throw new \Crystal\Exceptions\ControllerNotHaveFunction([$action[0] , $action[1]]);
		}

		$method_reflection = new \ReflectionMethod($controller_obj, $action[1]);
    	if( ! $method_reflection->isPublic()){
    		
    		throw new \Crystal\Exceptions\ControllerMethodIsNotPublic([$controller_name , $action[1]]);
    		
    	}

		$func_name = $action[1];
		$req = new Request;
		$res = call_user_func_array([$controller_obj , $func_name], [$req , $params]);
		echo \Crystal\Controllers\Controller::make_output($res);
	}

	public static function get_config($key=null)
	{
		include_once libs('/App/helpers.php');
		$configs = require app_path('/app/config.php');
		if($key !== null){
			return $configs[$key];
		}
		return $configs;
	}

	public static function view($name, $data = null, $include=false)
	{
		$path = app_path('/storage/viewcache/' . $name . '.cv.php');

		if( ! is_file($path)){
			throw new \Crystal\Exceptions\ViewNotFound([$name]);
		}

		if($include){
			include $path;
			return '';
		}
		
		ob_start();
		include $path;
		$content = ob_get_clean();

		if(app::get_config('clean_views_output') === true){
			$content = str_replace('
', '', $content);
			$content = str_replace('	', '', $content);
		}

		return $content;
	}

	public static function env($key , $default=null){
		$result = KEVRender::render_by_file(app_path('/.env'));
		if(isset($result[$key])){
			return $result[$key];
		}else{
			return $default;
		}
	}
}

define('APP_URL' , str_replace('{servername}' , $_SERVER['HTTP_HOST'] , app::get_config('app_url')));









