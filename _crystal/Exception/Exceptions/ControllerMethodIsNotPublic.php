<?php

namespace Exceptions;

use Exceptions\BaseException;

class ControllerMethodIsNotPublic extends BaseException{
	protected $controller;
	protected $method;
	function __construct($data=[]){
		$this->controller = $data[0];
		$this->method = $data[1];

		$code_line = $this->get_line_contains(app_path('/app/routes.php') , $this->controller . '@' . $this->method);

		$this->handle($this->__toString() , app_path('/app/routes.php') , $code_line);
	}

	function __toString(){
		return "the method {$this->method} in controller {$this->controller} is not public";
	}
}
