<?php

namespace Crystal\Utilities;

class Hash{
	static function __callStatic($name , $args){
		if( ! in_array($name , hash_algos())){
			throw new \Crystal\Exceptions\ArgumentError(["the hash algo \"{$name}\" Not found"]);
		}
		if( ! isset($args[0])){
			throw new \Crystal\Exceptions\ArgumentError(['argument data is required for Hash class functions']);
		}
		return hash($name, $args[0]);
	}

	function __call($name , $args){
		return static::__callStatic($name , $args);
	}
}
