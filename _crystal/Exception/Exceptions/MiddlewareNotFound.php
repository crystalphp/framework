<?php

namespace Exceptions;

use Exceptions\BaseException;

class MiddlewareNotFound extends BaseException{
	protected $middleware;
	function __construct($data=[]){
		$this->middleware = $data[0];

		$code_line = $this->line;

		$this->handle($this->__toString() , $this->file , $code_line);
	}

	function __toString(){
		return "middleware {$this->middleware} Not Found";
	}
}
