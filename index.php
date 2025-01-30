<?php

require_once __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router("APPLICATION_URL");

$router->namespace("Src\Controller");

$router->dispatch();

if ($router->error()) 
{
   var_dump($router->error());
   echo "Route with error";
   die();
}
