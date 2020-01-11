<?php

namespace Exceptions;

use Exceptions\BaseException;

class ViewNotFound extends BaseException{
	protected $view;
	function __construct($data=[]){
		$this->view = $data[0];

		$code_line = $this->line - 1;

		$this->handle($this->__toString() , $this->file , $code_line);
	}

	function __toString(){
		return "view \"{$this->view}\" not Found. if the APP_DEBUG in .env file equals false, try \"php crystal compile-views\" in the terminal may fix this";
	}
}
