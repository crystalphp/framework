<?php

namespace Crystal\Exceptions;

use Crystal\Exceptions\BaseException;

class InvalidRouteMethod extends BaseException{
	protected $route = null;
	protected $method = null;
	function __construct($data=[]){
		$this->route = $data[0];
		$this->method = $data[1];

		$code_line = $this->line - 1;

		$this->handle($this->__toString() , $this->file , $code_line);
	}

	function __toString(){
		return "route \"{$this->route}\" not supported method {$this->method}";
	}
}
