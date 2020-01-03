<?php

namespace Crystal\Forms;

class Formfield{
	
	public $name;
	
	public $required = false;
	public $required_error = '';

	public $max = null;
	public $max_error = '';

	public $type = 'text';

	public $default = '';

	public $placeholder = '';

	public $most_equals = null;
	public $most_equals_error = null;

	public $numeric_error = null;


    public function equals($field_name , $error='')
    {
        $this->most_equals = $field_name;
        $this->most_equals_error = $error;
        return $this;
	}
	
	
	public function required($error=''){
		$this->required = true;
        $this->required_error = $error;
		return $this;
	}
	
	public function nullable(){
		$this->required = false;
		return $this;
	}
	
	public function max($max , $error=''){
		$this->max = intval($max);
        $this->max_error = $error;
		return $this;
	}
	
	public function default($val){
		$this->default = ($val);
		return $this;
	}
	
	public function placeholder($txt){
		$this->placeholder = ($txt);
		return $this;
	}

	public function numeric_error($txt_error){
		$this->numeric_error = $txt_error;
		return $this;
	}
	
}