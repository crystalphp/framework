<?php

namespace Exceptions;

use Exceptions\BaseException;

class MethodTypeError extends BaseException{
	protected $method;
	protected $class;
	protected $should_be;
	function __construct($data=[]){
		$this->method = $data[0];
		$this->class = $data[1];
		$this->should_be = $data[2];

		$code_line = $this->line;

		$this->handle($this->__toString() , $this->file , $code_line);
	}

	function __toString(){
		return "the method {$this->method} in {$this->class} is not {$this->should_be}";
	}
}
