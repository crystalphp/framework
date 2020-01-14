<?php

namespace Crystal\View;

use Crystal\App\app;
use Crystal\Utilities\Hash;

class View{
    public static function make($name, $data = null, $include=false)
	{
		$name = Hash::sha256($name . '.cv.php') . '.php';
		$path = app_path('/storage/viewcache/' . $name);

		if( ! is_file($path)){
			throw new \Crystal\Exceptions\ViewNotFound([$name]);
		}

		if($include){
			include $path;
			return '';
		}
		
		ob_start();
		include $path;
		$content = ob_get_clean();

		if(app::get_config('clean_views_output') === true){
			$content = str_replace('
', '', $content);
			$content = str_replace('	', '', $content);
		}

		return $content;
	}
}
