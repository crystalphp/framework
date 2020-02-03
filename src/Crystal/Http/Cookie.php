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

			return $value; 
		}else{
			return $default;
		}
	}

	public function remove($name){
		setcookie($name , null , time() - 100);
	}
}
