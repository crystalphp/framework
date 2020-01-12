<?php

namespace Crystal\Exceptions;

use Crystal\Exceptions\BaseException;

class MethodNotFound extends BaseException{
	protected $method = null;
	protected $class = null;
	function __construct($data=[]){
		$this->method = $data[0];
		$this->class = $data[1];

		$code_line = $this->line;

		$this->handle($this->__toString() , $this->file , $code_line);
	}

	function __toString(){
		return "the method {$this->method} not found in {$this->class}";
	}
}
