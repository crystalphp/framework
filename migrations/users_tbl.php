<?php

namespace Migrations;

use Crystal\Database\Migrations\Migration;

class users_tbl extends Migration{
    public function up(){
        $this->create('users' , '
        ');
    }

    public function down(){
        $this->dropIfExist('users');
    }
}
