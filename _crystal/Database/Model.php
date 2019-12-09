<?php

class Model{

	private $columns = [];

	public static function convert_result_to_collection($result){
		$collection = [];
		while($row = mysqli_fetch_array($result)){
			array_push($collection , new static($row));
		}

		return $collection;
	}


	public function all($fields=['*']){
		$fields_sql = '';
		for($i = 0; $i < count($fields); $i++){
			$tmp = ',';
			if($i + 1 == count($fields)){
				$tmp = '';
			}
			$fields_sql .= $fields[$i] . $tmp;
		}
		$sql = 'SELECT ' . $fields_sql . ' FROM ' . static::$table;
		

		return static::convert_result_to_collection(DB::query($sql));
	}


	public function __construct($row=null){
		if($row != null){
			foreach($row as $key => $value){
				$this->$key = $value;
			}
		}
	}



	public function __get($name){
		if(isset($this->columns[$name])){
			return $this->columns[$name];
		}else{
			return null;
		}
	}


	public function __set($name , $value){
		$this->columns[$name] = $value;
	}

}
