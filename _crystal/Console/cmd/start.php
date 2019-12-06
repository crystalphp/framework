<?php

function cmd_run($args){



$public = APP_PATH . '/public';
echo 'crystal server started on http://localhost:8000
';
system('cd "' . $public . '";' . 'php -S localhost:8000');




}
