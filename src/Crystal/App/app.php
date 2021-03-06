<?php

namespace Crystal\App;

use Crystal\Http\Middleware;
use Crystal\Http\Request;
use Crystal\Utilities\KEVRender;


class app{

	private static $loaded_config = null;

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
		return \Crystal\Http\Controller::make_output($res);
	}

	public static function get_config($key=null)
	{
		if(static::$loaded_config === null){
			$configs = glob(app_path('/app/config/*.php'));
			$loaded_config = [];
			foreach($configs as $config){
				$tmp = require $config;
				$tmp_key = explode('/' , $config);
				$tmp_key = $tmp_key[count($tmp_key) - 1];
				$tmp_key = explode('.' , $tmp_key);
				$tmp_key = $tmp_key[0];
				$loaded_config[$tmp_key] = $tmp;
			}
			static::$loaded_config = $loaded_config;
			$configs = static::$loaded_config;
		}else{
			$configs = static::$loaded_config;
		}
		if($key !== null){
			return $configs[$key];
		}
		return $configs;
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

include_once APP_PATH . '/vendor/crystalphp/framework/src/Crystal/App/helpers.php';
