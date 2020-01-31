<?php

namespace Crystal\Utilities;

use Crystal\App\app;

class Cache{
	public static function put($name , $obj , $expire=null){
		if($expire == null){
			$expire = app::get_config('cache_default_life_time');
		}

		$expire = time() + $expire;
		$path = app_path('/storage/cache/' . Hash::sha256($name));
		File::create($path);
		File::write($path , serialize(
			[$expire , $obj]
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

	public static function remove($name){
		$path = app_path('/storage/cache/' . Hash::sha256($name));
		if(is_file($path)){
			unlink($path);
		}
	}

	public function has($name){
		$path = app_path('/storage/cache/' . Hash::sha256($name));
		if( ! is_file($name)){
			return false;
		}

		$obj = unserialize(File::read($path));

		if($obj[0] < time()){
			unlink($path);
			return false;
		}

		return true;
	}
}
