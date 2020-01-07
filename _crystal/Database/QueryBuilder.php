<?php

namespace Crystal\Database;

use Crystal\Utilities\Str;

class QueryBuilder{

	function __construct($model){
		$this->model = $model;
	}

	private $model;
	private $wheres = [];
	private $orderBy = null;
	private $limit = null;





	public function orderBy($column , $type='asc'){
		$this->orderBy = 'ORDER BY ' . $column . ' ' . $type;

		return $this;
	}


	public function limit($count){
		$this->limit = ' LIMIT ' . $count;
		
		return $this;
	}



	public function where($key , $operator=null , $value){
		if($operator == null){
			$operator = '=';
		}
		if($this->wheres != []){
			array_push($this->wheres , 'and');
		}
		array_push($this->wheres , $key . $operator . '"' . addslashes($value) . '"');

		return $this;
	}

	public function orWhere($key , $operator=null , $value){
		if($operator == null){
			$operator = '=';
		}
		if($this->wheres != []){
			array_push($this->wheres , 'or');
		}
		array_push($this->wheres , $key . $operator . '"' . addslashes($value) . '"');

		return $this;
	}


	public function get($columns=['*']){
		$model = $this->model;
		if(is_string($columns)){
			$columns = [$columns];
		}

		$wheres_str = '';
		if($this->wheres == []){
			$wheres_str = '1';
		}else{
			foreach($this->wheres as $w){
				$wheres_str .= $w . ' ';
			}
		}

		$sql = 'SELECT ' . Str::make_string_from_array($columns) . ' FROM ' . $model::tbl_name() . ' WHERE ' . $wheres_str . ' ' . $this->orderBy . $this->limit;
		
		return $model::query($sql , true);
	}

	public function delete(){
		$model = $this->model;
		if(is_string($columns)){
			$columns = [$columns];
		}

		$wheres_str = '';
		if($this->wheres == []){
			$wheres_str = '1';
		}else{
			foreach($this->wheres as $w){
				$wheres_str .= $w . ' ';
			}
		}

		$sql = 'DELETE FROM ' . $model::tbl_name() . ' WHERE ' . $wheres_str;
		
		return $model::query($sql , false);
	}

	public function update($columns){
		$model = $this->model;

		$wheres_str = '';
		if($this->wheres == []){
			$wheres_str = '1';
		}else{
			foreach($this->wheres as $w){
				$wheres_str .= $w . ' ';
			}
		}

		$columns_str = [];
		foreach($columns as $key => $value){
			array_push($columns_str , $key . '=' . '"' . addslashes($value) . '"');
		}
		$columns_str = Str::make_string_from_array($columns_str);

		$sql = 'UPDATE ' . $model::tbl_name() . ' SET ' . $columns_str . ' WHERE ' . $wheres_str;
		
		return $model::query($sql , false);
	}
}
