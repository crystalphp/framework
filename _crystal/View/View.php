<?php

namespace Crystal\View;

use Crystal\App\app;
use Crystal\Utilities\Hash;

class View{
	protected static $sections = [];
	protected static $current_section = null;

	private static $tmp;
	private static $tmp2;

	private static function include_view($path , $data=[]){
		static::$tmp = [$path , $data];
		unset($path);
		unset($data);

		foreach(static::$tmp[1] as static::$tmp2[0] => static::$tmp2[1]){
			${static::$tmp2[0]} = static::$tmp2[1];
		}
		static::$tmp2 = null;
		static::$tmp = static::$tmp[0];

		include static::$tmp;

		static::$tmp = null;
	}

    public static function make($name, $data = [], $include=false)
	{
		$name = Hash::sha256($name . '.cv.php') . '.php';
		$path = app_path('/storage/viewcache/' . $name);

		if( ! is_file($path)){
			throw new \Crystal\Exceptions\ViewNotFound([$name]);
		}

		if($include){
			static::include_view($path , $data);
			return '';
		}
		
		ob_start();
		static::include_view($path , $data);
		$content = ob_get_clean();

		if(app::get_config('clean_views_output') === true){
			$content = str_replace('
', '', $content);
			$content = str_replace('	', '', $content);
		}

		return $content;
	}






	public static function section($name){
		static::$sections[$name] = '';
		static::$current_section = $name;
		ob_start();
	}


	public static function endsection(){
		static::$sections[static::$current_section] = ob_get_clean();
		static::$current_section = '';
	}

	public static function getsection($name){
		if(isset(static::$sections[$name])){
			return static::$sections[$name];
		}else{
			return '';
		}
	}
}
