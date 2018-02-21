<?php

use GuzzleHttp\Client;
use Interop\Container\ContainerInterface;
use Monolog\Logger;

$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

return [
    'settings.displayErrorDetails' => true,
    Client::class => function (ContainerInterface $container) {
        return new Client();
    },
    PDO::class => function (ContainerInterface $container) {
        return new PDO('mysql:host='.getenv('MYSQL_HOST').';dbname='.getenv('MYSQL_DATABASE'), getenv('MYSQL_USERNAME'), getenv('MYSQL_PASSWORD'));
    },
    Logger::class => function (ContainerInterface $container) {
        $log = new Monolog\Logger('crypto');

        $log->pushHandler(new \Monolog\Handler\RotatingFileHandler(__DIR__ . '/../logs/logs.log', 3, Logger::WARNING));

        return $log;
    }
];
