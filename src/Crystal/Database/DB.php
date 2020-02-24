<?php

namespace Crystal\Database;

use Crystal\App\AppEventListener;
use Crystal\App\app;

class DB{
	private static $connection;
	private static $on_listen = null;

	public static function connect($conf){
		$con = Connector::connect($conf);
		static::$connection = $con;
		AppEventListener::on_end_request(function(){
			\Crystal\Database\DB::close_connection();
		});
		return true;
	}


	public static function query($sql){
		$result = static::$connection->query($sql);
		if($result === false){
			throw new \Crystal\Exceptions\DatabaseError([static::$connection->error]);
		}

		if(static::$on_listen != null){
			$f = static::$on_listen;
			$f($sql);
		}

		return $result;
	}

	public static function close_connection(){
		static::$connection = null;
	}

	public static function listen(\Closure $func){
		static::$on_listen = $func;
	}


}
