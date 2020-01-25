<?php

namespace Crystal\Exceptions;

use Crystal\Exceptions\BaseException;

class EventNotFound extends BaseException{
	protected $event = null;
	function __construct($data=[]){
		$this->event = $data[0];

		$code_line = $this->get_line_contains(app_path('/app/events.php') , $this->event);

		$this->handle($this->__toString() , app_path('/app/events.php') , $code_line);
	}

	function __toString(){
		return "the event {$this->event} not found";
	}
}
