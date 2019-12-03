<?php

AppEventListener::on_error_404(function ($req){
    echo '404 Not Found';
});
