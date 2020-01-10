<?php

namespace Migrations;

use Crystal\Database\Migrations\Migration;

class example_tbl extends Migration{
    public function up(){
        $this->create('example' , '
        	
		');
    }

    public function down(){
        $this->dropIfExist('example');
    }
}
