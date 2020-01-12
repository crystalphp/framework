<?php

namespace Crystal\Database;

use Crystal\App\AppEventListener;

class DB{
	private static $connection;
	private static $on_listen = null;

	public static function connect($host, $user, $password, $db_name){
		$con = new \mysqli($host, $user, $password, $db_name);
		if($con->connect_errno){
			throw new \Crystal\Exceptions\DatabaseError([$con->connect_errno]);
		}else{
			static::$connection = $con;
			AppEventListener::on_end_request(function(){
				\Crystal\Database\DB::close_connection();
			});
			return true;
		}
	}


	public static function query($sql){
		if(static::$on_listen != null){
			$f = static::$on_listen;
			$f($sql);
		}
		$result = mysqli_query(static::$connection , $sql);
		if($result === false){
			throw new \Crystal\Exceptions\DatabaseError([static::$connection->error]);
		}

		return $result;
	}

	public static function close_connection(){
		mysqli_close(static::$connection);
	}

	public static function listen(\Closure $func){
		static::$on_listen = $func;
	}


}
