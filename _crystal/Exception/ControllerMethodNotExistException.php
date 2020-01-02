<?php

class ControllerMethodNotExistException extends \Exception{

	public function __construct($details) {
    	$this->details = $details;
    	parent::__construct();
  	}

	public function __toString() {
    	return '';
	}

}
