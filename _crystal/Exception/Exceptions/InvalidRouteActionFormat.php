<?php

namespace Exceptions;

use Exceptions\BaseException;

class InvalidRouteActionFormat extends BaseException{
	protected $action;
	function __construct($data=[]){
		$this->action = $data[0];

		$code_line = $this->get_line_contains(app_path('/app/routes.php') , $this->action);

		$this->handle($this->__toString() , app_path('/app/routes.php') , $code_line);
	}

	function __toString(){
		return "route action \"" . $this->action . "\" is Invalid format";
	}
}
