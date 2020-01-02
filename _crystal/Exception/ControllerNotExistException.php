<?php

class ControllerNotExistException extends \Exception{

	public function __construct($details) {
    	$this->details = $details;
    	parent::__construct();
  	}

	public function __toString() {
    	return "controller " . $this->details . ' Not Exist';
	}

}
