<?php

namespace Crystal\Exceptions;

use Crystal\Exceptions\BaseException;

class DatabaseConnectionError extends BaseException{
	protected $msg = null;
	function __construct($data=[]){
		$this->msg = $data[0];

		$code_line = $this->line - 1;

		$this->handle($this->__toString() , $this->file , $code_line);
	}

	function __toString(){
		return $this->msg;
	}
}
