<?php

namespace Crystal\Utilities;

class File{
	public static function read($path , $max_byte=null){
		if($max_byte === null){
			$max_byte = filesize($path) + 1;
		}

		$f = fopen($path, 'r');
		return fread($f , $max_byte);
	}


	public static function write($path , $content){
		$f = fopen($path, 'w');
		return fwrite($f, $content);
	}


	public static function append($path , $content){
		$c = static::read($path);
		$c .= $content;
		return static::write($path , $c);
	}


	public static function appendBefore($path , $content){
		$c = static::read($path);
		$c = $content . $c;
		return static::write($path , $c);
	}


	public static function delete($path){
		return unlink($path);
	}


	public static function create($path , $default_content=''){
		if( ! file_exists($path)){
			return static::write($path , $default_content);
		}
	}


	public static function exist($path){
		return file_exists($path);
	}


	public static function is_file($path){
		return is_file($path);
	}


	public static function is_dir($path){
		return is_dir($path);
	}
}
