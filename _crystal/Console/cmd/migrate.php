<?php

function cmd_run($args){
    define('JUST_BOOTLOADERS' , true);
    $_SERVER['SERVER_NAME'] = 'localhost';
    $_SERVER['REQUEST_URI'] = '/';
    $_SERVER['REQUEST_METHOD'] = 'get';
    
    include_once libs('/Boot/bootloader.php');
    
    $migrations = glob(app_path('/migrations/*.php'));
    foreach($migrations as $migration){
        if(is_file($migration)){
            include_once $migration;
            $name = explode('/' , $migration);
            $name = $name[count($name) - 1];
            $name = \Crystal\Utilities\Str::remove_last_chars($name , 4);

            echo 'Migrating: ' . $name . '
';
            $cn = '\Migrations\\' . $name;
            $obj = new $cn;
            $obj->down();
            $obj->up();
            echo 'Migrated: ' . $name . '
';
            echo '---------------------------------';
        }
    }
}
