<?php 

session_start();
include('config.php');
include('classes/Autoload.php');
define('ROOT', dirname(__FILE__));
$router = new Router;
$router->run();
