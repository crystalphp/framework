<?php

namespace Crystal\Database;

use Crystal\App\AppEventListener;

class DB{
	private static $connection;

	public static function connect($host, $user, $password, $db_name){
		$con = new \mysqli($host, $user, $password, $db_name);
		if($con->connect_errno){
			return $con->connect_error;
		}else{
			static::$connection = $con;
			AppEventListener::on_end_request(function(){
				\Crystal\Database\DB::close_connection();
			});
			return true;
		}
	}


	public function query($sql){
		return mysqli_query(static::$connection , $sql);
	}

	public function close_connection(){
		mysqli_close(static::$connection);
	}


}
