<?php

namespace Crystal\Utilities;

use Crystal\App\app;

class Cache{
	public static function put($name , $obj , $expire=null){
		if($expire == null){
			$expire = app::get_config('cache')['default_life_time'];
		}

		$expire = time() + $expire;
		$path = app_path('/storage/cache/' . Hash::sha256($name));
		File::create($path);
		File::write($path , serialize(
			[$expire , $obj , $name]
		));
	}

	public static function get($name){
		$path = app_path('/storage/cache/' . Hash::sha256($name));
		if( ! is_file($path)){
			return null;
		}
		$content = File::read($path);
		$chunk = unserialize($content);
		if($chunk[0] < time()){
			unlink($path);
			return null;
		}

		return $chunk[1];
	}

	public static function all(){
		$files = glob(app_path('/storage/cache/*'));
		$all = [];
		foreach($files as $file){
			$object_content = unserialize(File::read($file));
			if(static::has($object_content[2])){
				$all[$object_content[2]] = $object_content[1];
			}
		}

		return $all;
	}

	public static function remove($name){
		$path = app_path('/storage/cache/' . Hash::sha256($name));
		if(is_file($path)){
			unlink($path);
		}
	}

	public static function has($name){
		if(static::get($name)){
			return true;
		}

		return false;
	}
}
