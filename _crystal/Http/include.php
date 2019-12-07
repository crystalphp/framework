<?php
define('FULL_REQUEST_URI' , $_SERVER['REQUEST_URI']);
$_SERVER['REQUEST_URI'] = explode('?' , $_SERVER['REQUEST_URI'])[0];
session_start();
$router = new Router(new Request);
