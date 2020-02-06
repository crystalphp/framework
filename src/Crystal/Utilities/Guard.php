<?php

namespace Crystal\Utilities;

class Guard{

	protected static $guards = [];

	public static function define($name , \Closure $func){
		static::$guards[$name] = $func;
	}

	public function has($name){
		return isset(static::$guards[$name]);
	}

	private static function chck($name , $args){
		$name = $args[0];
		$args[0] = Auth::user();
		$func = static::$guards[$name];
		return call_user_func_array($func, $args);
	}

	public static function __callStatic($name , $args){
		if($name == 'check'){
			return static::chck($name , $args);
		}
	}
}
