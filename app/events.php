<?php

AppEventListener::on_error_404(function ($req){
    echo httpcode(404);
});


AppEventListener::on_start(function ($req){
    //
});
