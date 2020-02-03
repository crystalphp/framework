<?php

namespace Crystal\Exceptions;

use Crystal\Exceptions\BaseException;

class ControllerNotFound extends BaseException{
	protected $controller_name;
	function __construct($data=[]){
		$this->controller_name = explode('\\', $data[0]);
		$this->controller_name = $this->controller_name[count($this->controller_name) - 1];
		$code_line = $this->get_line_contains(app_path('/app/routes.php') , $this->controller_name . '@');

		$this->handle($this->__toString() , app_path('/app/routes.php') , $code_line);
	}

	function __toString(){
		return "controller {$this->controller_name} Not Found";
	}
}
