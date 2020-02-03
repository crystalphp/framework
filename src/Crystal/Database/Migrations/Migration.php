<?php

namespace Crystal\Database\Migrations;

use Crystal\Database\DB;

class Migration{
    protected function create($tbl_name , $sql){
    	$sql = 'CREATE TABLE ' . $tbl_name . '( ' . $sql . ' );';
        DB::query($sql);
    }

    protected function dropIfExist($tbl_name){
        DB::query('DROP TABLE IF EXISTS ' . $tbl_name . ';');
    }
}
