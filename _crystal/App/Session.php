<?php

class Session{
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
