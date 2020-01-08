<?php

function cmd_run($args){
    define('JUST_BOOTLOADERS' , true);
    $_SERVER['SERVER_NAME'] = 'localhost';
    $_SERVER['REQUEST_URI'] = '/';
    $_SERVER['REQUEST_METHOD'] = 'get';
    
    include_once libs('/Boot/bootloader.php');
    
    $migrations = glob(app_path('/migrations/*.php'));
    $migrated_list = \Crystal\Utilities\Str::get_list_from_string(
        fread(fopen(app_path('/migrations/.data') , 'r'),
        filesize(app_path('/migrations/.data')) + 1)
    );
    if(isset($args[0])){
        if(strtolower($args[0]) == 'again'){
            $migrated_list = [];
        }
    }

    $some_thing_migrated = false;
    foreach($migrations as $migration){
        if(is_file($migration)){
            $name = explode('/' , $migration);
            $name = $name[count($name) - 1];
            $name = \Crystal\Utilities\Str::remove_last_chars($name , 4);
            if( ! in_array($name , $migrated_list)){
                include_once $migration;

                echo 'Migrating: ' . $name . '
';
                $cn = '\Migrations\\' . $name;
                $obj = new $cn;
                $obj->down();
                $obj->up();
                echo 'Migrated: ' . $name . '
';
                echo '---------------------------------';

                $fdata = fopen(app_path('/migrations/.data') , 'r');
                $fd_content = fread($fdata , filesize(app_path('/migrations/.data')) + 1);
                $fd_content .= '
' . $name;
                $fdata = fopen(app_path('/migrations/.data') , 'w');
                fwrite($fdata, $fd_content);
                fclose($fdata);
                $some_thing_migrated = true;
            }
        }
    }


    if(!$some_thing_migrated){
        echo 'Nothing To migrate
if you want to migrate again all migrations use "php crystal migrate again"';
    }
}
