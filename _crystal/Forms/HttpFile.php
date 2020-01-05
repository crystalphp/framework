<?php

namespace Crystal\Forms;

class HttpFile{

	private $name = '';
	private $type = '';
	private $tmp = '';

	function __construct($key){
		$file = $_FILES[$key];
		$this->name = $file['name'];
		$this->type = $file['type'];
		$this->tmp = $file['tmp_name'];
	}


	public function name(){
		return $this->name;
	}


	public function type(){
		return $this->type;
	}


	public function validTypes($valid_types){
		$result = false;
		for($i = 0; $i < count($valid_types); $i++){
			if(strpos('/', $valid_types[$i])){
				if($this->type == $valid_types[$i]){
					$result = true;
					break;
				}
			}else{
				if(substr($this->type, 0 , strlen($valid_types[$i])) == $valid_types[$i]){
					$result = true;
					break;
				}
			}
		}
		return $result;
	}


	public function invalidTypes($invalid_types){
		$result = true;
		for($i = 0; $i < count($invalid_types); $i++){
			if(strpos('/', $invalid_types[$i])){
				if($this->type == $invalid_types[$i]){
					$result = false;
					break;
				}
			}else{
				if(substr($this->type, 0 , strlen($invalid_types[$i])) == $invalid_types[$i]){
					$result = false;
					break;
				}
			}
		}
		return $result;
	}


	public function save($directory , $name){
		return move_uploaded_file($this->tmp, $directory . '/' . $name);
	}


	public function saveIfNotExist($directory , $name){
		if(file_exists($directory . '/' . $name)){
			return false;
		}
		return move_uploaded_file($name, $directory);
	}


	public function size(){
		return filesize($this->tmp);
	}
}
