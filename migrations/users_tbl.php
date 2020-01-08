<?php

namespace Migrations;

use Crystal\Database\Migrations\Migration;

class users_tbl extends Migration{
    public function up(){
        $this->create('tests' , '
        	id int primary key,
        	name varchar(100) not null
');
    }

    public function down(){
        $this->dropIfExist('tests');
    }
}
