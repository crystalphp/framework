<?php

namespace Crystal\Database;

class Connector{
    public static function connect($conf){
        if(!method_exists((new static) , $conf['driver'])){
            throw new \Crystal\Exceptions\ArgumentError(['Unsupported driver ' . $conf['driver']]);
        }
        $con = static::{$conf['driver']}($conf);
		return $con;
    }

    private static function mysql($conf){
        $host = $conf['host'];
        $db_name = $conf['name'];
        $user = $conf['username'];
        $password = $conf['password'];
        return new \PDO("mysql:host={$host};dbname={$db_name}" , $user , $password);
    }

    private static function sqlite($conf){
        $file = str_replace('~' , app_path() , $conf['src']);
        return new \PDO("sqlite:" . $file);
    }
}
