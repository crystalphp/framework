<?php

namespace Crystal\Database\Migrations;

use Crystal\Database\DB;

class Migration{
    protected function create($tbl_name , $sql){
        DB::query('CREATE TABLE ' . $tbl_name . '( ' . $sql . ' );');
    }

    protected function dropIfExist($tbl_name){
        DB::query('DROP TABLE ' . $tbl_name . ';');
    }
}
