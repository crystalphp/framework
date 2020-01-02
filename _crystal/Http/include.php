<?php

namespace Crystal\Http;

define('FULL_REQUEST_URI' , $_SERVER['REQUEST_URI']);
$_SERVER['REQUEST_URI'] = explode('?' , $_SERVER['REQUEST_URI'])[0];
$router = new Router(new Request);
