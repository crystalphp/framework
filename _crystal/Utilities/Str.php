<?php

namespace Crystal\Utilities;

class Str{
	public function make_string_from_array($array){
		$str = '';
		foreach($array as $v){
			$str .= $v . ', ';
		}
		$str = substr($str, 0 , strlen($str) - 2);
		return $str;
	}

	public function remove_last_chars($string , $char_count){
		return substr($string, 0 , strlen($string) - $char_count);
	}
}
