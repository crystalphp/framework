<?php

AppEventListener::on_error_404(function ($req){
    echo '404 Not Found';
});


AppEventListener::on_start(function ($req){
    echo 'app started';
});





