<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

$connectionParams = [
    'driver' => $_ENV['DB_DRIVER'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'port' => $_ENV['DB_PORT'],
    'host' => $_ENV['DB_HOST'],
    'dbname' => $_ENV['DB_NAME'],
];

$dbConnection = DriverManager::getConnection($connectionParams);

return $dbConnection;