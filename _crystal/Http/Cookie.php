<?php

namespace Crystal\Http;

use Crystal\App\app;

class Cookie{
	public function set($name , $value , $time=null , $path='/'){
		if($time === null){
			$time = app::get_config('cookies_default_life_time');
		}

		setcookie($name , $value , $time , $path);

	}

	public function get($name , $default=null){
		if(isset($_COOKIE[$name])){
			$value = $_COOKIE[$name];
			if(isset(app::get_config()['decryptor_class'])){
				if(app::get_config()['decryptor_class'] != null){
					$tmp_obj = app::get_config()['decryptor_class'];
					$tmp_obj = new $tmp_obj();
					$func = app::get_config()['decryptor_class_func'];
					$value = $tmp_obj->$func($value);
				}
			}

			return $value; 
		}else{
			return $default;
		}
	}
}
