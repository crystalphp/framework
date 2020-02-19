<?php

namespace Migrations;

use Crystal\Database\Migrations\Migration;

class ClassName extends Migration{
    public function up(){
        $this->create('ClassName' , '
        	
		');
    }

    public function down(){
        $this->dropIfExist('ClassName');
    }
}
