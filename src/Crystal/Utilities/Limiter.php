<?php

namespace Crystal\Utilities;

use Crystal\Http\Response;

class Limiter{

	private static function get_time_by_char($ch){
		if($ch == 'm'){
			return 60;
		}else if($ch == 'h'){
			return 60*60;
		}else if($ch == 'd'){
			return 60*60*24;
		}
	}

	private static function new_request(){
		if( ! Session::exist('crystal_limiter_count')){
			Session::set('crystal_limiter_count' , 0);
		}

		$requests_count = Session::get('crystal_limiter_count');
		$requests_count++;
		Session::set('crystal_limiter_count' , $requests_count);
	}

	private static function per($per , $time , $closure=null){
		static::new_request();
		
		if( ! Session::exist('crystal_limiter_start_time')){
			Session::set('crystal_limiter_start_time' , time());
		}

		$converted_time = static::get_time_by_char($time);

		if(time() - Session::get('crystal_limiter_start_time') > $converted_time){
			Session::set('crystal_limiter_count' , 0);
			Session::set('crystal_limiter_start_time' , time());
		}

		if(Session::get('crystal_limiter_count') > $per){
			if(is_callable($closure)){
				$data = [
					'time' => $time,
					'per' => $per,
					'remaining_time' => $converted_time - (time() - Session::get('crystal_limiter_start_time')),
				];
				echo Response::make(call_user_func_array($closure, [$data]) , 429);
				die();
			}
			die(httpcode(429));
		}
	}

	public static function perMinute($per , $closure=null){
		return static::per($per , 'm' , $closure);
	}

	public static function perHour($per , $closure=null){
		return static::per($per , 'h' , $closure);
	}

	public static function perDay($per , $closure=null){
		return static::per($per , 'd' , $closure);
	}
}
