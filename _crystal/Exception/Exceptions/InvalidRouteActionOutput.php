<?php

namespace Exceptions;

use Exceptions\BaseException;

class InvalidRouteActionOutput extends BaseException{
	protected $output;
	protected $controller = null;
	protected $method = null;
	function __construct($data=[]){
		$this->output = $data[0];

		if(isset($data[1])){
			$this->controller = $data[1];
		}
		if(isset($data[2])){
			$this->method = $data[2];
		}

		$code_line = $this->line;

		$this->handle($this->__toString() , $this->file , $code_line);
	}

	function __toString(){
		$res_type = get_class($this->output);
		if($this->method !== null && $this->controller !== null){
			$str_part = "method \"{$this->method}\" in \"{$this->controller}\"";
		}else{
			$str_part = "Closure for route \"" . request()->path() . '"';
		}
		
		return "the output of {$str_part} have not showable output. output type is {$res_type}";
	}
}
