<?php

namespace Crystal\Exceptions;

use Crystal\Exceptions\BaseException;

class Error extends BaseException{
	function __construct($data=[]){
        $this->errno = $data[0];
        $this->message = $data[1];
        $this->file = $data[2];
        $this->line = $data[3] - 1;

		$code_line = $this->line;

		$this->handle($this->__toString() , $this->file , $code_line);
	}

	function __toString(){
		return $this->message;
	}
}
