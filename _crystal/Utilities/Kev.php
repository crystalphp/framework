<?php

namespace Crystal\Utilities;

use Crystal\Utilities\KEVRender;

class Kev{
	private static $caches = [];

	public static function get($fname , $key=null , $default=null){
		if(isset(static::$caches[$fname])){
			$data = static::$caches[$fname];
		}else{
			$data = KEVRender::render_by_file(app_path('/resources/kev/' . $fname . '.kev'));
			static::$caches[$fname] = $data;
		}

		if(! is_null($key)){
			if(isset($data[$key])){
				return $data[$key];
			}else{
				return $default;
			}
		}else{
			return $data;
		}
	}
}

