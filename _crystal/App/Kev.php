<?php

namespace Crystal\App;

use Crystal\App\KEVRender;

class Kev{
	public static function get($fname , $key=null , $default=null){
		$data = KEVRender::render_by_file(app_path('/resources/kev/' . $fname . '.kev'));

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

