<?php

namespace Crystal\Utilities;

class KEVRender{

	public static function render_by_content($content){
		$tmp = explode('
', $content);

		$data = [];

		foreach($tmp as $t){
			$kv = explode('=', $t);
			if(count($kv) >= 2){
				$data[$kv[0]] = $kv[1];
			}
		}

		return $data;
	}

	public static function render_by_file($path){
		$f = fopen($path, 'r');
		$content = fread($f , filesize($path) + 1);
		return static::render_by_content($content);
	}

}


