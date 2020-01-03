<?php

namespace Crystal\Forms;

class Formprint{
	
	public $fields = [];

	private function add_new($name , $type){
		$field = new Formfield;
		$field->type = $type;
		$field->name = $name;
		array_push($this->fields , $field);
		return $this->fields[count($this->fields) - 1];
	}

	public function text($name){
		return static::add_new($name , 'text');
	}
	
	public function password($name){
		return static::add_new($name , 'password');
	}
	
	public function email($name){
		return static::add_new($name , 'email');
	}
	
	public function number($name){
		return static::add_new($name , 'number');
	}
	
	public function date($name){
		return static::add_new($name , 'date');
	}

    public function textarea($name)
    {
        return static::add_new($name , 'textarea');
	}
	
}