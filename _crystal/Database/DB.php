<?php

namespace Crystal\Database;

class DB{
	private static $connection;

	public static function connect($host, $user, $password, $db_name){
		$con = new mysqli($host, $user, $password, $db_name);
		if($con->connect_errno){
			return $con->connect_error;
		}else{
			static::$connection = $con;
			return true;
		}
	}


	public function query($sql){
		return mysqli_query(static::$connection , $sql);
	}


}
