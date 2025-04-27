
<?php
header("Content-Type: application/json");
require "vendor/autoload.php";
require_once "core/Router.php";


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();
$router->run();
