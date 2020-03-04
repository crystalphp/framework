<?php

namespace Crystal\Utilities;

class Session{
	protected static $flash = [];

	public static function bootstrap(){
		session_start();
		if(static::exist('flash')){
			static::$flash = static::get('flash');
		}

		static::remove('flash');
	}

	public static function flash($key , $value=null){
		if(!static::exist('flash')){
			static::set('flash' , []);
		}

		if($value === null){
			if(!isset(static::$flash[$key])){
				return null;
			}
			return static::$flash[$key];
		}

		$flash = static::get('flash');
		$flash[$key] = $value;
		static::set('flash' , $flash);
	}

	public static function get($key , $default=null){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}else{
			return $default;
		}
	}

	public static function set($key , $value){
		$_SESSION[$key] = $value;
	}

	public static function remove($key){
		if(static::exist($key)){
			unset($_SESSION[$key]);
		}
	}

	public static function all(){
		return $_SESSION;
	}

	public static function exist($key){
		return isset($_SESSION[$key]);
	}

	public static function reset(){
		foreach($_SESSION as $key => $value){
			unset($_SESSION[$key]);
		}
	}
}
