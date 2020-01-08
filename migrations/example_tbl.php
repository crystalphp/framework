<?php

namespace Migrations;

use Crystal\Database\Migrations\Migration;

class example_tbl extends Migration{
    public function up(){
        $this->create('tbl' , '
        	
		');
    }

    public function down(){
        $this->dropIfExist('tbl');
    }
}
