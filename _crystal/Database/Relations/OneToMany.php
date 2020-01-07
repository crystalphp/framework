<?php

namespace Crystal\Database\Relations;

use Crystal\Database\QueryBuilder;
use Crystal\Utilities\Str;

class OneToMany{
	public function has(\Crystal\Database\Model $model , $many_model , $fk=null){
		$fk_id = $model->id;
		$tbl_name = $many_model::tbl_name();

		if($fk === null){
			$fk = $model->tbl_name();
			$fk = Str::remove_last_chars($fk , 1);
			$fk .= '_id';
		}

		$query = new QueryBuilder($many_model);
		$query = $query->where($fk , '=' , $fk_id);

		return $query;
	}



	public function belongs(\Crystal\Database\Model $model , $owner_model , $fk=null){

		if($fk === null){
			$fk = $owner_model::tbl_name();
			$fk = Str::remove_last_chars($fk , 1);
			$fk .= '_id';
		}

		$fk_id = $model->$fk;

		$query = new QueryBuilder($owner_model);
		$query = $query->where('id' , '=' , $fk_id)
			->get()->first();

		return $query;
	}
}
