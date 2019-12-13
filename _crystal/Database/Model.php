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


	public static function query($sql , $selectabe=false){
		$result = DB::query($sql);
		if($selectabe){
			return static::convert_result_to_collection($result);
		}else{
			return $result;
		}
	}

	public static function select($sql){
		return static::query($sql , true);
	}



	public static function find($id){
		$result = DB::query('SELECT * FROM ' . static::$table . ' WHERE id=' . addslashes($id));
		$colect = static::convert_result_to_collection($result);
		if(count($colect) > 0){
			return $colect[0];
		}else{
			return null;
		}
	}

	public function save(){

		$fields_sql = '';
		$f_keys = array_keys($this->columns);
		$keys = [];
		for($i = 1; $i < count($f_keys); $i += 2){
			array_push($keys, $f_keys[$i]);
		}

		if($this->id == null){
			return static::insert($this->columns , $this);
		}

		foreach($keys as $key){
			$v = $this->$key;
			if($v === null){
				$v = "NULL";
			}else{
				$v = '"' . addslashes($v) . '"';
			}
			$fields_sql .= $key . '=' . $v . ',';
		}

		$fields_sql = substr($fields_sql, 0, strlen($fields_sql) - 1);


		$sql = 'UPDATE ' . static::$table . ' SET ' . $fields_sql . ' WHERE id="'. addslashes($this->id) .'"';

		return boolval(DB::query($sql));
	}



	private static function insert($columns , Model $obj){
		$keys = array_keys($columns);
		$values_sql = '';
		$columns_sql = '';
		foreach($keys as $key){
			$v = $obj->$key;
			if($v === null){
				$v = "NULL";
			}else{
				$v = '"' . addslashes($v) . '"';
			}
			$values_sql .= $v . ',';
			$columns_sql .= $key . ',';
		}


		$values_sql = substr($values_sql, 0, strlen($values_sql) - 1);
		$columns_sql = substr($columns_sql, 0, strlen($columns_sql) - 1);

		$columns_sql = '(' . $columns_sql . ')';
		$values_sql = '(' . $values_sql . ')';

		$sql = 'INSERT INTO ' . static::$table . $columns_sql . ' VALUES' . $values_sql;

		DB::query($sql);
	}



	public function delete(){
		$sql = 'DELETE FROM ' . static::$table . ' WHERE id="' . addslashes($this->id) . '"';
		return boolval(DB::query($sql));
	}
}
